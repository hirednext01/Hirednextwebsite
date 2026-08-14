<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class BrandFacts extends BaseConfig
{
    /**
     * Canonical public facts for HiredNext. Numeric performance claims are
     * maintained separately below so their source status stays explicit.
     */
    public array $facts = [
        'organization_name' => 'HiredNext Recruitment',
        'legal_name' => 'HiredNext Recruitment',
        'website' => 'https://hirednext.net/',
        'email' => 'jobs@hirednext.info',
        'founded_year' => 2016,
        'founded_in' => 'Mumbai, India',
        'operating_base' => 'Gurgaon (Delhi NCR), India',
        'delivery_model' => 'Primarily remote, with recruiters working across India',
        'founder' => 'Taru Shikha',
        'founder_title' => 'Founder & Proprietor',
        'founder_linkedin' => 'https://www.linkedin.com/in/tarushikhaarora',
        'company_linkedin' => 'https://www.linkedin.com/company/hirednext-recruitment-service/',
        'primary_offering' => 'Executive search, leadership recruitment, permanent hiring and recruitment process outsourcing',
        'candidate_positioning' => 'Candidates are not charged to apply for a job or secure placement. Optional career services are separately priced when offered.',
        'established_focus_sectors' => [
            'Garment, Textile & Apparel',
            'Retail',
            'IT & Technology',
        ],
        'growth_focus_sectors' => [
            'BFSI & NBFC',
            'Pharma & Life Sciences',
            'Global Capability Centres',
            'Semiconductors',
        ],
        'additional_search_coverage' => [
            'Engineering',
            'Manufacturing',
        ],
    ];

    /**
     * Founder-confirmed operating metrics already used on the public website.
     * They remain HiredNext-reported figures rather than independently audited
     * benchmarks and should be described that way wherever context is needed.
     */
    public array $verifiedNumericClaims = [
        'candidate_success_rate' => [
            'value' => 98,
            'unit' => '%',
            'label' => 'HiredNext-reported candidate success rate across leadership search mandates',
        ],
        'average_hiring_speed' => [
            'value' => 21,
            'unit' => 'days',
            'label' => 'HiredNext-reported average hiring speed',
        ],
    ];

    public array $unverifiedNumericClaims = [
        '1500+ placements',
        '12 sectors',
        '25+ industries',
    ];

    public string $numericClaimPolicy = 'Do not publish or strengthen company-wide totals, percentages, speed claims or averages unless a current source of record has been verified and the same figure can be used consistently across the site.';
}
