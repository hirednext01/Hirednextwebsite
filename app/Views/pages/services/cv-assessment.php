<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-16 bg-primary text-white overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>
    <div class="relative z-10 max-w-[1100px] mx-auto px-4 sm:px-8 lg:px-12 grid lg:grid-cols-[1.2fr_.8fr] gap-10 items-center">
        <div>
            <div class="inline-flex px-4 py-2 bg-white/10 border border-white/15 rounded-full text-xs uppercase tracking-[0.25em] font-bold mb-6">12-hour recruiter assessment</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-5">Not getting shortlisted? See what your CV may be failing to show.</h1>
            <p class="text-lg md:text-xl text-white/80 leading-relaxed">Think your CV has no gaps? Get a written, role-focused assessment of what it communicates, the evidence it leaves unclear and the corrections to make first.</p>
            <?php if (!empty($job)): ?><div class="mt-7 inline-flex flex-wrap items-center gap-3 rounded-2xl bg-white/10 border border-white/15 px-5 py-4 text-sm"><span class="text-white/60">For the role:</span><strong><?= esc($job['title']) ?></strong><span>· <?= esc($job['location'] ?? '') ?></span></div><?php endif; ?>
            <a href="#assessment-form" class="inline-flex mt-8 rounded-xl bg-accent px-7 py-4 font-black text-white">Get My CV Assessed — ₹599 <span class="ml-1 text-xs font-bold opacity-80">(inclusive of GST)</span></a>
            <p class="mt-3 text-xs text-white/55">Pay by HiredNext UPI QR after CV upload. Job applications and placements remain free.</p>
            <a href="#cv-questions" class="inline-block mt-4 text-sm text-white underline underline-offset-4">Questions before buying? Get instant answers</a>
        </div>
        <aside class="rounded-[2rem] border border-white/15 bg-white/10 p-7">
            <div class="text-xs font-black uppercase tracking-[0.2em] text-gold">What you receive</div>
            <ul class="mt-5 space-y-4 text-sm text-white/85"><li>✓ Recruiter’s first impression</li><li>✓ ATS and role-keyword gaps</li><li>✓ Positioning and credibility risks</li><li>✓ Evidence missing from the CV</li><li>✓ Prioritised corrections and recommendation</li></ul>
            <div class="mt-6 border-t border-white/15 pt-5 flex items-end justify-between"><span class="text-sm text-white/65">After payment verification</span><strong class="text-3xl text-gold">12 hours</strong></div>
        </aside>
    </div>
</section>

<?php if (session('success')): ?><section class="py-5 bg-green-50 border-b border-green-200"><div class="max-w-[900px] mx-auto px-4 text-green-800 font-semibold"><?= esc(session('success')) ?></div></section><?php endif; ?>
<?php if (session('errors')): ?><section class="py-5 bg-red-50 border-b border-red-200"><div class="max-w-[900px] mx-auto px-4 text-red-800 font-semibold"><?= esc(implode(' ', session('errors'))) ?></div></section><?php endif; ?>

<section class="py-16 bg-gray-50">
    <div class="max-w-[1100px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="text-center max-w-3xl mx-auto mb-10"><div class="text-xs font-black uppercase tracking-[0.2em] text-accent mb-3">See before you buy</div><h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">Preview the assessment you will receive</h2></div>
        <div class="relative overflow-hidden rounded-[2rem] border border-gray-200 bg-white shadow-xl p-7 md:p-10">
            <div class="pointer-events-none absolute inset-0 flex items-center justify-center text-primary/5 text-5xl md:text-7xl font-black -rotate-12">SAMPLE · HIREDNEXT</div>
            <div class="relative grid md:grid-cols-2 gap-6">
                <article class="rounded-2xl border border-gray-200 p-5"><div class="text-xs font-black text-accent">01</div><h3 class="font-black text-primary mt-2">Recruiter’s first impression</h3><p class="text-sm text-gray-600 mt-2">What is clear in the first scan—and what remains difficult to understand about your level, scope and target role.</p></article>
                <article class="rounded-2xl border border-gray-200 p-5"><div class="text-xs font-black text-accent">02</div><h3 class="font-black text-primary mt-2">ATS and keyword gaps</h3><p class="text-sm text-gray-600 mt-2">Role language, skills and structure that may prevent the CV from matching the opportunity accurately.</p></article>
                <article class="rounded-2xl border border-gray-200 p-5"><div class="text-xs font-black text-accent">03</div><h3 class="font-black text-primary mt-2">Positioning and missing evidence</h3><p class="text-sm text-gray-600 mt-2">Where responsibilities are visible but business scale, ownership and measurable outcomes are not.</p></article>
                <article class="rounded-2xl border border-gray-200 p-5"><div class="text-xs font-black text-accent">04</div><h3 class="font-black text-primary mt-2">Priority corrections</h3><p class="text-sm text-gray-600 mt-2">A practical order of changes, with a recommendation on whether correction or a full rebuild is justified.</p></article>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="rounded-[2rem] bg-primary p-8 md:p-10 text-white">
            <div class="text-xs font-black uppercase tracking-[0.2em] text-gold">ILLUSTRATIVE ASSESSMENT EXAMPLE</div>
            <h2 class="mt-4 text-2xl md:text-3xl font-serif font-bold">A responsibility is visible. The scale is missing.</h2>
            <div class="mt-6 grid md:grid-cols-2 gap-6">
                <div><h3 class="font-bold text-gold">CV line</h3><p class="mt-2 text-white/85">“Responsible for merchandising and buyer coordination.”</p></div>
                <div><h3 class="font-bold text-gold">Assessment finding</h3><p class="mt-2 text-white/85">The function is clear. The reader cannot see the categories, buyer relationships or decisions this person owned.</p></div>
            </div>
            <div class="mt-6 border-t border-white/20 pt-5"><h3 class="font-bold text-gold">Priority correction</h3><p class="mt-2 text-white/85">Add the category scope, your actual decision authority and an outcome you can support. Use numbers only when you can verify them.</p></div>
            <p class="mt-5 text-xs text-white/65">Illustrative wording, not a customer testimonial. Your report is based on your own CV and target role.</p>
        </div>
        <div class="mt-7 text-center"><a href="#assessment-form" class="inline-flex rounded-xl bg-accent px-7 py-4 font-black text-white">Get My CV Assessed — ₹599</a><p class="mt-3 text-sm text-gray-600">GST included. A written diagnosis before you decide on further work.</p></div>
    </div>
</section>

<section id="assessment-form" class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="text-center mb-10"><h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Start your ₹599 assessment <span class="block mt-2 text-sm font-sans font-semibold text-gray-500">Inclusive of GST</span></h2><p class="text-gray-600">Upload your CV first. You will then see the HiredNext UPI QR and submit your transaction reference.</p></div>
        <form action="<?= base_url('cv-assessment/submit') ?>" method="post" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-[2rem] p-8 md:p-10 space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="assessment_plan" value="priority_599"><input type="hidden" name="job_slug" value="<?= esc($job['slug'] ?? '') ?>"><input type="hidden" name="job_title" value="<?= esc($job['title'] ?? '') ?>">
            <input type="hidden" name="utm_source" value=""><input type="hidden" name="utm_medium" value=""><input type="hidden" name="utm_campaign" value=""><input type="hidden" name="utm_content" value="">
            <input type="hidden" name="first_touch_source" value=""><input type="hidden" name="first_touch_medium" value=""><input type="hidden" name="first_touch_campaign" value=""><input type="hidden" name="first_touch_content" value="">
            <input type="hidden" name="latest_touch_source" value=""><input type="hidden" name="latest_touch_medium" value=""><input type="hidden" name="latest_touch_campaign" value=""><input type="hidden" name="latest_touch_content" value="">
            <div class="grid md:grid-cols-2 gap-5"><input name="name" minlength="3" required value="<?= esc(old('name')) ?>" placeholder="Full name" class="w-full border border-gray-200 rounded-xl px-4 py-3"><input name="email" type="email" required value="<?= esc(old('email')) ?>" placeholder="Email address" class="w-full border border-gray-200 rounded-xl px-4 py-3"></div>
            <input name="phone" required minlength="6" value="<?= esc(old('phone')) ?>" placeholder="Phone number" class="w-full border border-gray-200 rounded-xl px-4 py-3">
            <div><label for="cv-target-role" class="block text-sm font-bold text-primary mb-2">Which role are you targeting?</label><textarea id="cv-target-role" name="message" rows="4" required placeholder="For example: Merchandising Manager. Add a job description if you have one." class="w-full border border-gray-200 rounded-xl px-4 py-3"><?= esc(old('message') ?: ($job['title'] ?? '')) ?></textarea></div>
            <div class="rounded-xl border border-dashed border-gray-300 px-4 py-4"><label class="block text-sm font-bold text-primary mb-2">Upload your CV</label><input name="resume" type="file" accept=".pdf,.doc,.docx" required class="w-full text-sm"><p class="text-xs text-gray-500 mt-2">PDF, DOC or DOCX. Maximum 5MB.</p></div>
            <button type="submit" class="w-full bg-accent text-white py-4 rounded-xl font-black">Continue to ₹599 payment <span class="text-xs opacity-80">(GST included)</span></button>
            <p class="text-xs text-gray-500 text-center">Your assessment request is submitted only after you enter your payment reference on the next step. No submission email is sent before that. This service does not guarantee interviews, shortlisting or placement.</p>
        </form>
    </div>
</section>

<section class="py-10 bg-gray-50 border-t border-gray-200"><div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12 text-center"><h2 class="text-2xl font-serif font-bold text-primary">Already want a complete rewrite?</h2><p class="mt-3 text-gray-600">The ₹1,799 Professional CV Rebuild includes assessment, two CV variants and two revision rounds. GST included. You do not have to buy both services.</p><a href="<?= base_url('career-services/start/rebuild_1799') ?>" class="inline-flex mt-5 rounded-xl bg-primary px-6 py-3 font-bold text-white">Get My CV Rebuilt — ₹1,799</a></div></section>

<?= view('pages/services/_cv-service-faq') ?>

<script>
(function () {
    const params = new URLSearchParams(window.location.search), keys = ['source','medium','campaign','content'], latest = {};
    keys.forEach(key => latest[key] = params.get('utm_' + key) || '');
    if (Object.values(latest).some(Boolean)) localStorage.setItem('hn_cv_latest_touch', JSON.stringify(latest));
    const savedLatest = JSON.parse(localStorage.getItem('hn_cv_latest_touch') || '{}');
    const savedFirst = JSON.parse(localStorage.getItem('hn_cv_first_touch') || 'null') || savedLatest;
    if (!localStorage.getItem('hn_cv_first_touch') && Object.keys(savedFirst).length) localStorage.setItem('hn_cv_first_touch', JSON.stringify(savedFirst));
    keys.forEach(function (key) {
        const current = latest[key] || savedLatest[key] || '';
        document.querySelector('[name="utm_' + key + '"]').value = current;
        document.querySelector('[name="latest_touch_' + key + '"]').value = current;
        document.querySelector('[name="first_touch_' + key + '"]').value = savedFirst[key] || '';
    });
})();
</script>
<script type="application/ld+json"><?= json_encode(['@context'=>'https://schema.org','@type'=>'Service','name'=>'HiredNext Priority CV Assessment','provider'=>['@type'=>'Organization','name'=>'HiredNext Recruitment','url'=>base_url()],'serviceType'=>'Role-focused CV Assessment','offers'=>[['@type'=>'Offer','price'=>'599','priceCurrency'=>'INR','name'=>'Priority CV Assessment']]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?= $this->endSection() ?>
