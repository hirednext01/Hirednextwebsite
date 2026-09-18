<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class HiringIntelligence extends BaseConfig
{
    /**
     * Qualitative recruiter intelligence derived from HiredNext's limited,
     * anonymised joined-placement evidence, documented mandate history and
     * practitioner observations.
     */
    public string $scopeNote = 'HiredNext Hiring Intelligence combines qualitative recruiter observations with selected anonymised joined-placement evidence, documented mandate history and founder-confirmed historical placement context. Each evidence type is labelled separately so roles worked are not presented as placements unless a joining outcome is supported.';

    public string $methodology = 'Signals are published only when they can be supported by privacy-safe role-family evidence, documented mandate records or HiredNext practitioner commentary. We do not infer salaries, client mix, success rates or unverified placement outcomes from the selected sample.';

    /**
     * Founder-confirmed historical context. This is deliberately separated
     * from the selected joined-placement table below.
     */
    public string $automotiveHistoryNote = 'Founder-confirmed historical context: HiredNext reports 50 roles closed over multiple years for one global automotive and mobility group. This historical figure is not derived from, or extrapolated from, the selected joined-placement sample shown on this page.';

    /**
     * Founder-confirmed historical leadership placement families.
     * Client/candidate identity, date and compensation are intentionally withheld.
     */
    public string $leadershipPlacementNote = 'Founder-confirmed historical leadership placement families. Client and candidate identities, dates, compensation and commercial terms are intentionally not published in this evidence layer.';

    public array $leadershipPlacementFamilies = [
        'Chief Operating Officer (COO)',
        'Chief Human Resources Officer (CHRO)',
        'Head of HR',
        'Head of Manufacturing Excellence',
        'Chief Technology Officer (CTO)',
    ];

    /**
     * Role families taken from documented historical mandate records.
     * These show search breadth only and are NOT presented as joined placements.
     */
    public array $documentedMandateGroups = [
        'Cybersecurity & Security' => [
            'Automotive Cyber Security Lead',
            'Penetration Testing',
            'OT Penetration / OT Security',
            'Solution Architect / Security Assessor',
        ],
        'Data, AI & Analytics' => [
            'Data Scientist',
            'Gen AI Data Scientist',
            'AI Engineer',
            'Snowflake Data Engineer',
            'Azure Data Engineer',
            'Engineering Data Analysis',
            'Data Governance Product Owner',
            'Process Analyst',
        ],
        'ServiceNow & Enterprise Platforms' => [
            'ServiceNow SMO / SIAM Specialist',
            'ServiceNow Senior Program Manager',
            'ServiceNow Service Owner — CMDB/CSDM & ITOM',
            'ServiceNow Developer',
            'Salesforce Expert',
            'SAP Basis',
            'ESB Developer',
        ],
        'Automotive, Engineering & Technical' => [
            'Technical & Domain Expert Aftersales / Senior Program Manager',
            'Operations AI Solution Specialist & Technical Specialist',
            'Business Support Engineer — Clara',
            'Clara Support',
            'Diagnostics Specialist',
            'Diagnostic Engineer',
            'Senior Engineer',
            'Quality Management System Manager',
        ],
        'Cloud, Architecture & Corporate Specialist' => [
            'Senior Cloud Engineer',
            'Principal Consultant — Azure Data Factory',
            'Application Lifecycle Management',
            'Senior Program Manager — Procurement',
            'Manager — Procurement',
            'University Relations & Employer Branding',
        ],
    ];

    public array $signals = [
        [
            'id' => 'technology-role-specificity',
            'sector' => 'IT & Technology',
            'title' => 'Specialist technology hiring needs role-context, not keyword matching',
            'observation' => 'The selected joined-placement evidence spans cybersecurity leadership, web development, enterprise integration, platform development and specialist technology. Treating these mandates as one generic technology search would hide material differences in scope, seniority and assessment criteria.',
            'evidence_roles' => ['Cyber Security Lead', 'Web Development Lead', 'Lead Pega Developer', 'ESB Developer', 'Liferay Developer'],
            'employer_implication' => 'Define the technical problem, decision scope and must-have depth before sourcing. Use keywords as discovery clues, not as the assessment itself.',
            'related_url' => '/industry/it-recruitment-services-india',
        ],
        [
            'id' => 'automotive-specialist-map',
            'sector' => 'Automotive / Mobility',
            'title' => 'Automotive talent work now spans security, data, AI, platforms and engineering',
            'observation' => 'Documented historical mandate records include automotive cybersecurity, penetration testing, data science, Gen AI, data engineering, ServiceNow, diagnostics, cloud, enterprise platforms and specialist engineering. These are mandate records; they are not all represented as placement outcomes.',
            'evidence_roles' => ['Automotive Cyber Security', 'Data Scientist', 'Data Engineer', 'ServiceNow', 'Diagnostics', 'Engineering Data Analysis'],
            'employer_implication' => 'Build separate capability maps for each technical family instead of treating automotive technology as a single talent pool.',
            'related_url' => null,
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
            'observation' => 'HiredNext’s documented history includes C-suite and functional-head placements alongside narrow specialist technology and domain mandates. The evidence supports a search model where scope, decision authority and specialist depth are calibrated separately instead of using one screening template for every mandate.',
            'evidence_roles' => ['COO', 'CHRO', 'Head of HR', 'Head of Manufacturing Excellence', 'CTO', 'Cyber Security Lead'],
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
        'Keep documented mandates separate from confirmed joining outcomes.',
        'Do not calculate success rates, averages or client mix from the selected evidence sample.',
        'Label founder-confirmed historical context separately from documentary joined-placement evidence.',
        'Label qualitative signals as observations, not universal market facts.',
        'Link to the supporting sector/service context wherever practical.',
    ];
}
