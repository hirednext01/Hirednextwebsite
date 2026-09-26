<?php
require_once dirname(__DIR__) . '/app/Services/Cv/CvUpgradePlans.php';
require_once dirname(__DIR__) . '/app/Services/Cv/LeadershipContext.php';

use App\Services\Cv\CvUpgradePlans;
use App\Services\Cv\LeadershipContext;

$check = static function (bool $ok, string $message): void {
    if (!$ok) throw new RuntimeException($message);
};
$professional = CvUpgradePlans::get('linkedin_8999');
$leadership = CvUpgradePlans::get('leadership_17500');
$check($professional['name'] === 'Professional LinkedIn Profile Build', 'Existing standard tier must remain professional');
$check($leadership['name'] === 'CXO / Global Leadership Positioning', 'Leadership needs a distinct order name');
foreach ([[$professional, 8999, 10619], [$leadership, 17500, 20650]] as [$plan, $base, $total]) {
    $check($plan['base_amount'] === $base && $plan['amount'] === $total, 'Incorrect base or payable price');
    $check(abs($plan['payable_exact'] - ($plan['base_amount'] + $plan['gst_amount'])) < 0.001, 'Tax breakdown must reconcile');
}
$check(($professional['regular_base_amount'] ?? null) === 17500, 'Professional LinkedIn campaign must retain documented regular reference price');
$check(($professional['regular_price_label'] ?? null) === '₹17,500 + GST', 'Professional LinkedIn regular campaign label must be explicit');
$check(!isset($leadership['regular_price_label']), 'Leadership service remains a standalone price');
$check(CvUpgradePlans::get('leadership_unknown') === null, 'Unknown tier must not acquire a price');
$input = array_combine(array_keys(LeadershipContext::FIELDS), ['Business Head', '₹1,500 Cr', 'Full P&L', '600 people', 'India / APAC', 'Board and CEO', 'CEO', 'Enterprise leadership']);
$message = LeadershipContext::appendToMessage($input, '17 years of experience; please keep client names private.');
foreach ($input as $value) $check(str_contains($message, $value), 'Intake must retain every suitability dimension');
$check(str_contains($message, '17 years of experience; please keep client names private.'), 'Retain user context');
$check(str_contains(LeadershipContext::appendToMessage([], ''), 'Not provided'), 'Missing evidence must not be invented');
$check(str_contains(LeadershipContext::appendToMessage(['leadership_level' => ['bad']], ''), 'Not provided'), 'Ignore non-scalar input');

// Render the actual views with lightweight framework helpers, including loops and escaping.
if (!function_exists('base_url')) { function base_url($path = '') { return 'https://hirednext.net/' . $path; } }
if (!function_exists('esc')) { function esc($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('session')) { function session($key) { return null; } }
if (!function_exists('old')) { function old($key) { return ''; } }
if (!function_exists('csrf_field')) { function csrf_field() { return '<input type="hidden" name="csrf">'; } }
$renderer = new class {
    public function extend($layout) { return ''; }
    public function section($section) { return ''; }
    public function endSection() { return ''; }
    public function render($file, $plan, $tier) { ob_start(); include $file; return ob_get_clean(); }
};
$viewRoot = dirname(__DIR__) . '/app/Views/pages/services/';
$standardHtml = $renderer->render($viewRoot . 'linkedin-leadership.php', $professional, 'linkedin_8999');
$leadershipHtml = $renderer->render($viewRoot . 'cxo-global-leadership.php', $leadership, 'leadership_17500');
$check(str_contains($standardHtml, '₹8,999 + GST') && str_contains($standardHtml, '₹17,500 + GST'), 'Standard page must show documented regular and campaign prices');
$check(str_contains($leadershipHtml, '₹17,500 + GST') && !str_contains($leadershipHtml, '₹8,999'), 'Leadership page must show only its price');
$check(str_contains($standardHtml, '/career-services/start/linkedin_8999'), 'Standard CTA must retain its checkout');
$check(str_contains($leadershipHtml, '/career-services/start/leadership_17500'), 'Leadership CTA must use its checkout');
$check(str_contains($standardHtml, 'Campaign price · limited profile slots'), 'Professional LinkedIn page must explain campaign access');
foreach ([['linkedin_8999', $professional], ['leadership_17500', $leadership]] as [$tier, $plan]) {
    $html = $renderer->render($viewRoot . 'cv-service-start.php', $plan, $tier);
    $check(str_contains($html, esc($plan['name'])) && str_contains($html, $plan['payable_label']), 'Checkout name and price must match');
    $check(str_contains($html, 'name="leadership_scope"') === ($tier === 'leadership_17500'), 'Leadership intake is exclusive to the leadership service');
    $check(str_contains($html, 'action="https://hirednext.net/career-services/start/' . $tier . '"'), 'Checkout must preserve the selected tier');
}
echo "PASS separate LinkedIn pricing, intake and rendered journeys\n";
