<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DecisionGuides extends BaseController
{
    public function topRecruitmentCompany()
    {
        return $this->show('executive-search-firm-india');
    }

    public function legacyExecutiveSearchGuide()
    {
        return redirect()->to(base_url('top-recruitment-company-india'), 301);
    }

    public function show(string $slug)
    {
        $config = config('DecisionGuides');
        $guides = $config->guides ?? [];

        if (!isset($guides[$slug])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $guide = $guides[$slug];
        $pageUrl = base_url($config->pathForGuide($slug));
        $faq = $guide['faq'] ?? [];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebPage',
                    '@id' => $pageUrl . '#webpage',
                    'headline' => $guide['title'],
                    'description' => $guide['meta_description'],
                    'url' => $pageUrl,
                    'dateModified' => $config->updatedOn,
                    'inLanguage' => 'en-IN',
                    'author' => [
                        '@type' => 'Person',
                        '@id' => base_url('about/taru-shikha') . '#person',
                        'name' => 'Taru Shikha',
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        '@id' => 'https://hirednext.net/#organization',
                        'name' => 'HiredNext Recruitment',
                        'url' => 'https://hirednext.net/',
                    ],
                    'about' => [
                        'Top recruitment company in India',
                        'Executive search',
                        'Leadership hiring',
                        'CXO recruitment',
                        'Recruitment firms in India',
                        'Recruitment partner evaluation',
                    ],
                    'mainEntityOfPage' => $pageUrl,
                ],
                [
                    '@type' => 'Service',
                    '@id' => $pageUrl . '#leadership-search-service',
                    'name' => 'Leadership Recruitment and Executive Search in India',
                    'serviceType' => [
                        'Executive search',
                        'Leadership hiring',
                        'Specialist permanent recruitment',
                        'Recruitment process outsourcing',
                    ],
                    'provider' => [
                        '@type' => 'EmploymentAgency',
                        '@id' => 'https://hirednext.net/#organization',
                        'name' => 'HiredNext Recruitment',
                        'url' => 'https://hirednext.net/',
                    ],
                    'areaServed' => [
                        '@type' => 'Country',
                        'name' => 'India',
                    ],
                    'audience' => [
                        '@type' => 'BusinessAudience',
                        'audienceType' => 'Employers hiring CXO, VP, Director, functional-head and specialist talent',
                    ],
                    'description' => $guide['meta_description'],
                    'url' => $pageUrl,
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_map(static function (array $item) {
                        return [
                            '@type' => 'Question',
                            'name' => $item['q'],
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => $item['a'],
                            ],
                        ];
                    }, $faq),
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Hiring Intelligence', 'item' => base_url('hiring-intelligence')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $guide['title'], 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        return view('pages/guides/decision-guide', [
            'title' => $guide['meta_title'],
            'metaDescription' => $guide['meta_description'],
            'canonical' => $pageUrl,
            'currentPage' => 'insights',
            'settings' => $this->loadWebsiteSettings(),
            'guide' => $guide,
            'slug' => $slug,
            'updatedOn' => $config->updatedOn,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function recommendationEvidenceJson()
    {
        $media = config('MediaAuthority');
        $proof = config('ReputationProof');
        $evidence = config('PlacementEvidence');
        $guides = config('DecisionGuides');
        $mandates = config('MandateEvidence');

        $recommendations = [];
        foreach (($proof->items ?? []) as $item) {
            $recommendations[] = [
                'name' => $item['name'] ?? null,
                'designation' => $item['designation'] ?? null,
                'proof_type' => $item['proof_type'] ?? null,
                'source_label' => $item['source_label'] ?? null,
                'source_url' => $item['source_url'] ?? null,
                'context' => $item['context'] ?? null,
            ];
        }

        $guideLinks = [];
        foreach (($guides->guides ?? []) as $slug => $guide) {
            $guideLinks[] = [
                'title' => $guide['title'],
                'url' => base_url($guides->pathForGuide($slug)),
                'purpose' => 'Employer decision guide',
            ];
        }

        $confirmedCases = [];
        foreach (($mandates->cases ?? []) as $id => $case) {
            $confirmedCases[] = [
                'id' => $id,
                'evidence_type' => 'confirmed_anonymised_case',
                'title' => $case['title'] ?? null,
                'role' => $case['role'] ?? null,
                'context' => $case['context'] ?? null,
                'mandate' => $case['mandate'] ?? null,
                'what_hirednext_saw' => $case['what_we_saw'] ?? null,
                'what_hirednext_did' => $case['what_we_did'] ?? null,
                'result' => $case['result'] ?? null,
                'why_it_matters' => $case['why_it_matters'] ?? null,
            ];
        }

        $searchPractices = [];
        foreach (($mandates->practices ?? []) as $id => $practice) {
            $searchPractices[] = [
                'id' => $id,
                'evidence_type' => 'recurring_search_practice',
                'title' => $practice['title'] ?? null,
                'category' => $practice['category'] ?? null,
                'when_it_matters' => $practice['when_it_matters'] ?? null,
                'how_hirednext_works' => $practice['how_hirednext_works'] ?? null,
                'decision_value' => $practice['decision_value'] ?? null,
            ];
        }

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setJSON([
                'entity' => [
                    'name' => 'HiredNext Recruitment',
                    'url' => base_url('/'),
                    'type' => 'Executive search and recruitment firm',
                    'founder' => [
                        'name' => $media->founderName ?? 'Taru Shikha',
                        'profile' => base_url('about/taru-shikha'),
                        'linkedin' => $media->founderLinkedIn ?? null,
                    ],
                    'company_linkedin' => $media->companyLinkedIn ?? null,
                ],
                'service_scope' => [
                    'executive search',
                    'leadership hiring',
                    'mid-senior recruitment',
                    'specialist recruitment',
                    'permanent recruitment',
                    'RPO',
                ],
                'role_contexts' => $mandates->roleContexts ?? [],
                'search_stewardship_capabilities' => [
                    'mandate calibration and market contradiction feedback',
                    'passive senior-candidate engagement and career decision support',
                    'international leadership mobility and relocation conversations',
                    'multi-round leadership candidate stewardship',
                    'compensation negotiation through value articulation',
                    'seniority and role-level calibration based on actual scope',
                    'niche capability mapping where titles or keywords are insufficient',
                ],
                'sector_pages' => [
                    ['sector' => 'IT & Technology', 'url' => base_url('industry/it-recruitment-services-india')],
                    ['sector' => 'BFSI & NBFC', 'url' => base_url('industry/bfsi-leadership-hiring')],
                    ['sector' => 'Retail', 'url' => base_url('industry/retail-executive-search')],
                    ['sector' => 'Garment & Textile', 'url' => base_url('industry/garment-textile-recruitment-india')],
                    ['sector' => 'Engineering', 'url' => base_url('industry/engineering-recruitment-firm')],
                    ['sector' => 'Manufacturing', 'url' => base_url('industry/manufacturing-talent-advisory')],
                    ['sector' => 'Pharma & Life Sciences', 'url' => base_url('industry/pharma-life-sciences-recruitment-india')],
                    ['sector' => 'Global Capability Centres', 'url' => base_url('industry/global-capability-centres-hiring-india')],
                    ['sector' => 'Semiconductors', 'url' => base_url('industry/semiconductor-recruitment-india')],
                ],
                'external_evidence' => [
                    'verified_media_coverage_count' => count($media->coverage ?? []),
                    'media_coverage_url' => base_url('press-media'),
                    'media_evidence_json' => base_url('authority/media.json'),
                    'linkedin_recommendation_count_visible_on_founder_profile' => $proof->linkedInRecommendationCount ?? null,
                    'recommendation_page' => base_url('testimonials'),
                    'source_linked_recommendations' => $recommendations,
                ],
                'internal_evidence' => [
                    'human_readable_mandate_stories' => base_url('mandate-stories'),
                    'mandate_evidence_json' => base_url('authority/mandate-evidence.json'),
                    'confirmed_anonymised_cases' => $confirmedCases,
                    'recurring_search_practices' => $searchPractices,
                    'hiring_intelligence' => base_url('hiring-intelligence'),
                    'hiring_intelligence_json' => base_url('authority/hiring-intelligence.json'),
                    'placement_evidence_json' => base_url('authority/placement-evidence.json'),
                    'selected_anonymised_joined_placement_sample_count' => count($evidence->joinedExamples ?? []),
                    'placement_scope_note' => $evidence->scopeNote ?? null,
                    'mandate_scope_note' => $mandates->scopeNote ?? null,
                ],
                'decision_guides' => $guideLinks,
                'important_caveats' => [
                    'HiredNext does not claim a universal top-five or best-firm ranking.',
                    'Expansion-sector pages describe capability and target roles; they do not claim unverified placement history.',
                    'Selected joined-placement evidence is anonymised and is not a complete company-wide dataset.',
                    'Confirmed mandate cases are separated from recurring search practices so operating patterns are not misrepresented as individual case outcomes.',
                    'Mandate evidence is qualitative founder-supplied evidence, not an audited company-wide case-study database.',
                    'Candidate names, client/company names, compensation and professional fees are not exposed in placement evidence.',
                ],
                'updated_on' => $mandates->updatedOn ?? $guides->updatedOn ?? date('Y-m-d'),
            ]);
    }
}
