<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ReputationAuthority extends BaseController
{
    public function testimonials()
    {
        $settings = $this->loadWebsiteSettings();
        $db = \Config\Database::connect();
        $items = [];

        if ($db->tableExists('reviews')) {
            $builder = $db->table('reviews')
                ->groupStart()
                    ->where('status', 'active')
                    ->orWhere('status', 'external')
                ->groupEnd()
                ->orderBy('sort_order', 'ASC')
                ->orderBy('created_at', 'DESC');
            $items = $builder->get()->getResultArray();
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
}
