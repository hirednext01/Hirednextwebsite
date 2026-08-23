<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-24 bg-primary text-white overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent/15 rounded-full blur-3xl"></div>
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="max-w-4xl">
            <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-5">For Candidates</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-6">Career advisory for senior professionals who need clarity, positioning and interview strategy.</h1>
            <p class="text-lg md:text-xl text-white/78 leading-relaxed max-w-3xl">HiredNext combines recruiter-informed career advisory with practical CV, positioning and interview support for professionals navigating a senior move, leadership transition or difficult career decision.</p>
        </div>
    </div>
</section>

<section class="bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 py-5">
        <div class="rounded-2xl border border-primary/10 bg-primary/5 px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-sm text-gray-700 leading-relaxed">
                <span class="font-extrabold text-primary">Candidate safety:</span> HiredNext does not charge candidates to apply for a job or secure placement. Optional career services shown on this page are separately priced.
            </p>
            <a href="<?= base_url('jobs') ?>" class="shrink-0 text-sm font-extrabold text-primary hover:text-accent">View open jobs →</a>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid lg:grid-cols-12 gap-10 items-start">
            <div class="lg:col-span-5">
                <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-4">Senior Career Advisory</div>
                <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary mb-6">What career advisory should solve for an experienced professional</h2>
                <p class="text-gray-600 text-lg leading-relaxed">At senior levels, the problem is often not “how do I write a CV?” It is deciding what role to target, how to explain the value you bring, which achievements matter, how to frame a transition and how to present yourself credibly to recruiters, founders, CEOs and boards.</p>
            </div>
            <div class="lg:col-span-7 grid sm:grid-cols-2 gap-5">
                <article class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h3 class="text-xl font-bold text-primary mb-3">Role & transition clarity</h3>
                    <p class="text-gray-600 leading-relaxed">Clarify the next role, level, sector or functional move you are actually targeting and identify where your background transfers strongly — and where it does not.</p>
                </article>
                <article class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h3 class="text-xl font-bold text-primary mb-3">Leadership positioning</h3>
                    <p class="text-gray-600 leading-relaxed">Translate responsibilities into evidence of scale, decisions, transformation, commercial impact and people leadership so your profile reads like a senior operator rather than a job description.</p>
                </article>
                <article class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h3 class="text-xl font-bold text-primary mb-3">Interview narrative</h3>
                    <p class="text-gray-600 leading-relaxed">Prepare a coherent explanation of your career choices, achievements, difficult outcomes, leadership style, motivation and why the next mandate makes sense.</p>
                </article>
                <article class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h3 class="text-xl font-bold text-primary mb-3">Search strategy</h3>
                    <p class="text-gray-600 leading-relaxed">Decide how to use recruiters, professional networks, targeted companies, LinkedIn and direct conversations without turning a senior job search into indiscriminate applications.</p>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
            <article class="rounded-[2rem] border border-gray-200 p-7 shadow-sm">
                <div class="text-sm font-black text-accent mb-2">FREE · 7–10 DAYS</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">CV Assessment</h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Understand the strengths, gaps and obvious shortlisting issues in your current CV.</p>
                <a href="<?= base_url('services/cv-assessment') ?>" class="font-bold text-primary hover:text-accent">Assess my CV →</a>
            </article>

            <article class="rounded-[2rem] border-2 border-accent p-7 shadow-sm">
                <div class="text-sm font-black text-accent mb-2">₹599 · 12 HOURS</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">Priority CV Assessment</h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Get a faster, role-aware review before an application, recruiter conversation or interview.</p>
                <a href="<?= base_url('services/cv-assessment') ?>#assessment-form" class="font-bold text-primary hover:text-accent">Get priority review →</a>
            </article>

            <article class="rounded-[2rem] border border-gray-200 p-7 shadow-sm">
                <div class="text-sm font-black text-accent mb-2">₹2,500</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">Get a New CV Made</h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">A recruiter-informed CV rebuild focused on clarity, stronger positioning and the information hiring teams look for.</p>
                <a href="<?= base_url('contact') ?>?service=cv-rebuild" class="font-bold text-primary hover:text-accent">Request a CV rebuild →</a>
            </article>

            <article class="rounded-[2rem] border border-gray-200 p-7 shadow-sm">
                <div class="text-sm font-black text-accent mb-2">₹12,500 · 60 MIN</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">Senior Career & Interview Strategy</h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Work through target roles, CV and LinkedIn positioning, career story, leadership evidence and interview strategy with a recruiter-informed perspective.</p>
                <a href="<?= base_url('contact') ?>?service=senior-career-advisory" class="font-bold text-primary hover:text-accent">Discuss my career strategy →</a>
            </article>
        </div>
        <p class="mt-7 text-xs text-gray-500">These services improve positioning, decision-making and preparation; hiring and interview outcomes remain at the employer's discretion.</p>
    </div>
</section>

<section class="py-20 bg-primary text-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <div>
                <div class="text-gold text-xs font-black uppercase tracking-[0.24em] mb-4">When senior professionals seek advice</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mb-5">Career situations where a recruiter-informed view can help</h2>
                <p class="text-white/75 leading-relaxed">A useful session is not designed to tell you what you want to hear. It should help you test whether your target is realistic, identify gaps in how you present your track record and make clearer choices about the next move.</p>
            </div>
            <ul class="grid sm:grid-cols-2 gap-4 text-sm text-white/85">
                <li class="rounded-2xl border border-white/15 bg-white/5 p-5">Moving from functional head to CXO or business leadership</li>
                <li class="rounded-2xl border border-white/15 bg-white/5 p-5">Returning to the market after a long tenure with one company</li>
                <li class="rounded-2xl border border-white/15 bg-white/5 p-5">Explaining a career break, redundancy or difficult exit</li>
                <li class="rounded-2xl border border-white/15 bg-white/5 p-5">Changing sector while preserving seniority and credibility</li>
                <li class="rounded-2xl border border-white/15 bg-white/5 p-5">Repeatedly reaching interviews but not closing senior roles</li>
                <li class="rounded-2xl border border-white/15 bg-white/5 p-5">Choosing between stability, scope, title, compensation and career risk</li>
            </ul>
        </div>
    </div>
</section>

<?php if (!empty($faq)): ?>
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-8">
        <div class="text-center mb-12">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Senior Career Advisory FAQ</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">Questions senior professionals ask before seeking career advice</h2>
        </div>
        <div class="space-y-5">
            <?php foreach ($faq as $item): ?>
                <article class="rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-primary mb-3"><?= esc($item['q']) ?></h3>
                    <p class="text-gray-600 leading-relaxed"><?= esc($item['a']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-5">Not sure which service fits you?</h2>
        <p class="text-white/75 mb-8">Start with the free CV assessment if the immediate problem is your profile. If the bigger question is what role to target and how to position a senior move, use the career strategy option.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= base_url('services/cv-assessment') ?>" class="inline-flex justify-center px-8 py-4 rounded-full bg-accent text-white font-bold">Start with a Free CV Assessment</a>
            <a href="<?= base_url('contact') ?>?service=senior-career-advisory" class="inline-flex justify-center px-8 py-4 rounded-full border border-white/30 bg-white/10 text-white font-bold">Discuss Senior Career Strategy</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
