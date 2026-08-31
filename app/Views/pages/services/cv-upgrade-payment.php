<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $qrUrl = base_url('cv-payment/qr') . '?v=20260831'; ?>
<style>
    #navbar { background:#fff !important; box-shadow:0 8px 30px rgba(12,52,102,.08); padding-top:1rem !important; padding-bottom:1rem !important; }
    #navbar #logoText, #navbar .nav-link, #navbar #menuBtn { color:#0c3466 !important; }
</style>
<section class="min-h-[75vh] pt-32 pb-20 bg-gray-50">
    <div class="max-w-[900px] mx-auto px-4 sm:px-8">
        <div class="bg-white rounded-[2rem] border border-gray-200 p-7 md:p-10 shadow-sm">
            <div class="grid md:grid-cols-2 gap-10 items-start">
                <div>
                    <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">HiredNext CV Service</div>
                    <h1 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4"><?= esc($order['service_name'] ?? 'CV Service') ?></h1>
                    <p class="text-gray-600 leading-relaxed mb-6"><?= esc($plan['description'] ?? '') ?></p>
                    <div class="rounded-2xl bg-primary text-white p-6 mb-6">
                        <div class="text-[10px] uppercase tracking-[0.22em] text-white/55 font-black mb-2">Amount to pay</div>
                        <div class="text-4xl font-black">₹<?= esc(number_format((int)($order['amount'] ?? 0))) ?></div>
                        <div class="text-sm text-white/70 mt-2"><?= esc($plan['delivery'] ?? '') ?></div>
                    </div>
                    <div class="flex flex-col items-center rounded-2xl border border-gray-200 bg-gray-50 p-5">
                        <div class="bg-white p-3 rounded-2xl border border-gray-200 shadow-sm">
                            <img src="<?= esc($qrUrl) ?>" alt="HiredNext payment QR" width="280" height="280" class="block w-[280px] max-w-full h-auto object-contain" loading="eager" decoding="sync">
                        </div>
                        <div class="mt-4 font-black tracking-[0.16em] text-primary">HIREDNEXT</div>
                    </div>
                </div>
                <div>
                    <?php if (session('success')): ?><div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800 font-semibold"><?= esc(session('success')) ?></div><?php endif; ?>
                    <?php if (session('error')): ?><div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 font-semibold"><?= esc(session('error')) ?></div><?php endif; ?>
                    <div class="mb-6">
                        <div class="text-[10px] uppercase tracking-[0.22em] text-accent font-black mb-2">After payment</div>
                        <h2 class="text-2xl font-serif font-bold text-primary mb-2">Submit the transaction reference</h2>
                        <p class="text-sm text-gray-600 leading-relaxed">Use the same email address used for your HiredNext CV request. Payment remains pending until HiredNext verifies the transaction.</p>
                    </div>
                    <form action="<?= base_url('cv-upgrade/' . esc($order['token'])) ?>" method="post" class="space-y-4">
                        <?= csrf_field() ?>
                        <div><label class="block text-sm font-bold text-primary mb-1">Email used with HiredNext *</label><input type="email" name="email" required value="<?= esc(old('email')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="you@example.com"></div>
                        <div><label class="block text-sm font-bold text-primary mb-1">UPI transaction/reference number *</label><input name="payment_reference" required minlength="6" value="<?= esc(old('payment_reference')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Reference shown by your payment app"></div>
                        <button type="submit" class="w-full bg-accent text-white py-4 rounded-xl font-bold hover:opacity-90 transition">I have paid ₹<?= esc(number_format((int)($order['amount'] ?? 0))) ?> — Submit for verification</button>
                        <p class="text-xs text-gray-500 text-center">This professional CV service is optional and separate from recruitment consideration, job applications, interviews or placement through HiredNext.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
