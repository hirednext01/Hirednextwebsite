<?php
$root = dirname(__DIR__);
$checkout = file_get_contents($root . '/app/Controllers/CvServiceCheckout.php');
$payment = file_get_contents($root . '/app/Controllers/CvUpgrade.php');
$admin = file_get_contents($root . '/app/Controllers/CvReviewAdmin.php');
$creator = file_get_contents($root . '/app/Services/Cv/CvCreationAgent.php');
$delivery = file_get_contents($root . '/app/Controllers/CvStudioDocumentController.php');
$view = file_get_contents($root . '/app/Views/pages/services/cv-service-start.php');

$checks = [
    'unpaid public checkout creates only a draft' => str_contains($checkout, "'status' => 'checkout_started'")
        && str_contains($checkout, "'public_service_checkout_started'"),
    'unpaid public checkout sends no email' => !str_contains($checkout, 'sendStartEmails')
        && !str_contains($checkout, "setTo('tarushikha@hirednext.info')"),
    'payment submission owns candidate and internal notifications' => str_contains($payment, 'sendUpgradePaymentAcknowledgement')
        && str_contains($payment, 'sendInternalUpgradeAlert'),
    'fulfilment requires verified payment' => str_contains($admin, 'Payment must be verified before fulfilment can begin.')
        && str_contains($admin, "!in_array((string) (\$order['status'] ?? ''), ['verified', 'in_fulfilment', 'delivered'], true)"),
    'paid CV generation requires verified order' => str_contains($creator, 'Payment must be verified before HiredNext can generate this paid CV service.'),
    'paid CV delivery requires verified order' => str_contains($delivery, 'Payment must be verified before this paid CV can be delivered.'),
    'checkout page states the gate' => str_contains($view, 'Your service request is submitted only after you pay and enter the transaction reference')
        && str_contains($view, 'No request email is sent before payment'),
];

$failed = [];
foreach ($checks as $label => $ok) {
    if (!$ok) $failed[] = $label;
}
if ($failed) {
    fwrite(STDERR, 'FAIL: ' . implode(', ', $failed) . PHP_EOL);
    exit(1);
}
echo "PASS: every paid candidate service is gated by payment\n";
