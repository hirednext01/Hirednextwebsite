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

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => base_url('jobs') . '#collection',
                    'url' => base_url('jobs'),
                    'name' => 'Jobs in India – Leadership, Technology & Specialist Roles',
                    'description' => 'Current employer mandates managed by HiredNext Recruitment across India, including leadership, technology and specialist roles.',
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
            ],
        ];

        return view('pages/jobs', [
            'title' => 'Jobs in India – Leadership, Technology & Specialist Roles | HiredNext',
            'metaDescription' => 'Explore current employer mandates managed by HiredNext across India. Search leadership, technology and specialist jobs by location, industry, employment type or keyword.',
            'metaKeywords' => 'jobs in India, leadership jobs India, technology jobs India, specialist jobs India, HiredNext jobs, recruitment jobs India',
            'canonical' => base_url('jobs'),
            'currentPage' => 'jobs',
            'settings' => $settings,
            'jobs' => $jobs,
            'pager' => $pager,
            'filters' => $query,
            'types' => array_values(array_filter(array_map(static fn($row) => trim((string) ($row['type'] ?? '')), $typeRows))),
            'locations' => array_values($locations),
            'industries' => $industries,
            'filterQuery' => http_build_query($activeFilters),
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
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
