<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-20 bg-primary text-white overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 -left-24 w-80 h-80 bg-gold/10 rounded-full blur-3xl"></div>
    <div class="relative z-10 max-w-[1200px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/15 rounded-full text-xs uppercase tracking-[0.25em] font-bold mb-7">Candidate Career Services</div>
            <h1 class="text-5xl md:text-7xl font-serif font-bold leading-tight mb-6">Is your CV ready for the role you want?</h1>
            <p class="text-xl text-white/80 leading-relaxed">Get a practical assessment of your CV before you apply. Choose our free review or get a priority, detailed assessment within 12 hours.</p>
            <?php if (!empty($job)): ?>
                <div class="mt-8 inline-flex items-center gap-3 rounded-2xl bg-white/10 border border-white/15 px-5 py-4 text-sm">
                    <span class="text-white/60">For the role:</span>
                    <strong><?= esc($job['title']) ?></strong>
                    <span class="text-white/50">·</span>
                    <span><?= esc($job['location'] ?? '') ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (session('success')): ?>
<section class="py-5 bg-green-50 border-b border-green-200"><div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12 text-green-800 font-semibold"><?= esc(session('success')) ?></div></section>
<?php endif; ?>
<?php if (session('errors')): ?>
<section class="py-5 bg-red-50 border-b border-red-200"><div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12 text-red-800 font-semibold"><?= esc(implode(' ', session('errors'))) ?></div></section>
<?php endif; ?>

<section class="py-20 bg-gray-50">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid md:grid-cols-2 gap-8 items-stretch">
            <article class="bg-white rounded-[2rem] border border-gray-200 p-8 md:p-10 shadow-sm">
                <div class="text-sm font-black uppercase tracking-widest text-gray-500 mb-3">Free</div>
                <h2 class="text-3xl font-serif font-bold text-primary mb-3">CV Assessment</h2>
                <div class="text-4xl font-black text-primary mb-6">₹0</div>
                <p class="text-gray-600 leading-relaxed mb-7">A useful first review for candidates who want to understand the biggest strengths and gaps in their CV.</p>
                <ul class="space-y-4 text-sm text-gray-700 mb-8"><li>✓ CV readability and structure review</li><li>✓ Key strengths and obvious gaps</li><li>✓ Basic ATS-readiness observations</li><li>✓ Practical improvement pointers</li><li>✓ Delivered within 7–10 days</li></ul>
                <a href="#assessment-form" class="inline-flex w-full justify-center px-6 py-4 rounded-xl border-2 border-primary text-primary font-bold hover:bg-primary hover:text-white transition">Get Free Assessment</a>
            </article>
            <article class="bg-primary text-white rounded-[2rem] border-2 border-accent p-8 md:p-10 shadow-xl relative overflow-hidden">
                <div class="absolute top-5 right-5 px-3 py-1 rounded-full bg-accent text-white text-[10px] font-black uppercase tracking-widest">Priority</div>
                <div class="text-sm font-black uppercase tracking-widest text-gold mb-3">12-hour service</div>
                <h2 class="text-3xl font-serif font-bold mb-3">Priority CV Assessment</h2>
                <div class="text-4xl font-black text-gold mb-6">₹599</div>
                <p class="text-white/75 leading-relaxed mb-7">A deeper, role-focused assessment for candidates who want actionable recommendations quickly.</p>
                <ul class="space-y-4 text-sm text-white/85 mb-8"><li>✓ Everything in the free assessment</li><li>✓ Role-specific CV fit review</li><li>✓ ATS and keyword gap analysis</li><li>✓ Experience positioning recommendations</li><li>✓ Priority delivery within 12 hours</li></ul>
                <a href="#priority-payment" class="inline-flex w-full justify-center px-6 py-4 rounded-xl bg-accent text-white font-bold hover:opacity-90 transition">Pay ₹599 & Submit CV</a>
            </article>
        </div>
    </div>
</section>

<section id="priority-payment" class="py-20 bg-white">
    <div class="max-w-[1050px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-10 items-center rounded-[2rem] border border-gray-200 bg-gray-50 p-7 md:p-10">
            <div>
                <div class="text-xs font-black uppercase tracking-[0.2em] text-accent mb-3">Priority payment</div>
                <h2 class="text-4xl font-serif font-bold text-primary mb-4">Pay ₹599 by UPI</h2>
                <p class="text-gray-600 leading-relaxed mb-6">Scan the verified HiredNext Paytm QR using any UPI app. After payment, enter the UPI transaction/reference number in the form below so we can verify the payment and start the 12-hour priority assessment.</p>
                <div class="rounded-2xl border border-gray-200 bg-white p-5 text-sm text-gray-700">
                    <div class="font-bold text-primary mb-1">Hirednext</div>
                    <div>UPI ID: <strong>7738578358@ptaxis</strong></div>
                    <div class="mt-2 text-xs text-gray-500">Priority assessment: ₹599</div>
                </div>
            </div>
            <div class="flex justify-center">
                <img src="<?= base_url('theme/assets/hirednext-paytm-qr.jpg') ?>" alt="HiredNext Paytm UPI QR code for ₹599 priority CV assessment" class="w-full max-w-[360px] rounded-2xl border border-gray-200 shadow-sm bg-white" loading="lazy">
            </div>
        </div>
    </div>
</section>

<section id="assessment-form" class="py-20 bg-white border-t border-gray-100">
    <div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="text-center mb-12"><h2 class="text-4xl font-serif font-bold text-primary mb-4">Start your CV assessment</h2><p class="text-gray-600">Submit your details and CV. Your request is separate from any job application.</p></div>
        <form action="<?= base_url('cv-assessment/submit') ?>" method="post" enctype="multipart/form-data" class="bg-gray-50 border border-gray-200 rounded-[2rem] p-8 md:p-10 space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="job_slug" value="<?= esc($job['slug'] ?? '') ?>">
            <input type="hidden" name="job_title" value="<?= esc($job['title'] ?? '') ?>">
            <div class="grid md:grid-cols-2 gap-5"><input name="name" required value="<?= esc(old('name')) ?>" placeholder="Full name" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white"><input name="email" type="email" required value="<?= esc(old('email')) ?>" placeholder="Email address" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white"></div>
            <input name="phone" required value="<?= esc(old('phone')) ?>" placeholder="Phone number" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
            <select id="assessmentPlan" name="assessment_plan" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white"><option value="">Select assessment</option><option value="free" <?= old('assessment_plan') === 'free' ? 'selected' : '' ?>>Free CV Assessment — 7–10 days</option><option value="priority_599" <?= old('assessment_plan') === 'priority_599' ? 'selected' : '' ?>>Priority CV Assessment — ₹599 / 12 hours</option></select>
            <div id="paymentReferenceWrap" class="rounded-2xl border border-accent/30 bg-orange-50 p-5">
                <label class="block text-sm font-bold text-primary mb-2">UPI transaction/reference number <span class="text-gray-500 font-normal">(required for ₹599 priority)</span></label>
                <input name="payment_reference" value="<?= esc(old('payment_reference')) ?>" placeholder="Enter transaction ID after paying ₹599" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
                <p class="text-xs text-gray-500 mt-2">We verify this against the HiredNext Paytm payment before marking the priority assessment as paid.</p>
            </div>
            <textarea name="message" rows="4" placeholder="Tell us which role you're targeting (optional)" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white"><?= esc(old('message')) ?></textarea>
            <div class="rounded-xl border border-dashed border-gray-300 bg-white px-4 py-4"><label class="block text-sm font-bold text-primary mb-2">Upload your CV</label><input name="resume" type="file" accept=".pdf,.doc,.docx" required class="w-full text-sm"><p class="text-xs text-gray-500 mt-2">PDF, DOC or DOCX. Maximum 5MB.</p></div>
            <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-bold hover:bg-accent transition">Submit CV Assessment Request</button>
            <p class="text-xs text-gray-500 text-center">Free requests require no payment. Priority requests are activated after UPI payment verification.</p>
        </form>
    </div>
</section>

<section class="py-16 bg-gray-50"><div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12"><h2 class="text-3xl font-serif font-bold text-primary text-center mb-10">CV Assessment FAQs</h2><div class="space-y-4"><details class="bg-white border border-gray-200 rounded-2xl p-5"><summary class="font-bold text-primary cursor-pointer">What does the free CV assessment include?</summary><p class="mt-3 text-gray-600 text-sm leading-relaxed">Structure, readability, key strengths, obvious gaps and basic ATS-readiness observations, delivered within 7–10 days.</p></details><details class="bg-white border border-gray-200 rounded-2xl p-5"><summary class="font-bold text-primary cursor-pointer">How do I pay for the ₹599 assessment?</summary><p class="mt-3 text-gray-600 text-sm leading-relaxed">Scan the HiredNext Paytm QR shown above with any UPI app, pay ₹599, then enter the UPI transaction/reference number with your CV submission.</p></details><details class="bg-white border border-gray-200 rounded-2xl p-5"><summary class="font-bold text-primary cursor-pointer">Does an assessment apply for a job automatically?</summary><p class="mt-3 text-gray-600 text-sm leading-relaxed">No. A CV assessment is a separate career service. Apply through the specific job page if you want to submit a job application.</p></details></div></div></section>

<script type="application/ld+json"><?= json_encode(['@context'=>'https://schema.org','@type'=>'Service','name'=>'HiredNext CV Assessment','provider'=>['@type'=>'Organization','name'=>'HiredNext Recruitment','url'=>base_url()],'serviceType'=>'CV Assessment','offers'=>[['@type'=>'Offer','price'=>'0','priceCurrency'=>'INR','name'=>'Free CV Assessment'],['@type'=>'Offer','price'=>'599','priceCurrency'=>'INR','name'=>'Priority CV Assessment']],], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?= $this->endSection() ?>
