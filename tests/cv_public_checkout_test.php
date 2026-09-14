<?php
$root = dirname(__DIR__);
$plans = file_get_contents($root . '/app/Services/Cv/CvUpgradePlans.php');
$routes = file_get_contents($root . '/app/Config/Routes.php');
$controllerPath = $root . '/app/Controllers/CvServiceCheckout.php';
$view = file_get_contents($root . '/app/Views/pages/services/candidate-services.php');

$checks = [
    'career consultation price' => str_contains($plans, "'career_4500'") && str_contains($plans, "'amount' => 4500"),
    'public service start route' => str_contains($routes, "career-services/start/(:segment)"),
    'public service submit route' => str_contains($routes, "career-services/start/(:segment)") && str_contains($routes, "CvServiceCheckout::submit"),
    'public checkout controller exists' => is_file($controllerPath),
    'primary assessment CTA' => str_contains($view, 'Get My CV Assessed — ₹599'),
    'primary rebuild CTA' => str_contains($view, 'Get My CV Rebuilt — ₹1,799'),
    'campaign focuses on the two CV offers' => str_contains($view, "['primaryOnly' => true]") && str_contains($view, "pages/services/_cv-service-faq"),
];

$failed = [];
foreach ($checks as $label => $ok) {
    if (!$ok) $failed[] = $label;
}
if ($failed) {
    fwrite(STDERR, "FAIL: " . implode(', ', $failed) . PHP_EOL);
    exit(1);
}
echo "PASS: public CV service checkout contract\n";
