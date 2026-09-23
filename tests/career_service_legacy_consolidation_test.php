<?php

$root = dirname(__DIR__);
$routes = file_get_contents($root . '/app/Config/Routes.php');
$home = file_get_contents($root . '/app/Views/pages/home.php');
$jobs = file_get_contents($root . '/app/Views/pages/jobs.php');
$legacyController = file_get_contents($root . '/app/Controllers/LegacyCareerRedirects.php');
$privateCheckout = file_get_contents($root . '/app/Controllers/PrivateCheckout.php');
$privateLinkedIn = file_get_contents($root . '/app/Views/pages/services/linkedin-leadership-payment.php');

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
    requireCheck(str_contains($surface, '₹992 + GST'), 'assessment public price updated');
    requireCheck(str_contains($surface, '₹2,500 + GST'), 'rebuild public price updated');
}

requireCheck(str_contains($home, "services/professional-cv-rebuild"), 'homepage rebuild link points to canonical service page');
requireCheck(str_contains($jobs, "services/professional-cv-rebuild"), 'jobs rebuild link points to canonical service page');
requireCheck(!str_contains($jobs, "base_url('cv-assessment')"), 'jobs contains no internal link to legacy /cv-assessment route');
requireCheck(str_contains($jobs, "services/cv-assessment"), 'jobs assessment link points directly to canonical service page');
requireCheck(str_contains($privateCheckout, "noindex, nofollow, noarchive"), 'named-client LinkedIn checkout is excluded from public indexing');
requireCheck(str_contains($privateCheckout, "no-store, private"), 'named-client LinkedIn checkout is not publicly cacheable');
requireCheck(str_contains($privateLinkedIn, 'Standard public fee'), 'private LinkedIn checkout labels the public fee separately');
requireCheck(str_contains($privateLinkedIn, '₹8,999 + GST'), 'private LinkedIn checkout preserves ₹8,999 + GST as public LinkedIn price');

echo "PASS: career service search consolidation and public pricing\n";
