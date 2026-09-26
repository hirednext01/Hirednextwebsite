<?php
$root = dirname(__DIR__);
$configPath = $root . '/app/Config/PaymentIdentity.php';
$gatePath = $root . '/app/Views/components/business-payment-gate.php';
$legacyQrPath = $root . '/public/theme/assets/private/hirednext-company-qr.png';

$requiredViews = [
    'app/Views/pages/services/cv-payment.php',
    'app/Views/pages/services/cv-payment-direct.php',
    'app/Views/pages/services/cv-upgrade-payment.php',
    'app/Views/pages/advisory-payment.php',
];

$checks = [
    'central payment identity config exists' => is_file($configPath),
    'central payment gate exists' => is_file($gatePath),
    'compromised legacy QR is deleted' => !is_file($legacyQrPath),
];

if (is_file($configPath)) {
    $config = file_get_contents($configPath);
    $checks['payee display is HiredNext Recruitment'] = str_contains($config, "DISPLAY_NAME = 'HiredNext Recruitment'");
    $checks['destination is fingerprint locked'] = str_contains($config, 'APPROVED_DESTINATION_SHA256')
        && str_contains($config, "hash('sha256', \$url)");
    $checks['destination fails closed until approved'] = str_contains($config, "APPROVED_DESTINATION_SHA256 = ''")
        && str_contains($config, "\$approvedHash !== ''");
    $checks['raw UPI/VPA destinations are rejected'] = str_contains($config, "!str_contains(\$url, '@')")
        && str_contains($config, "stripos(\$url, 'upi:') === false");
    $checks['owner supplied bank transfer details match screenshot'] = str_contains($config, "'beneficiary' => 'HIREDNEXT'")
        && str_contains($config, "'account_number' => '917020008798870'")
        && str_contains($config, "'ifsc' => 'UTIB0000131'")
        && str_contains($config, "'bank' => 'Axis Bank'");
}

$gate = file_get_contents($gatePath);
$checks['bank option uses central gate'] = str_contains($gate, 'data-hn-bank-transfer')
    && str_contains($gate, "\$payment['bank_transfer']")
    && str_contains($gate, 'A reference is not a payment confirmation');

foreach ($requiredViews as $relative) {
    $full = $root . '/' . $relative;
    $content = is_file($full) ? file_get_contents($full) : '';
    $checks[$relative . ' lets customer identify transfer method'] = str_contains($content, 'name="payment_method"')
        && str_contains($content, 'value="bank_transfer"')
        && str_contains($content, 'payment_reference');
    $checks[$relative . ' uses central gate'] = $content !== ''
        && str_contains($content, "components/business-payment-gate");
    $checks[$relative . ' contains no embedded QR'] = $content !== ''
        && !preg_match('/<img[^>]+(?:qr|upi|payment)/i', $content);
    $checks[$relative . ' contains no direct payment destination'] = $content !== ''
        && !preg_match('/href\s*=\s*["\'][^"\']*(?:upi:|paytm|phonepe|googlepay|gpay|razorpay|cashfree|instamojo)/i', $content);
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root . '/app/Views'));
foreach ($iterator as $file) {
    if (!$file->isFile() || strtolower($file->getExtension()) !== 'php') continue;
    $relative = str_replace($root . '/', '', $file->getPathname());
    $content = file_get_contents($file->getPathname());
    $isPaymentSurface = preg_match('/(?:payment|checkout)\.php$/i', $relative)
        || str_contains($content, 'payment_reference');
    if (!$isPaymentSurface || $relative === 'app/Views/components/business-payment-gate.php') continue;

    $checks[$relative . ' has no raw UPI URI'] = stripos($content, 'upi://') === false;
    $checks[$relative . ' has no provider QR image'] = !preg_match('/<img[^>]+(?:qr|upi|paytm)/i', $content);
    $checks[$relative . ' has no hard-coded provider payment href'] =
        !preg_match('/href\s*=\s*["\'][^"\']*(?:paytm|phonepe|googlepay|gpay|razorpay|cashfree|instamojo|upi:)/i', $content);
}

$failed = [];
foreach ($checks as $label => $ok) {
    if (!$ok) $failed[] = $label;
}
if ($failed) {
    fwrite(STDERR, "FAIL: " . implode(', ', $failed) . PHP_EOL);
    exit(1);
}
echo "PASS: HiredNext payment identity is iron-walled behind one verified business gate\n";
