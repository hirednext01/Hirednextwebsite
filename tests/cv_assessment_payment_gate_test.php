<?php
$root = dirname(__DIR__);
$assessmentController = file_get_contents($root . '/app/Controllers/CvAssessment.php');
$paymentController = file_get_contents($root . '/app/Controllers/CvPayment.php');
$view = file_get_contents($root . '/app/Views/pages/services/cv-assessment.php');

$checks = [
    'unpaid checkout does not email founder' => !str_contains($assessmentController, "setTo('tarushikha@hirednext.info')"),
    'unpaid checkout does not email candidate' => !str_contains($assessmentController, 'candidate_acknowledgement'),
    'payment-reference submission owns notifications' => str_contains($paymentController, 'internal_payment_alert')
        && str_contains($paymentController, 'priority_payment_acknowledgement'),
    'unpaid record is only a checkout draft' => str_contains($assessmentController, "'status' => 'checkout_started'"),
    'unpaid audit is not marked received' => str_contains($assessmentController, "'checkout_started'")
        && !str_contains($assessmentController, "'cv_received'"),
    'page states the payment gate clearly' => str_contains($view, 'Your assessment request is submitted only after you enter your payment reference')
        && str_contains($view, 'Continue to ₹599 payment'),
];

$failed = [];
foreach ($checks as $label => $ok) {
    if (!$ok) $failed[] = $label;
}

if ($failed) {
    fwrite(STDERR, "FAIL: " . implode(', ', $failed) . PHP_EOL);
    exit(1);
}

echo "PASS: unpaid CV checkout cannot trigger submission emails\n";
