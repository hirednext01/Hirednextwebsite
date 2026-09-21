<?php
$root = dirname(__DIR__);
$view = file_get_contents($root . '/app/Views/pages/services/cv-assessment.php');
$controller = file_get_contents($root . '/app/Controllers/CvAssessment.php');
$pageController = file_get_contents($root . '/app/Controllers/CandidateServices.php');

$checks = [
    'single paid CTA' => substr_count($view, 'Get My CV Assessed — ₹992 + GST') >= 2,
    'free offer removed from landing page' => !str_contains($view, 'Get Free Assessment') && !str_contains($view, 'value="free"'),
    'priority plan fixed by form' => str_contains($view, 'type="hidden" name="assessment_plan" value="priority_992"'),
    'sample assessment proof' => str_contains($view, 'Preview the assessment you will receive') && str_contains($view, 'Recruiter’s first impression'),
    'sample is not presented as a customer outcome' => str_contains($view, 'ILLUSTRATIVE ASSESSMENT EXAMPLE') && str_contains($view, 'not a customer testimonial'),
    'campaign attribution fields' => str_contains($view, 'name="utm_source"') && str_contains($view, 'name="utm_medium"') && str_contains($view, 'name="utm_campaign"') && str_contains($view, 'name="utm_content"'),
    'paid plan enforced server side' => str_contains($controller, "'assessment_plan' => 'permit_empty|in_list[priority_992,priority_599]'") && str_contains($controller, '$plan = \'priority_992\';'),
    'paid only metadata' => str_contains($pageController, '12-hour, role-focused CV assessment for ₹992 + GST') && !str_contains($pageController, 'Choose a free review or a priority'),
];

$failed = [];
foreach ($checks as $label => $ok) {
    if (!$ok) $failed[] = $label;
}
if ($failed) {
    fwrite(STDERR, "FAIL: " . implode(', ', $failed) . PHP_EOL);
    exit(1);
}
echo "PASS: paid CV assessment conversion contract\n";
