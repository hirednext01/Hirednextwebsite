<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\Cv\LyzrClient;
use App\Services\Revenue\RevenueCouncilRouter;
use App\Services\Revenue\SlackBotClient;
use App\Services\Revenue\SlackEventGuard;
use App\Services\Revenue\SlackSignatureVerifier;

class RevenueCouncilWebhook extends BaseController
{
    public function handle()
    {
        $body = (string) $this->request->getBody();
        $signingSecret = trim((string) env('SLACK_SIGNING_SECRET', ''));
        $timestamp = $this->request->getHeaderLine('X-Slack-Request-Timestamp');
        $signature = $this->request->getHeaderLine('X-Slack-Signature');

        if (!(new SlackSignatureVerifier())->verify($timestamp, $signature, $body, $signingSecret)) {
            return $this->response->setStatusCode(401)->setJSON(['ok' => false, 'error' => 'invalid_signature']);
        }

        $payload = json_decode($body, true);
        if (!is_array($payload)) {
            return $this->response->setStatusCode(400)->setJSON(['ok' => false, 'error' => 'invalid_json']);
        }
        if (($payload['type'] ?? '') === 'url_verification') {
            return $this->response->setJSON(['challenge' => (string) ($payload['challenge'] ?? '')]);
        }
        if (($payload['type'] ?? '') !== 'event_callback') {
            return $this->response->setJSON(['ok' => true, 'ignored' => true]);
        }

        $event = is_array($payload['event'] ?? null) ? $payload['event'] : [];
        if (($event['type'] ?? '') !== 'message' || isset($event['bot_id']) || ($event['subtype'] ?? '') === 'bot_message') {
            return $this->response->setJSON(['ok' => true, 'ignored' => true]);
        }

        $channel = trim((string) ($event['channel'] ?? ''));
        $text = trim((string) ($event['text'] ?? ''));
        if ($channel === '' || $text === '') {
            return $this->response->setJSON(['ok' => true, 'ignored' => true]);
        }

        $allowed = array_values(array_filter(array_map('trim', explode(',', (string) env('SLACK_REVENUE_CHANNEL_IDS', '')))));
        if ($allowed !== [] && !in_array($channel, $allowed, true)) {
            return $this->response->setJSON(['ok' => true, 'ignored' => true]);
        }

        $eventId = trim((string) ($payload['event_id'] ?? ''));
        $guard = new SlackEventGuard();
        if (!$guard->acquire($eventId)) {
            return $this->response->setJSON(['ok' => true, 'duplicate' => true]);
        }

        try {
            $agents = (new RevenueCouncilRouter())->agentsFor($text);
            $threadTs = (string) ($event['thread_ts'] ?? $event['ts'] ?? '');
            $userId = (string) ($event['user'] ?? 'slack-user');
            $sessionId = 'slack-' . $channel . '-' . ($threadTs !== '' ? $threadTs : bin2hex(random_bytes(6)));
            $slack = new SlackBotClient();

            if ($agents === []) {
                $slack->postMessage($channel, "⚠️ Revenue Council bridge is live, but no Lyzr agent is configured for this request.", $threadTs);
                return $this->response->setJSON(['ok' => true, 'configured' => false]);
            }

            $lyzr = new LyzrClient();
            $sections = [];
            foreach ($agents as $agent) {
                try {
                    $response = $lyzr->chat(
                        (string) $agent['agent_id'],
                        $userId,
                        $sessionId . '-' . md5((string) $agent['agent_id']),
                        $text
                    );
                    $sections[] = '*Lyzr · ' . $agent['label'] . "*\n" . $this->extractText($response);
                } catch (\Throwable $e) {
                    $sections[] = '*Lyzr · ' . $agent['label'] . "*\n⚠️ " . $e->getMessage();
                }
            }

            $message = implode("\n\n", $sections);
            if (strlen($message) > 4500) {
                $message = substr($message, 0, 4450) . "\n\n…truncated";
            }
            $slack->postMessage($channel, $message, $threadTs);
            return $this->response->setJSON(['ok' => true]);
        } catch (\Throwable $e) {
            $guard->release($eventId);
            log_message('error', 'Revenue Council Slack bridge failed: {message}', ['message' => $e->getMessage()]);
            return $this->response->setStatusCode(500)->setJSON(['ok' => false, 'error' => 'bridge_failed']);
        }
    }

    private function extractText(array $response): string
    {
        foreach (['response', 'message', 'output', 'content', 'text', 'answer'] as $key) {
            if (!array_key_exists($key, $response)) {
                continue;
            }
            $value = $response[$key];
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
            if (is_array($value)) {
                return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: 'Lyzr returned structured output.';
            }
        }
        if (isset($response['data']) && is_array($response['data'])) {
            return $this->extractText($response['data']);
        }
        return json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: 'Lyzr returned a response.';
    }
}
