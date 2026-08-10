<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class IndustryAuthority extends BaseController
{
    public function garmentTextile()
    {
        $settings = $this->loadWebsiteSettings();
        $evidence = config('PlacementEvidence');
        $pageUrl = base_url('industry/garment-textile-recruitment-india');

        $industry = [
            'slug' => 'garment-textile-recruitment-india',
            'label' => 'Garment & Textile Recruitment',
            'meta_title' => 'Garment & Textile Recruitment in India',
            'h1' => 'Garment & Textile Recruitment in India – Leadership & Specialist Hiring',
            'intro' => 'HiredNext supports garment, textile, apparel and fashion hiring across leadership and specialist roles in India. Our search process combines sector mapping, role-calibrated assessment and recruiter-led closure for functions spanning design, merchandising, textile product, finance, commercial and executive-office mandates.',
            'challenges' => [
                'Specialist talent pools are fragmented across brands, exporters, manufacturers, buying houses and sourcing ecosystems.',
                'Titles can hide major differences in product category, export market, sourcing model, scale and decision ownership.',
                'Leadership and specialist roles often require a blend of commercial judgement, product understanding and execution discipline.',
                'Location and mobility constraints can materially narrow talent pools across Gurugram, Bengaluru, Mumbai, Coimbatore and other apparel and textile hubs.',
            ],
            'approach' => [
                'Calibrate the mandate around product category, business model, market, team scope and measurable outcomes rather than job title alone.',
                'Map relevant talent across apparel brands, textile businesses, exporters, manufacturers, sourcing organisations and adjacent consumer businesses.',
                'Assess evidence of ownership across design, merchandising, product, finance, commercial or leadership outcomes as relevant to the mandate.',
                'Manage candidate engagement, referencing, offer alignment and joining risk through a recruiter-led process.',
            ],
            'differentiators' => [
                'Sector-specific search context across garment, textile, apparel and fashion talent markets.',
                'Search coverage across leadership and specialist functions rather than title-only matching.',
                'Selected anonymised joined-placement evidence from a limited internal sample spans design leadership, design, fabric technology, finance and executive-office roles in the garment and textile sector.',
                'Candidate and client confidentiality is protected: names, compensation and company identities are not published from placement records.',
            ],
            'cta_title' => 'Get in Touch',
            'cta_description' => 'Share your garment, textile, apparel or fashion hiring mandate. We will align on target companies, role evidence and search timelines.',
            'cta_panel_heading' => 'Specialist search for garment, textile and apparel talent.',
            'cta_panel_body' => 'For leadership or hard-to-find specialist roles across design, merchandising, product, sourcing, finance and commercial functions, share the mandate and operating context. We will build the search map around the evidence the role actually requires.',
        ];

        $selectedExamples = [];
        if ($evidence && !empty($evidence->joinedExamples) && is_array($evidence->joinedExamples)) {
            foreach ($evidence->joinedExamples as $item) {
                if (($item['industry'] ?? '') !== 'Garment & Textile') {
                    continue;
                }
                $selectedExamples[] = [
                    '@type' => 'ListItem',
                    'position' => count($selectedExamples) + 1,
                    'name' => $item['role_family'] ?? 'Anonymised placement',
                    'description' => implode(' · ', array_filter([
                        $item['function'] ?? null,
                        $item['location'] ?? null,
                        !empty($item['joined_month']) ? 'Joined ' . $item['joined_month'] : null,
                    ])),
                ];
            }
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    '@id' => $pageUrl . '#service',
                    'name' => 'Garment & Textile Recruitment in India',
                    'serviceType' => 'Recruitment and Executive Search',
                    'provider' => [
                        '@type' => 'EmploymentAgency',
                        '@id' => 'https://hirednext.net/#organization',
                        'name' => 'HiredNext Recruitment',
                        'url' => 'https://hirednext.net/',
                    ],
                    'areaServed' => ['@type' => 'Country', 'name' => 'India'],
                    'description' => 'Recruitment and executive search for garment, textile, apparel and fashion leadership and specialist roles in India.',
                    'url' => $pageUrl,
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $pageUrl . '#webpage',
                    'url' => $pageUrl,
                    'name' => 'Garment & Textile Recruitment in India',
                    'isPartOf' => ['@id' => 'https://hirednext.net/#website'],
                    'about' => ['@id' => $pageUrl . '#service'],
                    'publisher' => ['@id' => 'https://hirednext.net/#organization'],
                    'inLanguage' => 'en-IN',
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Industry Expertise', 'item' => base_url('/#industry-expertise')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => 'Garment & Textile Recruitment', 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        if (!empty($selectedExamples)) {
            $jsonLd['@graph'][] = [
                '@type' => 'ItemList',
                '@id' => $pageUrl . '#selected-evidence',
                'name' => 'Selected anonymised joined-placement examples',
                'description' => $evidence->scopeNote,
                'numberOfItems' => count($selectedExamples),
                'itemListElement' => $selectedExamples,
            ];
        }

        return view('pages/industry/industry', [
            'title' => 'Garment & Textile Recruitment India | HiredNext',
            'metaDescription' => 'Garment, textile, apparel and fashion recruitment in India for leadership and specialist roles across design, merchandising, product, finance and commercial functions.',
            'metaKeywords' => 'garment recruitment India, textile recruitment agency India, apparel recruitment India, fashion recruitment firm, garment executive search, textile leadership hiring',
            'canonical' => $pageUrl,
            'currentPage' => 'industry',
            'settings' => $settings,
            'industry' => $industry,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }
}
