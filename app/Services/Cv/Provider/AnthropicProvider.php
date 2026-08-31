<?php

namespace App\Services\Cv\Provider;

class AnthropicProvider implements AiProviderInterface
{
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->apiKey = trim((string) env('ANTHROPIC_API_KEY', ''));
        $this->model = trim((string) env('ANTHROPIC_CV_MODEL', 'claude-sonnet-4-6'));
    }

    public function name(): string
    {
        return 'anthropic';
    }

    public function configured(): bool
    {
        return $this->apiKey !== '' || $this->lyzr()->configured();
    }

    public function review(string $cvText, array $context = []): array
    {
        if ($this->apiKey === '') {
            if ($this->lyzr()->configured()) {
                return $this->lyzr()->review($cvText, $context);
            }
            throw new \RuntimeException('Anthropic reviewer is not configured.');
        }

        $client = service('curlrequest', ['timeout' => 40]);
        $response = $client->post('https://api.anthropic.com/v1/messages', [
            'headers' => [
                'x-api-key' => $this->apiKey,
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $this->model,
                'max_tokens' => 5000,
                'system' => CvReviewPrompt::system('independent recruiter and devil-s-advocate reviewer'),
                'messages' => [
                    ['role' => 'user', 'content' => CvReviewPrompt::user($cvText, $context)],
                ],
            ],
            'http_errors' => false,
            'timeout' => 40,
        ]);

        $status = $response->getStatusCode();
        $body = json_decode((string) $response->getBody(), true);
        if ($status < 200 || $status >= 300 || !is_array($body)) {
            throw new \RuntimeException('Anthropic review failed with HTTP ' . $status . '.');
        }

        $text = '';
        foreach (($body['content'] ?? []) as $content) {
            if (($content['type'] ?? '') === 'text') {
                $text .= (string) ($content['text'] ?? '');
            }
        }
        if ($text === '') {
            throw new \RuntimeException('Anthropic review returned no text output.');
        }

        $decoded = CvReviewPrompt::decodeJson($text);
        $decoded['reviewer'] = 'anthropic';
        $decoded['usage'] = [
            'via' => 'direct',
            'model' => $body['model'] ?? $this->model,
            'input_tokens' => $body['usage']['input_tokens'] ?? null,
            'output_tokens' => $body['usage']['output_tokens'] ?? null,
        ];

        return $decoded;
    }

    private function lyzr(): LyzrAgentProvider
    {
        $config = LyzrAgentProvider::registry()['claude_critic'] ?? [];
        return new LyzrAgentProvider('claude_critic', is_array($config) ? $config : []);
    }
}
