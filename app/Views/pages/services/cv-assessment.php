<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-16 bg-primary text-white overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 -left-24 w-80 h-80 bg-gold/10 rounded-full blur-3xl"></div>
    <div class="relative z-10 max-w-[1200px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/15 rounded-full text-xs uppercase tracking-[0.25em] font-bold mb-6">Candidate Career Services</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-5">Is your CV ready for the role you want?</h1>
            <p class="text-lg md:text-xl text-white/80 leading-relaxed">Get a practical assessment before you apply. Choose a free review or a priority, role-focused assessment within 12 hours.</p>
            <?php if (!empty($job)): ?>
                <div class="mt-7 inline-flex flex-wrap items-center gap-3 rounded-2xl bg-white/10 border border-white/15 px-5 py-4 text-sm">
                    <span class="text-white/60">For the role:</span><strong><?= esc($job['title']) ?></strong><span class="text-white/50">·</span><span><?= esc($job['location'] ?? '') ?></span>
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

<section class="py-16 bg-gray-50">
    <div class="max-w-[1100px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid md:grid-cols-2 gap-8 items-stretch">
            <article class="bg-white rounded-[2rem] border border-gray-200 p-8 md:p-10 shadow-sm">
                <div class="text-sm font-black uppercase tracking-widest text-gray-500 mb-3">Free</div>
                <h2 class="text-3xl font-serif font-bold text-primary mb-3">CV Assessment</h2>
                <div class="text-4xl font-black text-primary mb-6">₹0</div>
                <p class="text-gray-600 leading-relaxed mb-7">A useful first review to identify the biggest strengths and gaps in your CV.</p>
                <ul class="space-y-4 text-sm text-gray-700 mb-8"><li>✓ CV readability and structure review</li><li>✓ Key strengths and obvious gaps</li><li>✓ Basic ATS-readiness observations</li><li>✓ Practical improvement pointers</li><li>✓ Delivered within 7–10 days</li></ul>
                <a href="#assessment-form" data-plan="free" class="plan-link inline-flex w-full justify-center px-6 py-4 rounded-xl border-2 border-primary text-primary font-bold hover:bg-primary hover:text-white transition">Get Free Assessment</a>
            </article>
            <article class="bg-primary text-white rounded-[2rem] border-2 border-accent p-8 md:p-10 shadow-xl relative overflow-hidden">
                <div class="absolute top-5 right-5 px-3 py-1 rounded-full bg-accent text-white text-[10px] font-black uppercase tracking-widest">Priority</div>
                <div class="text-sm font-black uppercase tracking-widest text-gold mb-3">12-hour service</div>
                <h2 class="text-3xl font-serif font-bold mb-3">Priority CV Assessment</h2>
                <div class="text-4xl font-black text-gold mb-6">₹599</div>
                <p class="text-white/75 leading-relaxed mb-7">A deeper, role-focused assessment for candidates who want actionable recommendations quickly.</p>
                <ul class="space-y-4 text-sm text-white/85 mb-8"><li>✓ Everything in the free assessment</li><li>✓ Role-specific CV fit review</li><li>✓ ATS and keyword gap analysis</li><li>✓ Experience positioning recommendations</li><li>✓ Priority delivery within 12 hours</li></ul>
                <a href="#assessment-form" data-plan="priority_599" class="plan-link inline-flex w-full justify-center px-6 py-4 rounded-xl bg-accent text-white font-bold hover:opacity-90 transition">Choose Priority ₹599</a>
            </article>
        </div>
    </div>
</section>

<section id="assessment-form" class="py-16 bg-white border-t border-gray-100">
    <div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="text-center mb-10"><h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Start your CV assessment</h2><p class="text-gray-600">Submit your details and CV first. If you choose Priority, the ₹599 QR payment page opens next.</p></div>
        <form action="<?= base_url('cv-assessment/submit') ?>" method="post" enctype="multipart/form-data" class="bg-gray-50 border border-gray-200 rounded-[2rem] p-8 md:p-10 space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="job_slug" value="<?= esc($job['slug'] ?? '') ?>">
            <input type="hidden" name="job_title" value="<?= esc($job['title'] ?? '') ?>">
            <div class="grid md:grid-cols-2 gap-5">
                <input name="name" minlength="3" required value="<?= esc(old('name')) ?>" placeholder="Full name" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
                <input name="email" type="email" required value="<?= esc(old('email')) ?>" placeholder="Email address" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
            </div>
            <input name="phone" required minlength="6" value="<?= esc(old('phone')) ?>" placeholder="Phone number" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
            <select id="assessmentPlan" name="assessment_plan" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
                <option value="">Select assessment</option>
                <option value="free" <?= old('assessment_plan') === 'free' ? 'selected' : '' ?>>Free CV Assessment — 7–10 days</option>
                <option value="priority_599" <?= old('assessment_plan') === 'priority_599' ? 'selected' : '' ?>>Priority CV Assessment — ₹599 / 12 hours</option>
            </select>
            <div id="priorityNote" class="hidden rounded-2xl border border-accent/30 bg-orange-50 p-5 text-sm text-gray-700">
                <strong class="text-primary">Priority payment comes next.</strong> After this form is saved, you will see the HiredNext QR and can pay ₹599 with any UPI app. Your phone-linked UPI ID is not displayed on the website.
            </div>
            <textarea name="message" rows="4" placeholder="Tell us which role you're targeting (optional)" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white"><?= esc(old('message')) ?></textarea>
            <div class="rounded-xl border border-dashed border-gray-300 bg-white px-4 py-4"><label class="block text-sm font-bold text-primary mb-2">Upload your CV</label><input name="resume" type="file" accept=".pdf,.doc,.docx" required class="w-full text-sm"><p class="text-xs text-gray-500 mt-2">PDF, DOC or DOCX. Maximum 5MB.</p></div>
            <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-bold hover:bg-accent transition">Continue</button>
            <p class="text-xs text-gray-500 text-center">Free requests require no payment. Priority requests continue to the ₹599 QR payment page.</p>
        </form>
    </div>
</section>

<section class="py-14 bg-gray-50"><div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12"><h2 class="text-3xl font-serif font-bold text-primary text-center mb-8">CV Assessment FAQs</h2><div class="space-y-4"><details class="bg-white border border-gray-200 rounded-2xl p-5"><summary class="font-bold text-primary cursor-pointer">What does the free CV assessment include?</summary><p class="mt-3 text-gray-600 text-sm leading-relaxed">Structure, readability, key strengths, obvious gaps and basic ATS-readiness observations, delivered within 7–10 days.</p></details><details class="bg-white border border-gray-200 rounded-2xl p-5"><summary class="font-bold text-primary cursor-pointer">How do I pay for the ₹599 assessment?</summary><p class="mt-3 text-gray-600 text-sm leading-relaxed">Choose Priority and submit your details and CV. The next page shows the HiredNext QR. Scan it with any UPI app, pay ₹599, then submit the transaction/reference number for verification.</p></details><details class="bg-white border border-gray-200 rounded-2xl p-5"><summary class="font-bold text-primary cursor-pointer">Does an assessment apply for a job automatically?</summary><p class="mt-3 text-gray-600 text-sm leading-relaxed">No. A CV assessment is a separate career service. Apply through the specific job page if you want to submit a job application.</p></details></div></div></section>

<script>
(function () {
    const plan = document.getElementById('assessmentPlan');
    const note = document.getElementById('priorityNote');
    const sync = () => note.classList.toggle('hidden', plan.value !== 'priority_599');
    document.querySelectorAll('.plan-link').forEach(link => link.addEventListener('click', function () {
        plan.value = this.dataset.plan;
        sync();
    }));
    plan.addEventListener('change', sync);
    sync();
})();
</script>
<script type="application/ld+json"><?= json_encode(['@context'=>'https://schema.org','@type'=>'Service','name'=>'HiredNext CV Assessment','provider'=>['@type'=>'Organization','name'=>'HiredNext Recruitment','url'=>base_url()],'serviceType'=>'CV Assessment','offers'=>[['@type'=>'Offer','price'=>'0','priceCurrency'=>'INR','name'=>'Free CV Assessment'],['@type'=>'Offer','price'=>'599','priceCurrency'=>'INR','name'=>'Priority CV Assessment']],], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?= $this->endSection() ?>
