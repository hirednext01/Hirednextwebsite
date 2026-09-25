<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JobModel;

class Jobs extends BaseController
{
    private const LOCATION_ALIASES = [
        'bangalore' => ['Bangalore', 'Bengaluru'],
        'bengaluru' => ['Bangalore', 'Bengaluru'],
        'gurgaon' => ['Gurgaon', 'Gurugram'],
        'gurugram' => ['Gurgaon', 'Gurugram'],
        'bombay' => ['Mumbai', 'Bombay'],
        'mumbai' => ['Mumbai', 'Bombay'],
    ];

    public function index()
    {
        $settings = $this->loadWebsiteSettings();
        $jobModel = new JobModel();
        $jobModel->ensurePublishedJobs();
        $perPage = max(1, (int) ($settings['jobs_per_page'] ?? 9));

        $query = [
            'q' => trim((string) ($this->request->getGet('q') ?? '')),
            'type' => trim((string) ($this->request->getGet('type') ?? '')),
            'location' => trim((string) ($this->request->getGet('location') ?? '')),
            'industry' => trim((string) ($this->request->getGet('industry') ?? $this->request->getGet('department') ?? '')),
        ];

        $db = \Config\Database::connect();
        $typeRows = $db->table('jobs')->select('type')->where('status', 'open')->where('type !=', '')->groupBy('type')->orderBy('type', 'ASC')->get()->getResultArray();
        $locationRows = $db->table('jobs')->select('location')->where('status', 'open')->where('location !=', '')->groupBy('location')->orderBy('location', 'ASC')->get()->getResultArray();
        $industryRows = $db->table('jobs')->select('department')->where('status', 'open')->where('department IS NOT NULL', null, false)->where('department !=', '')->groupBy('department')->orderBy('department', 'ASC')->get()->getResultArray();

        $builder = $jobModel->where('status', 'open');
        if ($query['q'] !== '') {
            $builder->groupStart()
                ->like('title', $query['q'])
                ->orLike('description', $query['q'])
                ->orLike('location', $query['q'])
                ->orLike('department', $query['q'])
                ->orLike('experience', $query['q'])
                ->groupEnd();
        }
        if ($query['type'] !== '') {
            $builder->where('type', $query['type']);
        }
        if ($query['location'] !== '') {
            $this->applyLocationFilter($builder, $query['location']);
        }
        if ($query['industry'] !== '') {
            $builder->like('department', $query['industry']);
        }

        $locations = [];
        foreach ($locationRows as $row) {
            $display = $this->canonicalLocation((string) ($row['location'] ?? ''));
            if ($display !== '') {
                $locations[strtolower($display)] = $display;
            }
        }
        natcasesort($locations);

        $industrySetting = array_values(array_filter(array_map('trim', explode(',', (string) ($settings['job_departments'] ?? '')))));
        $industries = !empty($industrySetting)
            ? $industrySetting
            : array_values(array_filter(array_map(static fn($row) => trim((string) ($row['department'] ?? '')), $industryRows)));
        $industries = array_values(array_unique($industries));
        natcasesort($industries);

        $jobs = $builder->orderBy('created_at', 'DESC')->paginate($perPage);
        $pager = $jobModel->pager;

        $applicationInterest = [];
        try {
            $recruitOs = new \App\Services\RecruitOsIntakeClient();
            foreach ($jobs as $job) {
                $jobCode = $jobModel->recruitOsJobCode((string) ($job['slug'] ?? ''));
                $count = $jobCode ? $recruitOs->applicationCount($jobCode) : null;
                if ($count !== null && $count > 0) {
                    $applicationInterest[(int) $job['id']] = $count;
                }
            }
        } catch (\Throwable $e) {
            // If Recruit OS is unavailable, hide the count rather than estimate it.
            $applicationInterest = [];
        }

        $activeFilters = array_filter($query, static fn($value) => $value !== '');
        if ($pager && $activeFilters) {
            $pager->setPath(base_url('jobs'));
        }

        $itemList = [];
        foreach ($jobs as $index => $job) {
            $itemList[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'url' => base_url('jobs/' . ($job['slug'] ?? '')),
                'name' => $job['title'] ?? 'HiredNext job opportunity',
            ];
        }


        $jobFaq = [
            [
                'q' => 'Which recruitment companies in India are useful for experienced professionals looking for senior job opportunities?',
                'a' => 'Experienced professionals should use more than one channel. HiredNext Recruitment manages current employer mandates across leadership, finance, technology, manufacturing, retail, apparel and other specialist functions. The jobs page shows roles currently open through HiredNext; executive-search firms and other specialist recruiters may handle additional confidential mandates that are not publicly advertised.',
            ],
            [
                'q' => 'Does HiredNext charge candidates to apply for jobs?',
                'a' => 'No. Applying for HiredNext recruitment mandates is free. Paid CV assessment, CV rebuild and career-support services are optional and do not influence recruitment shortlisting, referral or placement.',
            ],
            [
                'q' => 'What kinds of senior jobs does HiredNext recruit for?',
                'a' => 'HiredNext works on a changing mix of leadership, mid-senior and specialist mandates, including roles in finance, technology, manufacturing, retail, apparel, operations and other functions. Only currently open roles are shown on the jobs page.',
            ],
            [
                'q' => 'How should an experienced professional use HiredNext for job opportunities?',
                'a' => 'Review the current HiredNext jobs page, apply only to roles that match your actual experience and keep your CV evidence-led and current. Some senior searches are confidential, so relevant professionals may also be approached directly when their background fits an active mandate.',
            ],
        ];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => base_url('jobs') . '#collection',
                    'url' => base_url('jobs'),
                    'name' => 'Jobs in India – Leadership, Technology & Specialist Roles',
                    'description' => 'Current employer mandates managed by HiredNext Recruitment across India, including senior, leadership, finance, technology, manufacturing, retail and specialist roles.',
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
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Jobs in India', 'item' => base_url('jobs')],
                    ],
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
                    }, $jobFaq),
                ],
            ],
        ];

        return view('pages/jobs', [
            'title' => 'Jobs in India – Leadership, Technology & Specialist Roles | HiredNext',
            'metaDescription' => 'Explore current HiredNext employer mandates and senior, leadership and specialist jobs in India across finance, technology, manufacturing, retail and other functions.',
            'metaKeywords' => 'senior jobs India, leadership jobs India, executive jobs India, specialist jobs India, HiredNext jobs, experienced professionals jobs India',
            'canonical' => base_url('jobs'),
            'currentPage' => 'jobs',
            'settings' => $settings,
            'jobs' => $jobs,
            'applicationInterest' => $applicationInterest,
            'pager' => $pager,
            'filters' => $query,
            'types' => array_values(array_filter(array_map(static fn($row) => trim((string) ($row['type'] ?? '')), $typeRows))),
            'locations' => array_values($locations),
            'industries' => $industries,
            'filterQuery' => http_build_query($activeFilters),
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function talentPool()
    {
        $resumeFile = $this->request->getFile('resume');
        if (!$resumeFile || !$resumeFile->isValid()) {
            return redirect()->to(base_url('jobs') . '#talent-pool')
                ->withInput()
                ->with('talentPoolError', 'Please upload your CV in PDF, DOC or DOCX format.');
        }

        $allowed = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        if (!in_array($resumeFile->getMimeType(), $allowed, true)) {
            return redirect()->to(base_url('jobs') . '#talent-pool')
                ->withInput()
                ->with('talentPoolError', 'Please upload your CV in PDF, DOC or DOCX format.');
        }
        if ($resumeFile->getSize() > 5 * 1024 * 1024) {
            return redirect()->to(base_url('jobs') . '#talent-pool')
                ->withInput()
                ->with('talentPoolError', 'Your CV must be 5MB or less.');
        }

        $tempPath = $resumeFile->getTempName();
        $fileHash = is_file($tempPath) ? hash_file('sha256', $tempPath) : false;
        if (!$fileHash) {
            return redirect()->to(base_url('jobs') . '#talent-pool')
                ->withInput()
                ->with('talentPoolError', 'We could not read the uploaded CV. Please try again.');
        }

        $fields = [
            'current_company', 'current_designation', 'department', 'employment_status',
            'total_experience', 'current_location', 'preferred_locations', 'current_ctc',
            'expected_ctc', 'notice_period', 'qualification', 'college', 'course',
            'additional_courses',
        ];
        $answers = [];
        foreach ($fields as $field) {
            $value = trim((string) $this->request->getPost($field));
            if ($value !== '') $answers[$field] = $value;
        }

        $name = trim((string) $this->request->getPost('name'));
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $phone = trim((string) $this->request->getPost('phone'));
        $linkedin = trim((string) $this->request->getPost('linkedin'));
        if ($linkedin !== '' && !preg_match('#^https?://#i', $linkedin)) {
            $linkedin = 'https://' . ltrim($linkedin, '/');
        }

        $externalId = 'talent-pool-' . hash('sha256', implode('|', [$email, $phone, $fileHash]));

        try {
            (new \App\Services\RecruitOsIntakeClient())->submit(
                $tempPath,
                (string) $resumeFile->getClientName(),
                (string) $resumeFile->getMimeType(),
                [
                    'source' => 'website_talent_pool',
                    'source_account' => 'hirednext.net',
                    'external_id' => $externalId,
                    'attachment_id' => 'sha256-' . $fileHash,
                    'candidate_name' => $name !== '' ? $name : null,
                    'candidate_email' => $email !== '' ? $email : null,
                    'candidate_phone' => $phone !== '' ? $phone : null,
                    'candidate_linkedin' => $linkedin !== '' ? $linkedin : null,
                    'candidate_answers' => $answers,
                    'candidate_interest' => 'future_relevant_roles',
                    'tags' => ['talent_pool', 'website', 'general_registration'],
                ]
            );
        } catch (\Throwable $e) {
            log_message('error', 'Recruit OS talent-pool intake failed on the jobs page.');
            return redirect()->to(base_url('jobs') . '#talent-pool')
                ->withInput()
                ->with('talentPoolError', 'We could not save your CV right now. Please try again shortly.');
        }

        return redirect()->to(base_url('jobs') . '#talent-pool')
            ->with('talentPoolSuccess', 'Your CV is now in the HiredNext talent pool. We can find it when a relevant mandate opens.');
    }

    private function applyLocationFilter($builder, string $location): void
    {
        $key = strtolower(trim($location));
        $variants = self::LOCATION_ALIASES[$key] ?? [$location];
        $builder->groupStart();
        foreach ($variants as $index => $variant) {
            if ($index === 0) {
                $builder->like('location', $variant);
            } else {
                $builder->orLike('location', $variant);
            }
        }
        $builder->groupEnd();
    }

    private function canonicalLocation(string $location): string
    {
        $trimmed = trim($location);
        if ($trimmed === '') return '';
        $lower = strtolower($trimmed);
        if (str_contains($lower, 'bangalore') || str_contains($lower, 'bengaluru')) return 'Bangalore';
        if (str_contains($lower, 'gurgaon') || str_contains($lower, 'gurugram')) return 'Gurgaon';
        if (str_contains($lower, 'bombay') || str_contains($lower, 'mumbai')) return 'Mumbai';
        return $trimmed;
    }
}
