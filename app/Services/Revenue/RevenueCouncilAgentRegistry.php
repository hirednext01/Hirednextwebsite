<?php

namespace App\Services\Revenue;

class RevenueCouncilAgentRegistry
{
    public function path(): string
    {
        return WRITEPATH . 'revenue/lyzr-agents.json';
    }

    public function all(): array
    {
        $path = $this->path();
        if (!is_file($path) || !is_readable($path)) {
            return [];
        }
        $decoded = json_decode((string) file_get_contents($path), true);
        return is_array($decoded) ? $decoded : [];
    }

    public function get(string $key): ?array
    {
        $entry = $this->all()[$key] ?? null;
        return is_array($entry) ? $entry : null;
    }

    public function agentId(string $key): string
    {
        return trim((string) (($this->get($key)['agent_id'] ?? '')));
    }

    public function upsert(string $key, array $entry): void
    {
        $registry = $this->all();
        $registry[$key] = $entry;
        $path = $this->path();
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
        }
        file_put_contents($path, json_encode($registry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX);
        @chmod($path, 0640);
    }
}
