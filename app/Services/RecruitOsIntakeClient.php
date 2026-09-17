<?php

namespace App\Services;

use RuntimeException;

final class RecruitOsIntakeClient
{
    private string $ingestUrl;
    private string $apiKey;
    private $transport;

    public function __construct(?string $ingestUrl = null, ?string $apiKey = null, ?callable $transport = null)
    {
        $this->ingestUrl = trim((string) ($ingestUrl ?? getenv('RECRUIT_OS_INGEST_URL')));
        $this->apiKey = trim((string) ($apiKey ?? getenv('RECRUIT_OS_INGEST_API_KEY')));
        $this->transport = $transport;

        if (!filter_var($this->ingestUrl, FILTER_VALIDATE_URL)
            || parse_url($this->ingestUrl, PHP_URL_SCHEME) !== 'https') {
            throw new RuntimeException('Recruit OS intake URL is not configured securely.');
        }
        if ($this->apiKey === '') {
            throw new RuntimeException('Recruit OS intake key is not configured.');
        }
    }

    public function submit(string $filePath, string $originalName, string $mimeType, array $metadata): array
    {
        if (!is_file($filePath) || !is_readable($filePath)) {
            throw new RuntimeException('The temporary CV upload is unavailable.');
        }

        $response = $this->request('POST', $this->ingestUrl, [
            'headers' => ['X-Api-Key' => $this->apiKey],
            'file_path' => $filePath,
            'file_name' => $this->safeFileName($originalName),
            'mime_type' => $mimeType,
            'metadata' => json_encode($metadata, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
        ]);
        $payload = $this->decode($response);

        foreach (['receipt_id', 'candidate_id', 'document_id'] as $field) {
            if (!is_string($payload[$field] ?? null) || trim($payload[$field]) === '') {
                throw new RuntimeException('Recruit OS did not return a durable intake receipt.');
            }
        }
        if (!in_array($payload['status'] ?? null, ['stored', 'duplicate'], true)) {
            throw new RuntimeException('Recruit OS did not acknowledge the CV.');
        }
        if (!empty($metadata['job_code']) && !empty($metadata['identity_verified'])
            && (!is_string($payload['application_id'] ?? null) || trim($payload['application_id']) === '')) {
            throw new RuntimeException('Recruit OS did not attach the application to the mapped job.');
        }

        return $payload;
    }

    public function applicationCount(string $jobCode): ?int
    {
        if (!preg_match('/^[A-Z0-9][A-Z0-9-]{1,19}$/', $jobCode)) {
            return null;
        }
        $countUrl = preg_replace('#/resumes/?$#', '/jobs/' . rawurlencode($jobCode) . '/application-count', $this->ingestUrl);
        if (!is_string($countUrl) || $countUrl === $this->ingestUrl) {
            return null;
        }

        try {
            $payload = $this->decode($this->request('GET', $countUrl, ['headers' => []]));
        } catch (RuntimeException $e) {
            return null;
        }
        $count = $payload['application_count'] ?? null;
        return is_int($count) && $count >= 0 ? $count : null;
    }

    private function request(string $method, string $url, array $options): array
    {
        if ($this->transport) {
            return ($this->transport)($method, $url, $options);
        }
        if (!function_exists('curl_init')) {
            throw new RuntimeException('Secure Recruit OS transfer is unavailable.');
        }

        $handle = curl_init($url);
        $headers = ['Accept: application/json'];
        foreach (($options['headers'] ?? []) as $name => $value) {
            $headers[] = $name . ': ' . $value;
        }
        $curlOptions = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 45,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_USERAGENT => 'HiredNext-Website-CV-Intake/1.0',
        ];
        if ($method === 'POST') {
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = [
                'file' => new \CURLFile($options['file_path'], $options['mime_type'], $options['file_name']),
                'metadata' => $options['metadata'],
            ];
        }
        curl_setopt_array($handle, $curlOptions);
        $body = curl_exec($handle);
        if ($body === false) {
            $error = curl_error($handle);
            curl_close($handle);
            throw new RuntimeException('Recruit OS transfer failed: ' . $error);
        }
        $status = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        curl_close($handle);
        return ['status' => $status, 'body' => $body];
    }

    private function decode(array $response): array
    {
        $status = (int) ($response['status'] ?? 0);
        if ($status < 200 || $status >= 300) {
            throw new RuntimeException('Recruit OS rejected the application.');
        }
        try {
            $payload = json_decode((string) ($response['body'] ?? ''), true, 32, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new RuntimeException('Recruit OS returned an invalid response.');
        }
        if (!is_array($payload)) {
            throw new RuntimeException('Recruit OS returned an invalid response.');
        }
        return $payload;
    }

    private function safeFileName(string $name): string
    {
        $name = basename(str_replace('\\', '/', $name));
        $name = preg_replace('/[^A-Za-z0-9._ -]+/', '_', $name) ?: 'resume';
        return substr($name, 0, 255);
    }
}
