<?php

namespace App\Services\Revenue;

use App\Services\Cv\Provider\LyzrAgentProvider;

class RevenueCouncilRouter
{
    public function agentsFor(string $text): array
    {
        $text = strtolower($text);

        $isCandidateRevenue = preg_match('/\b(599|signup|signups|checkout|conversion|candidate revenue|paid assessment|sales)\b/', $text) === 1;
        if ($isCandidateRevenue) {
            $candidateRevenue = $this->fromEnv('Candidate Revenue', 'LYZR_CANDIDATE_REVENUE_AGENT_ID');
            if ($candidateRevenue !== []) {
                return $candidateRevenue;
            }
        }

        $mentionsCv = preg_match('/\b(cv|resume)\b/', $text) === 1;
        $asksForReview = preg_match('/\b(review|assess|assessment|ats|analyse|analyze|score)\b/', $text) === 1;
        if ($mentionsCv && $asksForReview) {
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
