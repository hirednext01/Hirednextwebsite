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
            ['loc' => base_url('cv-assessment'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('insights'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => base_url('about'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => base_url('blog'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => base_url('press-media'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => base_url('contact'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        $db = \Config\Database::connect();
        foreach ($db->table('jobs')->select('slug, updated_at')->where('status', 'open')->get()->getResultArray() as $row) {
            $urls[] = ['loc' => base_url('jobs/' . $row['slug']), 'lastmod' => $row['updated_at'] ?? null, 'changefreq' => 'daily', 'priority' => '0.9'];
        }
        foreach ($db->table('blog_posts')->select('slug, updated_at')->where('status', 'published')->get()->getResultArray() as $row) {
            $urls[] = ['loc' => base_url('blog/' . $row['slug']), 'lastmod' => $row['updated_at'] ?? null, 'changefreq' => 'monthly', 'priority' => '0.7'];
        }
        foreach ($db->table('aeo_insights')->select('slug, updated_at, published_at')->where('status', 'published')->get()->getResultArray() as $row) {
            $urls[] = ['loc' => base_url('insights/' . $row['slug']), 'lastmod' => $row['updated_at'] ?: $row['published_at'], 'changefreq' => 'monthly', 'priority' => '0.8'];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $url) {
            $xml .= '<url><loc>' . htmlspecialchars($url['loc'], ENT_XML1) . '</loc>';
            if (!empty($url['lastmod'])) $xml .= '<lastmod>' . htmlspecialchars(date('c', strtotime($url['lastmod'])), ENT_XML1) . '</lastmod>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq><priority>' . $url['priority'] . '</priority></url>';
        }
        $xml .= '</urlset>';
        return $this->response->setContentType('application/xml')->setBody($xml);
    }
}
