<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-24 bg-primary text-white overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent/15 rounded-full blur-3xl"></div>
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="max-w-4xl">
            <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-5">HiredNext Career Services</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-6">Give us the CV you have. We rebuild the CV you should be sending.</h1>
            <p class="text-lg md:text-xl text-white/78 leading-relaxed max-w-3xl">Your experience may be strong while the document undersells it. HiredNext reviews the evidence in your current CV, identifies what a recruiter or ATS may miss, rewrites the career story and creates the finished CV for you.</p>
            <div class="flex flex-col sm:flex-row gap-3 mt-8"><a href="<?= base_url('services/cv-assessment') ?>" class="inline-flex justify-center rounded-full bg-accent px-7 py-3.5 font-black text-white">Upload my current CV</a><a href="#cv-creation" class="inline-flex justify-center rounded-full border border-white/25 bg-white/5 px-7 py-3.5 font-black text-white">See how HiredNext rebuilds it</a></div>
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

<section id="cv-creation" class="py-20 bg-gray-50">
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

<section class="py-20 bg-gray-50">
<?= view('pages/services/_candidate-offers') ?>
</section>

<section class="py-20 bg-primary text-white">
<div class="max-w-[1180px] mx-auto px-4 sm:px-8 grid lg:grid-cols-2 gap-12 items-start">
    <div><div class="text-gold text-xs font-black uppercase tracking-[0.24em] mb-4">For senior professionals</div><h2 class="text-3xl md:text-4xl font-serif font-bold">The CV should make the scale of your career easier to understand.</h2><p class="text-white/70 mt-5 leading-relaxed">For experienced professionals, the issue is rarely a missing buzzword alone. It is often that responsibility, scale, progression and outcomes are buried inside dense job descriptions. HiredNext restructures the document so the reader can see the career logic faster.</p></div>
    <div class="grid sm:grid-cols-2 gap-4 text-sm text-white/85"><?php foreach (['Role and seniority positioning','Quantified impact where evidenced','Leadership and team scale','P&L / commercial exposure where stated','Career progression and transitions','ATS-safe headings and chronology','Relevant skills and role language','Board / stakeholder evidence for executives'] as $item): ?><div class="rounded-2xl border border-white/15 bg-white/5 p-5"><?= esc($item) ?></div><?php endforeach; ?></div>
</div>
</section>

<?= $this->endSection() ?>