<?php

$root = dirname(__DIR__);
require_once $root . '/app/Services/Cv/CvUpgradePlans.php';

use App\Services\Cv\CvUpgradePlans;

function expectTrue(bool $ok, string $label): void {
    if (!$ok) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

$plans = CvUpgradePlans::all();

expectTrue(isset($plans['priority_992']), '₹992 + GST assessment plan exists');
expectTrue(($plans['priority_992']['base_amount'] ?? null) === 992, 'assessment base price is ₹992');
expectTrue(($plans['priority_992']['amount'] ?? null) === 1171, 'assessment rounded GST-inclusive payable is ₹1,171');

expectTrue(isset($plans['rebuild_2500']), '₹2,500 + GST rebuild plan exists');
expectTrue(($plans['rebuild_2500']['base_amount'] ?? null) === 2500, 'rebuild base price is ₹2,500');
expectTrue(($plans['rebuild_2500']['amount'] ?? null) === 2950, 'rebuild GST-inclusive payable is ₹2,950');

expectTrue(isset($plans['bundle_3317']), 'assessment + rebuild bundle exists');
expectTrue(abs((float)($plans['bundle_3317']['base_amount'] ?? 0) - 3317.40) < 0.001, 'bundle is 5% off ₹3,492');
expectTrue(($plans['bundle_3317']['amount'] ?? null) === 3915, 'bundle rounded GST-inclusive payable is ₹3,915');

expectTrue(isset($plans['linkedin_8999']), 'LinkedIn Leadership Positioning plan exists');
expectTrue(($plans['linkedin_8999']['base_amount'] ?? null) === 8999, 'LinkedIn campaign base is ₹8,999');
expectTrue(($plans['linkedin_8999']['regular_base_amount'] ?? null) === 17500, 'LinkedIn regular base is ₹17,500');
expectTrue(($plans['linkedin_8999']['amount'] ?? null) === 10619, 'LinkedIn rounded GST-inclusive payable is ₹10,619');

$routes = file_get_contents($root . '/app/Config/Routes.php');
$controller = file_get_contents($root . '/app/Controllers/CandidateServices.php');
$hub = file_get_contents($root . '/app/Views/pages/services/candidate-services.php');
$assessment = file_get_contents($root . '/app/Views/pages/services/cv-assessment.php');
$decisionGuides = file_get_contents($root . '/app/Config/DecisionGuides.php');
$linkedinView = $root . '/app/Views/pages/services/linkedin-leadership.php';

expectTrue(str_contains($routes, "services/linkedin-leadership-positioning"), 'LinkedIn service route exists');
expectTrue(str_contains($controller, 'LinkedIn Leadership Positioning'), 'LinkedIn service controller content exists');
expectTrue(str_contains($hub, 'Assessment + CV Rebuild Bundle'), 'bundle is visible on career-services hub');
expectTrue(str_contains($hub, 'LinkedIn Leadership Positioning'), 'LinkedIn service is visible on career-services hub');
expectTrue(str_contains($assessment, '₹992 + GST'), 'assessment page shows ₹992 + GST');
expectTrue(!str_contains($decisionGuides, '₹599 CV Assessment'), 'buyer guide no longer exposes stale ₹599 assessment pricing');
expectTrue(!str_contains($decisionGuides, '₹1,799 Professional CV Rebuild'), 'buyer guide no longer exposes stale ₹1,799 rebuild pricing');
expectTrue(str_contains($decisionGuides, '₹2,500 + GST'), 'buyer guide uses canonical rebuild base price');
expectTrue(str_contains($decisionGuides, 'services/professional-cv-rebuild'), 'buyer guide links directly to canonical commercial rebuild page');
expectTrue(is_file($linkedinView), 'LinkedIn leadership page exists');

$linkedin = is_file($linkedinView) ? file_get_contents($linkedinView) : '';
expectTrue(str_contains($linkedin, '₹17,500 + GST'), 'LinkedIn regular price is shown');
expectTrue(str_contains($linkedin, '₹8,999 + GST'), 'LinkedIn campaign price is shown');
expectTrue(str_contains($linkedin, 'Senior LinkedIn specialists'), 'specialist panel is explained');
expectTrue(str_contains($linkedin, 'NDA'), 'NDA/confidentiality is explained');
expectTrue(str_contains($linkedin, 'Illustrative'), 'example metrics are clearly labelled illustrative');
expectTrue(str_contains($linkedin, '50K+'), 'illustrative impressions metric is shown');
expectTrue(str_contains($linkedin, '20K+'), 'illustrative engagement metric is shown');

echo "PASS career services 2026 premium pricing and LinkedIn positioning\n";
