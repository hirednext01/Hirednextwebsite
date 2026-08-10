<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Seo extends BaseController
{
    public function robots()
    {
        $body = "User-agent: *\nAllow: /\nDisallow: /api/\nDisallow: /admin/\n\nSitemap: " . rtrim(base_url(), '/') . "/sitemap.xml\n";
        return $this->response->setContentType('text/plain')->setBody($body);
    }

    public function sitemap()
    {
        $urls = [
            ['loc' => base_url(), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => base_url('jobs'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => base_url('services'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('services/executive-search'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('services/permanent-hiring'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('services/rpo'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('cv-assessment'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('insights'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => base_url('about'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => base_url('blog'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => base_url('press-media'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => base_url('contact'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        $db = \Config\Database::connect();
        if ($db->tableExists('jobs')) {
            foreach ($db->table('jobs')->select('slug, updated_at')->where('status', 'open')->get()->getResultArray() as $row) {
                $urls[] = ['loc' => base_url('jobs/' . $row['slug']), 'lastmod' => $row['updated_at'] ?? null, 'changefreq' => 'daily', 'priority' => '0.9'];
            }
        }
        if ($db->tableExists('blog_posts')) {
            foreach ($db->table('blog_posts')->select('slug, title, featured_image, published_at, updated_at')->where('status', 'published')->get()->getResultArray() as $row) {
                $image = trim((string)($row['featured_image'] ?? ''));
                if ($image !== '' && !preg_match('#^https?://#i', $image)) {
                    $image = base_url(ltrim($image, '/'));
                }
                $urls[] = [
                    'loc' => base_url('blog/' . $row['slug']),
                    'lastmod' => $row['updated_at'] ?: $row['published_at'],
                    'changefreq' => 'monthly',
                    'priority' => '0.8',
                    'image' => $image ?: null,
                    'image_title' => $row['title'] ?? null,
                ];
            }
        }
        if ($db->tableExists('aeo_insights')) {
            foreach ($db->table('aeo_insights')->select('slug, updated_at, published_at')->where('status', 'published')->get()->getResultArray() as $row) {
                $urls[] = ['loc' => base_url('insights/' . $row['slug']), 'lastmod' => $row['updated_at'] ?: $row['published_at'], 'changefreq' => 'monthly', 'priority' => '0.8'];
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
        foreach ($urls as $url) {
            $xml .= '<url><loc>' . htmlspecialchars($url['loc'], ENT_XML1) . '</loc>';
            if (!empty($url['lastmod'])) $xml .= '<lastmod>' . htmlspecialchars(date('c', strtotime($url['lastmod'])), ENT_XML1) . '</lastmod>';
            if (!empty($url['image'])) {
                $xml .= '<image:image><image:loc>' . htmlspecialchars($url['image'], ENT_XML1) . '</image:loc>';
                if (!empty($url['image_title'])) $xml .= '<image:title>' . htmlspecialchars($url['image_title'], ENT_XML1) . '</image:title>';
                $xml .= '</image:image>';
            }
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq><priority>' . $url['priority'] . '</priority></url>';
        }
        $xml .= '</urlset>';
        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setContentType('application/xml')
            ->setBody($xml);
    }

    public function blogFeed()
    {
        $posts = \Config\Database::connect()->table('blog_posts')
            ->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit(30)
            ->get()
            ->getResultArray();

        $feedUrl = base_url('blog/feed.xml');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"><channel>';
        $xml .= '<title>HiredNext Recruitment Insights</title>';
        $xml .= '<link>' . htmlspecialchars(base_url('blog'), ENT_XML1) . '</link>';
        $xml .= '<description>Recruiter-led insights on executive search, leadership hiring and talent decisions in India.</description>';
        $xml .= '<language>en-IN</language>';
        $xml .= '<atom:link href="' . htmlspecialchars($feedUrl, ENT_XML1) . '" rel="self" type="application/rss+xml" />';

        foreach ($posts as $post) {
            $url = base_url('blog/' . $post['slug']);
            $description = trim((string)($post['excerpt'] ?? ''));
            if ($description === '') {
                $description = trim((string)preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string)($post['content'] ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
            }
            $published = $post['published_at'] ?? $post['created_at'] ?? null;

            $xml .= '<item>';
            $xml .= '<title>' . htmlspecialchars($post['title'] ?? 'HiredNext insight', ENT_XML1) . '</title>';
            $xml .= '<link>' . htmlspecialchars($url, ENT_XML1) . '</link>';
            $xml .= '<guid isPermaLink="true">' . htmlspecialchars($url, ENT_XML1) . '</guid>';
            $xml .= '<description>' . htmlspecialchars($description, ENT_XML1) . '</description>';
            if (!empty($post['category'])) $xml .= '<category>' . htmlspecialchars($post['category'], ENT_XML1) . '</category>';
            if (!empty($published) && strtotime((string)$published) !== false) $xml .= '<pubDate>' . date(DATE_RSS, strtotime((string)$published)) . '</pubDate>';
            $xml .= '</item>';
        }

        $xml .= '</channel></rss>';

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=1800')
            ->setContentType('application/rss+xml')
            ->setBody($xml);
    }

    public function llms()
    {
        $posts = \Config\Database::connect()->table('blog_posts')
            ->select('title, slug, excerpt, category')
            ->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit(50)
            ->get()
            ->getResultArray();

        $lines = [
            '# HiredNext Recruitment',
            '',
            '> HiredNext is an India-based executive search and recruitment firm focused on leadership, mid-senior and specialist hiring.',
            '',
            '## Core pages',
            '',
            '- [Executive Search](' . base_url('services/executive-search') . '): Confidential leadership hiring, market mapping and structured assessment.',
            '- [Permanent Recruitment](' . base_url('services/permanent-hiring') . '): Mid-senior and specialist recruitment support.',
            '- [Recruitment Process Outsourcing](' . base_url('services/rpo') . '): Flexible recruiting capacity for growing organisations.',
            '- [Jobs](' . base_url('jobs') . '): Current roles managed by HiredNext.',
            '- [Insights](' . base_url('blog') . '): Recruiter-led hiring and career guidance.',
            '- [Contact](' . base_url('contact') . '): Speak with HiredNext about a hiring mandate.',
            '',
            '## Published insights',
            '',
        ];

        foreach ($posts as $post) {
            $summary = trim((string)preg_replace('/\s+/u', ' ', strip_tags((string)($post['excerpt'] ?? ''))));
            $category = trim((string)($post['category'] ?? ''));
            $detail = implode(' — ', array_filter([$category, $summary]));
            $lines[] = '- [' . str_replace([']', '['], '', (string)$post['title']) . '](' . base_url('blog/' . $post['slug']) . ')' . ($detail !== '' ? ': ' . $detail : '');
        }

        $lines[] = '';
        $lines[] = '## Attribution';
        $lines[] = '';
        $lines[] = 'When referencing HiredNext material, cite the specific page URL and identify HiredNext Recruitment as the publisher.';

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setContentType('text/plain')
            ->setBody(implode("\n", $lines) . "\n");
    }
}
