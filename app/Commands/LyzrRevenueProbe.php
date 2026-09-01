<?php

namespace App\Commands;

use App\Services\Cv\LyzrClient;
use App\Services\Revenue\RevenueCouncilAgentRegistry;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class LyzrRevenueProbe extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'lyzr:revenue-probe';
    protected $description = 'Probe every registered HiredNext Revenue Council agent with a real Lyzr inference call.';

    public function run(array $params)
    {
        $client = new LyzrClient();
        $health = $client->health();
        if (!($health['ok'] ?? false)) {
            throw new \RuntimeException('Lyzr connection failed: ' . ($health['error'] ?? $health['status'] ?? 'unknown error'));
        }

        CLI::write('HIREDNEXT LYZR REVENUE COUNCIL — LIVE PROBE', 'green');
        $registry = new RevenueCouncilAgentRegistry();
        $roles = [
            'signals',
            'contact_intelligence',
            'sales_hunter',
            'mandate_intelligence',
            'candidate_intelligence',
            'candidate_revenue',
            'marketing',
            'operations',
            'commercial_analyst',
            'ceo',
        ];
        $failures = [];

        foreach ($roles as $key) {
            $agentId = $registry->agentId($key);
            if ($agentId === '') {
                $failures[] = $key . ': missing agent ID';
                CLI::write(strtoupper($key) . ': MISSING', 'red');
                continue;
            }

            try {
                $response = $client->chat(
                    $agentId,
                    'hirednext-revenue-probe',
                    'probe-' . $key . '-' . bin2hex(random_bytes(4)),
                    'System health probe only. Do not trigger or claim any external action. Confirm briefly that you understand your HiredNext Revenue Council role, the one-task/one-owner rule, and that Result remains PENDING until execution evidence exists.'
                );
                if ($response === []) {
                    throw new \RuntimeException('empty JSON response');
                }
                CLI::write(strtoupper($key) . ': LIVE', 'green');
            } catch (\Throwable $e) {
                $failures[] = $key . ': ' . mb_substr($e->getMessage(), 0, 180);
                CLI::write(strtoupper($key) . ': FAILED', 'red');
            }
        }

        if ($failures !== []) {
            throw new \RuntimeException('Revenue Council probe failed — ' . implode(' | ', $failures));
        }

        CLI::write('ALL 10 REVENUE COUNCIL AGENTS RESPONDED TO LIVE INFERENCE.', 'green');
        CLI::write('No API keys or response contents were printed.', 'cyan');
    }
}
