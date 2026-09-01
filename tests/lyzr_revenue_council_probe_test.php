<?php
$root = dirname(__DIR__);
$probePath = $root . '/app/Commands/LyzrRevenueProbe.php';
$workflowPath = $root . '/.github/workflows/lyzr-revenue-council-bootstrap.yml';
$probe = is_file($probePath) ? file_get_contents($probePath) : '';
$workflow = is_file($workflowPath) ? file_get_contents($workflowPath) : '';
$checks = [
    'probe command exists' => is_file($probePath),
    'probe command name' => str_contains($probe, 'lyzr:revenue-probe'),
    'probe uses registry' => str_contains($probe, 'RevenueCouncilAgentRegistry'),
    'probe calls inference' => str_contains($probe, '->chat('),
    'probe covers all ten' => str_contains($probe, "'commercial_analyst'") && str_contains($probe, "'candidate_revenue'") && str_contains($probe, "'ceo'"),
    'workflow exists' => is_file($workflowPath),
    'workflow runs setup' => str_contains($workflow, 'php spark lyzr:revenue-setup'),
    'workflow runs probe' => str_contains($workflow, 'php spark lyzr:revenue-probe'),
    'workflow uses Hostinger SSH secrets' => str_contains($workflow, 'HOSTINGER_SSH_KEY') && str_contains($workflow, 'HOSTINGER_PASSWORD'),
];
$failed = [];
foreach ($checks as $label => $ok) {
    if (!$ok) $failed[] = $label;
}
if ($failed) {
    fwrite(STDERR, "FAIL: " . implode(', ', $failed) . PHP_EOL);
    exit(1);
}
echo "PASS: Revenue Council live-probe contract\n";
