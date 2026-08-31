<?php

namespace App\Services\Cv\Provider;

use App\Services\Cv\LyzrClient;

class LyzrAgentProvider implements AiProviderInterface
{
    private string $key;
    private array $config;

    public function __construct(string $key, array $config)
    {
        $this->key = $key;
        $this->config = $config;
    }

    public function name(): string
    {
        return match ($this->key) {
            'openai_recruiter' => 'openai',
            'claude_critic' => 'claude',
            'gemini_rolefit' => 'gemini',
            default => 'lyzr_' . $this->key,
        };
    }

    public function configured(): bool
    {
        return trim((string) ($this->config['agent_id'] ?? '')) !== ''
            && trim((string) env('LYZR_API_KEY', '')) !== '';
    }

    public function review(string $cvText, array $context = []): array
    {
        if (!$this->configured()) {
            throw new \RuntimeException('Lyzr reviewer ' . $this->key . ' is not configured.');
        }

        $agentId = trim((string) $this->config['agent_id']);
        $sessionId = 'hn-cv-' . bin2hex(random_bytes(8));
        $message = CvReviewPrompt::user($cvText, $context) . "\n\nReturn JSON only.";
        $response = (new LyzrClient())->chat(
            $agentId,
            'hirednext-cv-engine',
            $sessionId,
            $message
        );

        $decoded = $this->decodeResponse($response);
        $decoded['reviewer'] = $this->name();
        $decoded['usage'] = [
            'via' => 'lyzr',
            'provider' => $this->config['provider'] ?? 'Lyzr',
            'model' => $this->config['model'] ?? null,
            'agent_id' => $agentId,
        ];
        return $decoded;
    }

    private function decodeResponse(array $response): array
    {
        if (isset($response['summary'], $response['findings']) && is_array($response['findings'])) {
            return $response;
        }

        $candidates = [];
        foreach (['response', 'message', 'output', 'content', 'text', 'answer'] as $key) {
            if (isset($response[$key])) {
                $candidates[] = $response[$key];
            }
        }
        if (isset($response['data']) && is_array($response['data'])) {
            foreach (['response', 'message', 'output', 'content', 'text', 'answer'] as $key) {
                if (isset($response['data'][$key])) {
                    $candidates[] = $response['data'][$key];
                }
            }
        }

        foreach ($candidates as $candidate) {
            if (is_array($candidate) && isset($candidate['summary'], $candidate['findings'])) {
                return $candidate;
            }
            if (is_string($candidate) && trim($candidate) !== '') {
                try {
                    return CvReviewPrompt::decodeJson($candidate);
                } catch (\Throwable $e) {
                    // Try the next supported Lyzr response shape.
                }
            }
        }

        throw new \RuntimeException('Lyzr reviewer returned no usable JSON assessment.');
    }

    public static function registry(): array
    {
        $path = WRITEPATH . 'cv/lyzr-agents.json';
        if (!is_file($path) || !is_readable($path)) {
            return [];
        }
        $decoded = json_decode((string) file_get_contents($path), true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function providers(): array
    {
        $registry = self::registry();
        $ordered = ['openai_recruiter', 'claude_critic', 'gemini_rolefit'];
        $out = [];
        foreach ($ordered as $key) {
            $config = $registry[$key] ?? null;
            if (is_array($config) && !empty($config['agent_id'])) {
                $out[] = new self($key, $config);
            }
        }
        return $out;
    }
}
