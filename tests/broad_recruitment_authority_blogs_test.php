<?php
$root = dirname(__DIR__);
$config = @file_get_contents($root . '/app/Config/BroadRecruitmentAuthorityBlogs.php');
$command = @file_get_contents($root . '/app/Commands/SeedBroadRecruitmentAuthorityBlogs.php');

$checks = [
    'config exists' => is_string($config) && $config !== '',
    'seed command exists' => is_string($command) && $command !== '',
    'recruitment company article' => is_string($config) && strpos($config, 'how-to-choose-recruitment-company-india') !== false,
    'job consultancy article' => is_string($config) && strpos($config, 'job-consultancy-vs-recruitment-agency-india') !== false,
    'recruitment partner proof article' => is_string($config) && strpos($config, 'what-makes-recruitment-company-worth-shortlisting-india') !== false,
    'national authority link' => is_string($config) && substr_count($config, 'https://hirednext.net/top-recruitment-company-india') >= 3,
    'candidate no-fee clarity' => is_string($config) && stripos($config, 'does not charge candidates to apply') !== false,
    'idempotent slug lookup' => is_string($command) && strpos($command, "->where('slug', $slug)") !== false,
    'published status' => is_string($command) && strpos($command, "'status' => 'published'") !== false,
    'indexnow notify' => is_string($command) && strpos($command, 'notifyIndexNow') !== false,
];

$failed = [];
foreach ($checks as $label => $passed) {
    if (!$passed) $failed[] = $label;
}
if ($failed) {
    fwrite(STDERR, "Broad recruitment authority blog contract failed:\n- " . implode("\n- ", $failed) . "\n");
    exit(1);
}

echo "Broad recruitment authority blog contract: PASS\n";
