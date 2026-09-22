<?php
use Config\PaymentIdentity;

$payment = PaymentIdentity::destination();
$amountLabel = trim((string)($amountLabel ?? ''));
$secondaryLabel = trim((string)($secondaryLabel ?? ''));
$contactEmail = trim((string)($contactEmail ?? $payment['payment_email']));
?>
<div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 text-center" data-hn-payment-identity-gate>
    <div class="text-sm font-black tracking-[0.14em] text-primary mb-3">VERIFIED BUSINESS PAYMENT ONLY</div>
    <div class="text-lg font-black text-primary"><?= esc($payment['display_name']) ?></div>

    <?php if ($payment['active']): ?>
        <p class="mt-3 text-sm text-gray-700 leading-relaxed">Use only the secure HiredNext business checkout below. Before approving payment, your payment provider must show <strong><?= esc($payment['display_name']) ?></strong>. If it shows an individual or phone-linked identity, do not pay.</p>
        <a href="<?= esc($payment['url']) ?>" rel="noopener noreferrer" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-accent px-5 py-4 font-bold text-white transition hover:opacity-90">Continue to verified business payment →</a>
    <?php else: ?>
        <p class="mt-3 text-sm text-gray-700 leading-relaxed"><strong>Secure online payment is temporarily unavailable.</strong> Do not use an older QR, screenshot, Paytm URL or UPI ID. A payment button will appear here only when the destination is verified to resolve to <strong><?= esc($payment['display_name']) ?></strong>.</p>
    <?php endif; ?>

    <?php if ($amountLabel !== ''): ?><div class="mt-4 text-xl font-black text-primary"><?= esc($amountLabel) ?></div><?php endif; ?>
    <?php if ($secondaryLabel !== ''): ?><div class="mt-1 text-xs font-semibold text-gray-500"><?= esc($secondaryLabel) ?></div><?php endif; ?>
</div>
