<?php

$path = __DIR__ . '/../app/Libraries/BuyingHouseDesignJobs.php';
if (!is_file($path)) {
    fwrite(STDERR, "FAIL: the four buying house roles have no publishing/schema provider.\n");
    exit(1);
}
require_once $path;

use App\Libraries\BuyingHouseDesignJobs;

function expectDesignJob(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, "FAIL: $message\n");
        exit(1);
    }
}

$cases = [
    'fashion-designer-womenswear-delhi-buying-house' => ['Delhi', 'maxValue', 1300000],
    'fashion-designer-apparel-home-gurgaon-buying-house' => ['Gurgaon', 'maxValue', 1200000],
    'graphic-designer-ai-fashion-delhi-buying-house' => ['Delhi', null, null],
    'fashion-designer-womenswear-european-buyers-gurgaon' => ['Gurgaon', 'value', 900000],
];
$jobs = BuyingHouseDesignJobs::publishedJobs();
expectDesignJob(count($jobs) === 4, 'Publish exactly four distinct roles.');
foreach ($cases as $slug => [$city, $salaryKey, $salary]) {
    expectDesignJob(isset($jobs[$slug]), "Missing separate role: $slug");
    $job = $jobs[$slug] + ['slug' => $slug, 'status' => 'open', 'created_at' => '2026-09-26 15:00:00'];
    $url = 'https://hirednext.net/jobs/' . $slug;
    $schema = BuyingHouseDesignJobs::schemaFor($job, $url);
    expectDesignJob($schema['@type'] === 'JobPosting', 'Emit JobPosting on each detail page.');
    expectDesignJob($schema['url'] === $url, 'Each role uses its own canonical URL.');
    expectDesignJob($schema['datePosted'] === '2026-09-26', 'Use the actual publication date.');
    expectDesignJob($schema['description'] === $job['description'], 'Schema matches the visible description.');
    expectDesignJob($schema['jobLocation']['address']['addressLocality'] === $city, 'Preserve the correct city.');
    expectDesignJob($schema['hiringOrganization']['name'] === 'confidential', 'Do not misidentify the recruiter as employer.');
    if ($salaryKey) {
        expectDesignJob($schema['baseSalary']['value'][$salaryKey] === $salary, 'Represent the supplied annual salary accurately.');
        expectDesignJob(!isset($schema['baseSalary']['value']['minValue']), 'Do not invent a salary floor.');
    } else {
        expectDesignJob(!isset($schema['baseSalary']), 'Do not invent a graphic designer salary.');
    }
    $job['status'] = 'closed';
    expectDesignJob(BuyingHouseDesignJobs::schemaFor($job, $url) === null, 'Closed roles must not emit active job schema.');
}
expectDesignJob(BuyingHouseDesignJobs::schemaFor(['slug' => 'unrelated-role', 'status' => 'open'], 'https://hirednext.net/jobs/unrelated-role') === null, 'Do not mark unrelated talent pools as confirmed jobs.');
echo "PASS: four distinct roles, faithful salaries, visible descriptions, confidential employers and closed-role schema.\n";
