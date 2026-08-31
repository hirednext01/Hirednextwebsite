<?php

namespace App\Commands;

use App\Services\Cv\LyzrClient;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class LyzrCvSetup extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'lyzr:cv-setup';
    protected $description = 'Create/update the HiredNext CV reviewer-agent registry in Lyzr without displaying the API key.';

    public function run(array $params)
    {
        $client = new LyzrClient();
        $health = $client->health();
        if (!($health['ok'] ?? false)) {
            CLI::error('Lyzr connection failed: ' . ($health['error'] ?? $health['status'] ?? 'unknown error'));
            return;
        }
        CLI::write('Lyzr API connection: READY', 'green');

        $registry = $this->loadRegistry();
        $definitions = [
            'openai_recruiter' => [
                'name' => 'HiredNext CV — Recruiter & ATS Reviewer',
                'provider_id' => env('LYZR_CV_OPENAI_PROVIDER', 'OpenAI'),
                'model' => env('LYZR_CV_OPENAI_MODEL', 'gpt-4o-mini'),
                'role' => 'independent recruiter and ATS reviewer',
            ],
            'claude_critic' => [
                'name' => 'HiredNext CV — Critical Career Reviewer',
                'provider_id' => env('LYZR_CV_CLAUDE_PROVIDER', 'Anthropic'),
                'model' => env('LYZR_CV_CLAUDE_MODEL', 'claude-sonnet-4-6'),
                'role' => 'critical career reviewer and devil advocate',
            ],
            'gemini_rolefit' => [
                'name' => 'HiredNext CV — Role Fit Reviewer',
                'provider_id' => env('LYZR_CV_GEMINI_PROVIDER', 'Google'),
                'model' => env('LYZR_CV_GEMINI_MODEL', 'gemini-2.5-flash'),
                'role' => 'role-fit, terminology and capability-evidence reviewer',
            ],
        ];

        foreach ($definitions as $key => $definition) {
            if (!empty($registry[$key]['agent_id'])) {
                CLI::write(strtoupper($key) . ': ALREADY REGISTERED (' . $registry[$key]['agent_id'] . ')', 'cyan');
                continue;
            }
            try {
                $created = $client->createAgent([
                    'name' => $definition['name'],
                    'system_prompt' => $this->systemPrompt($definition['role']),
                    'description' => 'Internal HiredNext CV reviewer. Candidate-facing output is produced separately by HiredNext.',
                    'features' => [],
                    'tools' => [],
                    'provider_id' => (string) $definition['provider_id'],
                    'model' => (string) $definition['model'],
                    'top_p' => 0.2,
                    'temperature' => 0.1,
                    'response_format' => new \stdClass(),
                ]);
                $agentId = (string) ($created['agent_id'] ?? $created['id'] ?? '');
                if ($agentId === '') {
                    throw new \RuntimeException('Agent was created but no agent ID was returned.');
                }
                $registry[$key] = [
                    'agent_id' => $agentId,
                    'provider' => (string) $definition['provider_id'],
                    'model' => (string) $definition['model'],
                    'role' => $definition['role'],
                    'created_at' => date(DATE_ATOM),
                ];
                $this->saveRegistry($registry);
                CLI::write(strtoupper($key) . ': CREATED (' . $agentId . ')', 'green');
            } catch (\Throwable $e) {
                CLI::write(strtoupper($key) . ': NOT CREATED — ' . mb_substr($e->getMessage(), 0, 240), 'yellow');
            }
        }

        CLI::write('Registry: ' . $this->registryPath(), 'cyan');
        CLI::write('No API key was printed.', 'cyan');
    }

    private function systemPrompt(string $role): string
    {
        return 'You are an internal HiredNext ' . $role . '. Assess only what is evidenced in the CV text. Never invent employers, dates, metrics, team sizes, qualifications, skills or achievements. "Not shown in the CV" must never be treated as proof that the candidate lacks the capability. Return JSON only with keys summary, scores, strengths, findings. findings must be an array of objects with category, finding, evidence, why_it_matters, severity (low|medium|high), recommendation. Write precise professional recruiter analysis, not generic AI advice.';
    }

    private function registryPath(): string
    {
        return WRITEPATH . 'cv/lyzr-agents.json';
    }

    private function loadRegistry(): array
    {
        $path = $this->registryPath();
        if (!is_file($path)) {
            return [];
        }
        $decoded = json_decode((string) file_get_contents($path), true);
        return is_array($decoded) ? $decoded : [];
    }

    private function saveRegistry(array $registry): void
    {
        $path = $this->registryPath();
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
        }
        file_put_contents($path, json_encode($registry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        @chmod($path, 0640);
    }
}
