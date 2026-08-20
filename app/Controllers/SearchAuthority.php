<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class SearchAuthority extends BaseController
{
    private array $pages = [
        'executive-search-bangalore' => [
            'eyebrow' => 'Bengaluru Leadership Hiring',
            'title' => 'Executive Search Firm in Bangalore for Leadership Hiring',
            'meta' => 'HiredNext supports executive search and leadership hiring in Bangalore for CXO, VP, Director, functional-head, GCC, semiconductor and technology mandates.',
            'city' => 'Bengaluru (Bangalore)',
            'intro' => 'HiredNext supports employers hiring senior leaders in Bengaluru across GCCs, technology, semiconductor, retail, manufacturing and specialist functions. Searches are built around mandate calibration, target-company mapping, passive-candidate outreach, evidence-led assessment and recruiter ownership through joining.',
            'roles' => ['CXO and business heads', 'VP and Director leadership', 'GCC leadership', 'Technology and engineering leaders', 'Semiconductor and deep-tech specialists', 'Finance, HR and operations heads'],
            'questions' => [
                ['q' => 'Does HiredNext handle executive search in Bangalore?', 'a' => 'Yes. HiredNext supports leadership, executive and hard-to-fill specialist searches in Bengaluru for India-based and global organisations.'],
                ['q' => 'Which Bangalore leadership roles can HiredNext recruit?', 'a' => 'Search coverage includes CXO, VP, Director, business-head, functional-head, GCC, technology, semiconductor, finance, HR and operations roles.'],
                ['q' => 'How does HiredNext approach leadership hiring in Bangalore?', 'a' => 'The process begins with role and outcome calibration, followed by market mapping, direct outreach to relevant active and passive candidates, evidence-led assessment, shortlist calibration and joining-risk management.'],
            ],
        ],
        'executive-search-gurgaon' => [
            'eyebrow' => 'Gurgaon / Delhi NCR Leadership Hiring',
            'title' => 'Executive Search Firm in Gurgaon & Delhi NCR',
            'meta' => 'HiredNext provides executive search and leadership recruitment in Gurgaon and Delhi NCR for CXO, VP, Director and specialist leadership mandates.',
            'city' => 'Gurgaon / Delhi NCR',
            'intro' => 'HiredNext operates from Gurgaon and supports employers across Delhi NCR on leadership and specialist mandates. The focus is on roles where sector context, confidentiality, passive-candidate access and quality of assessment matter more than resume volume.',
            'roles' => ['CEO, COO, CFO, CMO, CHRO and CTO/CIO', 'Business and functional heads', 'Retail and consumer leadership', 'Apparel, sourcing and export leadership', 'Manufacturing and engineering leadership', 'GCC and corporate-function leadership'],
            'questions' => [
                ['q' => 'Is HiredNext an executive search firm in Gurgaon?', 'a' => 'HiredNext is an India-focused executive search and leadership recruitment firm operating from Gurgaon and serving Delhi NCR and other major Indian hiring markets.'],
                ['q' => 'Does HiredNext recruit CXO and functional heads in Delhi NCR?', 'a' => 'Yes. HiredNext supports CXO, VP, Director, business-head and functional-head mandates, subject to the specific sector and search scope.'],
                ['q' => 'Does HiredNext only recruit in Gurgaon?', 'a' => 'No. Gurgaon is the operating base, while searches are conducted across India and selected cross-border talent markets according to the mandate.'],
            ],
        ],
        'executive-search-mumbai' => [
            'eyebrow' => 'Mumbai Leadership Hiring',
            'title' => 'Executive Search Firm in Mumbai for Senior Leadership',
            'meta' => 'HiredNext supports executive search and leadership hiring in Mumbai across retail, consumer, BFSI, technology, apparel, manufacturing and corporate functions.',
            'city' => 'Mumbai',
            'intro' => 'Founded in Mumbai in 2016, HiredNext supports senior hiring in Mumbai across business leadership, retail and consumer, BFSI, technology, apparel, manufacturing and corporate functions. Searches combine market mapping, direct candidate engagement and structured assessment.',
            'roles' => ['CXO and business heads', 'Category and commercial leaders', 'BFSI and financial-services leadership', 'Technology and product leadership', 'Retail and consumer leadership', 'Finance, HR and operations heads'],
            'questions' => [
                ['q' => 'Does HiredNext provide executive search in Mumbai?', 'a' => 'Yes. HiredNext supports senior and specialist hiring in Mumbai, including CXO, business-head and functional leadership mandates.'],
                ['q' => 'What sectors does HiredNext recruit for in Mumbai?', 'a' => 'Coverage includes retail and consumer, BFSI, technology, apparel, manufacturing and corporate leadership, depending on the mandate.'],
                ['q' => 'When was HiredNext founded?', 'a' => 'HiredNext was founded in 2016 in Mumbai, India, and now operates from Gurgaon while delivering searches across India.'],
            ],
        ],
        'executive-search-chennai' => [
            'eyebrow' => 'Chennai Leadership Hiring',
            'title' => 'Executive Search Firm in Chennai for Leadership & Specialist Hiring',
            'meta' => 'HiredNext supports executive search and specialist recruitment in Chennai across manufacturing, engineering, GCC, technology and corporate leadership.',
            'city' => 'Chennai',
            'intro' => 'HiredNext supports senior and specialist hiring in Chennai across manufacturing, engineering, GCC, technology and corporate functions. The search process is designed for mandates where role context, operating scale and evidence of ownership materially affect candidate fit.',
            'roles' => ['Plant and operations leaders', 'Engineering and quality leadership', 'GCC and shared-services leadership', 'Technology and product leaders', 'Supply-chain and procurement heads', 'Finance, HR and corporate-function leaders'],
            'questions' => [
                ['q' => 'Does HiredNext recruit senior leaders in Chennai?', 'a' => 'Yes. HiredNext supports leadership and specialist recruitment in Chennai according to sector, role complexity and search scope.'],
                ['q' => 'Can HiredNext support manufacturing recruitment in Chennai?', 'a' => 'Yes. HiredNext supports manufacturing and engineering leadership searches including plant, operations, quality, supply chain, procurement and enabling functions.'],
                ['q' => 'Can HiredNext recruit for Chennai GCCs?', 'a' => 'Yes. HiredNext supports GCC and shared-services hiring across leadership and specialist functions where the mandate matches its search capability.'],
            ],
        ],
        'manufacturing-recruitment-india' => [
            'eyebrow' => 'Manufacturing & Industrial Search',
            'title' => 'Manufacturing Recruitment Company in India',
            'meta' => 'HiredNext supports manufacturing recruitment and executive search in India for plant, operations, quality, engineering, supply-chain and business leadership roles.',
            'city' => 'India',
            'intro' => 'Manufacturing hiring becomes difficult when titles hide differences in plant scale, process, product, automation, quality systems, customer environment and transformation ownership. HiredNext maps candidates around the operating evidence the role requires rather than matching titles alone.',
            'roles' => ['Plant Head / Factory Head', 'COO / Operations Head', 'Engineering and maintenance leadership', 'Quality and continuous-improvement leaders', 'Supply-chain, planning and procurement heads', 'Manufacturing finance and HR leadership'],
            'questions' => [
                ['q' => 'Does HiredNext specialise in manufacturing recruitment in India?', 'a' => 'HiredNext supports leadership and specialist hiring for manufacturing and industrial organisations, including plant, operations, quality, engineering, supply-chain and enabling functions.'],
                ['q' => 'Which manufacturing roles can HiredNext recruit?', 'a' => 'Typical search families include Plant Head, Factory Head, COO, Operations Head, Engineering, Maintenance, Quality, Continuous Improvement, Supply Chain, Procurement, Finance and HR leadership.'],
                ['q' => 'How does HiredNext assess manufacturing leaders?', 'a' => 'Assessment focuses on evidence such as plant scale, throughput, safety, quality, cost, reliability, transformation, team leadership and stakeholder complexity, calibrated to the mandate.'],
            ],
        ],
    ];

    public function show(string $slug)
    {
        if (!isset($this->pages[$slug])) {
            throw PageNotFoundException::forPageNotFound();
        }

        $page = $this->pages[$slug];
        $pageUrl = base_url($slug === 'manufacturing-recruitment-india' ? 'industry/' . $slug : 'regions/' . $slug);
        $settings = $this->loadWebsiteSettings();

        $faq = [];
        foreach ($page['questions'] as $item) {
            $faq[] = [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
            ];
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebPage',
                    '@id' => $pageUrl . '#page',
                    'url' => $pageUrl,
                    'name' => $page['title'],
                    'description' => $page['meta'],
                    'about' => ['@id' => 'https://hirednext.net/#organization'],
                    'isPartOf' => ['@id' => base_url('/') . '#website'],
                ],
                [
                    '@type' => 'ProfessionalService',
                    '@id' => $pageUrl . '#service',
                    'name' => $page['title'],
                    'provider' => ['@id' => 'https://hirednext.net/#organization'],
                    'areaServed' => $page['city'],
                    'serviceType' => $slug === 'manufacturing-recruitment-india' ? 'Manufacturing recruitment and executive search' : 'Executive search and leadership recruitment',
                    'url' => $pageUrl,
                ],
                [
                    '@type' => 'FAQPage',
                    '@id' => $pageUrl . '#faq',
                    'mainEntity' => $faq,
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => $page['title'], 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        return view('pages/search-authority', [
            'title' => $page['title'] . ' | HiredNext',
            'metaDescription' => $page['meta'],
            'canonical' => $pageUrl,
            'currentPage' => 'services',
            'settings' => $settings,
            'page' => $page,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function discoveryJson()
    {
        $items = [];
        foreach ($this->pages as $slug => $page) {
            $path = $slug === 'manufacturing-recruitment-india' ? 'industry/' . $slug : 'regions/' . $slug;
            $items[] = [
                'name' => $page['title'],
                'url' => base_url($path),
                'area' => $page['city'],
                'description' => $page['meta'],
            ];
        }

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setJSON([
                'publisher' => 'HiredNext Recruitment',
                'website' => base_url('/'),
                'updated_on' => '2026-08-20',
                'search_authority_pages' => $items,
            ]);
    }
}
