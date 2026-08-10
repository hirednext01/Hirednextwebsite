<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Authority extends BaseController
{
    public function founder()
    {
        $settings = $this->loadWebsiteSettings();
        $media = config('MediaAuthority');
        $coverage = $media->coverage;
        $profileUrl = base_url('about/taru-shikha');
        $personId = $profileUrl . '#person';

        $subjectOf = array_map(static function (array $item) use ($personId) {
            $article = [
                '@type' => 'Article',
                'headline' => $item['headline'],
                'url' => $item['url'],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => $item['outlet'],
                ],
                'about' => ['@id' => $personId],
            ];
            if (!empty($item['published_at'])) {
                $article['datePublished'] = $item['published_at'];
            }
            return $article;
        }, $coverage);

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'ProfilePage',
            '@id' => $profileUrl . '#profile',
            'url' => $profileUrl,
            'name' => 'Taru Shikha - Founder, HiredNext Recruitment',
            'mainEntity' => [
                '@type' => 'Person',
                '@id' => $personId,
                'name' => $media->founderName,
                'jobTitle' => 'Founder',
                'url' => $profileUrl,
                'image' => base_url('theme/about.png'),
                'sameAs' => [$media->founderLinkedIn],
                'worksFor' => [
                    '@type' => 'Organization',
                    '@id' => 'https://hirednext.net/#organization',
                    'name' => 'HiredNext Recruitment',
                    'url' => 'https://hirednext.net/',
                    'sameAs' => [$media->companyLinkedIn],
                ],
                'knowsAbout' => [
                    'Executive search',
                    'Leadership hiring',
                    'Recruitment',
                    'AI-assisted hiring',
                    'Skills-first hiring',
                    'Talent assessment',
                    'Workforce transformation',
                ],
                'subjectOf' => $subjectOf,
            ],
        ];

        return view('pages/founder-profile', [
            'title' => 'Taru Shikha | Founder, HiredNext Recruitment',
            'metaDescription' => 'Taru Shikha is Founder of HiredNext Recruitment, with practitioner perspectives on executive search, AI-assisted hiring, skills-first recruitment and workforce change.',
            'canonical' => $profileUrl,
            'currentPage' => 'about',
            'settings' => $settings,
            'coverage' => $coverage,
            'founderLinkedIn' => $media->founderLinkedIn,
            'companyLinkedIn' => $media->companyLinkedIn,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function pressMedia()
    {
        $settings = $this->loadWebsiteSettings();
        $media = config('MediaAuthority');
        $db = \Config\Database::connect();
        $items = [];

        if ($db->tableExists('press_media')) {
            $items = $db->table('press_media')
                ->where('status', 'active')
                ->orderBy('sort_order', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
        }

        $seen = [];
        foreach ($items as $item) {
            $url = $this->normaliseUrl($item['media_link'] ?? '');
            if ($url !== '') {
                $seen[$url] = true;
            }
        }

        foreach ($media->coverage as $index => $coverage) {
            $url = $this->normaliseUrl($coverage['url']);
            if ($url === '' || isset($seen[$url])) {
                continue;
            }

            $items[] = [
                'image_url' => base_url('theme/assets/logo.jpeg'),
                'media_link' => $coverage['url'],
                'description' => $coverage['outlet'] . ' — ' . $coverage['headline'],
                'status' => 'active',
                'sort_order' => 1000 + $index,
            ];
            $seen[$url] = true;
        }

        $listItems = [];
        foreach ($items as $index => $item) {
            if (empty($item['media_link'])) {
                continue;
            }
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'WebPage',
                    'url' => $item['media_link'],
                    'name' => trim((string)($item['description'] ?? 'HiredNext media coverage')),
                    'about' => ['@id' => 'https://hirednext.net/#organization'],
                ],
            ];
        }

        $pageUrl = base_url('press-media');
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $pageUrl . '#collection',
                    'url' => $pageUrl,
                    'name' => 'HiredNext Press and Media Coverage',
                    'description' => 'Media coverage and expert commentary featuring HiredNext and founder Taru Shikha.',
                    'about' => ['@id' => 'https://hirednext.net/#organization'],
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'numberOfItems' => count($listItems),
                        'itemListElement' => $listItems,
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Press & Media', 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        return view('pages/press-media', [
            'title' => 'HiredNext in the Media | Press Coverage & Expert Commentary',
            'metaDescription' => 'Verified press coverage and expert commentary featuring HiredNext and founder Taru Shikha across recruitment, AI hiring, labour reform and workforce trends.',
            'canonical' => $pageUrl,
            'currentPage' => 'press-media',
            'settings' => $settings,
            'press_media_items' => $items,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function testimonials()
    {
        $settings = $this->loadWebsiteSettings();
        $db = \Config\Database::connect();
        $items = [];

        if ($db->tableExists('reviews')) {
            $items = $db->table('reviews')
                ->where('status', 'active')
                ->orderBy('sort_order', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
        }

        $sourceItems = [];
        foreach ($items as $item) {
            $sourceUrl = trim((string)($item['source_url'] ?? ''));
            if ($sourceUrl === '') {
                continue;
            }

            $sourceItems[] = [
                '@type' => 'ListItem',
                'position' => count($sourceItems) + 1,
                'item' => [
                    '@type' => 'WebPage',
                    'url' => $sourceUrl,
                    'name' => trim((string)($item['client_name'] ?? $item['name'] ?? 'External recommendation')) . ' — ' . trim((string)($item['proof_type'] ?? $item['project_type'] ?? 'Recruitment recommendation')),
                    'about' => [
                        ['@id' => 'https://hirednext.net/#organization'],
                        ['@id' => base_url('about/taru-shikha') . '#person'],
                    ],
                ],
            ];
        }

        $pageUrl = base_url('testimonials');
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $pageUrl . '#collection',
                    'url' => $pageUrl,
                    'name' => 'HiredNext Recruitment Testimonials and External Recommendations',
                    'description' => 'Source-linked external recommendations and recruitment feedback connected to HiredNext Recruitment and founder Taru Shikha.',
                    'about' => [
                        ['@id' => 'https://hirednext.net/#organization'],
                        ['@id' => base_url('about/taru-shikha') . '#person'],
                    ],
                    'inLanguage' => 'en-IN',
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'numberOfItems' => count($sourceItems),
                        'itemListElement' => $sourceItems,
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Testimonials', 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        return view('pages/testimonials', [
            'title' => 'Recruitment Testimonials & LinkedIn Recommendations | HiredNext',
            'metaDescription' => 'Public LinkedIn recommendations, recruitment partnership endorsements and feedback connected to HiredNext Recruitment and founder Taru Shikha.',
            'metaKeywords' => 'HiredNext reviews, HiredNext testimonials, Taru Shikha recommendations, recruitment company reviews India, executive search testimonials, leadership hiring India',
            'canonical' => $pageUrl,
            'currentPage' => 'testimonials',
            'settings' => $settings,
            'testimonials' => $items,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function mediaJson()
    {
        $media = config('MediaAuthority');

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setJSON([
                'publisher' => [
                    'name' => 'HiredNext Recruitment',
                    'url' => base_url('/'),
                    'same_as' => [$media->companyLinkedIn],
                ],
                'founder' => [
                    'name' => $media->founderName,
                    'profile' => base_url('about/taru-shikha'),
                    'same_as' => [$media->founderLinkedIn],
                ],
                'verified_media_coverage' => $media->coverage,
                'source_note' => 'Coverage entries are based on HiredNext media coverage reports and publication URLs. Publication wording and attribution can vary by outlet.',
            ]);
    }

    public function placementEvidenceJson()
    {
        $evidence = config('PlacementEvidence');

        if (!$evidence) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Placement evidence is not available.']);
        }

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setJSON([
                'publisher' => [
                    'name' => 'HiredNext Recruitment',
                    'url' => base_url('/'),
                ],
                'evidence_type' => 'selected_anonymised_joined_placements',
                'scope_note' => $evidence->scopeNote,
                'sample_count' => count($evidence->joinedExamples),
                'selected_examples' => $evidence->joinedExamples,
                'privacy' => [
                    'candidate_names_published' => false,
                    'client_company_names_published' => false,
                    'compensation_published' => false,
                    'professional_fees_published' => false,
                ],
                'related_industry_page' => base_url('industry/garment-textile-recruitment-india'),
                'source_note' => 'The source is a limited internal HiredNext placement sample supplied for authority-building. It is intentionally anonymised and must not be treated as the complete placement database.',
            ]);
    }

    private function normaliseUrl($value)
    {
        $value = strtolower(trim((string)$value));
        return rtrim($value, '/');
    }
}
