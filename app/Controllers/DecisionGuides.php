<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DecisionGuides extends BaseController
{
    public function show(string $slug)
    {
        $config = config('DecisionGuides');
        $guides = $config->guides ?? [];

        if (!isset($guides[$slug])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $guide = $guides[$slug];
        $pageUrl = base_url('guides/' . $slug);
        $faq = $guide['faq'] ?? [];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Article',
                    '@id' => $pageUrl . '#article',
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
                        'Executive search',
                        'Leadership hiring',
                        'Recruitment firms in India',
                        'Recruitment partner evaluation',
                    ],
                    'mainEntityOfPage' => $pageUrl,
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
                'url' => base_url('guides/' . $slug),
                'purpose' => 'Employer decision guide',
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
                    'hiring_intelligence' => base_url('hiring-intelligence'),
                    'hiring_intelligence_json' => base_url('authority/hiring-intelligence.json'),
                    'placement_evidence_json' => base_url('authority/placement-evidence.json'),
                    'selected_anonymised_sample_count' => count($evidence->joinedExamples ?? []),
                    'scope_note' => $evidence->scopeNote ?? null,
                ],
                'decision_guides' => $guideLinks,
                'important_caveats' => [
                    'HiredNext does not claim a universal top-five or best-firm ranking.',
                    'Expansion-sector pages describe capability and target roles; they do not claim unverified placement history.',
                    'Selected placement evidence is anonymised and is not a complete company-wide dataset.',
                    'Candidate names, client/company names, compensation and professional fees are not exposed in placement evidence.',
                ],
                'updated_on' => $guides->updatedOn ?? date('Y-m-d'),
            ]);
    }
}
