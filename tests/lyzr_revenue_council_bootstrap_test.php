<?php
$root = dirname(__DIR__);
$commandPath = $root . '/app/Commands/LyzrRevenueSetup.php';
$registryPath = $root . '/app/Services/Revenue/RevenueCouncilAgentRegistry.php';
$routerPath = $root . '/app/Services/Revenue/RevenueCouncilRouter.php';

$read = static fn(string $path): string => is_file($path) ? file_get_contents($path) : '';
$command = $read($commandPath);
$registry = $read($registryPath);
$router = $read($routerPath);

$roles = [
    'ceo',
    'signals',
    'contact_intelligence',
    'sales_hunter',
    'mandate_intelligence',
    'candidate_intelligence',
    'candidate_revenue',
    'marketing',
    'operations',
    'commercial_analyst',
];

$checks = [
    'bootstrap command exists' => is_file($commandPath),
    'bootstrap command name' => str_contains($command, "lyzr:revenue-setup"),
    'uses existing Lyzr client' => str_contains($command, 'App\\Services\\Cv\\LyzrClient'),
    'creates agents idempotently' => str_contains($command, 'ALREADY REGISTERED') && str_contains($command, 'createAgent'),
    'registry service exists' => is_file($registryPath) && str_contains($registry, "WRITEPATH . 'revenue/lyzr-agents.json'"),
    'router reads registry' => str_contains($router, 'RevenueCouncilAgentRegistry'),
    'ownership rule included' => str_contains($command, 'one task') && str_contains($command, 'lock_until'),
    'slack proposal protocol included' => str_contains($command, 'Estimated Revenue') && str_contains($command, 'Deadline') && str_contains($command, 'Result'),
];

foreach ($roles as $role) {
    $checks['role ' . $role] = str_contains($command, "'{$role}'");
}

$failed = [];
foreach ($checks as $label => $ok) {
    if (!$ok) $failed[] = $label;
}
if ($failed) {
    fwrite(STDERR, "FAIL: " . implode(', ', $failed) . PHP_EOL);
    exit(1);
}
echo "PASS: Lyzr Revenue Council bootstrap contract\n";
