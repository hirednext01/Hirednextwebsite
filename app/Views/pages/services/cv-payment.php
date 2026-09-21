<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
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
                        <div class="flex justify-between gap-4 py-2"><span class="text-gray-500">Total (inclusive of GST)</span><strong>₹599</strong></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 text-center">
                    <div class="text-sm font-black tracking-[0.14em] text-primary mb-3">VERIFIED BUSINESS PAYMENT ONLY</div>
                    <p class="text-sm text-gray-700 leading-relaxed">The previous QR has been retired. Wait for payment details issued by <strong>HiredNext Recruitment</strong> from jobs@hirednext.info.</p>
                    <div class="mt-4 text-xl font-black text-primary">₹599 · GST included</div>
                </div>
            </div>

            <form action="<?= base_url('cv-payment/verify') ?>" method="post" class="mt-8 space-y-4">
                <?= csrf_field() ?>
                <input type="hidden" name="lead_id" value="<?= esc($lead['id']) ?>">
                <div class="text-[10px] uppercase tracking-[0.2em] text-accent font-black">Already paid?</div>
                <label class="block text-sm font-bold text-primary">Submit the transaction/reference number</label>
                <input name="payment_reference" required minlength="6" value="<?= esc(old('payment_reference')) ?>" placeholder="Enter the transaction/reference ID shown after payment" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
                <button type="submit" class="w-full bg-accent text-white py-4 rounded-xl font-bold hover:opacity-90 transition">I have paid ₹599 (GST included) — Submit for verification</button>
                <p class="text-xs text-gray-500 text-center">Use this only if payment is already complete. Payment remains pending until HiredNext verifies the transaction.</p>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
