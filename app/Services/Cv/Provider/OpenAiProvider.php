<?php

namespace App\Services\Cv\Provider;

class OpenAiProvider implements AiProviderInterface
{
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->apiKey = trim((string) env('OPENAI_API_KEY', ''));
        $this->model = trim((string) env('OPENAI_CV_MODEL', 'gpt-5.6-luna'));
    }

    public function name(): string
    {
        return 'openai';
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
            throw new \RuntimeException('OpenAI reviewer is not configured.');
        }

        $client = service('curlrequest', ['timeout' => 40]);
        $response = $client->post('https://api.openai.com/v1/responses', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $this->model,
                'instructions' => CvReviewPrompt::system('independent recruiter, ATS and evidence reviewer'),
                'input' => CvReviewPrompt::user($cvText, $context),
                'max_output_tokens' => 5000,
                'store' => false,
            ],
            'http_errors' => false,
            'timeout' => 40,
        ]);

        $status = $response->getStatusCode();
        $body = json_decode((string) $response->getBody(), true);
        if ($status < 200 || $status >= 300 || !is_array($body)) {
            throw new \RuntimeException('OpenAI review failed with HTTP ' . $status . '.');
        }

        $text = (string) ($body['output_text'] ?? '');
        if ($text === '' && isset($body['output']) && is_array($body['output'])) {
            foreach ($body['output'] as $item) {
                foreach (($item['content'] ?? []) as $content) {
                    if (($content['type'] ?? '') === 'output_text' && isset($content['text'])) {
                        $text .= (string) $content['text'];
                    }
                }
            }
        }

        if ($text === '') {
            throw new \RuntimeException('OpenAI review returned no text output.');
        }

        $decoded = CvReviewPrompt::decodeJson($text);
        $decoded['reviewer'] = 'openai';
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
        $config = LyzrAgentProvider::registry()['openai_recruiter'] ?? [];
        return new LyzrAgentProvider('openai_recruiter', is_array($config) ? $config : []);
    }
}
