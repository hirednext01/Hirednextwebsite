<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CandidateServices extends BaseController
{
    public function services()
    {
        return redirect()->to('/services/clients');
    }

    public function clientServices()
    {
        $settings = $this->loadWebsiteSettings();

        return view('pages/services/client-services', [
            'title' => 'Recruitment Services for Employers | HiredNext India',
            'metaDescription' => 'Executive search, permanent hiring, RPO and sector-led recruitment services for employers hiring across India and international markets.',
            'currentPage' => 'services',
            'settings' => $settings,
        ]);
    }

    public function candidateServices()
    {
        $settings = $this->loadWebsiteSettings();
        $pageUrl = base_url('services/candidates');
        $faq = [
            [
                'q' => 'What is career advisory for senior professionals?',
                'a' => 'Career advisory for senior professionals is structured guidance on role positioning, CV and LinkedIn narrative, target-role choices, interview strategy, career transitions and how to communicate leadership impact. It improves decision quality and presentation; it does not guarantee interviews or job offers.',
            ],
            [
                'q' => 'Can HiredNext help a senior professional reposition for a leadership role?',
                'a' => 'Yes. HiredNext can help experienced professionals clarify their target role, identify the evidence that matters to recruiters and hiring leaders, strengthen their professional narrative and prepare for senior-level interviews.',
            ],
            [
                'q' => 'Does HiredNext charge candidates for job applications or placement?',
                'a' => 'No. HiredNext does not charge candidates to apply for jobs or secure placement. Optional career services such as CV assessment, CV rebuilding and interview or career strategy are separately priced services.',
            ],
            [
                'q' => 'What should a senior professional prepare before a career strategy session?',
                'a' => 'Bring your current CV or LinkedIn profile, the roles or transitions you are considering, examples of business outcomes you have delivered, any recurring interview or positioning challenges and the constraints that matter to your next move.',
            ],
        ];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    '@id' => $pageUrl . '#career-advisory',
                    'name' => 'Career Advisory for Senior Professionals in India',
                    'serviceType' => 'Career advisory and interview strategy',
                    'provider' => [
                        '@type' => 'Organization',
                        '@id' => 'https://hirednext.net/#organization',
                        'name' => 'HiredNext Recruitment',
                        'url' => 'https://hirednext.net/',
                    ],
                    'areaServed' => [
                        '@type' => 'Country',
                        'name' => 'India',
                    ],
                    'audience' => [
                        '@type' => 'Audience',
                        'audienceType' => 'Senior professionals, managers and leadership candidates',
                    ],
                    'description' => 'Recruiter-informed career advisory for senior professionals covering positioning, target roles, CV narrative, interview strategy and career transitions.',
                    'url' => $pageUrl,
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_map(static function (array $item) {
                        return [
                            '@type' => 'Question',
                            'name' => $item['q'],
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => $item['a'],
                            ],
                        ];
                    }, $faq),
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Candidate Services', 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        $html = view('pages/services/candidate-services', [
            'title' => 'Career Advisory for Senior Professionals in India | HiredNext',
            'metaDescription' => 'Recruiter-informed career advisory for senior professionals in India: role positioning, CV strategy, career transitions, leadership interview preparation and practical next-step guidance.',
            'metaKeywords' => 'career advisory senior professionals India, senior career coach India, leadership career advice, executive interview strategy, senior professional CV, career transition India',
            'canonical' => $pageUrl,
            'currentPage' => 'services',
            'settings' => $settings,
            'faq' => $faq,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);

        $proof = static function (string $key): string {
            return view('pages/services/_candidate-success', ['successKey' => $key]);
        };

        $replacements = [
            '<a href="' . base_url('services/cv-assessment') . '" class="mt-6 inline-flex rounded-full bg-accent px-6 py-3 font-black text-white">Get assessed →</a></article>'
                => '<a href="' . base_url('services/cv-assessment') . '" class="mt-6 inline-flex rounded-full bg-accent px-6 py-3 font-black text-white">Get assessed →</a>' . $proof('assessment') . '</article>',
            '<a href="' . base_url('career-services/start/rebuild_1799') . '" class="mt-6 inline-flex rounded-full bg-primary px-6 py-3 font-black text-white">Get a new CV made →</a></article>'
                => '<a href="' . base_url('career-services/start/rebuild_1799') . '" class="mt-6 inline-flex rounded-full bg-primary px-6 py-3 font-black text-white">Get a new CV made →</a>' . $proof('rebuild') . '</article>',
            '<a href="' . base_url('career-services/start/ats_999') . '" class="mt-5 inline-flex text-sm font-black text-primary hover:text-accent">Start ATS optimisation →</a></article>'
                => '<a href="' . base_url('career-services/start/ats_999') . '" class="mt-5 inline-flex text-sm font-black text-primary hover:text-accent">Start ATS optimisation →</a>' . $proof('ats') . '</article>',
            '<a href="' . base_url('career-services/start/career_4500') . '" class="mt-5 inline-flex text-sm font-black text-primary hover:text-accent">Book the 60-minute consultation →</a></article>'
                => '<a href="' . base_url('career-services/start/career_4500') . '" class="mt-5 inline-flex text-sm font-black text-primary hover:text-accent">Book the 60-minute consultation →</a>' . $proof('strategy') . '</article>',
        ];

        return strtr($html, $replacements);
    }

    public function cvAssessment()
    {
        $jobSlug = trim((string) ($this->request->getGet('job') ?? ''));
        $job = null;

        if ($jobSlug !== '') {
            $jobModel = new \App\Models\JobModel();
            $candidateJob = $jobModel->getBySlug($jobSlug);
            if ($candidateJob && ($candidateJob['status'] ?? '') === 'open') {
                $job = $candidateJob;
            }
        }

        return view('pages/services/cv-assessment', [
            'title' => 'CV Assessment | HiredNext',
            'metaDescription' => 'Get a detailed 12-hour, role-focused CV assessment for ₹599 from HiredNext recruitment experts.',
            'currentPage' => 'services',
            'job' => $job,
        ]);
    }
}
