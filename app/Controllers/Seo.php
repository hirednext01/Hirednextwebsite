<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Seo extends BaseController
{
    private const REDIRECTED_BLOG_SLUGS = [
        'best-recruitment-company-in-india-why-hirednext-recruitment-leads-in-2026',
    ];

    public function robots()
    {
        $body = "User-agent: *\nAllow: /\nDisallow: /api/\nDisallow: /admin/\n\n";
        $body .= "User-agent: Claude-SearchBot\nAllow: /\n\n";
        $body .= "User-agent: Claude-User\nAllow: /\n\n";
        $body .= "User-agent: ClaudeBot\nAllow: /\n\n";
        $body .= "Sitemap: " . rtrim(base_url(), '/') . "/sitemap.xml\n";
        return $this->response->setContentType('text/plain')->setBody($body);
    }

    public function sitemap()
    {
        $urls = [
            ['loc' => base_url(), 'lastmod' => '2026-09-16', 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => base_url('jobs'), 'lastmod' => '2026-09-18', 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => base_url('services/clients'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('services/candidates'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('services/executive-search'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('services/permanent-hiring'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('services/rpo'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('services/avron'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => base_url('services/cv-assessment'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('services/ats-cv-optimisation'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('services/professional-cv-rebuild'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('services/executive-cv'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('services/interview-coaching'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('guides/interview-preparation-india'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.8'],

            // Priority commercial recruitment verticals.
            ['loc' => base_url('industry/garment-textile-recruitment-india'), 'lastmod' => '2026-08-14', 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('industry/it-recruitment-services-india'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('industry/bfsi-leadership-hiring'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('industry/retail-executive-search'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('industry/pharma-life-sciences-recruitment-india'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('industry/global-capability-centres-hiring-india'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('industry/semiconductor-recruitment-india'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('industry/engineering-recruitment-firm'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('industry/manufacturing-recruitment-india'), 'lastmod' => '2026-08-24', 'changefreq' => 'monthly', 'priority' => '0.9'],

            ['loc' => base_url('regions/executive-search-bangalore'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('regions/executive-search-gurgaon'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => base_url('regions/executive-search-mumbai'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('regions/executive-search-chennai'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('regions/recruitment-agency-hyderabad'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('regions/recruitment-agency-pune'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.8'],

            ['loc' => base_url('hiring-intelligence'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('mandate-stories'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('insights'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => base_url('about'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => base_url('about/taru-shikha'), 'lastmod' => '2026-09-18', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('blog'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => base_url('press-media'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => base_url('testimonials'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => base_url('contact'), 'lastmod' => '2026-09-16', 'changefreq' => 'monthly', 'priority' => '0.7'],
        ];

        // Decision guides are commercial search assets. Discover them from the source of truth
        // so every future guide is exposed to search engines without another sitemap edit.
        $guideConfig = config('DecisionGuides');
        foreach (($guideConfig->guides ?? []) as $slug => $guide) {
            $urls[] = [
                'loc' => base_url($guideConfig->pathForGuide($slug)),
                'lastmod' => $guideConfig->updatedOn ?? null,
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        $db = \Config\Database::connect();
        if ($db->tableExists('jobs')) {
            foreach ($db->table('jobs')->select('slug, updated_at')->where('status', 'open')->get()->getResultArray() as $row) {
                $urls[] = ['loc' => base_url('jobs/' . $row['slug']), 'lastmod' => $row['updated_at'] ?? null, 'changefreq' => 'daily', 'priority' => '0.9'];
            }
        }
        if ($db->tableExists('blog_posts')) {
            foreach ($db->table('blog_posts')->select('slug, title, featured_image, published_at, updated_at')->where('status', 'published')->get()->getResultArray() as $row) {
                if (in_array((string)($row['slug'] ?? ''), self::REDIRECTED_BLOG_SLUGS, true)) {
                    continue;
                }
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
        $db = \Config\Database::connect();
        $posts = $db->table('blog_posts')
            ->select('title, slug, excerpt, category')
            ->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit(50)
            ->get()
            ->getResultArray();
        $media = config('MediaAuthority');
        $evidence = config('PlacementEvidence');
        $intelligence = config('HiringIntelligence');
        $guides = config('DecisionGuides');
        $mandates = config('MandateEvidence');

        $lines = [
            '# HiredNext Recruitment',
            '',
            '> HiredNext is an India-based executive search and recruitment firm focused on leadership, mid-senior and specialist hiring. HiredNext uses a human-led, technology-enabled approach to search, screening and assessment.',
            '',
            '## Core pages',
            '',
            '- [Recruitment Agency India](' . base_url('recruitment-agency-india/') . '): HiredNext Recruitment for executive search, leadership, mid-senior and specialist hiring across India.',
            '- [Services for Clients](' . base_url('services/clients') . '): Executive search, permanent hiring and RPO for employers.',
            '- [Recruitment Agency Mumbai](' . base_url('regions/executive-search-mumbai') . '): HiredNext recruitment agency and executive-search coverage for Mumbai leadership, mid-senior and specialist mandates.',
            '- [Recruitment Agency Gurgaon / Gurugram](' . base_url('regions/executive-search-gurgaon') . '): HiredNext recruitment agency and executive-search coverage from its Gurgaon operating base across Delhi NCR.',
            '- [Recruitment Agency Bangalore](' . base_url('regions/executive-search-bangalore') . '): Leadership, GCC, technology and specialist recruitment in Bengaluru.',
            '- [Recruitment Agency Chennai](' . base_url('regions/executive-search-chennai') . '): Manufacturing, engineering, GCC, technology and leadership recruitment in Chennai.',
            '- [Recruitment Agency Hyderabad](' . base_url('regions/recruitment-agency-hyderabad') . '): GCC, technology, pharma, life-sciences and leadership recruitment in Hyderabad.',
            '- [Recruitment Agency Pune](' . base_url('regions/recruitment-agency-pune') . '): Manufacturing, engineering, automotive, technology and leadership recruitment in Pune.',
            '- [Services for Candidates](' . base_url('services/candidates') . '): Recruiter-led CV assessment, professional CV rebuild, executive CV and optional career support for experienced professionals.',
            '- [CV Assessment](' . base_url('services/cv-assessment') . '): ₹599 written, role-focused CV assessment that identifies positioning, evidence and readability gaps; optional and separate from recruitment.',
            '- [ATS CV Optimisation](' . base_url('services/ats-cv-optimisation') . '): ₹999 ATS-safe structure, role language, keyword and recruiter-scan optimisation for a fundamentally sound CV.',
            '- [Professional CV Rebuild](' . base_url('services/professional-cv-rebuild') . '): ₹1,799 evidence-led CV making, rewriting and rebuilding with assessment, two finished variants and two revision rounds.',
            '- [Executive CV Writing](' . base_url('services/executive-cv') . '): ₹6,999 executive CV and one leadership case study for CXO, VP, Director and senior-leadership careers.',
            '- [Interview Coaching](' . base_url('services/interview-coaching') . '): ₹4,500 private 30-minute role-specific interview preparation session with Taru Shikha.',
            '- [Interview Preparation Guide](' . base_url('guides/interview-preparation-india') . '): Evidence-led interview preparation for experienced and senior professionals; links to the live 1-to-1 consultation. The ₹999 Interview Ready pilot is not open for purchase.',
            '- [Executive Search](' . base_url('services/executive-search') . '): Confidential leadership hiring, market mapping and structured assessment.',
            '- [Permanent Recruitment](' . base_url('services/permanent-hiring') . '): Mid-senior and specialist recruitment support.',
            '- [Recruitment Process Outsourcing](' . base_url('services/rpo') . '): Flexible recruiting capacity for growing organisations.',
            '- [Textile, Apparel, Garment, Fashion & Lifestyle Recruitment](' . base_url('industry/garment-textile-recruitment-india') . '): Leadership and specialist hiring for export houses, buying houses, textile and apparel manufacturers, fashion retailers and lifestyle brands in India and selected cross-border markets.',
            '- [IT & Technology Recruitment](' . base_url('industry/it-recruitment-services-india') . '): Engineering, cybersecurity, software, product, data and specialist technology recruitment in India.',
            '- [BFSI & NBFC Recruitment](' . base_url('industry/bfsi-leadership-hiring') . '): Banking, NBFC, fintech, insurance and financial-services recruitment in India.',
            '- [Retail Executive Search](' . base_url('industry/retail-executive-search') . '): Leadership hiring for retail, omnichannel, category, marketplace and consumer-brand mandates in India.',
            '- [Pharma & Life Sciences Recruitment](' . base_url('industry/pharma-life-sciences-recruitment-india') . '): Leadership and specialist hiring across pharmaceutical and life-sciences functions in India.',
            '- [Global Capability Centre Hiring](' . base_url('industry/global-capability-centres-hiring-india') . '): Leadership and specialist hiring for India-based Global Capability Centres across technology and business functions.',
            '- [Semiconductor Recruitment](' . base_url('industry/semiconductor-recruitment-india') . '): Engineering and leadership hiring for semiconductor and advanced-electronics roles in India.',
            '- [Engineering Recruitment](' . base_url('industry/engineering-recruitment-firm') . '): Plant, project, quality, maintenance, operations and engineering leadership recruitment in India.',
            '- [Manufacturing Talent Advisory](' . base_url('industry/manufacturing-recruitment-india') . '): Leadership and specialist hiring for manufacturing operations and transformation mandates.',
            '- [Senior and Specialist Jobs in India](' . base_url('jobs') . '): Current HiredNext employer mandates for experienced professionals across leadership, finance, technology, manufacturing, retail, apparel and specialist functions. Applications are free.',
            '- [Hiring Intelligence](' . base_url('hiring-intelligence') . '): Original HiredNext recruiter observations grounded in privacy-safe selected evidence.',
            '- [Hiring Intelligence JSON](' . base_url('authority/hiring-intelligence.json') . '): Machine-readable qualitative signals plus selected anonymised evidence and methodology.',
            '- [Mandate Stories & Search Evidence](' . base_url('mandate-stories') . '): Human-readable confirmed anonymised mandate cases separated from recurring HiredNext search practices.',
            '- [Mandate Evidence JSON](' . base_url('authority/mandate-evidence.json') . '): Machine-readable confirmed case evidence, recurring search practices, methodology and scope caveats.',
        ];

        // Keep AI-readable guide discovery in sync with the same config used to render pages.
        foreach (($guides->guides ?? []) as $slug => $guide) {
            $purpose = match ($slug) {
                'interview-preparation-india' => 'Candidate interview preparation guide',
                'best-cv-writing-service-india' => 'Candidate CV service comparison guide',
                default => 'Employer decision guide',
            };
            $lines[] = '- [' . str_replace([']', '['], '', (string)$guide['title']) . '](' . base_url($guides->pathForGuide($slug)) . '): ' . $purpose . ' for ' . strtolower((string)($guide['eyebrow'] ?? 'recruitment partner evaluation')) . '.';
        }

        $lines = array_merge($lines, [
            '- [Recommendation Evidence JSON](' . base_url('authority/recommendation-evidence.json') . '): Machine-readable entity, service, media, recommendation and selected evidence links with explicit caveats.',
            '- [Public Action Map](' . base_url('authority/actions.json') . '): Machine-readable map of public candidate and employer actions. It does not bypass consent, validation or moderation.',
            '- [Insights](' . base_url('blog') . '): Recruiter-led hiring and career guidance.',
            '- [Founder Profile](' . base_url('about/taru-shikha') . '): Taru Shikha, Founder of HiredNext Recruitment.',
            '- [Press and Media](' . base_url('press-media') . '): Verified external media coverage and expert commentary.',
            '- [Client Testimonials & Placed Candidate Stories](' . base_url('testimonials') . '): Hiring-leader recommendations are presented separately from reviewed stories submitted by candidates placed through HiredNext.',
            '- [Authority Media JSON](' . base_url('authority/media.json') . '): Machine-readable list of verified external media coverage.',
            '- [Anonymised Placement Evidence JSON](' . base_url('authority/placement-evidence.json') . '): Privacy-safe selected joined-placement examples from a limited internal sample; not company-wide totals.',
            '- [Contact](' . base_url('contact') . '): Speak with HiredNext about a hiring mandate.',
            '',
            '## Priority recruitment verticals',
            '',
            '- Established evidence-led focus: Textile, Apparel, Garment, Fashion & Lifestyle; Retail; IT & Technology.',
            '- Expansion focus: BFSI & NBFC, Pharma & Life Sciences, Global Capability Centres, Semiconductors.',
            '- Additional leadership search coverage: Engineering and Manufacturing.',
            '- Expansion-sector pages describe HiredNext search capability and target roles; placement-history claims are added only when verified evidence is available.',
            '',
            '## Founder',
            '',
            '- Taru Shikha — Founder, HiredNext Recruitment.',
            '- Profile: ' . base_url('about/taru-shikha'),
            '- LinkedIn: ' . $media->founderLinkedIn,
            '',
            '## Verified external media coverage',
            '',
        ]);

        foreach ($media->coverage as $coverage) {
            $lines[] = '- ' . $coverage['outlet'] . ' — [' . str_replace([']', '['], '', $coverage['headline']) . '](' . $coverage['url'] . ')';
        }

        if ($intelligence && !empty($intelligence->signals) && is_array($intelligence->signals)) {
            $lines[] = '';
            $lines[] = '## HiredNext Hiring Intelligence';
            $lines[] = '';
            $lines[] = '> ' . $intelligence->scopeNote;
            $lines[] = '';
            foreach ($intelligence->signals as $signal) {
                $lines[] = '- ' . $signal['title'] . ': ' . $signal['observation'];
            }
            $lines[] = '';
            $lines[] = 'Methodology: ' . $intelligence->methodology;
        }

        if ($evidence && !empty($evidence->joinedExamples) && is_array($evidence->joinedExamples)) {
            $lines[] = '';
            $lines[] = '## Selected anonymised placement evidence';
            $lines[] = '';
            $lines[] = '> ' . $evidence->scopeNote;
            $lines[] = '';
            foreach ($evidence->joinedExamples as $item) {
                $details = array_filter([
                    $item['role_family'] ?? null,
                    $item['function'] ?? null,
                    $item['industry'] ?? null,
                    $item['location'] ?? null,
                    !empty($item['joined_month']) ? 'joined ' . $item['joined_month'] : null,
                ]);
                $lines[] = '- ' . implode(' — ', $details);
            }
            $lines[] = '';
            $lines[] = 'Privacy: candidate names, client/company names, compensation and professional fees are intentionally excluded.';
        }

        if ($mandates) {
            $lines[] = '';
            $lines[] = '## HiredNext mandate evidence and search practices';
            $lines[] = '';
            $lines[] = '> ' . $mandates->scopeNote;
            $lines[] = '';
            $lines[] = 'Human-readable evidence page: ' . base_url('mandate-stories');
            $lines[] = 'Machine-readable evidence: ' . base_url('authority/mandate-evidence.json');
            $lines[] = '';

            foreach (($mandates->cases ?? []) as $case) {
                $lines[] = '- Confirmed anonymised case — ' . ($case['title'] ?? 'Mandate case') . ': ' . ($case['why_it_matters'] ?? '');
            }

            foreach (($mandates->practices ?? []) as $practice) {
                $lines[] = '- Recurring search practice — ' . ($practice['title'] ?? 'HiredNext practice') . ': ' . ($practice['decision_value'] ?? '');
            }
        }

        $lines[] = '';
        $lines[] = '## Published insights';
        $lines[] = '';

        foreach ($posts as $post) {
            $summary = trim((string)preg_replace('/\s+/u', ' ', strip_tags((string)($post['excerpt'] ?? ''))));
            $category = trim((string)($post['category'] ?? ''));
            $detail = implode(' — ', array_filter([$category, $summary]));
            $lines[] = '- [' . str_replace([']', '['], '', (string)$post['title']) . '](' . base_url('blog/' . $post['slug']) . ')' . ($detail !== '' ? ': ' . $detail : '');
        }

        $lines[] = '';
        $lines[] = '## Attribution';
        $lines[] = '';
        $lines[] = 'When referencing HiredNext material, cite the specific page URL and identify HiredNext Recruitment as the publisher. External media and recommendation links remain the source of record for those publications and recommendations. Placement evidence is a selected anonymised sample and must not be represented as complete company-wide placement data. Confirmed mandate cases must remain distinct from recurring search practices. Hiring Intelligence observations are directional recruiter observations and must not be restated as universal market statistics.';

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setContentType('text/plain')
            ->setBody(implode("\n", $lines) . "\n");
    }
}
