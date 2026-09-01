<?php

namespace App\Services\Revenue;

class RevenueCouncilRouter
{
    public function agentsFor(string $text): array
    {
        $text = strtolower($text);
        $isCv = preg_match('/\b(cv|resume|candidate|ats|599|assessment)\b/', $text) === 1;
        if ($isCv) {
            $cvAgents = $this->configured([
                ['label' => 'OpenAI Recruiter / ATS Reviewer', 'env' => 'LYZR_CV_OPENAI_AGENT_ID'],
                ['label' => 'Claude Critical Career Reviewer', 'env' => 'LYZR_CV_CLAUDE_AGENT_ID'],
                ['label' => 'Gemini Role-Fit Reviewer', 'env' => 'LYZR_CV_GEMINI_AGENT_ID'],
            ]);
            if ($cvAgents !== []) {
                return $cvAgents;
            }
            return $this->configured([
                ['label' => 'Candidate Revenue', 'env' => 'LYZR_CANDIDATE_REVENUE_AGENT_ID'],
            ]);
        }

        $isSignal = preg_match('/\b(funding|funded|gcc|semiconductor|expansion|plant|office|leadership|ipo|signal)\b/', $text) === 1;
        if ($isSignal) {
            $signal = $this->configured([
                ['label' => 'Signals', 'env' => 'LYZR_SIGNALS_AGENT_ID'],
            ]);
            if ($signal !== []) {
                return $signal;
            }
        }

        return $this->configured([
            ['label' => 'CEO / Revenue Strategist', 'env' => 'LYZR_REVENUE_CEO_AGENT_ID'],
        ]);
    }

    private function configured(array $definitions): array
    {
        $out = [];
        foreach ($definitions as $definition) {
            $id = trim((string) (getenv($definition['env']) ?: ''));
            if ($id !== '') {
                $out[] = ['label' => $definition['label'], 'agent_id' => $id];
            }
        }
        return $out;
    }
}
