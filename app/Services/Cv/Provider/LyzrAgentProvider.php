<?php

namespace App\Services\Cv\Provider;

use App\Services\Cv\CvReviewPrompt;
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
        return 'lyzr_' . $this->key;
    }

    public function configured(): bool
    {
        return trim((string) ($this->config['agent_id'] ?? '')) !== '' && trim((string) env('LYZR_API_KEY', '')) !== '';
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
            'hirednext-cv-agent@hirednext.info',
            $sessionId,
            $message
        );

        $text = trim((string) ($response['response'] ?? ''));
        if ($text === '') {
            throw new \RuntimeException('Lyzr reviewer returned no response text.');
        }
        $decoded = CvReviewPrompt::decodeJson($text);
        $decoded['reviewer'] = $this->name();
        $decoded['usage'] = [
            'provider' => $this->config['provider'] ?? 'Lyzr',
            'model' => $this->config['model'] ?? null,
            'agent_id' => $agentId,
        ];
        return $decoded;
    }

    public static function registry(): array
    {
        $path = WRITEPATH . 'cv/lyzr-agents.json';
        if (!is_file($path)) {
            return [];
        }
        $decoded = json_decode((string) file_get_contents($path), true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function providers(): array
    {
        $out = [];
        foreach (self::registry() as $key => $config) {
            if (is_array($config) && !empty($config['agent_id'])) {
                $out[] = new self((string) $key, $config);
            }
        }
        return $out;
    }
}
