<?php

namespace App\Services\Revenue;

use RuntimeException;

class LyzrClient
{
    private string $apiKey;
    private string $endpoint;

    public function __construct(?string $apiKey = null, ?string $endpoint = null)
    {
        $this->apiKey = trim((string) ($apiKey ?? getenv('LYZR_API_KEY') ?: ''));
        $this->endpoint = rtrim(trim((string) ($endpoint ?? getenv('LYZR_API_URL') ?: 'https://agent-prod.studio.lyzr.ai/v3/inference/chat/')), '/') . '/';
    }

    public function chat(string $agentId, string $message, string $userId, string $sessionId): string
    {
        if ($this->apiKey === '') {
            throw new RuntimeException('LYZR_API_KEY is not configured.');
        }
        if (trim($agentId) === '') {
            throw new RuntimeException('Lyzr agent ID is not configured.');
        }
        $payload = json_encode([
            'user_id' => $userId,
            'agent_id' => $agentId,
            'session_id' => $sessionId,
            'message' => $message,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($payload === false) {
            throw new RuntimeException('Could not encode Lyzr request.');
        }
        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 45,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'x-api-key: ' . $this->apiKey,
            ],
            CURLOPT_POSTFIELDS => $payload,
        ]);
        $raw = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($raw === false || $error !== '') {
            throw new RuntimeException('Lyzr request failed: ' . ($error ?: 'unknown transport error'));
        }
        $decoded = json_decode((string) $raw, true);
        if ($status < 200 || $status >= 300) {
            $detail = is_array($decoded) ? (string) ($decoded['detail'] ?? $decoded['message'] ?? '') : '';
            throw new RuntimeException('Lyzr returned HTTP ' . $status . ($detail !== '' ? ': ' . $detail : '.'));
        }
        if (!is_array($decoded)) {
            throw new RuntimeException('Lyzr returned invalid JSON.');
        }
        $text = $decoded['response']
            ?? $decoded['message']
            ?? $decoded['content']
            ?? ($decoded['data']['response'] ?? null)
            ?? ($decoded['data']['message'] ?? null);
        if (is_array($text)) {
            $text = json_encode($text, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        $text = trim((string) $text);
        if ($text === '') {
            throw new RuntimeException('Lyzr returned an empty response.');
        }
        return $text;
    }
}
