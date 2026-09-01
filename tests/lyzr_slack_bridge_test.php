<?php
$root = dirname(__DIR__);
$routesPath = $root . '/app/Config/Routes.php';
$controllerPath = $root . '/app/Controllers/Api/RevenueCouncilWebhook.php';
$verifierPath = $root . '/app/Services/Revenue/SlackSignatureVerifier.php';
$lyzrPath = $root . '/app/Services/Revenue/LyzrClient.php';
$slackPath = $root . '/app/Services/Revenue/SlackBotClient.php';
$routerPath = $root . '/app/Services/Revenue/RevenueCouncilRouter.php';

$read = static fn(string $path): string => is_file($path) ? file_get_contents($path) : '';
$routes = $read($routesPath);
$controller = $read($controllerPath);
$verifier = $read($verifierPath);
$lyzr = $read($lyzrPath);
$slack = $read($slackPath);
$router = $read($routerPath);

$checks = [
    'slack webhook route' => str_contains($routes, "webhooks/slack/revenue-council") && str_contains($routes, 'RevenueCouncilWebhook::handle'),
    'controller exists' => is_file($controllerPath),
    'slack url verification' => str_contains($controller, "url_verification") && str_contains($controller, "challenge"),
    'bot-loop suppression' => str_contains($controller, "bot_id") || str_contains($controller, "bot_message"),
    'signature verifier exists' => is_file($verifierPath) && str_contains($verifier, 'hash_hmac') && str_contains($verifier, 'hash_equals'),
    'lyzr client exists' => is_file($lyzrPath) && str_contains($lyzr, 'LYZR_API_KEY') && str_contains($lyzr, 'x-api-key') && str_contains($lyzr, '/v3/inference/chat/'),
    'slack client exists' => is_file($slackPath) && str_contains($slack, 'SLACK_BOT_TOKEN') && str_contains($slack, 'chat.postMessage'),
    'router uses env agent ids' => is_file($routerPath) && str_contains($router, 'LYZR_REVENUE_CEO_AGENT_ID') && str_contains($router, 'LYZR_CANDIDATE_REVENUE_AGENT_ID'),
    'no hardcoded token' => !preg_match('/xoxb-[A-Za-z0-9-]{10,}/', $controller . $slack . $router),
];

$failed = [];
foreach ($checks as $label => $ok) {
    if (!$ok) $failed[] = $label;
}
if ($failed) {
    fwrite(STDERR, "FAIL: " . implode(', ', $failed) . PHP_EOL);
    exit(1);
}
echo "PASS: Lyzr Slack revenue bridge contract\n";
