<?php

namespace App\Services\Revenue;

use App\Services\Cv\Provider\LyzrAgentProvider;

class RevenueCouncilRouter
{
    public function agentsFor(string $text): array
    {
        $text = strtolower($text);

        if (preg_match('/\b(599|signup|signups|checkout|conversion|candidate revenue|paid assessment|career service|cv service)\b/', $text) === 1) {
            return $this->role('candidate_revenue', 'Candidate Revenue', 'LYZR_CANDIDATE_REVENUE_AGENT_ID');
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

        if (preg_match('/\b(funding|funded|gcc|semiconductor|expansion|plant|office|leadership|ipo|signal|acquisition|store opening)\b/', $text) === 1) {
            return $this->role('signals', 'Signals', 'LYZR_SIGNALS_AGENT_ID');
        }
        if (preg_match('/\b(contact|decision maker|decision-maker|buyer|account intelligence|enrich|email address)\b/', $text) === 1) {
            return $this->role('contact_intelligence', 'Contact & Account Intelligence');
        }
        if (preg_match('/\b(client|business|outreach|pitch|meeting|mandate|revenue from client|sales hunter)\b/', $text) === 1) {
            return $this->role('sales_hunter', 'Sales Hunter');
        }
        if (preg_match('/\b(jd|job description|search strategy|non-negotiable|target companies|mandate intelligence)\b/', $text) === 1) {
            return $this->role('mandate_intelligence', 'Mandate Intelligence');
        }
        if (preg_match('/\b(shortlist|top 5|top 10|candidate fit|fit percentage|candidate intelligence)\b/', $text) === 1) {
            return $this->role('candidate_intelligence', 'Candidate Intelligence');
        }
        if (preg_match('/\b(marketing|campaign|linkedin|content|inbound|authority)\b/', $text) === 1) {
            return $this->role('marketing', 'Marketing');
        }
        if (preg_match('/\b(overdue|failed|failure|stalled|unpaid|unverified|operations|leakage|fulfilment|fulfillment)\b/', $text) === 1) {
            return $this->role('operations', 'Operations');
        }
        if (preg_match('/\b(roi|probability|commercial analyst|expected revenue|effort|cost|worth it)\b/', $text) === 1) {
            return $this->role('commercial_analyst', 'Commercial Analyst');
        }

        return $this->role('ceo', 'CEO / Revenue Strategist', 'LYZR_REVENUE_CEO_AGENT_ID');
    }

    private function role(string $key, string $label, ?string $envKey = null): array
    {
        $id = (new RevenueCouncilAgentRegistry())->agentId($key);
        if ($id === '' && $envKey !== null) {
            $id = trim((string) env($envKey, ''));
        }
        return $id === '' ? [] : [['label' => $label, 'agent_id' => $id]];
    }
}
