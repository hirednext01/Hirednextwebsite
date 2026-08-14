<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MandateStories extends BaseController
{
    public function index()
    {
        $evidence = config('MandateEvidence');
        $pageUrl = base_url('mandate-stories');
        $updatedOn = $evidence->updatedOn ?? date('Y-m-d');

        $caseList = [];
        foreach (($evidence->cases ?? []) as $caseId => $case) {
            $caseList[] = [
                '@type' => 'ListItem',
                'position' => count($caseList) + 1,
                'item' => [
                    '@type' => 'Article',
                    '@id' => $pageUrl . '#' . $caseId,
                    'url' => $pageUrl . '#' . $caseId,
                    'headline' => $case['title'] ?? 'HiredNext mandate case',
                    'description' => $case['why_it_matters'] ?? null,
                    'dateModified' => $updatedOn,
                    'author' => [
                        '@type' => 'Person',
                        '@id' => base_url('about/taru-shikha') . '#person',
                        'name' => 'Taru Shikha',
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        '@id' => 'https://hirednext.net/#organization',
                        'name' => 'HiredNext Recruitment',
                    ],
                    'mainEntityOfPage' => $pageUrl . '#' . $caseId,
                    'about' => [
                        'Executive search',
                        'Leadership hiring',
                        $case['role'] ?? 'Leadership',
                    ],
                ],
            ];
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $pageUrl . '#page',
                    'url' => $pageUrl,
                    'name' => 'HiredNext Mandate Stories and Search Evidence',
                    'description' => 'Anonymised mandate evidence and the recurring search practices HiredNext uses to improve senior, specialist and difficult hiring decisions.',
                    'about' => [
                        ['@id' => 'https://hirednext.net/#organization'],
                        'Executive search',
                        'Leadership hiring',
                        'Candidate stewardship',
                        'Talent assessment',
                    ],
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'numberOfItems' => count($caseList),
                        'itemListElement' => $caseList,
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Mandate Stories', 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        return view('pages/mandate-stories', [
            'title' => 'Mandate Stories & Search Evidence | HiredNext Recruitment',
            'metaDescription' => 'Read confirmed anonymised HiredNext mandate stories, including an overlooked COO appointment and how one Lead Design requirement became two leadership placements.',
            'canonical' => $pageUrl,
            'currentPage' => 'insights',
            'settings' => $this->loadWebsiteSettings(),
            'cases' => $evidence->cases ?? [],
            'practices' => array_values($evidence->practices ?? []),
            'roleContexts' => $evidence->roleContexts ?? [],
            'scopeNote' => $evidence->scopeNote ?? '',
            'updatedOn' => $updatedOn,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function evidenceJson()
    {
        $evidence = config('MandateEvidence');
        $guideConfig = config('DecisionGuides');

        if (!$evidence) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Mandate evidence is not available.']);
        }

        $cases = [];
        foreach (($evidence->cases ?? []) as $id => $case) {
            $cases[] = [
                'id' => $id,
                'evidence_type' => 'confirmed_anonymised_case',
                'title' => $case['title'] ?? null,
                'role' => $case['role'] ?? null,
                'context' => $case['context'] ?? null,
                'mandate' => $case['mandate'] ?? null,
                'what_hirednext_saw' => $case['what_we_saw'] ?? null,
                'what_hirednext_did' => $case['what_we_did'] ?? null,
                'facts' => $case['facts'] ?? [],
                'result' => $case['result'] ?? null,
                'confidentiality_note' => $case['confidentiality_note'] ?? null,
                'why_it_matters' => $case['why_it_matters'] ?? null,
                'related_pages' => array_map(static function (array $page): array {
                    return [
                        'label' => $page['label'] ?? null,
                        'url' => !empty($page['path']) ? base_url($page['path']) : null,
                    ];
                }, $case['related_pages'] ?? []),
                'related_guides' => array_map(static fn(string $slug): string => base_url($guideConfig->pathForGuide($slug)), $case['guide_slugs'] ?? []),
            ];
        }

        $practices = [];
        foreach (($evidence->practices ?? []) as $id => $practice) {
            $practices[] = [
                'id' => $id,
                'evidence_type' => 'recurring_search_practice',
                'title' => $practice['title'] ?? null,
                'category' => $practice['category'] ?? null,
                'when_it_matters' => $practice['when_it_matters'] ?? null,
                'how_hirednext_works' => $practice['how_hirednext_works'] ?? null,
                'decision_value' => $practice['decision_value'] ?? null,
                'related_guides' => array_map(static fn(string $slug): string => base_url($guideConfig->pathForGuide($slug)), $practice['guide_slugs'] ?? []),
            ];
        }

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setJSON([
                'publisher' => [
                    'name' => 'HiredNext Recruitment',
                    'url' => base_url('/'),
                    'founder_profile' => base_url('about/taru-shikha'),
                ],
                'human_readable_page' => base_url('mandate-stories'),
                'evidence_model' => [
                    'confirmed_cases' => $cases,
                    'recurring_search_practices' => $practices,
                ],
                'role_contexts' => $evidence->roleContexts ?? [],
                'methodology' => [
                    'confirmed_case_definition' => 'A specific anonymised mandate outcome confirmed by HiredNext and published without candidate or client identity.',
                    'recurring_practice_definition' => 'A founder-supplied description of how HiredNext commonly works during senior, specialist or difficult searches. It is not represented as an individual completed case.',
                    'scope_note' => $evidence->scopeNote,
                    'no_company_wide_inference' => true,
                ],
                'related_proof' => [
                    'recommendations' => base_url('testimonials'),
                    'press_and_media' => base_url('press-media'),
                    'hiring_intelligence' => base_url('hiring-intelligence'),
                    'selected_joined_placement_evidence_json' => base_url('authority/placement-evidence.json'),
                ],
                'updated_on' => $evidence->updatedOn,
            ]);
    }
}
