<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class PlacementEvidence extends BaseConfig
{
    /**
     * Privacy-safe, selected examples supplied from a small internal placement sample.
     * This is not a complete placement database and must never be used to infer
     * company-wide percentages, average compensation, total placements, or client mix.
     * Candidate names, client/company names, compensation and fee data are intentionally excluded.
     */
    public string $scopeNote = 'Selected anonymised joined-placement examples from a small internal sample supplied by HiredNext. This sample is not representative of all HiredNext placements and must not be used to infer company-wide percentages or totals.';

    public array $joinedExamples = [
        [
            'role_family' => 'Web Development Lead',
            'function' => 'Technology',
            'industry' => 'Automotive / Mobility',
            'location' => null,
            'joined_month' => '2026-03',
        ],
        [
            'role_family' => 'Cyber Security Lead',
            'function' => 'Cybersecurity',
            'industry' => 'Automotive / Mobility',
            'location' => null,
            'joined_month' => '2026-03',
        ],
        [
            'role_family' => 'Designer',
            'function' => 'Design',
            'industry' => 'Garment & Textile',
            'location' => null,
            'joined_month' => '2025-12',
        ],
        [
            'role_family' => 'Human Resources',
            'function' => 'Human Resources',
            'industry' => null,
            'location' => null,
            'joined_month' => '2026-02',
        ],
        [
            'role_family' => 'Designer',
            'function' => 'Design',
            'industry' => 'Retail / Apparel',
            'location' => null,
            'joined_month' => '2026-01',
        ],
        [
            'role_family' => 'Fabric Technologist',
            'function' => 'Textile / Product',
            'industry' => 'Garment & Textile',
            'location' => null,
            'joined_month' => '2026-02',
        ],
        [
            'role_family' => 'Liferay Developer',
            'function' => 'Technology',
            'industry' => null,
            'location' => null,
            'joined_month' => '2026-03',
        ],
        [
            'role_family' => 'Finance Manager',
            'function' => 'Finance',
            'industry' => 'Garment & Textile',
            'location' => 'Bengaluru',
            'joined_month' => '2026-04',
        ],
        [
            'role_family' => 'Design Leadership',
            'function' => 'Design',
            'industry' => 'Garment & Textile',
            'location' => 'Gurugram',
            'joined_month' => '2026-04',
        ],
        [
            'role_family' => 'Executive Office / EA',
            'function' => 'Executive Office',
            'industry' => 'Garment & Textile',
            'location' => 'Mumbai',
            'joined_month' => '2026-05',
        ],
    ];

    public array $publicationRules = [
        'Never publish candidate names or personal contact details.',
        'Never publish client or company names from the underlying placement records without explicit permission.',
        'Never publish salary, CTC, fee percentage or professional fee from the underlying placement records.',
        'Use this dataset only as selected anonymised evidence; do not extrapolate company-wide percentages or totals.',
        'Prefer role families and month-level dates over exact identifying details.',
    ];
}
