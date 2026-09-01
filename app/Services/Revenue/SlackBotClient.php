<?php

namespace App\Services\Revenue;

use RuntimeException;

class SlackBotClient
{
    private string $token;

    public function __construct(?string $token = null)
    {
        $this->token = trim((string) ($token ?? getenv('SLACK_BOT_TOKEN') ?: ''));
    }

    public function postMessage(string $channel, string $text, ?string $threadTs = null): void
    {
        if ($this->token === '') {
            throw new RuntimeException('SLACK_BOT_TOKEN is not configured.');
        }
        $payload = ['channel' => $channel, 'text' => $text];
        if ($threadTs !== null && $threadTs !== '') {
            $payload['thread_ts'] = $threadTs;
        }
        $ch = curl_init('https://slack.com/api/chat.postMessage');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json; charset=utf-8',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ]);
        $raw = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($raw === false || $error !== '') {
            throw new RuntimeException('Slack post failed: ' . ($error ?: 'unknown transport error'));
        }
        $decoded = json_decode((string) $raw, true);
        if (!is_array($decoded) || !($decoded['ok'] ?? false)) {
            throw new RuntimeException('Slack post failed: ' . (string) ($decoded['error'] ?? 'unknown_error'));
        }
    }
}
