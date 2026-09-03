<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$qrUrl = base_url('cv-payment/qr') . '?v=20260903';
?>

<style>
    #navbar { background:#fff !important; box-shadow:0 8px 30px rgba(12,52,102,.08); padding-top:1rem !important; padding-bottom:1rem !important; }
    #navbar #logoText, #navbar .nav-link, #navbar #menuBtn { color:#0c3466 !important; }
</style>

<section class="min-h-[80vh] pt-32 pb-20 bg-gray-50">
    <div class="max-w-[980px] mx-auto px-4 sm:px-8">
        <div class="mb-6">
            <a href="<?= base_url('advisory') ?>" class="text-sm font-bold text-primary hover:text-accent">← Back to advisory options</a>
        </div>

        <div class="bg-white rounded-[2rem] border border-gray-200 p-7 md:p-10 shadow-sm">
            <div class="grid lg:grid-cols-[0.9fr_1.1fr] gap-10 items-start">
                <div>
                    <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Advisory checkout</div>
                    <h1 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4"><?= esc($plan['name'] ?? 'HiredNext Advisory') ?></h1>
                    <p class="text-gray-600 leading-relaxed mb-6"><?= esc($plan['description'] ?? '') ?></p>

                    <div class="rounded-2xl bg-primary text-white p-6 mb-6">
                        <div class="text-[10px] uppercase tracking-[0.22em] text-white/55 font-black mb-2">Amount to pay</div>
                        <div class="text-4xl font-black mb-2"><?= esc($plan['amount_label'] ?? '') ?></div>
                        <div class="text-sm text-white/70">Pay exactly this amount using the HiredNext payment QR below.</div>
                    </div>

                    <div class="flex flex-col items-center rounded-2xl border border-gray-200 bg-gray-50 p-5">
                        <div class="text-sm font-black tracking-[0.18em] text-primary mb-3">HIREDNEXT</div>
                        <div class="bg-white p-3 rounded-2xl border border-gray-200 shadow-sm">
                            <img src="<?= esc($qrUrl) ?>" alt="HiredNext payment QR" width="280" height="280" class="block w-[280px] max-w-full h-auto object-contain" loading="eager" decoding="sync">
                        </div>
                        <div class="mt-4 text-xl font-black text-primary">PAY <?= esc($plan['amount_label'] ?? '') ?></div>
                    </div>
                </div>

                <div>
                    <?php if (session('error')): ?>
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 font-semibold"><?= esc(session('error')) ?></div>
                    <?php endif; ?>

                    <div class="mb-6">
                        <div class="text-[10px] uppercase tracking-[0.22em] text-accent font-black mb-2">After payment</div>
                        <h2 class="text-2xl font-serif font-bold text-primary mb-2">Submit your advisory request</h2>
                        <p class="text-sm text-gray-600 leading-relaxed">Enter the UPI reference and the information needed to prepare the session. Payment remains pending until HiredNext verifies the transaction.</p>
                    </div>

                    <form action="<?= base_url('advisory/payment/submit') ?>" method="post" class="space-y-4">
                        <?= csrf_field() ?>
                        <input type="hidden" name="plan" value="<?= esc($planKey ?? '') ?>">

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-primary mb-1">Name *</label>
                                <input name="name" required value="<?= esc(old('name')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Your name">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-primary mb-1">Email *</label>
                                <input type="email" name="email" required value="<?= esc(old('email')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="you@example.com">
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-primary mb-1">Phone *</label>
                                <input name="phone" required value="<?= esc(old('phone')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Mobile number">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-primary mb-1">Years of experience *</label>
                                <input name="years_experience" required value="<?= esc(old('years_experience')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="e.g. 18 years">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-primary mb-1">LinkedIn URL *</label>
                            <input type="url" name="linkedin" required value="<?= esc(old('linkedin')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="https://www.linkedin.com/in/...">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-primary mb-1">Current role / company *</label>
                            <input name="current_role" required value="<?= esc(old('current_role')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Current designation and company">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-primary mb-1">Target roles / industries *</label>
                            <textarea name="target_roles" required rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="What are you considering next?"><?= esc(old('target_roles')) ?></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-primary mb-1">What challenge do you want the session to solve? *</label>
                            <textarea name="challenge" required rows="4" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Give us the context we should research before the session."><?= esc(old('challenge')) ?></textarea>
                        </div>

                        <?php if (($planKey ?? '') === 'cxo-advisory'): ?>
                            <div>
                                <label class="block text-sm font-bold text-primary mb-1">Decision / successful outcome *</label>
                                <textarea name="decision" required rows="4" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="What decision are you trying to make, and what would a useful outcome look like?"><?= esc(old('decision')) ?></textarea>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="decision" value="">
                        <?php endif; ?>

                        <div class="rounded-xl bg-gray-50 border border-gray-200 p-4">
                            <label class="block text-sm font-bold text-primary mb-1">UPI transaction/reference number *</label>
                            <input name="payment_reference" required minlength="6" value="<?= esc(old('payment_reference')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Enter the reference shown by your payment app">
                            <p class="mt-2 text-xs text-gray-500">We use this reference only to match and verify the payment.</p>
                        </div>

                        <button type="submit" class="w-full bg-accent text-white py-4 rounded-xl font-bold hover:opacity-90 transition">I have paid <?= esc($plan['amount_label'] ?? '') ?> — Submit for verification</button>
                        <p class="text-xs text-gray-500 text-center">Advisory payment is separate from recruitment consideration. HiredNext does not charge candidates to apply for jobs or secure placement.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
