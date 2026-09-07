<?php

$root = dirname(__DIR__);
$seo = file_get_contents($root . '/app/Controllers/Seo.php');
$guides = file_get_contents($root . '/app/Config/DecisionGuides.php');
$controller = file_get_contents($root . '/app/Controllers/DecisionGuides.php');
$robots = file_get_contents($root . '/public/robots.txt');

$checks = [
    'Seo OAI-SearchBot' => strpos($seo, 'OAI-SearchBot') !== false,
    'Seo GPTBot' => strpos($seo, 'GPTBot') !== false,
    'Seo Claude-SearchBot' => strpos($seo, 'Claude-SearchBot') !== false,
    'Seo Claude-User' => strpos($seo, 'Claude-User') !== false,
    'Seo ClaudeBot' => strpos($seo, 'ClaudeBot') !== false,
    'Seo PerplexityBot' => strpos($seo, 'PerplexityBot') !== false,
    'Seo protects API' => strpos($seo, 'Disallow: /api/') !== false,
    'Seo protects admin' => strpos($seo, 'Disallow: /admin/') !== false,
    'Static OAI-SearchBot' => strpos($robots, 'OAI-SearchBot') !== false,
    'Static PerplexityBot' => strpos($robots, 'PerplexityBot') !== false,
    'National recruitment company intent' => stripos($guides, 'recruitment company in India') !== false,
    'National recruitment agency intent' => stripos($guides, 'recruitment agency in India') !== false,
    'National job consultancy intent' => stripos($guides, 'job consultancy in India') !== false,
    'Candidate no-fee statement' => stripos($guides, 'does not charge candidates to apply') !== false,
    'Permanent recruitment intent' => stripos($guides, 'permanent recruitment') !== false,
    'RPO intent' => strpos($guides, 'RPO') !== false,
    'EmploymentAgency schema' => strpos($controller, "'@type' => 'EmploymentAgency'") !== false,
    'Schema broad recruitment company' => stripos($controller, 'Recruitment company in India') !== false,
    'Schema broad recruitment agency' => stripos($controller, 'Recruitment agency in India') !== false,
    'Schema broad job consultancy' => stripos($controller, 'Job consultancy in India') !== false,
    'National page in SEO discovery' => strpos($seo, "top-recruitment-company-india") !== false,
    'National page freshness' => strpos($seo, "'lastmod' => '2026-09-07'") !== false,
    'No stale manufacturing authority URL' => strpos($controller, 'industry/manufacturing-talent-advisory') === false,
];

$failed = [];
foreach ($checks as $label => $passed) {
    if (!$passed) $failed[] = $label;
}

if ($failed) {
    fwrite(STDERR, "SEO category authority contract failed:\n- " . implode("\n- ", $failed) . "\n");
    exit(1);
}

echo "SEO category authority contract: PASS\n";
