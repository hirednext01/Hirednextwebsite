<?php
$root = dirname(__DIR__);
$routes = file_get_contents($root . '/app/Config/Routes.php');
$home = file_get_contents($root . '/app/Controllers/Home.php');
$list = file_get_contents($root . '/app/Views/pages/jobs.php');
$detail = file_get_contents($root . '/app/Views/pages/job-detail.php');

$checks = [
    'job listing route unchanged' => strpos($routes, '$routes->get(\'jobs\', \'Jobs::index\')') !== false,
    'job detail route unchanged' => strpos($routes, '$routes->get(\'jobs/(:any)\', \'Home::jobDetail/$1\')') !== false,
    'job apply route unchanged' => strpos($routes, '$routes->post(\'jobs/(:any)/apply\', \'Home::applyJob/$1\')') !== false,
    'application insert remains' => strpos($home, '$applicationModel->insert($data);') !== false,
    'resume field preserved' => strpos($detail, 'name="resume"') !== false,
    'linkedin field preserved' => strpos($detail, 'name="linkedin"') !== false,
    'phone field preserved' => strpos($detail, 'name="phone"') !== false,
    'email field preserved' => strpos($detail, 'name="email"') !== false,
    'name field preserved' => strpos($detail, 'name="name"') !== false,
    'compact job board header' => strpos($list, 'Find your next opportunity') !== false,
    'active filter chips' => strpos($list, 'Active filters') !== false,
    'share whatsapp' => strpos($detail, 'wa.me/?text=') !== false,
    'share email' => strpos($detail, 'mailto:?subject=') !== false,
    'share linkedin' => strpos($detail, 'linkedin.com/sharing/share-offsite') !== false,
    'copy link' => strpos($detail, 'copyJobLink') !== false,
    'similar jobs' => strpos($detail, 'Similar opportunities') !== false,
    'no job mutation in detail view' => strpos($detail, '->insert(') === false && strpos($detail, '->update(') === false && strpos($detail, '->delete(') === false,
];

$failed = [];
foreach ($checks as $label => $passed) {
    if (!$passed) $failed[] = $label;
}
if ($failed) {
    fwrite(STDERR, "Job board presentation contract failed:\n- " . implode("\n- ", $failed) . "\n");
    exit(1);
}
echo "Job board presentation contract: PASS\n";
