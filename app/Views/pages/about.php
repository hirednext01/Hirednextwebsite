<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="hero-about relative pt-36 pb-24 overflow-hidden text-white">
    <div class="hero-overlay"></div>
    <div class="hero-sheen"></div>
    <div class="hero-noise"></div>
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/15 rounded-full text-[11px] uppercase tracking-[0.28em] font-bold mb-7">
                <span class="h-2 w-2 rounded-full bg-gold"></span>
                About HiredNext
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold leading-tight mb-6">
                Human judgement.<br><span class="text-accent">Technology-enabled hiring.</span>
            </h1>
            <p class="text-lg md:text-xl text-white/80 leading-relaxed max-w-3xl mb-8">
                HiredNext combines experienced recruiters, sector knowledge and responsible use of AI and automation to help companies identify, assess and engage stronger talent.
            </p>
            <div class="flex flex-wrap gap-x-7 gap-y-3 text-xs uppercase tracking-[0.18em] text-white/65 font-bold">
                <span>10+ years</span>
                <span>1500+ placements</span>
                <span>25+ industries</span>
                <span>Human-led decisions</span>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid lg:grid-cols-2 gap-14 items-start">
            <div>
                <div class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-3">What we believe</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-6">Recruitment should become more intelligent without becoming less human.</h2>
                <p class="text-gray-600 leading-relaxed mb-5">
                    Technology can help recruiters process information faster, identify patterns and keep candidates engaged. But hiring decisions still require context, judgement, motivation assessment and an understanding of people that cannot be reduced to a score.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Our approach is therefore human-led and AI-assisted: recruiters own the mandate and the final assessment, while technology supports screening, research, workflow automation and candidate engagement where it adds value.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="rounded-2xl bg-gray-50 border border-gray-200 p-6">
                    <div class="text-sm font-black text-accent mb-2">Human judgement</div>
                    <p class="text-sm text-gray-600 leading-relaxed">Experienced recruiters calibrate the role, assess evidence and make the final recommendation.</p>
                </div>
                <div class="rounded-2xl bg-gray-50 border border-gray-200 p-6">
                    <div class="text-sm font-black text-accent mb-2">AI-assisted screening</div>
                    <p class="text-sm text-gray-600 leading-relaxed">AI can support CV parsing, candidate-role matching and structured review to help recruiters focus attention faster.</p>
                </div>
                <div class="rounded-2xl bg-gray-50 border border-gray-200 p-6">
                    <div class="text-sm font-black text-accent mb-2">Automation</div>
                    <p class="text-sm text-gray-600 leading-relaxed">Workflow automation can support outreach, scheduling, reminders, follow-ups and repetitive coordination.</p>
                </div>
                <div class="rounded-2xl bg-gray-50 border border-gray-200 p-6">
                    <div class="text-sm font-black text-accent mb-2">Assessment depth</div>
                    <p class="text-sm text-gray-600 leading-relaxed">Psychometric or other structured assessments can be added when the client and role genuinely require them.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-3">AI-enabled recruitment</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Where technology can support the hiring process</h2>
            <p class="text-gray-600 leading-relaxed">We use or can introduce technology selectively depending on the mandate. The objective is better signal and faster execution, not automation for its own sake.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <article class="bg-white border border-gray-200 rounded-2xl p-7 shadow-sm">
                <h3 class="text-xl font-bold text-primary mb-3">AI screening & role matching</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Structured CV review, skill and experience extraction, keyword and role-fit signals, followed by recruiter validation.</p>
            </article>
            <article class="bg-white border border-gray-200 rounded-2xl p-7 shadow-sm">
                <h3 class="text-xl font-bold text-primary mb-3">Automated candidate engagement</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Automated messages, reminders and follow-ups can reduce delays while keeping recruiter ownership of important conversations.</p>
            </article>
            <article class="bg-white border border-gray-200 rounded-2xl p-7 shadow-sm">
                <h3 class="text-xl font-bold text-primary mb-3">AI-assisted calling</h3>
                <p class="text-sm text-gray-600 leading-relaxed">For suitable high-volume workflows, AI-assisted or automated calling can support first-touch screening, confirmations and scheduling, with human escalation where needed.</p>
            </article>
            <article class="bg-white border border-gray-200 rounded-2xl p-7 shadow-sm">
                <h3 class="text-xl font-bold text-primary mb-3">Interview intelligence</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Structured scorecards, note summaries and evidence capture can make evaluation more consistent across interviewers.</p>
            </article>
            <article class="bg-white border border-gray-200 rounded-2xl p-7 shadow-sm">
                <h3 class="text-xl font-bold text-primary mb-3">Psychometric assessments</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Psychometric testing can be incorporated on request when it is relevant to the role, seniority and client assessment philosophy.</p>
            </article>
            <article class="bg-white border border-gray-200 rounded-2xl p-7 shadow-sm">
                <h3 class="text-xl font-bold text-primary mb-3">Recruitment analytics</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Pipeline visibility, response patterns and hiring-stage data can help clients and recruiters identify bottlenecks and improve decisions.</p>
            </article>
        </div>

        <div class="mt-8 rounded-2xl bg-primary text-white p-6 md:p-7 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <p class="text-sm md:text-base text-white/80 leading-relaxed max-w-4xl"><strong class="text-white">Responsible use matters.</strong> AI-generated signals are treated as decision support, not as an automatic hiring verdict. Final recommendations remain with recruiters and hiring stakeholders.</p>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-3">Our process</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Strategy first. Technology where useful. Recruiter judgement throughout.</h2>
            <p class="text-gray-600 leading-relaxed">Every mandate starts with understanding the business problem before choosing sourcing channels, automation or assessment tools.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php
            $steps = [
                ['01', 'Strategise the mandate', 'Clarify why the role exists, business outcomes, must-have evidence, culture context, compensation, location and decision-makers.'],
                ['02', 'Map the talent market', 'Identify target companies, adjacent talent pools, relevant industries and realistic candidate availability before outreach starts.'],
                ['03', 'Source & engage', 'Combine recruiter networks, direct search, databases and appropriate automation to reach relevant active and passive talent.'],
                ['04', 'Screen intelligently', 'Use structured recruiter screening supported by AI-assisted parsing or matching where useful, then validate the evidence through human conversation.'],
                ['05', 'Evaluate deeply', 'Assess achievements, scale, motivation, communication, leadership context and role fit. Add psychometric or other structured testing when requested and relevant.'],
                ['06', 'Present, close & support', 'Share evidence-led shortlists, coordinate interviews, manage feedback and offers, and support the candidate through joining.'],
            ];
            ?>
            <?php foreach ($steps as $step): ?>
                <article class="rounded-2xl border border-gray-200 p-7 bg-white hover:shadow-md transition-shadow">
                    <div class="text-accent text-sm font-black mb-4"><?= esc($step[0]) ?></div>
                    <h3 class="text-xl font-bold text-primary mb-3"><?= esc($step[1]) ?></h3>
                    <p class="text-sm text-gray-600 leading-relaxed"><?= esc($step[2]) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid lg:grid-cols-12 gap-10 items-center bg-white border border-gray-100 rounded-[2rem] p-7 md:p-10 shadow-sm">
            <div class="lg:col-span-4">
                <div class="rounded-[1.5rem] overflow-hidden max-w-[320px] mx-auto">
                    <img src="<?= base_url('theme/about.png') ?>" alt="Taru Shikha, Founder of HiredNext" class="w-full h-auto" loading="lazy">
                </div>
            </div>
            <div class="lg:col-span-8">
                <div class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-3">Founder perspective</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-5">Recruitment is still a judgement business.</h2>
                <p class="text-lg text-gray-600 leading-relaxed mb-5">“Technology should help us see more clearly and move faster. It should not replace the responsibility a recruiter has when recommending one person over another.”</p>
                <div class="font-bold text-primary">Taru Shikha</div>
                <div class="text-sm text-gray-500">Founder, HiredNext</div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-5">Planning a critical hire?</h2>
        <p class="text-white/75 mb-8">Tell us what the business needs from the role. We’ll help shape the search and assessment approach around it.</p>
        <a href="<?= base_url('services/clients') ?>" class="inline-flex px-8 py-4 rounded-full bg-accent text-white font-bold">Explore Services for Clients</a>
    </div>
</section>

<?= $this->endSection() ?>
