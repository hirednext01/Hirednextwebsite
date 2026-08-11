<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MandateEvidence extends BaseConfig
{
    public string $updatedOn = '2026-08-11';

    /**
     * Founder-supplied mandate evidence and recurring operating patterns.
     * One case below is a specific anonymised placement story confirmed by HiredNext.
     * The remaining items describe recurring ways HiredNext has created value across
     * senior, specialist and difficult-to-fill mandates. They are intentionally written
     * without client names, candidate names, compensation figures or unverifiable totals.
     */
    public string $scopeNote = 'Anonymised founder-supplied mandate evidence and recurring search-stewardship patterns. These examples are qualitative, not an audited or exhaustive case-study database, and should not be used to infer company-wide success rates, placement totals or average outcomes.';

    public array $items = [
        'overlooked-coo' => [
            'type' => 'confirmed_anonymised_case',
            'title' => 'The CV was already in the client inbox',
            'role' => 'COO',
            'context' => 'Overseas leadership appointment for a promoter-led business',
            'problem' => 'The client had been stuck on the mandate for months. The eventual hire had already sent a CV to the organisation earlier and had been overlooked.',
            'hirednext_intervention' => 'HiredNext re-read the profile in the context of the operating mandate, engaged the candidate, pitched the international move, prepared a detailed leadership synopsis and explained to the client why the candidate deserved reconsideration.',
            'outcome' => 'The company interviewed and hired the candidate. HiredNext reports that the leader has remained with the organisation for more than four years.',
            'lesson' => 'The missing asset was not the CV. It was interpretation, context and conviction.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india'],
        ],
        'international-leadership-mobility' => [
            'type' => 'recurring_practice_pattern',
            'title' => 'Moving an established Indian leader into an overseas mandate',
            'role' => 'Senior leadership / business leadership',
            'context' => 'International appointments requiring senior Indian candidates to relocate',
            'problem' => 'A successful senior professional may be leaving status, stability, family routines, accumulated reputation and a known organisation for an uncertain platform abroad. The career risk can matter as much as compensation.',
            'hirednext_intervention' => 'HiredNext works through the actual decision with the candidate: mandate authority, promoter or board context, career trajectory, relocation risk, family concerns, upside, what they are giving up and whether the move is genuinely right. The same concerns are translated back to the employer so both sides understand what must be resolved.',
            'outcome' => 'The purpose is not to force a move. It is to create enough clarity and conviction for the right candidate to make a high-stakes decision with open eyes.',
            'lesson' => 'International leadership hiring is partly a search problem and partly a conviction problem.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'confidential-cfo-search-india'],
        ],
        'niche-cybersecurity-product-search' => [
            'type' => 'recurring_practice_pattern',
            'title' => 'When cybersecurity hiring becomes a capability map, not a keyword search',
            'role' => 'Niche cybersecurity / technology hiring',
            'context' => 'Specialist hiring for a major German product company',
            'problem' => 'The relevant market was narrow, technically adjacent profiles could look similar on paper, and some candidates had to consider relocation from different parts of India.',
            'hirednext_intervention' => 'HiredNext focused on the exact capability required, mapped where that capability existed, distinguished genuine technical depth from title or keyword overlap and stayed involved in the candidate decision around role quality, product environment and relocation.',
            'outcome' => 'The search model prioritised precision and candidate engagement rather than increasing CV volume.',
            'lesson' => 'When the real market is small, more sourcing activity does not automatically create more relevant talent.',
            'guide_slugs' => ['specialist-recruitment-firm-india', 'leadership-hiring-partner-india'],
        ],
        'multi-round-leadership-stewardship' => [
            'type' => 'recurring_practice_pattern',
            'title' => 'Keeping the right candidate engaged through four or five leadership rounds',
            'role' => 'Leadership and senior functional hiring',
            'context' => 'Multi-stakeholder interview processes',
            'problem' => 'Senior candidates reassess the employer at every round. Delays, conflicting messages, changing expectations or poor feedback can turn a good search into a withdrawal even after strong interviews.',
            'hirednext_intervention' => 'HiredNext bridges the employer and candidate throughout the process: interprets concerns, maintains honest communication, pushes for clarity when required, prepares the candidate for the next conversation and keeps the client aware of motivation or withdrawal risk.',
            'outcome' => 'The objective is continuity of conviction on both sides, not simply interview scheduling.',
            'lesson' => 'A candidate agreeing to Round 1 is not the same as a candidate remaining convinced through Round 5.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'confidential-cfo-search-india', 'rpo-solutions-india'],
        ],
        'compensation-value-advocacy' => [
            'type' => 'recurring_practice_pattern',
            'title' => 'Salary negotiation should explain value, not merely defend a number',
            'role' => 'Senior and leadership hiring',
            'context' => 'Offer calibration and compensation negotiation',
            'problem' => 'A candidate may appear expensive when compensation is compared only with the original budget or current salary. The real question is whether the experience, scarcity, risk assumed and business value justify a different level of investment.',
            'hirednext_intervention' => 'HiredNext makes the case in business terms: what the candidate has handled, what capability is scarce, what value the person can bring, what risk the employer avoids and why the requested compensation may be justified. Where it is not justified, the candidate is told that too.',
            'outcome' => 'The aim is a defensible offer both sides can respect, rather than negotiation by percentage alone.',
            'lesson' => 'The strongest salary negotiation is an argument about value and role economics, not entitlement.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'confidential-cfo-search-india'],
        ],
        'level-calibration' => [
            'type' => 'recurring_practice_pattern',
            'title' => 'Sometimes the candidate belongs in the head role, not one level below',
            'role' => 'Business heads, functional heads, category, design and senior managers',
            'context' => 'Seniority and role-level calibration',
            'problem' => 'Titles, current hierarchy and compensation can anchor a candidate too low. A person may already be carrying enterprise-level complexity without the formal title, while another candidate with the title may have had narrower real scope.',
            'hirednext_intervention' => 'HiredNext looks at actual scale, decisions, team ownership, commercial consequence, transformation exposure and stakeholder complexity, then explains to the client why the candidate may deserve the senior role rather than the layer below it.',
            'outcome' => 'The search becomes an assessment of capability and leadership readiness instead of title matching.',
            'lesson' => 'Seniority should follow evidence of responsibility and consequence, not the wording on the current visiting card.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'specialist-recruitment-firm-india', 'confidential-cfo-search-india'],
        ],
        'career-decision-guidance' => [
            'type' => 'recurring_practice_pattern',
            'title' => 'Helping a stagnant senior professional decide whether to take the leap',
            'role' => 'Senior professionals and leadership candidates',
            'context' => 'Passive candidates weighing a known environment against an uncertain opportunity',
            'problem' => 'The “known devil” can feel safer even when a leader has become stagnant. A new mandate can offer growth but also carries risk, ambiguity and emotional resistance to leaving an established platform.',
            'hirednext_intervention' => 'Founder-led conversations examine the decision without trying to sell the vacancy at any cost: career runway, learning, authority, culture, promoter or leadership quality, family implications, future market value and the cost of staying stagnant. The candidate is supported toward the decision that is right for them, even when that means not moving.',
            'outcome' => 'When the opportunity is genuinely right, the candidate can move with greater conviction because the decision has been examined rather than pushed.',
            'lesson' => 'Good senior recruitment sometimes means advising someone not to jump. That independence is what makes the advice useful when the right opportunity does appear.',
            'guide_slugs' => ['executive-search-firm-india', 'leadership-hiring-partner-india', 'confidential-cfo-search-india'],
        ],
    ];

    public function forGuide(string $slug): array
    {
        return array_filter($this->items, static function (array $item) use ($slug): bool {
            return in_array($slug, $item['guide_slugs'] ?? [], true);
        });
    }
}
