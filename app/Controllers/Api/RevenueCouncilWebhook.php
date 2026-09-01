<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\Revenue\LyzrClient;
use App\Services\Revenue\RevenueCouncilRouter;
use App\Services\Revenue\SlackBotClient;
use App\Services\Revenue\SlackSignatureVerifier;

class RevenueCouncilWebhook extends BaseController
{
    public function handle()
    {
        $body = (string) $this->request->getBody();
        $signingSecret = trim((string) (getenv('SLACK_SIGNING_SECRET') ?: ''));
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

        $allowed = array_values(array_filter(array_map('trim', explode(',', (string) (getenv('SLACK_REVENUE_CHANNEL_IDS') ?: '')))));
        if ($allowed !== [] && !in_array($channel, $allowed, true)) {
            return $this->response->setJSON(['ok' => true, 'ignored' => true]);
        }

        $agents = (new RevenueCouncilRouter())->agentsFor($text);
        $threadTs = (string) ($event['thread_ts'] ?? $event['ts'] ?? '');
        $userId = (string) ($event['user'] ?? 'slack-user');
        $sessionId = 'slack-' . $channel . '-' . ($threadTs !== '' ? $threadTs : bin2hex(random_bytes(6)));
        $slack = new SlackBotClient();

        if ($agents === []) {
            $slack->postMessage($channel, "⚠️ Revenue Council bridge is live, but no Lyzr agent ID is configured for this request.", $threadTs);
            return $this->response->setJSON(['ok' => true, 'configured' => false]);
        }

        $lyzr = new LyzrClient();
        $sections = [];
        foreach ($agents as $agent) {
            try {
                $reply = $lyzr->chat(
                    (string) $agent['agent_id'],
                    $text,
                    $userId,
                    $sessionId . '-' . md5((string) $agent['agent_id'])
                );
                $sections[] = '*Lyzr · ' . $agent['label'] . "*\n" . $reply;
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
    }
}
