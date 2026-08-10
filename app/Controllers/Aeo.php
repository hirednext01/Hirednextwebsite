<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Aeo extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $insights = $db->table('aeo_insights')->where('status', 'published')->orderBy('published_at', 'DESC')->get()->getResultArray();

        return view('pages/insights/index', [
            'title' => 'Hiring Insights & Career Answers | HiredNext',
            'currentPage' => 'blog',
            'insights' => $insights,
        ]);
    }

    public function show($slug = null)
    {
        $db = \Config\Database::connect();
        $insight = $db->table('aeo_insights')->where('slug', $slug)->where('status', 'published')->get()->getRowArray();
        if (!$insight) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $faq = [];
        if (!empty($insight['faq_json'])) {
            $decoded = json_decode($insight['faq_json'], true);
            if (is_array($decoded)) $faq = $decoded;
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $insight['title'],
            'description' => $insight['meta_description'] ?: $insight['excerpt'],
            'datePublished' => $insight['published_at'],
            'dateModified' => $insight['updated_at'],
            'author' => ['@type' => 'Person', 'name' => $insight['author'] ?: 'HiredNext Recruitment'],
            'publisher' => ['@type' => 'Organization', 'name' => 'HiredNext Recruitment', 'url' => base_url()],
            'mainEntityOfPage' => base_url('insights/' . $insight['slug']),
        ];
        if (!empty($faq)) {
            $jsonLd['hasPart'] = ['@type' => 'FAQPage', 'mainEntity' => array_map(static function ($item) {
                return ['@type' => 'Question', 'name' => $item['question'] ?? '', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer'] ?? '']];
            }, $faq)];
        }

        return view('pages/insights/show', [
            'title' => ($insight['meta_title'] ?: $insight['title']) . ' | HiredNext',
            'currentPage' => 'blog',
            'insight' => $insight,
            'faq' => $faq,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ]);
    }
}
