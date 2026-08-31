<?php

namespace App\Services\Cv;

class OpenAiCvFileExtractor
{
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->apiKey = trim((string) (getenv('OPENAI_API_KEY') ?: ''));
        $this->model = trim((string) (getenv('OPENAI_CV_MODEL') ?: 'gpt-5.6-luna'));
    }

    public function configured(): bool
    {
        return $this->apiKey !== '' && function_exists('curl_init');
    }

    public function extract(string $path): string
    {
        if (!$this->configured()) {
            throw new \RuntimeException('OpenAI CV file extraction is not configured.');
        }
        if (!is_file($path) || !is_readable($path)) {
            throw new \RuntimeException('CV file is missing or unreadable.');
        }

        $fileId = null;
        try {
            $fileId = $this->upload($path);
            $body = $this->jsonRequest('POST', 'https://api.openai.com/v1/responses', [
                'model' => $this->model,
                'instructions' => 'Extract the CV text faithfully. Do not summarise, embellish, infer or rewrite. Preserve employer names, job titles, dates, locations, education, certifications, skills, achievements and numbers exactly as stated. Preserve useful section breaks. Return plain text only.',
                'input' => [[
                    'role' => 'user',
                    'content' => [
                        ['type' => 'input_text', 'text' => 'Extract all readable text from this CV. This text will be used for a recruiter assessment, so factual fidelity is more important than style.'],
                        ['type' => 'input_file', 'file_id' => $fileId, 'detail' => 'auto'],
                    ],
                ]],
                'reasoning' => ['effort' => 'low'],
                'max_output_tokens' => 16000,
                'store' => false,
            ]);

            $text = trim((string) ($body['output_text'] ?? ''));
            if ($text === '' && isset($body['output']) && is_array($body['output'])) {
                foreach ($body['output'] as $item) {
                    foreach (($item['content'] ?? []) as $content) {
                        if (($content['type'] ?? '') === 'output_text' && isset($content['text'])) {
                            $text .= (string) $content['text'];
                        }
                    }
                }
                $text = trim($text);
            }

            if (mb_strlen($text) < 120) {
                throw new \RuntimeException('OpenAI could not extract enough readable CV text.');
            }

            return $text;
        } finally {
            if ($fileId) {
                $this->deleteFile($fileId);
            }
        }
    }

    private function upload(string $path): string
    {
        $mime = function_exists('mime_content_type') ? (string) (mime_content_type($path) ?: 'application/octet-stream') : 'application/octet-stream';
        $curlFile = new \CURLFile($path, $mime, basename($path));

        $ch = curl_init('https://api.openai.com/v1/files');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $this->apiKey],
            CURLOPT_POSTFIELDS => ['purpose' => 'user_data', 'file' => $curlFile],
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 60,
        ]);
        $raw = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($raw === false || $status < 200 || $status >= 300) {
            throw new \RuntimeException('OpenAI file upload failed' . ($status ? ' with HTTP ' . $status : '') . ($error ? ': ' . $error : '.'));
        }
        $body = json_decode((string) $raw, true);
        $id = is_array($body) ? trim((string) ($body['id'] ?? '')) : '';
        if ($id === '') {
            throw new \RuntimeException('OpenAI file upload did not return a file ID.');
        }
        return $id;
    }

    private function jsonRequest(string $method, string $url, array $payload): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 90,
        ]);
        $raw = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        $body = json_decode((string) $raw, true);
        if ($raw === false || $status < 200 || $status >= 300 || !is_array($body)) {
            $apiMessage = is_array($body) ? trim((string) ($body['error']['message'] ?? '')) : '';
            throw new \RuntimeException('OpenAI CV extraction failed with HTTP ' . $status . ($apiMessage ? ': ' . $apiMessage : ($error ? ': ' . $error : '.')));
        }
        return $body;
    }

    private function deleteFile(string $fileId): void
    {
        $ch = curl_init('https://api.openai.com/v1/files/' . rawurlencode($fileId));
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $this->apiKey],
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
        ]);
        @curl_exec($ch);
        curl_close($ch);
    }
}
