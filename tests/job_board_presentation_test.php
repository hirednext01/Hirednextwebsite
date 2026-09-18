<?php
$root = dirname(__DIR__);
$routes = file_get_contents($root . '/app/Config/Routes.php');
$home = file_get_contents($root . '/app/Controllers/Home.php');
$list = file_get_contents($root . '/app/Views/pages/jobs.php');
$detail = file_get_contents($root . '/app/Views/pages/job-detail.php');
$jobModel = file_get_contents($root . '/app/Models/JobModel.php');

$checks = [
    'job listing route unchanged' => strpos($routes, '$routes->get(\'jobs\', \'Jobs::index\')') !== false,
    'job detail route unchanged' => strpos($routes, '$routes->get(\'jobs/(:any)\', \'Home::jobDetail/$1\')') !== false,
    'job apply route unchanged' => strpos($routes, '$routes->post(\'jobs/(:any)/apply\', \'Home::applyJob/$1\')') !== false,
    'website application insert removed' => strpos($home, '$applicationModel->insert($data);') === false,
    'website resume move removed' => strpos($home, 'move($uploadDir') === false,
    'direct Recruit OS intake required' => strpos($home, 'RecruitOsIntakeClient') !== false,
    'resume field preserved' => strpos($detail, 'name="resume"') !== false,
    'linkedin field preserved' => strpos($detail, 'name="linkedin"') !== false,
    'phone field preserved' => strpos($detail, 'name="phone"') !== false,
    'email field preserved' => strpos($detail, 'name="email"') !== false,
    'name field preserved' => strpos($detail, 'name="name"') !== false,
    'role-specific screening form selected by job slug' => strpos($detail, '$screeningProfile') !== false,
    'structured screening fields rendered' => strpos($detail, 'name="screening[') !== false,
    'DMM buying-export split captured' => strpos($home, "'buying_export_years' =>") !== false,
    'DMM retail split captured' => strpos($home, "'retail_years' =>") !== false,
    'DMM quantified evidence captured' => strpos($home, "'quantified_achievement' =>") !== false,
    'designer portfolio captured' => strpos($home, "'portfolio_url' =>") !== false,
    'screening answers sent to Recruit OS' => strpos($home, "'candidate_answers' => \$screeningAnswers") !== false,
    'compact job board header' => strpos($list, 'Find your next opportunity') !== false,
    'active filter chips' => strpos($list, 'Active filters') !== false,
    'share whatsapp' => strpos($detail, 'wa.me/?text=') !== false,
    'share email' => strpos($detail, 'mailto:?subject=') !== false,
    'share linkedin' => strpos($detail, 'linkedin.com/sharing/share-offsite') !== false,
    'copy link' => strpos($detail, 'copyJobLink') !== false,
    'similar jobs' => strpos($detail, 'Similar opportunities') !== false,
    'no job mutation in detail view' => strpos($detail, '->insert(') === false && strpos($detail, '->update(') === false && strpos($detail, '->delete(') === false,
    'fund accounting role published' => strpos($jobModel, "'fund-accounting-mumbai' =>") !== false,
    'fund accounting code mapped' => strpos($jobModel, "'fund-accounting-mumbai' => 'HN-FA-0918'") !== false,
    'fund accounting eligibility split' => strpos($jobModel, 'Non-CA finance professional with 3–4 years') !== false,
    'fund accounting poster included' => strpos($jobModel, '/theme/assets/jobs/fund-accounting-mumbai.svg') !== false,
    'revenue assurance role published' => strpos($jobModel, "'revenue-assurance-bengaluru' =>") !== false,
    'revenue assurance code mapped' => strpos($jobModel, "'revenue-assurance-bengaluru' => 'HN-RA-0918'") !== false,
    'revenue assurance standards included' => strpos($jobModel, 'IFRS 15 and Ind AS 115') !== false,
    'revenue assurance poster included' => strpos($jobModel, '/theme/assets/jobs/revenue-assurance-bengaluru.svg') !== false,
    'fund accounting poster file exists' => is_file($root . '/public/theme/assets/jobs/fund-accounting-mumbai.svg'),
    'revenue assurance poster file exists' => is_file($root . '/public/theme/assets/jobs/revenue-assurance-bengaluru.svg'),
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
