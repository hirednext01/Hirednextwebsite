<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class HiringIntelligence extends BaseConfig
{
    /**
     * Qualitative recruiter intelligence derived from HiredNext's limited,
     * anonymised joined-placement evidence and practitioner observations.
     * These signals are not company-wide benchmarks and deliberately avoid
     * candidate/client identity, compensation, fees, success rates or totals.
     */
    public string $scopeNote = 'HiredNext Hiring Intelligence combines qualitative recruiter observations with a selected anonymised sample of joined placements. It is directional evidence, not a company-wide benchmark or market census.';

    public string $methodology = 'Signals are published only when they can be supported by privacy-safe role-family evidence or HiredNext practitioner commentary. We do not extrapolate success rates, salary averages, client mix or placement totals from the limited sample.';

    public array $signals = [
        [
            'id' => 'technology-role-specificity',
            'sector' => 'IT & Technology',
            'title' => 'Specialist technology hiring needs role-context, not keyword matching',
            'observation' => 'The selected technology evidence spans leadership, cybersecurity and platform-specific development. Treating those mandates as one generic technology search would hide material differences in scope, seniority and assessment criteria.',
            'evidence_roles' => ['Web Development Lead', 'Cyber Security Lead', 'Liferay Developer'],
            'employer_implication' => 'Define the technical problem, decision scope and must-have depth before sourcing. Use keywords as discovery clues, not as the assessment itself.',
            'related_url' => '/industry/it-recruitment-services-india',
        ],
        [
            'id' => 'textile-cross-functional-map',
            'sector' => 'Garment, Textile & Apparel',
            'title' => 'Textile and apparel talent maps are cross-functional',
            'observation' => 'The selected joined-placement evidence includes design, fabric technology, finance, executive-office and design-leadership roles. Sector knowledge therefore needs to extend beyond one function or job family.',
            'evidence_roles' => ['Designer', 'Fabric Technologist', 'Finance Manager', 'Design Leadership', 'Executive Office / EA'],
            'employer_implication' => 'Segment searches by function, decision level and business context rather than treating apparel talent as a single pool.',
            'related_url' => '/industry/garment-textile-recruitment-india',
        ],
        [
            'id' => 'leadership-vs-specialist-calibration',
            'sector' => 'Leadership & Specialist Hiring',
            'title' => 'Leadership and specialist mandates require different calibration',
            'observation' => 'The sample contains both leadership roles and narrow specialist roles. The evidence supports a search model where scope, decision authority and specialist depth are calibrated separately instead of using one screening template for every mandate.',
            'evidence_roles' => ['Design Leadership', 'Web Development Lead', 'Cyber Security Lead', 'Fabric Technologist'],
            'employer_implication' => 'Set assessment criteria around business impact for leadership roles and demonstrable domain depth for specialist roles.',
            'related_url' => '/services/executive-search',
        ],
        [
            'id' => 'candidate-story-signal',
            'sector' => 'Candidate Experience',
            'title' => 'Candidate experience is part of recruitment quality',
            'observation' => 'HiredNext treats communication quality, role relevance and recruiter support as evidence worth capturing through moderated candidate stories and source-linked recommendations, rather than relying only on internal delivery claims.',
            'evidence_roles' => [],
            'employer_implication' => 'Measure the experience around a search as well as the outcome. Clear communication and relevant outreach affect trust in the hiring process.',
            'related_url' => '/testimonials',
        ],
    ];

    public array $publicationRules = [
        'Never identify candidates from placement evidence.',
        'Never identify client/company names from underlying placement records without explicit permission.',
        'Never publish salary, CTC, professional fees or fee percentages from underlying records.',
        'Never convert the limited sample into company-wide percentages, averages or placement totals.',
        'Label qualitative signals as observations, not universal market facts.',
        'Link to the supporting sector/service context wherever practical.',
    ];
}
