<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $settings = $this->loadWebsiteSettings();
        $jobModel = new \App\Models\JobModel();
        $brandFacts = config('BrandFacts');
        $brand = $brandFacts->facts ?? [];
        $schemaIdentity = $brandFacts->organizationSchemaIdentity();

        $faq = [
            [
                'q' => 'Do you provide IT recruitment services in India?',
                'a' => 'Yes. We support IT recruitment in India for mid-senior and leadership roles across product, engineering, data, security, and platform functions.',
            ],
            [
                'q' => 'Do you offer executive search for BFSI roles?',
                'a' => 'Yes. We run confidential executive searches for BFSI leadership roles across banking, NBFC, fintech, and insurance mandates.',
            ],
            [
                'q' => 'How do you find senior retail leaders?',
                'a' => 'We use competitor mapping, performance-based shortlisting, and structured interviews to identify leaders with proven P&L and omnichannel execution.',
            ],
            [
                'q' => 'Do you recruit for textile, apparel, garment and fashion businesses?',
                'a' => 'Yes. HiredNext recruits leadership and specialist talent for export houses, buying houses, textile and apparel manufacturers, fashion retailers and lifestyle brands across India and selected cross-border mandates.',
            ],
            [
                'q' => 'What engineering leadership roles do you specialize in?',
                'a' => 'We specialize in leadership roles across engineering, projects, quality, maintenance, operations, plant leadership, and supply chain.',
            ],
        ];

        $faqJsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(function ($item) {
                return [
                    '@type' => 'Question',
                    'name' => $item['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $item['a'],
                    ],
                ];
            }, $faq),
        ];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'EmploymentAgency',
                    '@id' => 'https://hirednext.net/#organization',
                    'name' => $brand['organization_name'] ?? 'HiredNext Recruitment',
                    'legalName' => $schemaIdentity['legalName'],
                    'taxID' => $schemaIdentity['taxID'],
                    'url' => $brand['website'] ?? 'https://hirednext.net/',
                    'email' => $brand['email'] ?? 'jobs@hirednext.info',
                    'foundingDate' => (string)($brand['founded_year'] ?? 2016),
                    'description' => 'HiredNext is a talent advisory and recruitment firm specializing in executive search, leadership hiring and specialist recruitment across India.',
                    'areaServed' => [
                        '@type' => 'Country',
                        'name' => 'India',
                    ],
                    'founder' => [
                        '@type' => 'Person',
                        '@id' => base_url('about/taru-shikha') . '#person',
                        'name' => $brand['founder'] ?? 'Taru Shikha',
                        'jobTitle' => $brand['founder_title'] ?? 'Founder & Proprietor',
                    ],
                    'sameAs' => [
                        $brand['company_linkedin'] ?? 'https://www.linkedin.com/company/hirednext-recruitment-service/',
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => 'https://hirednext.net/#website',
                    'url' => 'https://hirednext.net/',
                    'name' => 'HiredNext',
                    'publisher' => [
                        '@id' => 'https://hirednext.net/#organization'
                    ]
                ],
                $faqJsonLd
            ]
        ];
        $data = [
            'title' => 'Executive Search & Leadership Recruitment India | HiredNext',
            'metaDescription' => 'HiredNext helps companies hire CXOs, functional heads and hard-to-find senior talent through confidential executive search, market mapping and structured assessment across India.',
            'canonical' => base_url('/'),
            'currentPage' => 'home',
            'settings' => $settings,
            'testimonials' => $this->loadActiveReviews(),
            'jobs' => $jobModel->getOpenJobs(),
            'press_media_items' => $this->loadActivePressMedia(),
            'faq' => $faq,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ];

        return view('pages/home', $data);
    }

    public function about()
    {
        $settings = $this->loadWebsiteSettings();

        $data = [
            'title' => 'About Us | HiredNext - Shaping Careers, Powering Organizations',
            'currentPage' => 'about',
            'settings' => $settings,
        ];

        return view('pages/about', $data);
    }

    public function services()
    {
        $settings = $this->loadWebsiteSettings();

        $data = [
            'title' => 'Services | HiredNext - Shaping Careers, Powering Organizations',
            'currentPage' => 'services',
            'settings' => $settings,
        ];

        return view('pages/services', $data);
    }

    public function serviceDetail($slug)
    {
        $settings = $this->loadWebsiteSettings();
        $serviceViews = [
            'executive-search' => 'pages/services/service-executive-search',
            'permanent-hiring' => 'pages/services/service-permanent-hiring',
            'rpo' => 'pages/services/service-rpo',
            'avron' => 'pages/services/service-avron',
        ];

        if (!isset($serviceViews[$slug])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $serviceMeta = [
            'executive-search' => [
                'title' => 'Executive Search Firm in India | Leadership Hiring | HiredNext',
                'description' => 'Confidential executive search in India for CXO, business and functional leadership roles. HiredNext combines market mapping, direct outreach and evidence-led assessment.',
            ],
            'permanent-hiring' => [
                'title' => 'Permanent Recruitment for Mid-Senior Roles | HiredNext',
                'description' => 'Industry-aligned permanent recruitment for mid-senior and specialist roles across India, with structured screening and clear candidate assessment.',
            ],
            'rpo' => [
                'title' => 'Recruitment Process Outsourcing (RPO) India | HiredNext',
                'description' => 'Flexible recruitment process outsourcing for growing teams that need dedicated sourcing, screening and hiring coordination.',
            ],
            'avron' => [
                'title' => 'HiredNext Avron | Career Services for Professionals',
                'description' => 'Practical career support for professionals, including CV assessment and recruiter-led guidance from HiredNext.',
            ],
        ];

        $data = [
            'title' => $serviceMeta[$slug]['title'],
            'metaDescription' => $serviceMeta[$slug]['description'],
            'canonical' => base_url('services/' . $slug),
            'currentPage' => 'services',
            'settings' => $settings,
        ];

        if ($slug === 'executive-search') {
            $faq = [
                [
                    'q' => 'What is executive search?',
                    'a' => 'Executive search is a targeted recruitment process for senior, confidential or business-critical roles. It combines market mapping, direct candidate outreach, structured assessment and support through selection and joining.',
                ],
                [
                    'q' => 'Which leadership roles does HiredNext recruit for?',
                    'a' => 'HiredNext supports CXO, business head, country and regional leadership, functional head, plant and operations leadership, technology, finance, people and commercial appointments.',
                ],
                [
                    'q' => 'Can HiredNext manage a confidential replacement search?',
                    'a' => 'Yes. Confidential searches are handled through controlled outreach, limited disclosure and a clear communication protocol agreed with the hiring stakeholders.',
                ],
                [
                    'q' => 'How are executive candidates assessed?',
                    'a' => 'Assessment is calibrated to the mandate and covers relevant achievements, scale handled, decision-making, leadership context, motivations and fit with the organisation’s immediate priorities.',
                ],
            ];

            $jsonLd = [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'Service',
                        '@id' => base_url('services/executive-search') . '#service',
                        'name' => 'Executive Search and Leadership Hiring',
                        'serviceType' => 'Executive Search',
                        'provider' => [
                            '@type' => 'EmploymentAgency',
                            '@id' => 'https://hirednext.net/#organization',
                            'name' => 'HiredNext Recruitment',
                            'url' => 'https://hirednext.net/',
                        ],
                        'areaServed' => [
                            '@type' => 'Country',
                            'name' => 'India',
                        ],
                        'description' => $serviceMeta[$slug]['description'],
                    ],
                    [
                        '@type' => 'BreadcrumbList',
                        'itemListElement' => [
                            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => base_url('services')],
                            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Executive Search', 'item' => base_url('services/executive-search')],
                        ],
                    ],
                    [
                        '@type' => 'FAQPage',
                        'mainEntity' => array_map(function ($item) {
                            return [
                                '@type' => 'Question',
                                'name' => $item['q'],
                                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
                            ];
                        }, $faq),
                    ],
                ],
            ];

            $data['faq'] = $faq;
            $data['jsonLd'] = json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return view($serviceViews[$slug], $data);
    }

    public function industry($slug)
    {
        $settings = $this->loadWebsiteSettings();
        $industries = $this->industryPages();

        if (!isset($industries[$slug])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $industry = $industries[$slug];

        $data = [
            'title' => $industry['meta_title'] . ' | ' . ($settings['site_name'] ?? 'HiredNext'),
            'currentPage' => 'industry',
            'settings' => $settings,
            'industry' => $industry,
        ];

        return view('pages/industry/industry', $data);
    }

    public function region($slug)
    {
        $settings = $this->loadWebsiteSettings();
        $regions = $this->regionPages();

        if (!isset($regions[$slug])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $region = $regions[$slug];

        $data = [
            'title' => $region['meta_title'] . ' | ' . ($settings['site_name'] ?? 'HiredNext'),
            'currentPage' => 'region',
            'settings' => $settings,
            'region' => $region,
        ];

        return view('pages/regions/region', $data);
    }

    public function projects()
    {
        return redirect()->to('/');
    }

    public function contact()
    {
        $settings = $this->loadWebsiteSettings();

        $data = [
            'title' => 'Contact | HiredNext - Shaping Careers, Powering Organizations',
            'currentPage' => 'contact',
            'settings' => $settings,
        ];

        return view('pages/contact', $data);
    }

    public function partners()
    {
        return redirect()->to('/');
    }

    public function submitContact()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'message' => 'required|min_length[10]'
        ]);

        $subject = $this->request->getPost('subject')
            ?: $this->request->getPost('service')
            ?: 'Website Inquiry';

        if (!$validation->withRequest($this->request)->run()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors()
                ]);
            }

            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $db = \Config\Database::connect();
        $request = \Config\Services::request();

        $data = [
            'name' => htmlspecialchars($this->request->getPost('name')),
            'email' => htmlspecialchars($this->request->getPost('email')),
            'subject' => htmlspecialchars($subject),
            'message' => htmlspecialchars($this->request->getPost('message')),
            'status' => 'new',
            'ip_address' => $request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $db->table('contact_messages')->insert($data);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Thank you! Your inquiry has been received.'
            ]);
        }

        return redirect()->to('/contact?submitted=1')->with('success', 'Thank you! Your inquiry has been received.');
    }

    public function blog()
    {
        $settings = $this->loadWebsiteSettings();
        $posts = $this->loadPublishedBlogPosts();
        $blogUrl = base_url('blog');
        $itemList = [];

        foreach ($posts as $index => $post) {
            $itemList[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'url' => base_url('blog/' . ($post['slug'] ?? '')),
                'name' => $post['title'] ?? 'HiredNext insight',
            ];
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $blogUrl . '#collection',
                    'url' => $blogUrl,
                    'name' => 'Recruitment and Leadership Hiring Insights',
                    'description' => 'Recruiter-led guidance on executive search, leadership hiring, talent assessment and workforce decisions in India.',
                    'inLanguage' => 'en-IN',
                    'isPartOf' => ['@id' => 'https://hirednext.net/#website'],
                    'publisher' => ['@id' => 'https://hirednext.net/#organization'],
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'numberOfItems' => count($itemList),
                        'itemListElement' => $itemList,
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Insights', 'item' => $blogUrl],
                    ],
                ],
            ],
        ];

        $data = [
            'title' => 'Recruitment & Leadership Hiring Insights India | HiredNext',
            'metaDescription' => 'Practical insights from HiredNext recruiters on executive search, leadership hiring, candidate assessment and talent strategy for employers and professionals in India.',
            'metaKeywords' => 'executive search insights India, leadership hiring, recruitment strategy, talent acquisition, candidate assessment',
            'canonical' => $blogUrl,
            'currentPage' => 'blog',
            'settings' => $settings,
            'blog_posts' => $posts,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ];

        return view('pages/blog', $data);
    }

    public function pressMedia()
    {
        $settings = $this->loadWebsiteSettings();

        $data = [
            'title' => 'Press & Media | HiredNext - Shaping Careers, Powering Organizations',
            'currentPage' => 'press-media',
            'settings' => $settings,
            'press_media_items' => $this->loadActivePressMedia(),
        ];

        return view('pages/press-media', $data);
    }

    public function blogPost($slug = null)
    {
        if (!$slug) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $settings = $this->loadWebsiteSettings();
        $post = $this->loadBlogPostBySlug($slug);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $document = $this->prepareBlogDocument($post['content'] ?? '');
        $postTitle = trim((string)($post['title'] ?? 'HiredNext insight'));
        $metaTitle = trim((string)($post['meta_title'] ?? '')) ?: $postTitle;
        if (stripos($metaTitle, 'HiredNext') === false) {
            $metaTitle .= ' | HiredNext';
        }

        $excerpt = $this->normaliseText($post['excerpt'] ?? '');
        if ($excerpt === '') {
            $excerpt = $this->truncateText($document['plainText'], 165);
        }
        $metaDescription = $this->normaliseText($post['meta_description'] ?? '');
        if ($metaDescription === '') {
            $metaDescription = $this->truncateText($excerpt ?: $document['plainText'], 165);
        }

        $postUrl = base_url('blog/' . $post['slug']);
        $postImage = trim((string)($post['featured_image'] ?? ''));
        if ($postImage === '') {
            $postImage = base_url('theme/assets/home.jpeg');
        } elseif (!preg_match('#^https?://#i', $postImage)) {
            $postImage = base_url(ltrim($postImage, '/'));
        }

        $author = trim((string)($post['author_name'] ?? '')) ?: 'HiredNext Editorial';
        if ($author === 'Metron Team') {
            $author = 'HiredNext Editorial';
        }
        $category = trim((string)($post['category'] ?? '')) ?: 'Recruitment';
        $tags = array_values(array_unique(array_filter(array_map('trim', explode(',', (string)($post['tags'] ?? ''))))));
        $keywordText = trim((string)($post['meta_keywords'] ?? '')) ?: implode(', ', $tags);
        $publishedAt = $this->formatSchemaDate($post['published_at'] ?? $post['created_at'] ?? null);
        $modifiedAt = $this->formatSchemaDate($post['updated_at'] ?? $post['published_at'] ?? $post['created_at'] ?? null);
        $authorSchema = stripos($author, 'HiredNext') !== false
            ? ['@type' => 'Organization', '@id' => 'https://hirednext.net/#organization', 'name' => $author]
            : ['@type' => 'Person', 'name' => $author, 'affiliation' => ['@id' => 'https://hirednext.net/#organization']];

        $articleSchema = [
            '@type' => 'BlogPosting',
            '@id' => $postUrl . '#article',
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $postUrl],
            'url' => $postUrl,
            'headline' => $postTitle,
            'description' => $metaDescription,
            'image' => ['@type' => 'ImageObject', 'url' => $postImage],
            'datePublished' => $publishedAt,
            'dateModified' => $modifiedAt,
            'author' => $authorSchema,
            'publisher' => [
                '@type' => 'Organization',
                '@id' => 'https://hirednext.net/#organization',
                'name' => 'HiredNext Recruitment',
                'url' => 'https://hirednext.net/',
                'logo' => ['@type' => 'ImageObject', 'url' => base_url('theme/assets/logo.jpeg')],
            ],
            'articleSection' => $category,
            'keywords' => $tags ?: [$category, 'HiredNext Recruitment'],
            'wordCount' => $document['wordCount'],
            'timeRequired' => 'PT' . $document['readMinutes'] . 'M',
            'inLanguage' => 'en-IN',
            'isPartOf' => ['@id' => base_url('blog') . '#collection'],
            'about' => array_map(static function ($tag) {
                return ['@type' => 'Thing', 'name' => $tag];
            }, $tags ?: [$category]),
            'speakable' => [
                '@type' => 'SpeakableSpecification',
                'cssSelector' => ['.article-title', '.answer-first', '.article-content h2'],
            ],
        ];

        if ($publishedAt === null) {
            unset($articleSchema['datePublished']);
        }
        if ($modifiedAt === null) {
            unset($articleSchema['dateModified']);
        }

        $schemaGraph = [
            $articleSchema,
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Insights', 'item' => base_url('blog')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $postTitle, 'item' => $postUrl],
                ],
            ],
        ];

        if (!empty($document['faq'])) {
            $schemaGraph[] = [
                '@type' => 'FAQPage',
                'mainEntity' => array_map(static function ($item) {
                    return [
                        '@type' => 'Question',
                        'name' => $item['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer']],
                    ];
                }, $document['faq']),
            ];
        }

        $data = [
            'title' => $metaTitle,
            'metaDescription' => $metaDescription,
            'metaKeywords' => $keywordText,
            'canonical' => $postUrl,
            'ogImage' => $postImage,
            'ogType' => 'article',
            'publishedTime' => $publishedAt,
            'modifiedTime' => $modifiedAt,
            'articleAuthor' => $author,
            'articleSection' => $category,
            'articleTags' => $tags,
            'currentPage' => 'blog',
            'settings' => $settings,
            'post' => $post,
            'post_excerpt' => $excerpt,
            'post_image' => $postImage,
            'post_author' => $author,
            'post_content' => $document['html'],
            'post_toc' => $document['toc'],
            'post_faq' => $document['faq'],
            'post_word_count' => $document['wordCount'],
            'post_read_minutes' => $document['readMinutes'],
            'related_posts' => $this->loadRelatedBlogPosts($post['category'] ?? null, $post['id'] ?? null),
            'jsonLd' => json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ];

        return view('pages/blog-details/blog-single', $data);
    }

    public function testimonials()
    {
        $settings = $this->loadWebsiteSettings();

        $data = [
            'title' => 'Testimonials | HiredNext - Shaping Careers, Powering Organizations',
            'currentPage' => 'testimonials',
            'settings' => $settings,
            'testimonials' => $this->loadActiveReviews(),
        ];

        return view('pages/testimonials', $data);
    }

    public function jobs()
    {
        $settings = $this->loadWebsiteSettings();
        $jobModel = new \App\Models\JobModel();
        $perPage = (int)($settings['jobs_per_page'] ?? 9);
        if ($perPage < 1) {
            $perPage = 9;
        }
        $query = [
            'q' => trim((string)($this->request->getGet('q') ?? '')),
            'type' => trim((string)($this->request->getGet('type') ?? '')),
            'location' => trim((string)($this->request->getGet('location') ?? '')),
            'department' => trim((string)($this->request->getGet('department') ?? '')),
        ];

        $db = \Config\Database::connect();
        $typeRows = $db->table('jobs')->select('type')->where('status', 'open')->groupBy('type')->orderBy('type', 'ASC')->get()->getResultArray();
        $locationRows = $db->table('jobs')->select('location')->where('status', 'open')->groupBy('location')->orderBy('location', 'ASC')->get()->getResultArray();
        $departmentRows = $db->table('jobs')->select('department')->where('status', 'open')->where('department IS NOT NULL', null, false)->where('department !=', '')->groupBy('department')->orderBy('department', 'ASC')->get()->getResultArray();
        $departmentSetting = $settings['job_departments'] ?? '';
        $departmentList = array_values(array_filter(array_map('trim', explode(',', (string)$departmentSetting))));

        $builder = $jobModel->where('status', 'open');
        if ($query['q'] !== '') {
            $builder->groupStart()
                ->like('title', $query['q'])
                ->orLike('description', $query['q'])
                ->orLike('location', $query['q'])
                ->orLike('department', $query['q'])
                ->groupEnd();
        }
        if ($query['type'] !== '') {
            $builder->where('type', $query['type']);
        }
        if ($query['location'] !== '') {
            $builder->where('location', $query['location']);
        }
        if ($query['department'] !== '') {
            $builder->where('department', $query['department']);
        }

        $data = [
            'title' => 'Jobs | HiredNext - Shaping Careers, Powering Organizations',
            'currentPage' => 'jobs',
            'settings' => $settings,
            'jobs' => $builder->orderBy('created_at', 'DESC')->paginate($perPage),
            'pager' => $jobModel->pager,
            'filters' => $query,
            'types' => array_map(static fn($row) => $row['type'], $typeRows),
            'locations' => array_map(static fn($row) => $row['location'], $locationRows),
            'departments' => !empty($departmentList)
                ? $departmentList
                : array_map(static fn($row) => $row['department'], $departmentRows),
        ];

        if (!empty($data['pager'])) {
            $params = array_filter($query, fn($v) => $v !== '');
            if (!empty($params)) {
                $data['pager']->setPath(current_url() . '?' . http_build_query($params));
            }
        }

        return view('pages/jobs', $data);
    }

    public function jobDetail($slug = null)
    {
        if (!$slug) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $settings = $this->loadWebsiteSettings();
        $jobModel = new \App\Models\JobModel();
        $job = $jobModel->getBySlug($slug);

        if (!$job || $job['status'] !== 'open') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $data = [
            'title' => ($job['title'] ?? 'Job') . ' | HiredNext',
            'currentPage' => 'jobs',
            'settings' => $settings,
            'job' => $job,
        ];

        return view('pages/job-detail', $data);
    }

    public function applyJob($slug = null)
    {
        if (!$slug) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $jobModel = new \App\Models\JobModel();
        $applicationModel = new \App\Models\JobApplicationModel();
        $job = $jobModel->getBySlug($slug);

        if (!$job || $job['status'] !== 'open') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[6]',
            'linkedin' => 'required|min_length[10]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $linkedin = trim((string) $this->request->getPost('linkedin'));
        if (!preg_match('#^https?://#i', $linkedin)) {
            $linkedin = 'https://' . ltrim($linkedin, '/');
        }

        $linkedinHost = strtolower((string) parse_url($linkedin, PHP_URL_HOST));
        $isLinkedInUrl = filter_var($linkedin, FILTER_VALIDATE_URL)
            && ($linkedinHost === 'linkedin.com' || str_ends_with($linkedinHost, '.linkedin.com'));

        if (!$isLinkedInUrl) {
            return redirect()->back()->withInput()->with('errors', [
                'linkedin' => 'Please enter a valid LinkedIn profile address.',
            ]);
        }

        $resumeFile = $this->request->getFile('resume');
        if (!$resumeFile || !$resumeFile->isValid()) {
            return redirect()->back()->withInput()->with('errors', ['resume' => 'Resume file is required.']);
        }

        $allowed = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        if (!in_array($resumeFile->getMimeType(), $allowed, true)) {
            return redirect()->back()->withInput()->with('errors', ['resume' => 'Resume must be PDF, DOC, or DOCX.']);
        }

        if ($resumeFile->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->withInput()->with('errors', ['resume' => 'Resume must be 5MB or less.']);
        }

        $uploadPath = FCPATH . 'uploads/resumes/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = $resumeFile->getRandomName();
        $resumeFile->move($uploadPath, $newName);

        $data = [
            'job_id' => $job['id'],
            'name' => htmlspecialchars($this->request->getPost('name')),
            'email' => htmlspecialchars($this->request->getPost('email')),
            'phone' => htmlspecialchars($this->request->getPost('phone')),
            'linkedin' => htmlspecialchars($linkedin),
            'message' => htmlspecialchars($this->request->getPost('message')),
            'resume_url' => base_url('candidate-resume') . '?file=' . rawurlencode($newName),
            'resume_name' => $resumeFile->getClientName(),
            'resume_size' => $resumeFile->getSize(),
            'status' => 'new',
        ];

        $applicationModel->insert($data);

    $to = 'jobs@hirednext.info';
    $subject = 'New Job Application: ' . ($job['title'] ?? 'Job');
    $body = "New application received on HiredNext\n\n" .
        "Job: " . ($job['title'] ?? 'N/A') . "\n" .
        "Candidate: " . ($data['name'] ?? 'N/A') . "\n" .
        "Email: " . ($data['email'] ?? 'N/A') . "\n" .
        "Phone: " . ($data['phone'] ?? 'N/A') . "\n" .
        "LinkedIn: " . ($data['linkedin'] ?? 'N/A') . "\n" .
        "Resume: " . ($data['resume_url'] ?? 'N/A') . "\n";
    $headers = "From: jobs@hirednext.info\r\n" . "Reply-To: " . ($data['email'] ?? 'jobs@hirednext.info') . "\r\n";
    @mail($to, $subject, $body, $headers);

        return redirect()->to('/jobs/' . $job['slug'] . '?applied=1')
            ->with('success', 'Your application has been submitted successfully.');
    }

    public function candidateResume()
    {
        $fileName = basename((string) $this->request->getGet('file'));
        if ($fileName === '' || !preg_match('/^[A-Za-z0-9._-]+\.(pdf|doc|docx)$/i', $fileName)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $path = FCPATH . 'uploads/resumes/' . $fileName;
        if (!is_file($path)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return $this->response->download($path, null, true)->setFileName($fileName)->inline();
    }

    private function industryPages()
    {
        return [
            'it-recruitment-services-india' => [
                'slug' => 'it-recruitment-services-india',
                'label' => 'IT Recruitment Services India',
                'meta_title' => 'IT Executive Search in India',
                'h1' => 'IT Recruitment Services India – Executive Search for Technology Leadership',
                'intro' => 'We deliver IT executive search in India for product, engineering, data, and platform leadership. For GCC and global teams hiring from India, we support confidential searches with market mapping and role-calibrated assessment.',
                'challenges' => [
                    'High competition for proven engineering and product leaders in growth-stage and enterprise environments.',
                    'Rapidly shifting skill priorities (cloud, security, data, AI/ML) driving constant org redesign.',
                    'Offer-to-join risk and counteroffers for senior tech talent.',
                    'Misalignment between architecture decisions, delivery constraints, and leadership style.',
                ],
                'approach' => [
                    'Role calibration with business outcomes, tech stack realities, and stakeholder expectations.',
                    'Market mapping across competitors, adjacent products, and specialist communities.',
                    'Structured evaluation for leadership scope, execution depth, and team-building capability.',
                    'Confidential reference checks and closure management through joining.',
                ],
                'differentiators' => [
                    'Technology-aligned search research and shortlist quality controls.',
                    'Speed with discipline: fewer profiles, higher relevance.',
                    'Confidentiality-first process for replacement and sensitive build-outs.',
                    'Support across India with GCC-ready hiring context.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'Share your leadership hiring brief. We respond with a calibrated search plan and timelines.',
                'cta_panel_heading' => 'Build leadership for product and platform execution.',
                'cta_panel_body' => 'If the mandate spans product delivery, engineering scale, or critical platform reliability, share your scope and stack context. We will align on mapping and evaluation.',
            ],
            'bfsi-leadership-hiring' => [
                'slug' => 'bfsi-leadership-hiring',
                'label' => 'BFSI Leadership Hiring',
                'meta_title' => 'BFSI Executive Search in India',
                'h1' => 'BFSI Leadership Hiring – Executive Search for Banking, NBFC & Insurance',
                'intro' => 'We support BFSI executive search in India for banking, NBFC, fintech, and insurance leadership roles. Our approach prioritizes governance, risk alignment, and performance track records across regulated environments and growth mandates.',
                'challenges' => [
                    'Regulatory and compliance constraints influencing leadership fit and operating style.',
                    'Risk, collections, credit, and underwriting outcomes that require validated performance history.',
                    'Talent scarcity for transformation roles (digital, analytics, partnerships) with governance rigor.',
                    'Confidential leadership changes where stakeholder communication must be controlled.',
                ],
                'approach' => [
                    'Define role success metrics across growth, risk, and compliance requirements.',
                    'Target mapping across banks, NBFCs, insurers, fintechs, and relevant adjacent sectors.',
                    'Assessment for governance mindset, decision quality, and execution under audit visibility.',
                    'Discreet referencing and closure support to reduce drop-offs.',
                ],
                'differentiators' => [
                    'Risk-aware search execution for regulated leadership hires.',
                    'Coverage across metro hiring hubs and pan-India leadership mobility.',
                    'Stakeholder-ready shortlists with clear evaluation notes.',
                    'Confidential retained search process and post-offer support.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'Tell us the role scope and reporting line. We will align on a search map and shortlist timeline.',
                'cta_panel_heading' => 'Hire BFSI leaders with governance and execution depth.',
                'cta_panel_body' => 'For regulated leadership roles where risk, compliance, and performance outcomes are non-negotiable, share the mandate and we will revert with a search plan.',
            ],
            'retail-executive-search' => [
                'slug' => 'retail-executive-search',
                'label' => 'Retail Executive Search',
                'meta_title' => 'Retail Executive Search in India',
                'h1' => 'Retail Executive Search – Leadership Hiring for Omnichannel & Brands',
                'intro' => 'We deliver retail executive search in India for commercial and operating leadership across omnichannel, marketplace, and brand-led retail. Our shortlists prioritize leaders who can scale profitable growth, improve conversion, and build high-performing teams.',
                'challenges' => [
                    'Need for leaders who can balance margin, inventory health, and growth under volatile demand.',
                    'Omnichannel execution complexity across stores, e-commerce, and supply chain.',
                    'High churn risk in senior commercial roles due to aggressive targets and market competition.',
                    'Category leadership gaps that impact assortment, pricing, and customer experience.',
                ],
                'approach' => [
                    'Calibrate the leadership mandate (growth, profitability, category, expansion, turnaround).',
                    'Map leaders across competitor brands, marketplaces, D2C, and adjacent consumer sectors.',
                    'Evaluate P&L ownership, retail math, execution cadence, and people leadership.',
                    'Close with reference depth and joining governance to reduce offer-to-join risk.',
                ],
                'differentiators' => [
                    'Shortlists built on proven P&L and execution outcomes, not titles.',
                    'Sector-specific mapping across brands, marketplaces, and D2C ecosystems.',
                    'Assessment notes designed for senior stakeholders.',
                    'Confidential process for sensitive replacements and expansion hiring.',
                ],
                'related_pages' => [
                    ['label' => 'Textile, Apparel, Fashion & Lifestyle Recruitment', 'url' => base_url('industry/garment-textile-recruitment-india')],
                    ['label' => 'Manufacturing Talent Advisory', 'url' => base_url('industry/manufacturing-talent-advisory')],
                    ['label' => 'Executive Search & Leadership Hiring', 'url' => base_url('services/executive-search')],
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'If you are hiring a senior retail leader, share the mandate and we will revert with a search plan.',
                'cta_panel_heading' => 'Leadership hiring for profitable retail growth.',
                'cta_panel_body' => 'For mandates across category, commercial, expansion, or omnichannel, we focus on leaders with verified outcomes. Share the business context and role scope to begin.',
            ],
            'engineering-recruitment-firm' => [
                'slug' => 'engineering-recruitment-firm',
                'label' => 'Engineering Recruitment Firm',
                'meta_title' => 'Engineering Executive Search in India',
                'h1' => 'Engineering Recruitment Firm – Executive Search for Technical Leadership',
                'intro' => 'We support engineering executive search in India for technical leadership roles across projects, quality, maintenance, and operations. Our process identifies leaders who deliver safety, reliability, and throughput with strong on-ground execution.',
                'challenges' => [
                    'Hard-to-verify leadership capability across multi-site operations and complex project delivery.',
                    'Safety, quality, and reliability outcomes that require evidence-backed track records.',
                    'Scarcity of leaders with both technical depth and strong people management.',
                    'Location constraints impacting talent availability for plant and project roles.',
                ],
                'approach' => [
                    'Align role scope with plant/project goals, CAPEX/OPEX context, and governance structure.',
                    'Map leaders across relevant industries and comparable operating environments.',
                    'Assess technical depth, shopfloor credibility, and execution under constraints.',
                    'Reference, offer management, and joining support with clear documentation.',
                ],
                'differentiators' => [
                    'Search mapping built around operating context, not generic job titles.',
                    'Evaluation for safety mindset, reliability outcomes, and execution cadence.',
                    'Support for leadership hiring across India’s industrial clusters.',
                    'Clear communication and controlled process for confidential searches.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'Share your engineering leadership requirement and operating context. We will respond with the search approach.',
                'cta_panel_heading' => 'Engineering leadership with on-ground credibility.',
                'cta_panel_body' => 'If the role impacts safety, reliability, project delivery, or throughput, share the plant/project context and team scope. We will align on mapping and assessment.',
            ],
            'manufacturing-talent-advisory' => [
                'slug' => 'manufacturing-talent-advisory',
                'label' => 'Manufacturing Talent Advisory',
                'meta_title' => 'Manufacturing Executive Search in India',
                'h1' => 'Manufacturing Talent Advisory – Executive Search for Plant & Operations Leadership',
                'intro' => 'We provide manufacturing executive search in India for plant, operations, and supply chain leadership. For global organizations building or scaling manufacturing footprints in India, we support leadership hiring with market mapping and structured assessment.',
                'challenges' => [
                    'Scaling operations while maintaining quality, safety, and compliance discipline.',
                    'Leadership gaps during expansion, turnaround, or capacity ramp-up phases.',
                    'Need for leaders who can drive productivity, cost, and reliability improvements.',
                    'Talent availability constraints across industrial clusters and location preferences.',
                ],
                'approach' => [
                    'Define the operating mandate: throughput, quality, safety, cost, and team capability.',
                    'Map proven leaders across comparable plants and relevant manufacturing ecosystems.',
                    'Assess operational cadence, continuous improvement approach, and workforce leadership.',
                    'Support closure through joining with clear stakeholder alignment.',
                ],
                'differentiators' => [
                    'Advisory-led retained search for plant and operations leadership.',
                    'Context-driven evaluation for productivity, reliability, and compliance outcomes.',
                    'Experience supporting India-based leadership hiring for global and GCC-linked teams.',
                    'Disciplined process management from mapping to joining.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'Discuss your manufacturing leadership requirement. We will align on scope, mapping, and timelines.',
                'geo_roles' => [
                    'Plant Head / Factory Head',
                    'Manufacturing Head',
                    'Operations Head',
                    'Supply Chain Head',
                    'Quality Head',
                    'Engineering & Maintenance Head',
                    'Project / Expansion Leadership',
                    'Continuous Improvement & Operational Excellence Leaders',
                ],
                'geo_faq' => [
                    [
                        'question' => 'How does HiredNext recruit manufacturing and plant leaders in India?',
                        'answer' => 'HiredNext uses role calibration, manufacturing-sector market mapping, confidential outreach, structured assessment, and offer-to-joining governance to recruit plant, operations, quality, engineering, supply chain, and manufacturing leadership across India.'
                    ],
                    [
                        'question' => 'What manufacturing leadership roles does HiredNext recruit?',
                        'answer' => 'HiredNext recruits Plant Heads, Manufacturing Heads, Operations Heads, Supply Chain Heads, Quality Heads, Engineering and Maintenance leaders, project leaders, and operational-excellence professionals.'
                    ],
                    [
                        'question' => 'Can HiredNext support confidential manufacturing leadership searches?',
                        'answer' => 'Yes. HiredNext supports confidential and retained searches for critical manufacturing leadership roles where discretion, market mapping, and structured evaluation are required.'
                    ],
                    [
                        'question' => 'How do you assess candidates for plant leadership roles?',
                        'answer' => 'Candidates are assessed against the operating context of the plant, including scale, throughput, quality, safety, people leadership, cost, maintenance, supply chain, transformation, and measurable business outcomes.'
                    ],
                ],
                'related_pages' => [
                    ['label' => 'Textile, Apparel, Fashion & Lifestyle Recruitment', 'url' => base_url('industry/garment-textile-recruitment-india')],
                    ['label' => 'Retail Executive Search', 'url' => base_url('industry/retail-executive-search')],
                    ['label' => 'Executive Search & Leadership Hiring', 'url' => base_url('services/executive-search')],
                ],
                'cta_panel_heading' => 'Leadership hiring for plant and operations scale.',
                'cta_panel_body' => 'For capacity ramp-ups, turnarounds, or new plant leadership mandates, share your operating metrics and constraints. We will propose a retained search plan and timelines.',
            ],
        ];
    }

    private function regionPages()
    {
        return [
            'india' => [
                'slug' => 'india',
                'label' => 'India',
                'meta_title' => 'Leadership Hiring in India (CXO & Mid-Senior)',
                'h1' => 'Leadership Hiring in India – CXO & Mid-Senior Executive Search',
                'intro' => 'We support retained executive search and leadership hiring across India’s major talent hubs. Our process is designed for confidential replacements, growth hires, and capability builds for India-based and global teams.',
                'focus' => [
                    'CXO and functional leadership roles across technology, finance, operations, commercial, and HR.',
                    'GCC leadership hiring and India-based global roles with cross-border stakeholder alignment.',
                    'Leadership mapping across metro clusters and emerging tier-2 talent markets where relevant.',
                ],
                'approach' => [
                    'Role calibration with business outcomes, reporting lines, and stakeholder expectations.',
                    'Market mapping across competitors and adjacent sectors for higher relevance.',
                    'Structured assessment for leadership scope, execution depth, and culture fit.',
                    'Closure management to reduce offer-to-join risk and ensure joining discipline.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'Share the role scope and location constraints. We will revert with a search plan and timelines.',
            ],
            'middle-east' => [
                'slug' => 'middle-east',
                'label' => 'Middle East',
                'meta_title' => 'Leadership Hiring for Middle East Mandates',
                'h1' => 'Leadership Hiring for Middle East – Executive Search Support',
                'intro' => 'We support Middle East leadership hiring for organizations operating across GCC markets, including roles requiring India-to-GCC mobility and cross-border stakeholder alignment. Our retained approach prioritizes confidentiality, compliance, and joining governance.',
                'focus' => [
                    'Leadership searches for GCC business expansion, transformation, and operational scale.',
                    'India-to-GCC talent mapping where relocation, compensation, and compliance are critical.',
                    'Shortlists aligned to sector context and local operating realities.',
                ],
                'approach' => [
                    'Mandate calibration with business goals, relocation feasibility, and governance requirements.',
                    'Market mapping across GCC and India-based leaders with relevant exposure.',
                    'Structured evaluation and referencing with discretion and documentation.',
                    'Offer and joining support to reduce cross-border drop-offs.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'If you are hiring for a GCC mandate, share role scope and location preferences to begin.',
            ],
            'apac' => [
                'slug' => 'apac',
                'label' => 'APAC',
                'meta_title' => 'Leadership Hiring for APAC Roles',
                'h1' => 'Leadership Hiring for APAC – Executive Search & Market Mapping',
                'intro' => 'We support executive search for APAC leadership roles where multi-market execution, matrix stakeholder management, and scale building are required. Our process is structured for senior hiring decisions with clear assessment notes.',
                'focus' => [
                    'Regional leadership hiring across growth, profitability, and operating transformation mandates.',
                    'Cross-market leadership assessments for multi-country stakeholder environments.',
                    'Market mapping for sector-specific leadership talent with proven outcomes.',
                ],
                'approach' => [
                    'Calibrate success metrics and stakeholder expectations across markets.',
                    'Target mapping across APAC leaders and India-based candidates with regional exposure.',
                    'Structured evaluation for leadership scope, execution cadence, and team-building capability.',
                    'Closure governance to ensure smooth transitions.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'Share the APAC role mandate and markets involved. We will align on mapping and timelines.',
            ],
            'europe' => [
                'slug' => 'europe',
                'label' => 'Europe',
                'meta_title' => 'Leadership Hiring for Europe Roles',
                'h1' => 'Leadership Hiring for Europe – Executive Search Support',
                'intro' => 'We support leadership hiring for Europe-based roles and global teams with European stakeholder alignment. Our retained approach emphasizes confidentiality, role calibration, and evidence-backed evaluation for senior mandates.',
                'focus' => [
                    'Leadership searches for business transformation, operations, and functional head roles.',
                    'Cross-border hiring involving India delivery hubs and European leadership requirements.',
                    'Shortlists built for governance, execution depth, and stakeholder communication.',
                ],
                'approach' => [
                    'Define mandate scope with stakeholders and decision timelines.',
                    'Map relevant leadership pools across Europe and India-linked talent where appropriate.',
                    'Assess leadership outcomes, decision quality, and operating style.',
                    'Support offer closure and transition planning.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'Share the role scope and stakeholder context. We will propose a structured search plan.',
            ],
            'usa' => [
                'slug' => 'usa',
                'label' => 'USA',
                'meta_title' => 'Leadership Hiring for USA Roles',
                'h1' => 'Leadership Hiring for USA – Executive Search & Cross-Border Support',
                'intro' => 'We support executive search for USA leadership roles and global mandates with India delivery or GCC growth context. Our process is built for senior stakeholders who require clear assessment, discretion, and closure discipline.',
                'focus' => [
                    'Leadership hiring for scaling teams, transformation programs, and critical functional roles.',
                    'Cross-border searches involving India-based leadership or global mobility requirements.',
                    'Shortlists aligned to outcomes, leadership scope, and culture fit.',
                ],
                'approach' => [
                    'Calibrate the mandate against business outcomes and operating constraints.',
                    'Market mapping across relevant leadership pools and adjacent sectors.',
                    'Structured evaluation, referencing, and controlled stakeholder feedback loops.',
                    'Offer and joining risk management to reduce drop-offs.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'If you are hiring a USA-based leader, share the mandate and we will revert with mapping and timelines.',
            ],
            'expanding-horizons' => [
                'slug' => 'expanding-horizons',
                'label' => 'Expanding Horizons',
                'meta_title' => 'Global Leadership Hiring (Expanding Horizons)',
                'h1' => 'Global Leadership Hiring – Expanding Horizons',
                'intro' => 'Our global search support is designed for organizations expanding into new markets, building GCC capability, or scaling multi-region operations. We run retained searches with confidentiality, structured evaluation, and joining governance.',
                'focus' => [
                    'New-market leadership hires where operating context and stakeholder alignment are critical.',
                    'GCC-linked and cross-border leadership mandates requiring careful mapping.',
                    'Confidential leadership changes and sensitive capability builds.',
                ],
                'approach' => [
                    'Mandate calibration and market feasibility assessment.',
                    'Region-by-region talent mapping and shortlist governance.',
                    'Structured evaluation and discreet referencing.',
                    'Closure support with transition planning to ensure stable joins.',
                ],
                'cta_title' => 'Get in Touch',
                'cta_description' => 'Share the regions, role scope, and timelines. We will align on search strategy and execution plan.',
            ],
        ];
    }

    // Helper methods to load dynamic content
    private function loadActiveServices()
    {
        $db = \Config\Database::connect();
        return $db->table('services')
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    private function loadActiveTeam()
    {
        $db = \Config\Database::connect();
        return $db->table('team_members')
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    private function loadActiveClients()
    {
        $db = \Config\Database::connect();
        return $db->table('clients')
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    private function loadActiveReviews()
    {
        $db = \Config\Database::connect();
        return $db->table('reviews')
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    private function loadPublishedBlogPosts()
    {
        $db = \Config\Database::connect();
        return $db->table('blog_posts')
            ->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    private function prepareBlogDocument($content)
    {
        $html = html_entity_decode((string)$content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $html = preg_replace('/<h1[^>]*>.*?<\/h1>/si', '', $html, 1);
        $toc = [];
        $usedIds = [];

        $html = preg_replace_callback('/<h([23])([^>]*)>(.*?)<\/h\1>/is', function ($matches) use (&$toc, &$usedIds) {
            $level = (int)$matches[1];
            $attributes = $matches[2];
            $innerHtml = $matches[3];
            $heading = $this->normaliseText($innerHtml);
            if ($heading === '') {
                return $matches[0];
            }

            if (preg_match('/\sid=(["\'])(.*?)\1/i', $attributes, $idMatch)) {
                $id = $idMatch[2];
            } else {
                $baseId = $this->headingSlug($heading);
                $id = $baseId;
                $suffix = 2;
                while (isset($usedIds[$id])) {
                    $id = $baseId . '-' . $suffix;
                    $suffix++;
                }
                $attributes .= ' id="' . esc($id, 'attr') . '"';
            }

            $usedIds[$id] = true;
            $toc[] = ['level' => $level, 'id' => $id, 'text' => $heading];
            return '<h' . $level . $attributes . '>' . $innerHtml . '</h' . $level . '>';
        }, $html);

        $faq = [];
        if (preg_match_all('/<h([23])[^>]*>(.*?)<\/h\1>\s*<p[^>]*>(.*?)<\/p>/is', $html, $questionMatches, PREG_SET_ORDER)) {
            foreach ($questionMatches as $match) {
                $question = $this->normaliseText($match[2]);
                $answer = $this->normaliseText($match[3]);
                if ($question !== '' && substr($question, -1) === '?' && $answer !== '') {
                    $faq[] = ['question' => $question, 'answer' => $answer];
                }
            }
        }

        $plainText = $this->normaliseText($html);
        $wordCount = $plainText === '' ? 0 : str_word_count($plainText);

        return [
            'html' => $html,
            'plainText' => $plainText,
            'toc' => $toc,
            'faq' => $faq,
            'wordCount' => $wordCount,
            'readMinutes' => max(1, (int)ceil($wordCount / 220)),
        ];
    }

    private function normaliseText($value)
    {
        $text = html_entity_decode(strip_tags((string)$value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return trim((string)preg_replace('/\s+/u', ' ', $text));
    }

    private function truncateText($value, $limit)
    {
        $text = $this->normaliseText($value);
        if (strlen($text) <= $limit) {
            return $text;
        }

        $truncated = substr($text, 0, $limit + 1);
        $lastSpace = strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = substr($truncated, 0, $lastSpace);
        }

        return rtrim($truncated, " \t\n\r\0\x0B,.;:-") . '…';
    }

    private function headingSlug($heading)
    {
        $slug = strtolower($this->normaliseText($heading));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim((string)$slug, '-');
        return $slug !== '' ? $slug : 'section';
    }

    private function formatSchemaDate($value)
    {
        if (empty($value) || strtotime((string)$value) === false) {
            return null;
        }

        return date(DATE_ATOM, strtotime((string)$value));
    }

    private function loadBlogPostBySlug($slug)
    {
        $db = \Config\Database::connect();
        return $db->table('blog_posts')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->get()
            ->getRowArray();
    }

    private function loadRelatedBlogPosts($category, $excludeId, $limit = 3)
    {
        $db = \Config\Database::connect();
        return $db->table('blog_posts')
            ->where('category', $category)
            ->where('id !=', $excludeId)
            ->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    private function loadPublishedProjects()
    {
        $db = \Config\Database::connect();
        return $db->table('projects')
            ->where('status', 'published')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    private function loadActivePressMedia()
    {
        $db = \Config\Database::connect();
        return $db->table('press_media')
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    private function loadProjectsByCategory($category)
    {
        $db = \Config\Database::connect();
        return $db->table('projects')
            ->where('status', 'published')
            ->like('category', $category, 'both')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
