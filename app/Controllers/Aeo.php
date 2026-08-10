<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Aeo extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $insights = $db->tableExists('aeo_insights')
            ? $db->table('aeo_insights')->where('status', 'published')->orderBy('published_at', 'DESC')->get()->getResultArray()
            : [];

        $url = base_url('insights');
        $items = [];
        foreach ($insights as $index => $insight) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $insight['title'] ?? 'HiredNext answer',
                'url' => base_url('insights/' . ($insight['slug'] ?? '')),
            ];
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $url . '#collection',
                    'url' => $url,
                    'name' => 'HiredNext Hiring Answers',
                    'description' => 'Direct answers from HiredNext on recruitment, executive search, careers, AI-assisted hiring and workforce decisions in India.',
                    'inLanguage' => 'en-IN',
                    'publisher' => ['@id' => 'https://hirednext.net/#organization'],
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'numberOfItems' => count($items),
                        'itemListElement' => $items,
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Hiring Answers', 'item' => $url],
                    ],
                ],
            ],
        ];

        return view('pages/insights/index', [
            'title' => 'Hiring Answers: Recruitment, Careers & AI | HiredNext',
            'metaDescription' => 'Direct, recruiter-led answers on executive search, leadership hiring, career decisions, AI-assisted recruitment and workforce strategy in India.',
            'canonical' => $url,
            'currentPage' => 'blog',
            'insights' => $insights,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function show($slug = null)
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('aeo_insights')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $insight = $db->table('aeo_insights')->where('slug', $slug)->where('status', 'published')->get()->getRowArray();
        if (!$insight) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $faq = [];
        if (!empty($insight['faq_json'])) {
            $decoded = json_decode($insight['faq_json'], true);
            if (is_array($decoded)) {
                $faq = array_values(array_filter($decoded, static fn($item) => !empty($item['question']) && !empty($item['answer'])));
            }
        }

        $url = base_url('insights/' . $insight['slug']);
        $description = trim((string)($insight['meta_description'] ?? '')) ?: trim((string)($insight['excerpt'] ?? ''));
        if ($description === '') {
            $description = $this->truncateText($insight['content'] ?? '', 165);
        }

        $authorName = trim((string)($insight['author'] ?? '')) ?: 'HiredNext Editorial';
        if (strcasecmp($authorName, 'Taru Shikha') === 0) {
            $authorSchema = [
                '@type' => 'Person',
                '@id' => base_url('about/taru-shikha') . '#person',
                'name' => 'Taru Shikha',
                'url' => base_url('about/taru-shikha'),
                'jobTitle' => 'Founder, HiredNext',
                'sameAs' => ['https://www.linkedin.com/in/tarushikhaarora'],
                'worksFor' => ['@id' => 'https://hirednext.net/#organization'],
            ];
        } else {
            $authorSchema = [
                '@type' => 'Organization',
                '@id' => 'https://hirednext.net/#organization',
                'name' => 'HiredNext Recruitment',
            ];
        }

        $about = [];
        foreach (['industry', 'location', 'role'] as $field) {
            $value = trim((string)($insight[$field] ?? ''));
            if ($value !== '') {
                $about[] = ['@type' => 'Thing', 'name' => $value];
            }
        }

        $article = [
            '@type' => 'Article',
            '@id' => $url . '#article',
            'headline' => $insight['title'],
            'description' => $description,
            'datePublished' => $this->schemaDate($insight['published_at'] ?? null),
            'dateModified' => $this->schemaDate($insight['updated_at'] ?? $insight['published_at'] ?? null),
            'author' => $authorSchema,
            'publisher' => ['@id' => 'https://hirednext.net/#organization'],
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $url],
            'url' => $url,
            'inLanguage' => 'en-IN',
            'articleSection' => trim((string)($insight['industry'] ?? '')) ?: 'Recruitment',
            'about' => $about,
        ];
        if ($article['datePublished'] === null) unset($article['datePublished']);
        if ($article['dateModified'] === null) unset($article['dateModified']);
        if (empty($article['about'])) unset($article['about']);

        $graph = [
            $article,
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Hiring Answers', 'item' => base_url('insights')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $insight['title'], 'item' => $url],
                ],
            ],
        ];

        if (!empty($faq)) {
            $graph[] = [
                '@type' => 'FAQPage',
                'mainEntity' => array_map(static function ($item) {
                    return [
                        '@type' => 'Question',
                        'name' => $item['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer']],
                    ];
                }, $faq),
            ];
        }

        $metaTitle = trim((string)($insight['meta_title'] ?? '')) ?: trim((string)$insight['title']);
        if (stripos($metaTitle, 'HiredNext') === false) {
            $metaTitle .= ' | HiredNext';
        }

        return view('pages/insights/show', [
            'title' => $metaTitle,
            'metaDescription' => $description,
            'canonical' => $url,
            'ogType' => 'article',
            'articleAuthor' => $authorName,
            'publishedTime' => $this->schemaDate($insight['published_at'] ?? null),
            'modifiedTime' => $this->schemaDate($insight['updated_at'] ?? $insight['published_at'] ?? null),
            'currentPage' => 'blog',
            'insight' => $insight,
            'faq' => $faq,
            'jsonLd' => json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    private function truncateText($value, int $limit): string
    {
        $text = html_entity_decode(strip_tags((string)$value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim((string)preg_replace('/\s+/u', ' ', $text));
        if (mb_strlen($text) <= $limit) return $text;
        $cut = mb_substr($text, 0, $limit + 1);
        $space = mb_strrpos($cut, ' ');
        if ($space !== false) $cut = mb_substr($cut, 0, $space);
        return rtrim($cut, " \t\n\r\0\x0B,.;:-") . '…';
    }

    private function schemaDate($value): ?string
    {
        if (empty($value) || strtotime((string)$value) === false) return null;
        return date(DATE_ATOM, strtotime((string)$value));
    }
}
