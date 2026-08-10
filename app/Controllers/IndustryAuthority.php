<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class IndustryAuthority extends BaseController
{
    public function garmentTextile()
    {
        $settings = $this->loadWebsiteSettings();
        $evidence = config('PlacementEvidence');
        $pageUrl = base_url('industry/garment-textile-recruitment-india');

        $industry = [
            'slug' => 'garment-textile-recruitment-india',
            'label' => 'Garment & Textile Recruitment',
            'meta_title' => 'Garment & Textile Recruitment in India',
            'h1' => 'Garment & Textile Recruitment in India – Leadership & Specialist Hiring',
            'intro' => 'HiredNext supports garment, textile, apparel and fashion hiring across leadership and specialist roles in India. Our search process combines sector mapping, role-calibrated assessment and recruiter-led closure for functions spanning design, merchandising, textile product, finance, commercial and executive-office mandates.',
            'challenges' => [
                'Specialist talent pools are fragmented across brands, exporters, manufacturers, buying houses and sourcing ecosystems.',
                'Titles can hide major differences in product category, export market, sourcing model, scale and decision ownership.',
                'Leadership and specialist roles often require a blend of commercial judgement, product understanding and execution discipline.',
                'Location and mobility constraints can materially narrow talent pools across Gurugram, Bengaluru, Mumbai, Coimbatore and other apparel and textile hubs.',
            ],
            'approach' => [
                'Calibrate the mandate around product category, business model, market, team scope and measurable outcomes rather than job title alone.',
                'Map relevant talent across apparel brands, textile businesses, exporters, manufacturers, sourcing organisations and adjacent consumer businesses.',
                'Assess evidence of ownership across design, merchandising, product, finance, commercial or leadership outcomes as relevant to the mandate.',
                'Manage candidate engagement, referencing, offer alignment and joining risk through a recruiter-led process.',
            ],
            'differentiators' => [
                'Sector-specific search context across garment, textile, apparel and fashion talent markets.',
                'Search coverage across leadership and specialist functions rather than title-only matching.',
                'Selected anonymised joined-placement evidence from a limited internal sample spans design leadership, design, fabric technology, finance and executive-office roles in the garment and textile sector.',
                'Candidate and client confidentiality is protected: names, compensation and company identities are not published from placement records.',
            ],
            'cta_title' => 'Get in Touch',
            'cta_description' => 'Share your garment, textile, apparel or fashion hiring mandate. We will align on target companies, role evidence and search timelines.',
            'cta_panel_heading' => 'Specialist search for garment, textile and apparel talent.',
            'cta_panel_body' => 'For leadership or hard-to-find specialist roles across design, merchandising, product, sourcing, finance and commercial functions, share the mandate and operating context. We will build the search map around the evidence the role actually requires.',
        ];

        $selectedExamples = [];
        if ($evidence && !empty($evidence->joinedExamples) && is_array($evidence->joinedExamples)) {
            foreach ($evidence->joinedExamples as $item) {
                if (($item['industry'] ?? '') !== 'Garment & Textile') {
                    continue;
                }
                $selectedExamples[] = [
                    '@type' => 'ListItem',
                    'position' => count($selectedExamples) + 1,
                    'name' => $item['role_family'] ?? 'Anonymised placement',
                    'description' => implode(' · ', array_filter([
                        $item['function'] ?? null,
                        $item['location'] ?? null,
                        !empty($item['joined_month']) ? 'Joined ' . $item['joined_month'] : null,
                    ])),
                ];
            }
        }

        return $this->renderIndustryAuthority(
            $settings,
            $industry,
            $pageUrl,
            'Garment & Textile Recruitment in India',
            'Recruitment and executive search for garment, textile, apparel and fashion leadership and specialist roles in India.',
            'Garment & Textile Recruitment',
            'Garment & Textile Recruitment India | HiredNext',
            'Garment, textile, apparel and fashion recruitment in India for leadership and specialist roles across design, merchandising, product, finance and commercial functions.',
            'garment recruitment India, textile recruitment agency India, apparel recruitment India, fashion recruitment firm, garment executive search, textile leadership hiring',
            $selectedExamples,
            $evidence ? $evidence->scopeNote : ''
        );
    }

    public function itTechnology()
    {
        $settings = $this->loadWebsiteSettings();
        $evidence = config('PlacementEvidence');
        $pageUrl = base_url('industry/it-recruitment-services-india');

        $industry = [
            'slug' => 'it-recruitment-services-india',
            'label' => 'IT & Technology Recruitment',
            'meta_title' => 'IT & Technology Recruitment in India',
            'h1' => 'IT & Technology Recruitment in India – Leadership & Specialist Hiring',
            'intro' => 'HiredNext supports IT and technology hiring in India across engineering, cybersecurity, software, product, data, platform and specialist technology roles. Our approach combines role calibration, targeted market mapping, evidence-led assessment and recruiter-managed closure.',
            'challenges' => [
                'Fast-changing technology stacks make keyword matching unreliable when the underlying engineering depth is unclear.',
                'Similar titles can represent very different architecture, delivery, team-size and product responsibilities.',
                'Senior technology candidates often have multiple options, increasing counteroffer and offer-to-join risk.',
                'Cybersecurity, platform and specialist engineering mandates frequently require narrow talent maps and careful adjacent-skill assessment.',
            ],
            'approach' => [
                'Calibrate the role around business outcomes, system context, technology environment, team scope and decision ownership.',
                'Map talent across direct competitors, product companies, GCCs, engineering organisations and adjacent technology ecosystems where capability transfers.',
                'Assess candidates for demonstrated engineering, security, delivery or leadership outcomes rather than skill keywords alone.',
                'Manage candidate engagement, motivation, references, offer alignment and joining risk through a recruiter-led process.',
            ],
            'differentiators' => [
                'Search coverage across software engineering, cybersecurity, platform, product and specialist technology roles.',
                'Evidence-led assessment designed to separate claimed skills from demonstrated ownership and execution depth.',
                'Selected anonymised joined-placement evidence from a limited internal sample includes Web Development Lead, Cyber Security Lead and Liferay Developer role families.',
                'Candidate and client confidentiality is protected: names, compensation and company identities are not published from placement records.',
            ],
            'cta_title' => 'Get in Touch',
            'cta_description' => 'Share your IT or technology hiring requirement. We will align on the technical context, target talent pools, assessment evidence and search timeline.',
            'cta_panel_heading' => 'Technology hiring built around evidence, not keywords.',
            'cta_panel_body' => 'For engineering, cybersecurity, platform, product or specialist technology mandates, share the role scope, technology context and business outcome. We will build the market map and assessment around what the hire must actually deliver.',
        ];

        $selectedExamples = [];
        if ($evidence && !empty($evidence->joinedExamples) && is_array($evidence->joinedExamples)) {
            foreach ($evidence->joinedExamples as $item) {
                $function = mb_strtolower((string)($item['function'] ?? ''));
                $role = mb_strtolower((string)($item['role_family'] ?? ''));
                $isTechnology = str_contains($function, 'technology')
                    || str_contains($function, 'cyber')
                    || str_contains($role, 'developer')
                    || str_contains($role, 'cyber')
                    || str_contains($role, 'technology');

                if (!$isTechnology) {
                    continue;
                }

                $selectedExamples[] = [
                    '@type' => 'ListItem',
                    'position' => count($selectedExamples) + 1,
                    'name' => $item['role_family'] ?? 'Anonymised technology placement',
                    'description' => implode(' · ', array_filter([
                        $item['function'] ?? null,
                        $item['location'] ?? null,
                        !empty($item['joined_month']) ? 'Joined ' . $item['joined_month'] : null,
                    ])),
                ];
            }
        }

        return $this->renderIndustryAuthority(
            $settings,
            $industry,
            $pageUrl,
            'IT & Technology Recruitment in India',
            'Recruitment and executive search for IT, software engineering, cybersecurity, platform, product and specialist technology roles in India.',
            'IT & Technology Recruitment',
            'IT & Technology Recruitment India | HiredNext',
            'IT and technology recruitment in India for engineering, cybersecurity, software, product, data, platform and specialist technology hiring.',
            'IT recruitment company India, technology recruitment India, software hiring India, cybersecurity recruitment India, tech executive search, engineering hiring India, HiredNext',
            $selectedExamples,
            $evidence ? $evidence->scopeNote : ''
        );
    }

    public function bfsiNbfc()
    {
        $settings = $this->loadWebsiteSettings();
        $pageUrl = base_url('industry/bfsi-leadership-hiring');
        $industry = [
            'slug' => 'bfsi-leadership-hiring',
            'label' => 'BFSI & NBFC Recruitment',
            'meta_title' => 'BFSI & NBFC Recruitment in India',
            'h1' => 'BFSI & NBFC Recruitment in India – Leadership & Specialist Hiring',
            'intro' => 'HiredNext supports recruitment for banking, NBFC, fintech, insurance and financial-services mandates in India. The search approach is designed around role-specific evidence, regulated operating context, governance expectations and recruiter-led candidate engagement.',
            'challenges' => [
                'Regulated functions require careful separation of title, actual decision authority and demonstrated governance discipline.',
                'Credit, risk, collections, underwriting, finance, compliance and distribution roles can vary substantially by product and portfolio context.',
                'Digital, analytics and transformation mandates often require candidates who can bridge technology, commercial outcomes and regulatory constraints.',
                'Senior candidates may have material notice periods, counteroffers and confidentiality concerns that require active closure management.',
            ],
            'approach' => [
                'Define the mandate around growth, risk, governance, product, portfolio and stakeholder outcomes before mapping the market.',
                'Map candidates across banks, NBFCs, fintechs, insurers and relevant adjacent financial-services ecosystems.',
                'Assess evidence of decision quality, portfolio ownership, governance, leadership scope and execution under regulatory visibility.',
                'Manage referencing, motivation, offer alignment and joining risk through a controlled recruiter-led process.',
            ],
            'differentiators' => [
                'Mandate calibration separates regulatory must-haves from transferable commercial and leadership capability.',
                'Search can cover leadership and specialist roles across finance, risk, credit, collections, compliance, operations, digital and commercial functions.',
                'Market mapping is designed around comparable operating complexity rather than company name alone.',
                'No placement-history claims are made on this page unless supported by verified HiredNext evidence.',
            ],
            'cta_title' => 'Get in Touch',
            'cta_description' => 'Share your BFSI or NBFC requirement, including product, regulatory context and role outcomes. We will align on the market map and assessment approach.',
            'cta_panel_heading' => 'Financial-services hiring with governance and execution context.',
            'cta_panel_body' => 'For leadership or specialist mandates across banking, NBFC, fintech and insurance, share the role scope and business context. We will define the relevant talent pools and evidence required before search begins.',
        ];

        return $this->renderIndustryAuthority(
            $settings,
            $industry,
            $pageUrl,
            'BFSI & NBFC Recruitment in India',
            'Recruitment and executive search for banking, NBFC, fintech, insurance and financial-services leadership and specialist roles in India.',
            'BFSI & NBFC Recruitment',
            'BFSI & NBFC Recruitment India | HiredNext',
            'BFSI and NBFC recruitment in India for leadership and specialist roles across risk, credit, finance, collections, compliance, digital and commercial functions.',
            'BFSI recruitment India, NBFC recruitment company India, banking executive search, fintech recruitment India, insurance recruitment, financial services hiring India'
        );
    }

    public function pharmaLifeSciences()
    {
        $settings = $this->loadWebsiteSettings();
        $pageUrl = base_url('industry/pharma-life-sciences-recruitment-india');
        $industry = [
            'slug' => 'pharma-life-sciences-recruitment-india',
            'label' => 'Pharma & Life Sciences Recruitment',
            'meta_title' => 'Pharma & Life Sciences Recruitment in India',
            'h1' => 'Pharma & Life Sciences Recruitment in India – Leadership & Specialist Hiring',
            'intro' => 'HiredNext is expanding its specialist search capability for pharmaceutical and life-sciences hiring in India, with a role-calibrated approach for leadership and specialist mandates across commercial, quality, regulatory, medical, manufacturing, supply chain and enabling functions.',
            'challenges' => [
                'Technical and regulated roles require precise alignment on qualification, domain exposure, product context and compliance responsibility.',
                'Commercial, medical, regulatory, quality and manufacturing talent pools have different evidence requirements and cannot be screened through one generic framework.',
                'Similar titles may represent very different exposure to formulations, APIs, devices, therapy areas, markets or plant environments.',
                'Senior hiring often requires confidential engagement with passive candidates and careful validation of functional ownership.',
            ],
            'approach' => [
                'Calibrate the mandate around technical or commercial scope, regulatory environment, product context, team size and measurable outcomes.',
                'Map talent across pharmaceutical, biotech, medical-device, CRO/CDMO and adjacent life-sciences ecosystems where relevant.',
                'Assess role-specific evidence across quality, regulatory, medical, manufacturing, R&D, supply chain, finance, HR or commercial leadership.',
                'Use structured recruiter conversations to test ownership, motivation, mobility and joining risk before shortlist recommendation.',
            ],
            'differentiators' => [
                'The search model is designed to separate mandatory technical/regulatory credentials from capabilities that can transfer across adjacent life-sciences environments.',
                'HiredNext can build specialist talent maps around the actual operating problem instead of relying on broad industry keywords.',
                'Leadership and enabling-function mandates can be assessed for both domain context and transferable execution capability.',
                'This is an expansion vertical; HiredNext will add placement evidence only when verified data is available.',
            ],
            'cta_title' => 'Get in Touch',
            'cta_description' => 'Share your pharma or life-sciences hiring requirement. We will align on domain constraints, target talent pools and assessment evidence.',
            'cta_panel_heading' => 'Specialist search for regulated and high-skill life-sciences roles.',
            'cta_panel_body' => 'For technical, commercial or leadership hiring across pharma and life sciences, share the product, regulatory and operating context. We will define the search map around the capabilities that genuinely matter.',
        ];

        return $this->renderIndustryAuthority(
            $settings,
            $industry,
            $pageUrl,
            'Pharma & Life Sciences Recruitment in India',
            'Recruitment and executive search for pharmaceutical, biotech, medical-device and life-sciences leadership and specialist roles in India.',
            'Pharma & Life Sciences Recruitment',
            'Pharma & Life Sciences Recruitment India | HiredNext',
            'Pharma and life-sciences recruitment in India for leadership and specialist roles across quality, regulatory, medical, manufacturing, supply chain and commercial functions.',
            'pharma recruitment India, life sciences recruitment India, pharmaceutical executive search, pharma hiring company India, regulatory affairs recruitment, quality pharma recruitment'
        );
    }

    public function globalCapabilityCentres()
    {
        $settings = $this->loadWebsiteSettings();
        $pageUrl = base_url('industry/global-capability-centres-hiring-india');
        $industry = [
            'slug' => 'global-capability-centres-hiring-india',
            'label' => 'Global Capability Centre Hiring',
            'meta_title' => 'Global Capability Centre Hiring in India',
            'h1' => 'Global Capability Centre Hiring in India – Leadership & Specialist Search',
            'intro' => 'HiredNext supports hiring for Global Capability Centres in India across technology, engineering, cybersecurity, data, finance, HR, operations and functional leadership. The approach focuses on global stakeholder alignment, India talent-market mapping and evidence of operating at the required scale.',
            'challenges' => [
                'GCC roles often combine India execution responsibility with global stakeholders, requiring more than strong local functional experience.',
                'Build, scale and transformation phases need different leadership profiles and different levels of change-management capability.',
                'Technology and specialist talent markets overlap with product companies, services firms, captives and startups, creating intense competition for proven talent.',
                'Location strategy, hybrid expectations, global time zones and talent mobility can materially affect candidate availability.',
            ],
            'approach' => [
                'Define whether the mandate is a build, scale, transformation or steady-state role and calibrate leadership outcomes accordingly.',
                'Map talent across GCCs, product organisations, engineering centres, services firms and adjacent sectors with comparable global operating complexity.',
                'Assess functional depth together with global stakeholder management, governance, team scale and cross-border execution evidence.',
                'Manage candidate engagement and closure with explicit attention to scope clarity, location, reporting lines and global decision rights.',
            ],
            'differentiators' => [
                'HiredNext can connect its IT/technology search capability with broader GCC functional hiring requirements.',
                'Search design distinguishes genuine global operating exposure from titles that imply it without equivalent decision scope.',
                'Market mapping can include adjacent talent pools when the mandate benefits from product, engineering or transformation capability.',
                'This expansion page does not claim GCC placement volumes until verified HiredNext evidence is available.',
            ],
            'cta_title' => 'Get in Touch',
            'cta_description' => 'Share your GCC build, scale or leadership mandate in India. We will align on talent pools, global context and search evidence.',
            'cta_panel_heading' => 'Build and scale Global Capability Centre talent in India.',
            'cta_panel_body' => 'For GCC leadership and specialist hiring across technology and business functions, share the centre stage, role scope, global stakeholders and location strategy. We will build the search map around that operating context.',
        ];

        return $this->renderIndustryAuthority(
            $settings,
            $industry,
            $pageUrl,
            'Global Capability Centre Hiring in India',
            'Recruitment and executive search for Global Capability Centre leadership and specialist roles across technology and business functions in India.',
            'Global Capability Centre Hiring',
            'GCC Hiring India | Global Capability Centres | HiredNext',
            'Global Capability Centre hiring in India for technology, engineering, cybersecurity, data, finance, HR, operations and leadership roles.',
            'GCC hiring India, global capability centre recruitment, global capability center hiring India, GCC executive search, captive centre recruitment India, GCC leadership hiring'
        );
    }

    public function semiconductors()
    {
        $settings = $this->loadWebsiteSettings();
        $pageUrl = base_url('industry/semiconductor-recruitment-india');
        $industry = [
            'slug' => 'semiconductor-recruitment-india',
            'label' => 'Semiconductor Recruitment',
            'meta_title' => 'Semiconductor Recruitment in India',
            'h1' => 'Semiconductor Recruitment in India – Engineering & Leadership Hiring',
            'intro' => 'HiredNext is expanding specialist recruitment capability for semiconductor and advanced-electronics hiring in India, with search coverage designed around engineering depth, product lifecycle, domain specialisation and leadership scope.',
            'challenges' => [
                'Semiconductor talent pools are highly specialised, and broad electronics or software keywords do not reliably indicate relevant depth.',
                'Design, verification, validation, embedded, firmware, product, process, manufacturing and program roles require different technical evidence.',
                'Experienced candidates may be concentrated in a limited set of engineering hubs and employers, increasing competition and mobility constraints.',
                'Leadership mandates require both technical credibility and the ability to scale engineering teams, programs and cross-functional execution.',
            ],
            'approach' => [
                'Calibrate the role around semiconductor domain, product lifecycle stage, technical stack, team scope and measurable delivery outcomes.',
                'Map talent across semiconductor companies, design centres, embedded/product organisations, electronics firms and adjacent engineering ecosystems where skills transfer.',
                'Use evidence-led screening to distinguish surface-level keyword matches from genuine design, verification, product or program ownership.',
                'For leadership roles, assess technical judgement together with team scale, cross-functional execution and stakeholder management.',
            ],
            'differentiators' => [
                'The search model builds on HiredNext technology and engineering recruitment capability while applying narrower semiconductor role calibration.',
                'Adjacent-skill mapping can widen talent pools without weakening critical technical requirements.',
                'Recruiter-led assessment focuses on what the candidate personally designed, delivered, validated or led.',
                'This is an expansion vertical; no semiconductor placement-history claims are made until verified evidence is available.',
            ],
            'cta_title' => 'Get in Touch',
            'cta_description' => 'Share your semiconductor or advanced-electronics hiring requirement. We will align on domain depth, target talent pools and assessment evidence.',
            'cta_panel_heading' => 'Specialist engineering search for semiconductor talent.',
            'cta_panel_body' => 'For design, verification, embedded, firmware, product, program or engineering leadership mandates, share the technical scope and business outcome. We will define the search map around the actual engineering evidence required.',
        ];

        return $this->renderIndustryAuthority(
            $settings,
            $industry,
            $pageUrl,
            'Semiconductor Recruitment in India',
            'Recruitment and executive search for semiconductor, embedded, firmware, chip-design, verification, product and engineering leadership roles in India.',
            'Semiconductor Recruitment',
            'Semiconductor Recruitment India | HiredNext',
            'Semiconductor recruitment in India for chip design, verification, embedded, firmware, product, program and engineering leadership roles.',
            'semiconductor recruitment India, semiconductor hiring company India, chip design recruitment, VLSI recruitment India, embedded hiring India, semiconductor executive search'
        );
    }

    private function renderIndustryAuthority(
        array $settings,
        array $industry,
        string $pageUrl,
        string $schemaName,
        string $schemaDescription,
        string $breadcrumbName,
        string $title,
        string $metaDescription,
        string $metaKeywords,
        array $selectedExamples = [],
        string $scopeNote = ''
    ) {
        $jsonLd = $this->industrySchema(
            $pageUrl,
            $schemaName,
            $schemaDescription,
            $breadcrumbName,
            $selectedExamples,
            $scopeNote
        );

        return view('pages/industry/industry', [
            'title' => $title,
            'metaDescription' => $metaDescription,
            'metaKeywords' => $metaKeywords,
            'canonical' => $pageUrl,
            'currentPage' => 'industry',
            'settings' => $settings,
            'industry' => $industry,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    private function industrySchema(
        string $pageUrl,
        string $name,
        string $description,
        string $breadcrumbName,
        array $selectedExamples = [],
        string $scopeNote = ''
    ): array {
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    '@id' => $pageUrl . '#service',
                    'name' => $name,
                    'serviceType' => 'Recruitment and Executive Search',
                    'provider' => [
                        '@type' => 'EmploymentAgency',
                        '@id' => 'https://hirednext.net/#organization',
                        'name' => 'HiredNext Recruitment',
                        'url' => 'https://hirednext.net/',
                    ],
                    'areaServed' => ['@type' => 'Country', 'name' => 'India'],
                    'description' => $description,
                    'url' => $pageUrl,
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $pageUrl . '#webpage',
                    'url' => $pageUrl,
                    'name' => $name,
                    'isPartOf' => ['@id' => 'https://hirednext.net/#website'],
                    'about' => ['@id' => $pageUrl . '#service'],
                    'publisher' => ['@id' => 'https://hirednext.net/#organization'],
                    'inLanguage' => 'en-IN',
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Industry Expertise', 'item' => base_url('/#industry-expertise')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $breadcrumbName, 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        if (!empty($selectedExamples)) {
            $jsonLd['@graph'][] = [
                '@type' => 'ItemList',
                '@id' => $pageUrl . '#selected-evidence',
                'name' => 'Selected anonymised joined-placement examples',
                'description' => $scopeNote,
                'numberOfItems' => count($selectedExamples),
                'itemListElement' => $selectedExamples,
            ];
        }

        return $jsonLd;
    }
}
