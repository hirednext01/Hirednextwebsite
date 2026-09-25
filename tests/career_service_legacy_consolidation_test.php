<?php

$root = dirname(__DIR__);
$routes = file_get_contents($root . '/app/Config/Routes.php');
$home = file_get_contents($root . '/app/Views/pages/home.php');
$jobs = file_get_contents($root . '/app/Views/pages/jobs.php');
$legacyController = file_get_contents($root . '/app/Controllers/LegacyCareerRedirects.php');

function requireCheck(bool $ok, string $label): void {
    if (!$ok) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

requireCheck(str_contains($routes, "LegacyCareerRedirects::cvAssessment"), 'legacy /cv-assessment uses a permanent redirect controller');
requireCheck(str_contains($routes, "LegacyCareerRedirects::avron"), 'legacy /services/avron uses a permanent redirect controller');
requireCheck(str_contains($legacyController, "services/cv-assessment"), 'legacy /cv-assessment redirects to canonical assessment route');
requireCheck(str_contains($legacyController, "services/professional-cv-rebuild"), 'legacy /services/avron redirects to canonical rebuild route');
requireCheck(substr_count($legacyController, "301") >= 2, 'both legacy career URLs use permanent 301 redirects');

foreach ([$home, $jobs] as $surface) {
    requireCheck(!str_contains($surface, '₹599'), 'old ₹599 public price removed');
    requireCheck(!str_contains($surface, '₹1,799'), 'old ₹1,799 public price removed');
    requireCheck(!str_contains($surface, 'rebuild_1799'), 'legacy rebuild tier removed from public links');
}

requireCheck(!str_contains($jobs, "base_url('cv-assessment')"), 'jobs contains no internal link to legacy /cv-assessment route');
requireCheck(!str_contains($routes, "pay/linkedin-leadership"), 'retired named-client LinkedIn checkout route removed');
requireCheck(!str_contains($home, 'Get My CV Assessed'), 'employer homepage does not sell candidate products');
requireCheck(!str_contains($home, 'Get My CV Rebuilt'), 'employer homepage does not sell candidate products');
requireCheck(!str_contains($jobs, 'Assess my CV'), 'job board keeps application as its primary action');
requireCheck(!str_contains($jobs, 'Get my CV rebuilt'), 'job board keeps application as its primary action');

echo "PASS: career service search consolidation and public pricing\n";
