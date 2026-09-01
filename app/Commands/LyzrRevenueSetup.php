<?php

namespace App\Commands;

use App\Services\Cv\LyzrClient;
use App\Services\Revenue\RevenueCouncilAgentRegistry;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class LyzrRevenueSetup extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'lyzr:revenue-setup';
    protected $description = 'Create and register the HiredNext Lyzr Revenue Council without duplicating existing agents.';

    public function run(array $params)
    {
        $client = new LyzrClient();
        $health = $client->health();
        if (!($health['ok'] ?? false)) {
            CLI::error('Lyzr connection failed: ' . ($health['error'] ?? $health['status'] ?? 'unknown error'));
            return;
        }
        CLI::write('Lyzr API connection: READY', 'green');

        $registry = new RevenueCouncilAgentRegistry();
        foreach ($this->definitions() as $key => $definition) {
            $existing = $registry->agentId($key);
            if ($existing !== '') {
                CLI::write(strtoupper($key) . ': ALREADY REGISTERED (' . $existing . ')', 'cyan');
                continue;
            }

            try {
                $created = $client->createAgent([
                    'name' => $definition['name'],
                    'system_prompt' => $this->systemPrompt($key, $definition['role'], $definition['mission']),
                    'description' => $definition['description'],
                    'features' => [],
                    'tools' => [],
                    'provider_id' => (string) env('LYZR_REVENUE_PROVIDER', 'OpenAI'),
                    'model' => (string) env('LYZR_REVENUE_MODEL', 'gpt-4o-mini'),
                    'top_p' => 0.2,
                    'temperature' => 0.1,
                    'response_format' => new \stdClass(),
                ]);
                $agentId = trim((string) ($created['agent_id'] ?? $created['id'] ?? ''));
                if ($agentId === '') {
                    throw new \RuntimeException('Agent was created but no agent ID was returned.');
                }
                $registry->upsert($key, [
                    'agent_id' => $agentId,
                    'name' => $definition['name'],
                    'role' => $definition['role'],
                    'provider' => (string) env('LYZR_REVENUE_PROVIDER', 'OpenAI'),
                    'model' => (string) env('LYZR_REVENUE_MODEL', 'gpt-4o-mini'),
                    'created_at' => date(DATE_ATOM),
                ]);
                CLI::write(strtoupper($key) . ': CREATED (' . $agentId . ')', 'green');
            } catch (\Throwable $e) {
                CLI::write(strtoupper($key) . ': NOT CREATED — ' . mb_substr($e->getMessage(), 0, 240), 'yellow');
            }
        }

        CLI::write('Registry: ' . $registry->path(), 'cyan');
        CLI::write('No API key was printed.', 'cyan');
    }

    private function definitions(): array
    {
        return [
            'signals' => [
                'name' => 'HiredNext Revenue Council — Signals',
                'role' => 'Signals Agent',
                'mission' => 'Find high-value commercial triggers: funding, GCC setups, acquisitions, leadership changes, plants, stores, offices, IPO preparation and hiring spikes. Produce qualified signals only; never send outreach.',
                'description' => 'Internal HiredNext commercial signal intelligence.',
            ],
            'contact_intelligence' => [
                'name' => 'HiredNext Revenue Council — Contact Intelligence',
                'role' => 'Contact & Account Intelligence Agent',
                'mission' => 'Fill missing company and decision-maker intelligence for qualified opportunities. Do not send emails, LinkedIn messages or other outreach.',
                'description' => 'Internal HiredNext account and buyer intelligence.',
            ],
            'sales_hunter' => [
                'name' => 'HiredNext Revenue Council — Sales Hunter',
                'role' => 'Sales Hunter',
                'mission' => 'Turn qualified unlocked opportunities into specific commercial approaches that lead to client conversations, founder meetings and recruitment mandates. Hand sending to the canonical execution workflow.',
                'description' => 'Internal HiredNext client-revenue sales strategist.',
            ],
            'mandate_intelligence' => [
                'name' => 'HiredNext Revenue Council — Mandate Intelligence',
                'role' => 'Mandate Intelligence Agent',
                'mission' => 'Convert a client requirement or JD into non-negotiables, search strategy, target companies, risk flags and mandate intelligence. Do not duplicate recruiter-owned work.',
                'description' => 'Internal HiredNext mandate search intelligence.',
            ],
            'candidate_intelligence' => [
                'name' => 'HiredNext Revenue Council — Candidate Intelligence',
                'role' => 'Candidate Intelligence Agent',
                'mission' => 'Work only against active mandates. Rank candidates using evidenced fit, gaps and role requirements, producing Top 5 or Top 10 recommendations without contacting recruiter-owned candidates.',
                'description' => 'Internal HiredNext candidate-to-mandate intelligence.',
            ],
            'candidate_revenue' => [
                'name' => 'HiredNext Revenue Council — Candidate Revenue',
                'role' => 'Candidate Revenue Agent',
                'mission' => 'Grow paid candidate services, with ₹599 Priority CV Assessment as the primary high-volume entry product, followed only when appropriate by ₹999 ATS optimisation, ₹1,799 done-for-you CV rebuild and ₹4,500 consultation. Target at least 20 paid ₹599 signups and protect standalone value.',
                'description' => 'Internal HiredNext candidate-services revenue owner.',
            ],
            'marketing' => [
                'name' => 'HiredNext Revenue Council — Marketing',
                'role' => 'Marketing Agent',
                'mission' => 'Create authority and inbound campaigns tied to real commercial opportunities and HiredNext evidence. Avoid generic posting and vanity activity.',
                'description' => 'Internal HiredNext opportunity-led growth marketing.',
            ],
            'operations' => [
                'name' => 'HiredNext Revenue Council — Operations',
                'role' => 'Operations Agent',
                'mission' => 'Identify revenue leakage, overdue actions, failed automation, unpaid or unverified services, stalled fulfilment and missing next actions. Escalate exceptions; do not create duplicate workflows.',
                'description' => 'Internal HiredNext revenue operations control.',
            ],
            'commercial_analyst' => [
                'name' => 'HiredNext Revenue Council — Commercial Analyst',
                'role' => 'Commercial Analyst',
                'mission' => 'Challenge expected revenue, probability, effort, cost and opportunity cost before HiredNext spends time or credits. Reject low-return activity.',
                'description' => 'Internal HiredNext commercial ROI challenger.',
            ],
            'ceo' => [
                'name' => 'HiredNext Revenue Council — CEO Strategist',
                'role' => 'CEO / Revenue Strategist',
                'mission' => 'Prioritise opportunities across client mandates and candidate services, allocate one owner, resolve conflicts, kill weak initiatives and drive measurable revenue. You decide; you do not bypass ownership or execution controls.',
                'description' => 'Internal HiredNext Revenue Council prioritisation and decision agent.',
            ],
        ];
    }

    private function systemPrompt(string $key, string $role, string $mission): string
    {
        return "You are the HiredNext {$role}. {$mission}\n\n"
            . "Operating rule: one task -> one owner -> one source record -> one next action. Before proposing work, require or infer where possible: entity_key, owner, status, last_action, next_action, lock_until. If another recruiter, Lyzr agent, ChatGPT process or n8n workflow owns the task, output SKIP_LOCKED and do not duplicate it.\n\n"
            . "Architecture boundaries: HiredNext ATS/site/database is the source of truth. Lyzr is intelligence and decision-making. Existing canonical n8n workflows own execution where already assigned. Slack is the visible command centre, not a database. Do not claim an email, meeting, payment, outreach or follow-up occurred unless an execution result confirms it.\n\n"
            . "Every commercial proposal must contain exactly these labelled fields: Opportunity; Evidence; Estimated Revenue; Probability; Action; Owner; Deadline; Result. Result must be PENDING until execution evidence exists. Keep discussion short and terminate in a decision, task, experiment, SKIP_LOCKED or explicit rejection.\n\n"
            . "Never invent facts, contacts, mandates, candidates, payments, meetings, replies or company events. Missing evidence must be stated as missing. Internal role key: {$key}.";
    }
}
