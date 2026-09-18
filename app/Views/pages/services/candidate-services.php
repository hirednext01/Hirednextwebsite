<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-24 bg-primary text-white overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent/15 rounded-full blur-3xl"></div>
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="max-w-4xl">
            <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-5">HiredNext Career Services</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-6">Not getting shortlisted? Start with the CV you are sending.</h1>
            <p class="text-lg md:text-xl text-white/80 leading-relaxed max-w-3xl">Your experience may be stronger than your CV shows. Find what needs attention with a written ₹599 assessment, or get HiredNext to rebuild it for ₹1,799.</p>
            <div class="flex flex-col sm:flex-row gap-3 mt-8"><a href="<?= base_url('services/cv-assessment') ?>" class="inline-flex justify-center rounded-full bg-accent px-7 py-3.5 font-black text-white">Get My CV Assessed — ₹599</a><a href="<?= base_url('career-services/start/rebuild_1799') ?>" class="inline-flex justify-center rounded-full border border-white/25 bg-white/5 px-7 py-3.5 font-black text-white">Get My CV Rebuilt — ₹1,799</a></div>
            <p class="mt-4 text-sm text-white/70">GST included. Rebuild includes assessment, two CV variants and two revision rounds.</p>
            <a href="#cv-questions" class="inline-block mt-4 text-sm text-white underline underline-offset-4">Questions before buying? Get instant answers</a>
        </div>
    </div>
</section>

<section class="bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 py-10">
        <div class="max-w-4xl">
            <div class="text-[11px] uppercase tracking-[0.22em] font-black text-accent mb-3">Recruiter-led CV services in India</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">Professional CV writing, CV making and CV rebuilding in India</h2>
            <p class="mt-4 text-gray-600 leading-relaxed">People use different words for the same need: CV making, CV writing, CV remake, CV rewriting, CV revamp or CV rebuild. HiredNext treats the work as evidence-led rebuilding rather than template filling. We use your verified career facts to make role level, scope, progression, achievements and relevant capability easier for recruiters and hiring managers to understand.</p>
            <p class="mt-3 text-gray-600 leading-relaxed">A CV assessment diagnoses what a recruiter or hiring manager can understand quickly, what evidence remains unclear and which corrections matter first. A CV rebuild goes further: HiredNext rewrites and restructures the document using verified career facts so responsibilities, scale and outcomes are easier to evaluate.</p>
            <p class="mt-3 text-gray-600 leading-relaxed"><a class="font-bold text-primary underline underline-offset-4" href="<?= base_url('guides/best-cv-writing-service-india') ?>">Looking for the best CV making or CV writing company in India?</a> Use our evidence-based buyer guide to compare what a genuine service should actually do before choosing any provider.</p>
            <p class="mt-3 text-gray-600 leading-relaxed">Interview preparation is separate from CV work. HiredNext also offers a live 1-to-1 consultation, while the ₹999 Interview Ready written-practice pilot is not open for purchase. Paid career services are optional and never influence recruitment shortlisting or placement.</p>
            <div class="mt-6 flex flex-wrap gap-3 text-sm font-bold">
                <a class="text-primary underline underline-offset-4" href="<?= base_url('services/cv-assessment') ?>">CV assessment</a>
                <a class="text-primary underline underline-offset-4" href="<?= base_url('career-services/start/rebuild_1799') ?>">Professional CV rebuild</a>
                <a class="text-primary underline underline-offset-4" href="<?= base_url('guides/interview-preparation-india') ?>">Interview preparation guide</a>
                <a class="text-primary underline underline-offset-4" href="<?= base_url('jobs') ?>">Current jobs</a>
            </div>
        </div>
    </div>
</section>

<section class="bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 py-5">
        <div class="rounded-2xl border border-primary/10 bg-primary/5 px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-sm text-gray-700 leading-relaxed"><span class="font-extrabold text-primary">Candidate safety:</span> HiredNext never charges candidates to apply for a job or secure placement. CV assessment, CV creation and career advisory are optional professional services and are handled separately from recruitment consideration.</p>
            <a href="<?= base_url('jobs') ?>" class="shrink-0 text-sm font-extrabold text-primary hover:text-accent">View open jobs →</a>
        </div>
    </div>
</section>

<section id="cv-offers" class="py-16 bg-gray-50">
    <?= view('pages/services/_candidate-offers', ['primaryOnly' => true]) ?>
</section>

<?= view('pages/services/_cv-rebuild-testimonials') ?>

<section id="interview-support" aria-labelledby="interview-support-title" class="py-16 bg-[#f6f0e7]">
    <div class="max-w-[1040px] mx-auto px-4 sm:px-8">
        <div class="max-w-3xl mb-8">
            <p class="text-accent text-xs font-black uppercase tracking-[0.2em] mb-3">Prepare for the conversation</p>
            <h2 id="interview-support-title" class="text-3xl md:text-4xl font-serif font-bold text-primary">Interview coming up? Know what to say.</h2>
            <p class="text-gray-600 mt-4">Explore written practice or speak 1-to-1 with Taru Shikha. Choose the support you need.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <article class="rounded-2xl border border-primary/15 bg-white p-8 flex flex-col">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-4">Practise your answers</p>
                <h3 class="text-3xl font-serif font-bold text-primary mb-3">Interview Ready</h3>
                <p class="text-2xl font-bold text-primary mb-4">₹999 <span class="text-sm font-normal text-gray-500">proposed price</span></p>
                <p class="text-gray-600 leading-relaxed mb-4">10 practice questions for your target job, help choosing examples from your experience, AI feedback on 5 answers you write, and a pack you can download.</p>
                <p class="text-sm text-gray-500 mb-6">The service is not open yet. See the example and register interest; no payment today.</p>
                <a href="<?= base_url('pilots/interview-ready.html?utm_source=website&utm_medium=candidate_services&utm_campaign=interview_ready') ?>" class="mt-auto inline-flex justify-center rounded-xl border border-primary/25 text-primary px-5 py-3 font-bold">Explore Interview Ready</a>
                <a href="<?= base_url('guides/interview-preparation-india') ?>" class="mt-3 text-center text-sm font-bold text-primary underline underline-offset-4">Read the interview preparation guide</a>
            </article>
            <article class="rounded-2xl border border-primary/15 bg-white p-8 flex flex-col">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-4">Speak with Taru Shikha</p>
                <h3 class="text-3xl font-serif font-bold text-primary mb-3">1-to-1 consultation</h3>
                <p class="text-2xl font-bold text-primary mb-4">₹4,500 <span class="text-sm font-normal text-gray-500">30 minutes</span></p>
                <p class="text-gray-600 leading-relaxed mb-4">Prepare your interview answers, explain your strengths clearly and get practical guidance from Taru Shikha, including company insights where available.</p>
                <p class="text-sm text-gray-500 mb-6">The HiredNext team shares her available slots by email and confirms the time with you.</p>
                <a href="<?= base_url('career-services/start/career_4500') ?>" class="mt-auto inline-flex justify-center rounded-xl bg-primary text-white px-5 py-3 font-bold">View consultation</a>
            </article>
        </div>
    </div>
</section>

<section id="cv-creation" class="py-20 bg-white">
<div class="max-w-[1180px] mx-auto px-4 sm:px-8">
    <div class="grid lg:grid-cols-12 gap-10 items-start">
        <div class="lg:col-span-5"><div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-4">Managed CV Creation</div><h2 class="text-3xl md:text-5xl font-serif font-bold text-primary">You do not fill a template. HiredNext builds the document.</h2><p class="text-gray-600 text-lg leading-relaxed mt-5">Start by uploading the CV you already use. We extract the career facts, review strengths and gaps, rewrite weak responsibilities into clearer evidence-led statements where the source supports them, and create the finished document in an ATS-safe HiredNext design direction.</p></div>
        <div class="lg:col-span-7 grid sm:grid-cols-2 gap-5">
            <?php foreach ([
                ['Recruiter-led narrative architecture','The CV is structured around what a recruiter needs to understand quickly: role level, scope, progression, achievements and relevant capability.'],
                ['Evidence before adjectives','Strong claims are tied to facts already present in the CV. Missing metrics or scale are flagged for clarification rather than invented.'],
                ['ATS-safe by construction','Standard headings, linear reading order, clean chronology and role-relevant terminology are prioritised over decorative layouts that can interfere with parsing.'],
                ['Finished by HiredNext','The candidate reviews a completed draft. They are not asked to rebuild the content or wrestle with columns, spacing and formatting themselves.'],
            ] as $item): ?><article class="rounded-2xl border border-gray-200 bg-white p-6"><h3 class="text-xl font-bold text-primary mb-3"><?= esc($item[0]) ?></h3><p class="text-gray-600 leading-relaxed"><?= esc($item[1]) ?></p></article><?php endforeach; ?>
        </div>
    </div>
</div>
</section>

<section class="py-20 bg-white">
<div class="max-w-[1180px] mx-auto px-4 sm:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12"><div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">3 ATS CV Design Directions</div><h2 class="text-3xl md:text-5xl font-serif font-bold text-primary">Premium enough for a human. Disciplined enough for an ATS.</h2><p class="text-gray-600 mt-4">The visual personality changes. The reading order stays clean. Final candidate CVs can be delivered without HiredNext branding.</p></div>
    <div class="grid md:grid-cols-3 gap-6">
        <?php foreach ([
            ['ATS Classic','The safest, cleanest direction for broad applications.','Single-column · standard section hierarchy · quiet executive typography'],
            ['ATS Modern','A sharper contemporary presentation without sacrificing source-order readability.','Modern accents · stronger hierarchy · clean recruiter scan'],
            ['Executive ATS','Designed for leadership careers where scale, mandate and outcomes need to lead.','Leadership impact · board/CXO readability · restrained executive styling'],
        ] as $i => $sample): ?>
            <article class="rounded-[1.75rem] border border-gray-200 overflow-hidden shadow-sm bg-white">
                <div class="h-[370px] bg-[#fbfbfa] p-6 relative overflow-hidden">
                    <div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none"><span class="-rotate-12 text-2xl font-black tracking-[0.18em] text-primary/10">SAMPLE PREVIEW</span></div>
                    <div class="text-[7px] leading-[1.4] text-gray-700" style="filter:blur(.42px);user-select:none">
                        <div class="<?= $i === 2 ? 'bg-primary text-white -mx-6 -mt-6 px-6 py-6 mb-4' : '' ?>"><div class="text-[18px] font-black <?= $i === 2 ? 'text-white' : 'text-primary' ?>">ARJUN MALHOTRA</div><div class="text-[8px] font-bold <?= $i === 1 ? 'text-accent' : '' ?>">SENIOR OPERATIONS & TRANSFORMATION LEADER</div><div class="mt-2">Mumbai · email@example.com · +91 98XXXXXX10</div></div>
                        <div class="border-b border-gray-300 pb-3 mb-3"><div class="font-black text-primary text-[9px]">PROFESSIONAL SUMMARY</div><div class="mt-1">Career summary rewritten to communicate seniority, operating scope, transformation experience and results with factual discipline.</div></div>
                        <div class="border-b border-gray-300 pb-3 mb-3"><div class="font-black text-primary text-[9px]">CORE COMPETENCIES</div><div class="mt-1">Strategy · Operations · Transformation · Cost Optimisation · Stakeholder Management · Team Leadership</div></div>
                        <div><div class="font-black text-primary text-[9px]">PROFESSIONAL EXPERIENCE</div><div class="font-black mt-2">XYZ MANUFACTURING PVT. LTD.</div><div>Operations Director · 2021–Present</div><ul class="list-disc ml-3 mt-1 space-y-1"><li>Achievement-led statement built from the source CV.</li><li>Sharper business language without fabricated outcomes.</li><li>Role-relevant evidence surfaced for recruiter scanning.</li></ul><div class="font-black mt-3">ABC INDUSTRIES LTD.</div><div>Senior Operations Manager · 2016–2020</div><ul class="list-disc ml-3 mt-1"><li>Earlier career condensed to preserve relevance and clarity.</li></ul></div>
                    </div>
                </div>
                <div class="p-6"><div class="text-xs font-black text-accent">OPTION <?= $i+1 ?></div><h3 class="text-2xl font-serif font-bold text-primary mt-1"><?= esc($sample[0]) ?></h3><p class="text-sm text-gray-600 mt-2"><?= esc($sample[1]) ?></p><p class="text-xs text-gray-400 mt-3"><?= esc($sample[2]) ?></p></div>
            </article>
        <?php endforeach; ?>
    </div>
    <p class="text-xs text-gray-400 text-center mt-5">Samples are intentionally softened and watermarked. Final paid CVs are delivered clean and high quality.</p>
</div>
</section>

<section class="py-20 bg-primary text-white">
<div class="max-w-[1180px] mx-auto px-4 sm:px-8 grid lg:grid-cols-2 gap-12 items-start">
    <div><div class="text-gold text-xs font-black uppercase tracking-[0.24em] mb-4">For senior professionals</div><h2 class="text-3xl md:text-4xl font-serif font-bold">The CV should make the scale of your career easier to understand.</h2><p class="text-white/70 mt-5 leading-relaxed">For experienced professionals, the issue is rarely a missing buzzword alone. It is often that responsibility, scale, progression and outcomes are buried inside dense job descriptions. HiredNext restructures the document so the reader can see the career logic faster.</p></div>
    <div class="grid sm:grid-cols-2 gap-4 text-sm text-white/85"><?php foreach (['Role and seniority positioning','Quantified impact where evidenced','Leadership and team scale','P&L / commercial exposure where stated','Career progression and transitions','ATS-safe headings and chronology','Relevant skills and role language','Board / stakeholder evidence for executives'] as $item): ?><div class="rounded-2xl border border-white/15 bg-white/5 p-5"><?= esc($item) ?></div><?php endforeach; ?></div>
</div>
</section>

<?= view('pages/services/_cv-service-faq') ?>
<?= $this->endSection() ?>
