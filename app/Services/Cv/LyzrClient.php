<?php

namespace App\Services\Cv;

class LyzrClient
{
    private string $baseUrl = 'https://agent-prod.studio.lyzr.ai';

    public function configured(): bool
    {
        return trim((string) env('LYZR_API_KEY', '')) !== '';
    }

    public function health(): array
    {
        if (!$this->configured()) {
            return ['ok' => false, 'status' => 'not_configured', 'http' => null];
        }
        try {
            $response = $this->request('GET', '/v3/semantic_model/documentation_agents');
            return ['ok' => true, 'status' => 'connected', 'http' => $response['http'] ?? 200];
        } catch (\Throwable $e) {
            return ['ok' => false, 'status' => 'connection_failed', 'http' => null, 'error' => mb_substr($e->getMessage(), 0, 300)];
        }
    }

    public function createAgent(array $payload): array
    {
        return $this->request('POST', '/v3/agents/', $payload)['json'];
    }

    public function chat(string $agentId, string $userId, string $sessionId, string $message): array
    {
        $result = $this->request('POST', '/v3/inference/chat/', [
            'user_id' => $userId,
            'agent_id' => $agentId,
            'session_id' => $sessionId,
            'message' => $message,
            'system_prompt_variables' => new \stdClass(),
            'filter_variables' => new \stdClass(),
            'features' => [],
        ]);
        return $result['json'];
    }

    private function request(string $method, string $path, ?array $payload = null): array
    {
        $key = trim((string) env('LYZR_API_KEY', ''));
        if ($key === '') {
            throw new \RuntimeException('LYZR_API_KEY is not configured.');
        }
        if (!function_exists('curl_init')) {
            throw new \RuntimeException('PHP cURL is required for the Lyzr integration.');
        }

        $curl = curl_init($this->baseUrl . $path);
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'x-api-key: ' . $key,
        ];
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 12,
            CURLOPT_TIMEOUT => 75,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
        ]);
        if ($payload !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        }
        $body = curl_exec($curl);
        $error = curl_error($curl);
        $http = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($body === false || $error !== '') {
            throw new \RuntimeException('Lyzr network error: ' . ($error ?: 'unknown transport error'));
        }
        $json = json_decode((string) $body, true);
        if ($http < 200 || $http >= 300) {
            $detail = is_array($json) ? ($json['detail'] ?? $json['message'] ?? $json['error'] ?? '') : '';
            throw new \RuntimeException('Lyzr API returned HTTP ' . $http . ($detail !== '' ? ': ' . (is_string($detail) ? $detail : json_encode($detail)) : ''));
        }
        if (!is_array($json)) {
            throw new \RuntimeException('Lyzr returned a non-JSON response.');
        }
        return ['http' => $http, 'json' => $json];
    }
}
