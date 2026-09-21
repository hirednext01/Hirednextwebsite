<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
    #navbar { background:#fff !important; box-shadow:0 8px 30px rgba(12,52,102,.08); padding-top:1rem !important; padding-bottom:1rem !important; }
    #navbar #logoText, #navbar .nav-link, #navbar #menuBtn { color:#0c3466 !important; }
</style>

<section class="min-h-[75vh] bg-gray-50 pb-20 pt-32">
    <div class="mx-auto max-w-[920px] px-4 sm:px-8">
        <div class="overflow-hidden rounded-[2rem] border border-gray-200 bg-white shadow-sm">
            <div class="bg-primary px-7 py-9 text-white md:px-12">
                <div class="text-xs font-black uppercase tracking-[0.24em] text-gold">Private HiredNext checkout</div>
                <h1 class="mt-3 text-3xl font-bold leading-tight md:text-5xl">LinkedIn Leadership Positioning</h1>
                <p class="mt-4 max-w-2xl text-white/80">Prepared exclusively for Jooney Narendran under the individually agreed professional-service fee.</p>
            </div>

            <div class="grid gap-10 p-7 md:grid-cols-2 md:p-12">
                <div>
                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                        <div class="flex items-center justify-between gap-4 border-b border-gray-200 pb-3 text-sm">
                            <span class="text-gray-500">Standard public fee</span>
                            <strong class="text-right text-gray-700">₹8,999 + GST</strong>
                        </div>
                        <div class="flex items-center justify-between gap-4 border-b border-gray-200 py-3 text-sm">
                            <span class="text-gray-500">Individually agreed fee</span>
                            <strong class="text-right text-primary">₹5,500</strong>
                        </div>
                        <div class="flex items-center justify-between gap-4 border-b border-gray-200 py-3 text-sm">
                            <span class="text-gray-500">GST at 18%</span>
                            <strong class="text-right text-primary">₹990</strong>
                        </div>
                        <div class="flex items-center justify-between gap-4 pt-4">
                            <span class="font-black text-primary">Total payable</span>
                            <strong class="text-3xl text-accent">₹6,490</strong>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-blue-100 bg-blue-50 p-5 text-sm leading-relaxed text-gray-700">
                        <strong class="text-primary">What happens after payment</strong>
                        <p class="mt-2">Once payment is confirmed, HiredNext will take one working day to review your CV and positioning direction and prepare the tailored questions needed for the assignment. The questions will then be sent to you, and the delivery process will begin from payment confirmation.</p>
                    </div>

                    <p class="mt-5 text-xs leading-relaxed text-gray-500">This private fee is specific to this engagement and does not change HiredNext’s public service price. This professional service is separate from recruitment consideration, interviews or placement.</p>
                </div>

                <div class="text-center">
                    <div class="text-xs font-black uppercase tracking-[0.2em] text-accent">Pay to the verified company account</div>
                    <div class="mt-3 text-lg font-black text-primary">Hirednext Avron Private Limited</div>
                    <div class="mx-auto mt-5 max-w-[360px] rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                        <img src="<?= base_url('theme/assets/private/hirednext-company-qr.png') ?>" alt="HiredNext company payment QR" width="560" height="560" class="block h-auto w-full" loading="eager" decoding="sync">
                    </div>
                    <div class="mt-5 rounded-2xl bg-amber-50 p-4 text-sm leading-relaxed text-gray-700">
                        Scan with any UPI app, confirm that the payee shown is <strong>Hirednext Avron Private Limited</strong>, and enter <strong>₹6,490</strong> before approving the payment.
                    </div>
                    <a href="mailto:partners@hirednext.info?subject=Jooney%20Narendran%20%7C%20LinkedIn%20Leadership%20Positioning%20%7C%20Payment%20confirmation" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-accent px-5 py-4 font-bold text-white transition hover:opacity-90">Email payment confirmation</a>
                    <p class="mt-3 text-xs text-gray-500">Please include the transaction reference or payment screenshot so the team can verify it promptly.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
