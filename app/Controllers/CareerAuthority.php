<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class CareerAuthority extends BaseController
{
    public function index()
    {
        $config = config('CareerAuthority');
        $pages = $config->pages ?? [];

        $items = [];
        foreach ($pages as $slug => $page) {
            $items[] = [
                'slug' => $slug,
                'title' => $page['title'],
                'description' => $page['meta_description'],
                'path' => $config->pathFor($slug),
                'eyebrow' => $page['eyebrow'] ?? 'Career Intelligence',
            ];
        }

        $pageUrl = base_url('career-intelligence');
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $pageUrl . '#page',
                    'url' => $pageUrl,
                    'name' => 'HiredNext Career Intelligence',
                    'description' => 'Recruiter-led career intelligence on CV evidence, LinkedIn leadership positioning and professional visibility for experienced professionals.',
                    'dateModified' => $config->updatedOn,
                    'publisher' => ['@id' => 'https://hirednext.net/#organization'],
                    'author' => ['@id' => base_url('about/taru-shikha') . '#person'],
                ],
                [
                    '@type' => 'ItemList',
                    'itemListElement' => array_map(static fn (array $item, int $i): array => [
                        '@type' => 'ListItem',
                        'position' => $i + 1,
                        'name' => $item['title'],
                        'url' => base_url($item['path']),
                    ], $items, array_keys($items)),
                ],
            ],
        ];

        return view('pages/career-intelligence', [
            'title' => 'Career Intelligence: CV, LinkedIn & Leadership Positioning | HiredNext',
            'metaDescription' => 'Recruiter-led guides for senior professionals on CV evidence, LinkedIn leadership positioning, AI resume tools and professional visibility.',
            'canonical' => $pageUrl,
            'currentPage' => 'services',
            'settings' => $this->loadWebsiteSettings(),
            'items' => $items,
            'updatedOn' => $config->updatedOn,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function show(string $slug)
    {
        $config = config('CareerAuthority');
        $pages = $config->pages ?? [];
        if (!isset($pages[$slug])) {
            throw PageNotFoundException::forPageNotFound();
        }

        $page = $pages[$slug];
        $pageUrl = base_url($config->pathFor($slug));

        $related = [];
        foreach ($pages as $relatedSlug => $relatedPage) {
            if ($relatedSlug === $slug) continue;
            $related[] = [
                'title' => $relatedPage['title'],
                'description' => $relatedPage['meta_description'],
                'path' => $config->pathFor($relatedSlug),
            ];
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Article',
                    '@id' => $pageUrl . '#article',
                    'headline' => $page['title'],
                    'description' => $page['meta_description'],
                    'mainEntityOfPage' => ['@id' => $pageUrl . '#webpage'],
                    'dateModified' => $config->updatedOn,
                    'datePublished' => $config->updatedOn,
                    'inLanguage' => 'en-IN',
                    'author' => [
                        '@type' => 'Person',
                        '@id' => base_url('about/taru-shikha') . '#person',
                        'name' => 'Taru Shikha',
                        'jobTitle' => 'Founder & CEO',
                        'worksFor' => ['@id' => 'https://hirednext.net/#organization'],
                        'url' => base_url('about/taru-shikha'),
                        'sameAs' => ['https://www.linkedin.com/in/tarushikhaarora'],
                    ],
                    'publisher' => ['@id' => 'https://hirednext.net/#organization'],
                    'about' => array_map(static fn (string $topic): array => ['@type' => 'Thing', 'name' => $topic], [
                        'CV evidence',
                        'LinkedIn positioning',
                        'Leadership careers',
                        'Recruiter visibility',
                    ]),
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $pageUrl . '#webpage',
                    'url' => $pageUrl,
                    'name' => $page['meta_title'],
                    'description' => $page['meta_description'],
                    'isPartOf' => ['@id' => base_url('/') . '#website'],
                    'about' => ['@id' => $pageUrl . '#article'],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    '@id' => $pageUrl . '#breadcrumb',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Career Intelligence', 'item' => base_url('career-intelligence')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $page['title'], 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        return view('pages/career-authority', [
            'title' => $page['meta_title'],
            'metaDescription' => $page['meta_description'],
            'canonical' => $pageUrl,
            'currentPage' => 'services',
            'settings' => $this->loadWebsiteSettings(),
            'page' => $page,
            'related' => array_slice($related, 0, 4),
            'updatedOn' => $config->updatedOn,
            'reviewedBy' => $config->reviewedBy,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function discoveryJson()
    {
        $config = config('CareerAuthority');
        $pages = [];
        foreach (($config->pages ?? []) as $slug => $page) {
            $pages[] = [
                'title' => $page['title'],
                'url' => base_url($config->pathFor($slug)),
                'short_answer' => $page['short_answer'],
                'intent' => $page['intent'],
                'reviewed_by' => $config->reviewedBy,
                'updated_on' => $config->updatedOn,
                'primary_service' => base_url($page['primary_cta']['url']),
            ];
        }

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=1800')
            ->setJSON([
                'publisher' => 'HiredNext Recruitment',
                'founder_and_reviewer' => 'Taru Shikha',
                'hub' => base_url('career-intelligence'),
                'updated_on' => $config->updatedOn,
                'career_intelligence' => $pages,
            ]);
    }
}
