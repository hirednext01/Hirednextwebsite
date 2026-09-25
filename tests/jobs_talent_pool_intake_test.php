<?php

$root = dirname(__DIR__);
$routes = file_get_contents($root . '/app/Config/Routes.php');
$controller = file_get_contents($root . '/app/Controllers/Jobs.php');
$view = file_get_contents($root . '/app/Views/pages/jobs.php');

function must(bool $ok, string $label): void {
    if (!$ok) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

must(str_contains($routes, "post('jobs/talent-pool', 'Jobs::talentPool')"), 'talent-pool POST route exists before generic job routes');
must(str_contains($controller, 'public function talentPool()'), 'Jobs controller accepts talent-pool CVs');
must(str_contains($controller, "'source' => 'website_talent_pool'"), 'generic CV intake is tagged separately from job applications');
must(str_contains($controller, 'RecruitOsIntakeClient'), 'generic CV intake feeds Recruit OS');
must(str_contains($view, 'Sign me up for relevant HiredNext roles'), 'jobs page visibly offers future-role registration');
must(str_contains($view, 'Add me to the talent pool'), 'inline form has a clear submit action');
must(str_contains($view, 'name="resume"'), 'inline form captures the CV');
must(str_contains($view, 'name="current_ctc"'), 'inline form captures salary context');
must(str_contains($view, 'name="total_experience"'), 'inline form captures total experience');
must(str_contains($view, 'name="preferred_locations"'), 'inline form captures preferred locations');
must(str_contains($view, 'name="linkedin"'), 'inline form captures LinkedIn when supplied');
must(!str_contains($view, 'action="<?= base_url(\'candidate'), 'talent-pool signup does not send the user to a separate page');

echo "PASS: jobs-page talent-pool intake\n";
