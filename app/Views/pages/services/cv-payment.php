<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="min-h-[70vh] pt-32 pb-20 bg-gray-50">
    <div class="max-w-[820px] mx-auto px-4 sm:px-8">
        <div class="bg-white rounded-[2rem] border border-gray-200 p-8 md:p-12 shadow-sm">
            <div class="text-center mb-8">
                <p class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-4">Priority CV Assessment</p>
                <h1 class="text-4xl font-serif font-bold text-primary mb-4">Complete your ₹599 payment</h1>
                <p class="text-gray-600">Your CV has been received. Scan the HiredNext QR using any UPI app, then submit the transaction/reference number below.</p>
            </div>

            <?php if (session('errors')): ?>
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 font-semibold"><?= esc(implode(' ', session('errors'))) ?></div>
            <?php endif; ?>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <div class="rounded-2xl bg-gray-50 p-5 mb-6">
                        <div class="flex justify-between py-2"><span class="text-gray-500">Candidate</span><strong><?= esc($lead['name']) ?></strong></div>
                        <div class="flex justify-between py-2"><span class="text-gray-500">Service</span><strong>Priority CV Assessment</strong></div>
                        <div class="flex justify-between py-2"><span class="text-gray-500">Amount</span><strong>₹599</strong></div>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 text-sm text-gray-700">
                        <div class="font-bold text-primary mb-1">HiredNext</div>
                        <div>Scan with any UPI app</div>
                        <div class="mt-2 text-xs text-gray-500">Your phone-linked UPI ID is not displayed on this page.</div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <img src="<?= base_url('theme/assets/hirednext-paytm-qr.jpg') ?>" alt="HiredNext Paytm UPI QR code for ₹599 priority CV assessment" class="w-full max-w-[320px] rounded-2xl border border-gray-200 shadow-sm bg-white">
                </div>
            </div>

            <form action="<?= base_url('cv-payment/verify') ?>" method="post" class="mt-8 space-y-4">
                <?= csrf_field() ?>
                <input type="hidden" name="lead_id" value="<?= esc($lead['id']) ?>">
                <label class="block text-sm font-bold text-primary">UPI transaction/reference number</label>
                <input name="payment_reference" required minlength="6" value="<?= esc(old('payment_reference')) ?>" placeholder="Enter the transaction/reference ID shown after payment" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
                <button type="submit" class="w-full bg-accent text-white py-4 rounded-xl font-bold hover:opacity-90 transition">I have paid ₹599 — Submit for verification</button>
                <p class="text-xs text-gray-500 text-center">Payment is marked pending until HiredNext verifies the UPI transaction.</p>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
