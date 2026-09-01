<?php

namespace App\Services\Revenue;

use App\Services\Cv\Provider\LyzrAgentProvider;

class RevenueCouncilRouter
{
    public function agentsFor(string $text): array
    {
        $text = strtolower($text);
        $isCv = preg_match('/\b(cv|resume|candidate|ats|599|assessment)\b/', $text) === 1;
        if ($isCv) {
            $registry = LyzrAgentProvider::registry();
            $cvAgents = [];
            foreach ([
                'openai_recruiter' => 'OpenAI Recruiter / ATS Reviewer',
                'claude_critic' => 'Claude Critical Career Reviewer',
                'gemini_rolefit' => 'Gemini Role-Fit Reviewer',
            ] as $key => $label) {
                $agentId = trim((string) ($registry[$key]['agent_id'] ?? ''));
                if ($agentId !== '') {
                    $cvAgents[] = ['label' => $label, 'agent_id' => $agentId];
                }
            }
            if ($cvAgents !== []) {
                return $cvAgents;
            }
            return $this->fromEnv('Candidate Revenue', 'LYZR_CANDIDATE_REVENUE_AGENT_ID');
        }

        $isSignal = preg_match('/\b(funding|funded|gcc|semiconductor|expansion|plant|office|leadership|ipo|signal)\b/', $text) === 1;
        if ($isSignal) {
            $signal = $this->fromEnv('Signals', 'LYZR_SIGNALS_AGENT_ID');
            if ($signal !== []) {
                return $signal;
            }
        }

        return $this->fromEnv('CEO / Revenue Strategist', 'LYZR_REVENUE_CEO_AGENT_ID');
    }

    private function fromEnv(string $label, string $key): array
    {
        $id = trim((string) env($key, ''));
        return $id === '' ? [] : [['label' => $label, 'agent_id' => $id]];
    }
}
