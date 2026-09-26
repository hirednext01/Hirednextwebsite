<?php

namespace App\Libraries;

/** Confirmed buying house mandates supplied on 26 September 2026. */
final class BuyingHouseDesignJobs
{
    private const ROLES = [
        'fashion-designer-womenswear-delhi-buying-house' => [
            'code' => 'HN-FD-DEL-0926',
            'title' => 'Fashion Designer, Womenswear',
            'location' => 'Delhi',
            'region' => 'Delhi',
            'experience' => 'Buying house or export house',
            'salary' => 'Up to ₹13 lakh per annum',
            'salary_key' => 'maxValue',
            'salary_value' => 1300000,
            'requirements' => [
                'Womenswear design experience.',
                'Experience working with a buying house or export house.',
                'A portfolio demonstrating relevant womenswear design work.',
            ],
        ],
        'fashion-designer-apparel-home-gurgaon-buying-house' => [
            'code' => 'HN-FD-GGN-0926',
            'title' => 'Fashion Designer, Apparel and Home',
            'location' => 'Gurgaon',
            'region' => 'Haryana',
            'experience' => 'Relevant design',
            'salary' => 'Up to ₹12 lakh per annum',
            'salary_key' => 'maxValue',
            'salary_value' => 1200000,
            'requirements' => [
                'Categories: womenswear, menswear, kidswear and home.',
                'Buying house or export house experience preferred.',
                'NIFT graduates preferred.',
                'Share a portfolio and clearly indicate the categories you have worked on.',
            ],
        ],
        'graphic-designer-ai-fashion-delhi-buying-house' => [
            'code' => 'HN-GD-DEL-0926',
            'title' => 'Graphic Designer, AI Rendering and Fashion',
            'location' => 'Delhi',
            'region' => 'Delhi',
            'experience' => '2 to 4 years',
            'requirements' => [
                '2 to 4 years of graphic design experience.',
                'Strong AI rendering capability.',
                'Hands on proficiency with AI tools and fashion design tools.',
                'Share a portfolio with relevant fashion graphics and AI rendering examples.',
            ],
        ],
        'fashion-designer-womenswear-european-buyers-gurgaon' => [
            'code' => 'HN-FDE-GGN-0926',
            'title' => 'Fashion Designer, Womenswear for European Buyers',
            'location' => 'Gurgaon',
            'region' => 'Haryana',
            'experience' => 'Up to 6 years',
            'salary' => '₹9 lakh per annum',
            'salary_key' => 'value',
            'salary_value' => 900000,
            'requirements' => [
                'Up to 6 years of fashion design experience.',
                'Womenswear design experience with exposure to European buyers.',
                'Share a portfolio highlighting relevant womenswear collections and buyer exposure.',
            ],
        ],
    ];

    public static function publishedJobs(): array
    {
        $jobs = [];
        foreach (self::ROLES as $slug => $role) {
            $bullets = '<li><strong>Employer:</strong> Buying house.</li>'
                . '<li><strong>Location:</strong> ' . $role['location'] . '.</li>';
            if (isset($role['salary'])) {
                $bullets .= '<li><strong>Salary:</strong> ' . $role['salary'] . '.</li>';
            }
            foreach ($role['requirements'] as $requirement) {
                $bullets .= '<li>' . $requirement . '</li>';
            }
            $subject = $role['code'] . ' | ' . $role['title'];
            $description = '<p>HiredNext Recruitment is hiring a <strong>' . $role['title']
                . '</strong> for a buying house in <strong>' . $role['location']
                . '</strong>. The employer name is confidential at this stage.</p>'
                . '<p><strong>Job code: ' . $role['code'] . '</strong></p>'
                . '<h3>Role details</h3><ul>' . $bullets . '</ul>'
                . '<h3>How to apply</h3><p>Apply through the form below and include your portfolio link in the short message. '
                . 'You can also email your CV and portfolio to <a href="mailto:jobs@hirednext.info?subject='
                . rawurlencode($subject) . '">jobs@hirednext.info</a> with the subject <strong>'
                . $subject . '</strong>.</p>'
                . '<p>Please include your current location, total experience, buying house or export house experience, '
                . 'categories and buyers handled, current salary, expected salary and notice period.</p>'
                . '<p>HiredNext does not charge candidates to apply for a role or secure placement.</p>';
            $jobs[$slug] = [
                'title' => $role['title'],
                'location' => $role['location'],
                'type' => 'full-time',
                'department' => 'Fashion and Design | Buying House',
                'experience' => $role['experience'],
                'description' => $description,
            ];
        }
        return $jobs;
    }

    public static function schemaFor(array $job, string $url): ?array
    {
        $role = self::ROLES[$job['slug'] ?? ''] ?? null;
        $posted = strtotime((string) ($job['created_at'] ?? ''));
        if (!$role || ($job['status'] ?? '') !== 'open' || $posted === false) {
            return null;
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            '@id' => $url . '#job',
            'url' => $url,
            'title' => $job['title'],
            'description' => $job['description'],
            'identifier' => ['@type' => 'PropertyValue', 'name' => 'HiredNext Recruitment', 'value' => $role['code']],
            'datePosted' => date('Y-m-d', $posted),
            'employmentType' => 'FULL_TIME',
            'hiringOrganization' => ['@type' => 'Organization', 'name' => 'confidential'],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job['location'],
                    'addressRegion' => $role['region'],
                    'addressCountry' => 'IN',
                ],
            ],
            'experienceRequirements' => $job['experience'],
        ];
        if (isset($role['salary_value'])) {
            $schema['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => 'INR',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    $role['salary_key'] => $role['salary_value'],
                    'unitText' => 'YEAR',
                ],
            ];
        }
        return $schema;
    }
}
