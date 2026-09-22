<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$amount = (int)($lead['amount'] ?? 1171);
$isNewAssessment = (($lead['assessment_plan'] ?? '') === 'priority_992');
$priceLabel = $isNewAssessment ? '₹992 + GST' : ('₹' . number_format($amount));
$payableLabel = '₹' . number_format($amount);
$paymentAvailable = \Config\PaymentIdentity::destination()['active'];
?>
<style>
    #navbar { background:#fff !important; box-shadow:0 8px 30px rgba(12,52,102,.08); padding-top:1rem !important; padding-bottom:1rem !important; }
    #navbar #logoText, #navbar .nav-link, #navbar #menuBtn { color:#0c3466 !important; }
</style>

<section class="min-h-[70vh] pt-32 pb-20 bg-gray-50">
    <div class="max-w-[820px] mx-auto px-4 sm:px-8">
        <div class="bg-white rounded-[2rem] border border-gray-200 p-8 md:p-12 shadow-sm">
            <div class="text-center mb-8">
                <p class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-4">Priority CV Assessment</p>
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Your CV has been received</h1>
                <p class="text-gray-600">HiredNext will send verified business payment details from <strong>jobs@hirednext.info</strong>. Do not use an old Paytm URL or a destination showing an individual's name or phone number.</p>
            </div>

            <?php if (session('success')): ?>
                <div class="mb-6 rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-primary">
                    <div class="font-bold mb-1">Your CV is safely with HiredNext.</div>
                    <div class="text-sm leading-relaxed"><?= esc(session('success')) ?></div>
                </div>
            <?php else: ?>
                <div class="mb-6 rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-primary">
                    <div class="font-bold mb-1">Watch for jobs@hirednext.info</div>
                    <div class="text-sm leading-relaxed">Your HiredNext assessment, report and any next steps will come from <strong>jobs@hirednext.info</strong>. Please save it to your contacts and check Promotions/Spam if you do not see our message.</div>
                </div>
            <?php endif; ?>

            <?php if (session('errors')): ?>
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 font-semibold"><?= esc(implode(' ', session('errors'))) ?></div>
            <?php endif; ?>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <div class="rounded-2xl bg-gray-50 p-5 mb-6">
                        <div class="flex justify-between gap-4 py-2"><span class="text-gray-500">Candidate</span><strong class="text-right"><?= esc($lead['name']) ?></strong></div>
                        <div class="flex justify-between gap-4 py-2"><span class="text-gray-500">Service</span><strong class="text-right">Priority CV Assessment</strong></div>
                        <div class="flex justify-between gap-4 py-2"><span class="text-gray-500">Service price</span><strong><?= esc($priceLabel) ?></strong></div>
                        <div class="flex justify-between gap-4 py-2"><span class="text-gray-500">Payable</span><strong><?= esc($payableLabel) ?></strong></div>
                    </div>
                </div>

                <?= view('components/business-payment-gate', ['amountLabel' => $payableLabel . ' payable', 'secondaryLabel' => $isNewAssessment ? '₹992 + GST' : '']) ?>
            </div>

            <?php if ($paymentAvailable): ?>
            <form action="<?= base_url('cv-payment/verify') ?>" method="post" class="mt-8 space-y-4">
                <?= csrf_field() ?>
                <input type="hidden" name="lead_id" value="<?= esc($lead['id']) ?>">
                <div class="text-[10px] uppercase tracking-[0.2em] text-accent font-black">Already paid?</div>
                <label class="block text-sm font-bold text-primary">Submit the transaction/reference number</label>
                <input name="payment_reference" required minlength="6" value="<?= esc(old('payment_reference')) ?>" placeholder="Enter the transaction/reference ID shown after payment" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
                <button type="submit" class="w-full bg-accent text-white py-4 rounded-xl font-bold hover:opacity-90 transition">I have paid <?= esc($payableLabel) ?> — Submit for verification</button>
                <p class="text-xs text-gray-500 text-center">Use this only if payment is already complete. Payment remains pending until HiredNext verifies the transaction.</p>
            </form>
            <?php else: ?>
            <div class="mt-8 rounded-2xl border border-gray-200 bg-gray-50 p-6 text-center">
                <div class="text-xs font-black uppercase tracking-[0.2em] text-accent">Payment confirmation locked</div>
                <p class="mt-3 text-sm leading-relaxed text-gray-600">No transaction reference can be submitted until the verified HiredNext business checkout is active.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
