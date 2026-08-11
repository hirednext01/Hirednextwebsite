<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MandateEvidence extends BaseConfig
{
    public string $updatedOn = '2026-08-11';

    /**
     * Founder-supplied qualitative evidence.
     * Confirmed cases and recurring operating practices are deliberately separated so
     * a practice pattern is never presented as though it were a completed case study.
     */
    public string $scopeNote = 'Founder-supplied qualitative evidence. Confirmed anonymised cases are separated from recurring HiredNext search practices. This is not an audited or exhaustive case-study database and must not be used to infer company-wide success rates, placement totals or average outcomes.';

    public array $roleContexts = [
        'CXO and C-suite leadership',
        'CEO, COO, CFO and CMO mandates',
        'Business and functional heads',
        'Category, design and commercial leadership',
        'Retail and apparel leadership',
        'Technology and niche cybersecurity hiring',
        'Senior managers and hard-to-fill specialists',
        'India-to-overseas leadership mobility',
    ];

    /**
     * Specific anonymised outcomes confirmed by HiredNext.
     */
    public array $cases = [
        'overlooked-coo' => [
            'status' => 'confirmed_anonymised_case',
            'title' => 'The CV was already in the client inbox',
            'role' => 'COO',
            'context' => 'Overseas leadership appointment for a promoter-led business',
            'mandate' => 'The organisation had been trying to close the COO mandate for months. The eventual hire was not hidden from the client: his CV had reached the organisation earlier and had been overlooked.',
            'what_we_saw' => 'HiredNext saw operating relevance in the profile that was not obvious from the CV alone. The question was not whether the candidate had the perfect title history, but whether his experience matched the business problem the promoter needed the COO to solve.',
            'what_we_did' => 'We engaged the candidate, pitched the international move, understood what he would be leaving behind, prepared a detailed leadership synopsis and went back to the company with a clear argument for why the profile deserved reconsideration.',
            'result' => 'The company interviewed and hired the candidate. HiredNext reports that the leader has remained with the organisation for more than four years.',
            'why_it_matters' => 'The missing asset was not the CV. It was interpretation, context and conviction.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india'],
        ],
    ];

    /**
     * Recurring ways HiredNext works across senior, specialist and difficult mandates.
     * These describe how the firm operates; they are not represented as individual case outcomes.
     */
    public array $practices = [
        'international-leadership-mobility' => [
            'title' => 'Helping an established leader decide whether an overseas move is worth the risk',
            'category' => 'International leadership mobility',
            'when_it_matters' => 'A successful senior professional may be leaving status, stability, family routines, accumulated reputation and a known organisation for an uncertain platform abroad. Compensation alone rarely resolves that decision.',
            'how_hirednext_works' => 'We work through mandate authority, promoter or board context, career trajectory, relocation, family implications, what the candidate is giving up and what the move could add to the next five years of the career. The same concerns are translated back to the employer so both sides know what must be resolved.',
            'decision_value' => 'The objective is not to push a relocation. It is to create enough clarity for the right person to move with conviction — and enough independence to say when the move is not right.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'confidential-cfo-search-india'],
        ],
        'niche-cybersecurity-product-search' => [
            'title' => 'Treating niche cybersecurity hiring as a capability map, not a keyword search',
            'category' => 'Specialist technology search',
            'when_it_matters' => 'For specialist cybersecurity work in a product environment, technically adjacent profiles can look similar on paper while the genuinely relevant market remains narrow. Relocation can narrow it further.',
            'how_hirednext_works' => 'We clarify the exact technical and operating capability, map where it actually exists, distinguish genuine depth from title or keyword overlap, and stay involved in the candidate decision around product environment, career value and relocation.',
            'decision_value' => 'When the real talent universe is small, precision and persuasion matter more than sending a larger volume of CVs.',
            'guide_slugs' => ['specialist-recruitment-firm-india', 'leadership-hiring-partner-india'],
        ],
        'multi-round-leadership-stewardship' => [
            'title' => 'Keeping a strong senior candidate engaged through four or five rounds',
            'category' => 'Leadership candidate stewardship',
            'when_it_matters' => 'Senior candidates reassess the employer at every round. Delays, conflicting messages, changing expectations and silence can turn a viable hire into a withdrawal even after excellent interviews.',
            'how_hirednext_works' => 'We stay between both decision processes: interpret concerns, maintain honest communication, prepare the candidate for the next conversation, push for clarity where required and keep the client aware of motivation, hesitation or withdrawal risk.',
            'decision_value' => 'A candidate accepting Round 1 is not the same thing as a candidate remaining convinced through Round 5.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'confidential-cfo-search-india'],
        ],
        'compensation-value-advocacy' => [
            'title' => 'Negotiating compensation by explaining the value behind the number',
            'category' => 'Offer and compensation calibration',
            'when_it_matters' => 'A candidate can look expensive when the discussion is anchored only to the original budget, current salary or an expected percentage increase. Senior hiring requires a view of scarcity, scope, business consequence and the risk the candidate is taking.',
            'how_hirednext_works' => 'We articulate what the candidate has actually handled, what capability is scarce, what the person can change for the business and why a different compensation level may be justified. If the value case is weak, we tell the candidate that too.',
            'decision_value' => 'The strongest salary negotiation is a business argument about value and role economics, not entitlement.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'confidential-cfo-search-india'],
        ],
        'level-calibration' => [
            'title' => 'Showing why a candidate may deserve the Head role, not the layer below it',
            'category' => 'Seniority and role-level calibration',
            'when_it_matters' => 'Current title, hierarchy and compensation can anchor a candidate too low. A person may already be carrying enterprise-level complexity without the formal title, while someone with the title may have had narrower real scope.',
            'how_hirednext_works' => 'We compare actual scale, decisions, team ownership, commercial consequence, transformation exposure and stakeholder complexity, then make the case to the client when the evidence supports a more senior role.',
            'decision_value' => 'Seniority should follow evidence of responsibility and consequence, not the wording on a visiting card.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'specialist-recruitment-firm-india', 'confidential-cfo-search-india'],
        ],
        'career-decision-guidance' => [
            'title' => 'Helping a stagnant senior professional decide whether to take the leap',
            'category' => 'Founder-led career decision support',
            'when_it_matters' => 'The known organisation can feel safer even when a leader has stopped growing. A new role may offer greater runway, but it also carries ambiguity and the emotional cost of leaving a successful platform.',
            'how_hirednext_works' => 'Founder-led conversations examine career runway, learning, authority, culture, promoter or leadership quality, family implications, future market value and the cost of staying stagnant. The role is not sold at any cost; the candidate is supported toward the decision that appears right for them.',
            'decision_value' => 'Independent advice is useful precisely because sometimes the right recommendation is not to move. When the opportunity is right, that same independence creates stronger conviction to take it.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'confidential-cfo-search-india'],
        ],
    ];

    public function casesForGuide(string $slug): array
    {
        return array_filter($this->cases, static function (array $item) use ($slug): bool {
            return in_array($slug, $item['guide_slugs'] ?? [], true);
        });
    }

    public function practicesForGuide(string $slug): array
    {
        return array_filter($this->practices, static function (array $item) use ($slug): bool {
            return in_array($slug, $item['guide_slugs'] ?? [], true);
        });
    }
}
