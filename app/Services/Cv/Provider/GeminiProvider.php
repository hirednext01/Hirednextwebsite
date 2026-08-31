<?php

namespace App\Services\Cv\Provider;

class GeminiProvider implements AiProviderInterface
{
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->apiKey = trim((string) (getenv('GEMINI_API_KEY') ?: ''));
        $this->model = trim((string) (getenv('GEMINI_CV_MODEL') ?: 'gemini-3.7-flash'));
    }

    public function name(): string
    {
        return 'gemini';
    }

    public function configured(): bool
    {
        return $this->apiKey !== '';
    }

    public function review(string $cvText, array $context = []): array
    {
        if (!$this->configured()) {
            throw new \RuntimeException('Gemini is not configured.');
        }

        $client = service('curlrequest', ['timeout' => 40]);
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($this->model) . ':generateContent';
        $response = $client->post($url, [
            'headers' => [
                'x-goog-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'systemInstruction' => [
                    'parts' => [['text' => CvReviewPrompt::system('independent ATS, recruiter and leadership reviewer')]],
                ],
                'contents' => [[
                    'role' => 'user',
                    'parts' => [['text' => CvReviewPrompt::user($cvText, $context)]],
                ]],
                'generationConfig' => [
                    'temperature' => 0.2,
                    'maxOutputTokens' => 5000,
                    'responseMimeType' => 'application/json',
                ],
            ],
            'http_errors' => false,
            'timeout' => 40,
        ]);

        $status = $response->getStatusCode();
        $body = json_decode((string) $response->getBody(), true);
        if ($status < 200 || $status >= 300 || !is_array($body)) {
            throw new \RuntimeException('Gemini review failed with HTTP ' . $status . '.');
        }

        $text = '';
        foreach (($body['candidates'][0]['content']['parts'] ?? []) as $part) {
            $text .= (string) ($part['text'] ?? '');
        }
        if ($text === '') {
            $blocked = $body['promptFeedback']['blockReason'] ?? null;
            throw new \RuntimeException($blocked ? 'Gemini review was blocked: ' . $blocked : 'Gemini review returned no text output.');
        }

        $decoded = CvReviewPrompt::decodeJson($text);
        $decoded['reviewer'] = 'gemini';
        $decoded['usage'] = [
            'model' => $body['modelVersion'] ?? $this->model,
            'input_tokens' => $body['usageMetadata']['promptTokenCount'] ?? null,
            'output_tokens' => $body['usageMetadata']['candidatesTokenCount'] ?? null,
        ];

        return $decoded;
    }
}
