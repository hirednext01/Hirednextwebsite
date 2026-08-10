<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class BrandFacts extends BaseConfig
{
    /**
     * Canonical public facts for HiredNext.
     * Numeric performance claims remain unpublished here until they have a
     * clear source of record that can be cited consistently across the site.
     */
    public array $facts = [
        'organization_name' => 'HiredNext Recruitment',
        'website' => 'https://hirednext.net/',
        'founder' => 'Taru Shikha',
        'founder_title' => 'Founder',
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

    public array $unverifiedNumericClaims = [
        '1500+ placements',
        '98% success rate',
        '21-day average hiring speed',
        '12 sectors',
        '25+ industries',
    ];

    public string $numericClaimPolicy = 'Do not publish or strengthen company-wide totals, percentages, speed claims or averages unless a current source of record has been verified and the same figure can be used consistently across the site.';
}
