<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $mediaAuthority = config('MediaAuthority'); ?>

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

<section class="py-14 md:py-16 bg-[#f4f6f8]">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="relative overflow-hidden rounded-[2.25rem] bg-primary border border-primary/10 shadow-2xl shadow-primary/10">
            <div class="absolute -top-24 -right-20 w-72 h-72 rounded-full bg-accent/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-28 left-1/3 w-80 h-80 rounded-full bg-gold/10 blur-3xl pointer-events-none"></div>

            <div class="relative grid lg:grid-cols-[0.82fr_1.18fr] items-stretch">
                <div class="p-5 md:p-7 lg:p-8">
                    <div class="relative h-full min-h-[360px] md:min-h-[440px] rounded-[1.65rem] overflow-hidden ring-1 ring-white/10 bg-white/5">
                        <img src="<?= base_url('theme/about.png') ?>" alt="Taru Shikha, Founder of HiredNext" class="absolute inset-0 w-full h-full object-cover object-top" loading="lazy">
                        <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-primary/80 to-transparent"></div>
                        <div class="absolute left-5 bottom-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-primary/70 backdrop-blur-md px-4 py-2 text-[10px] font-black uppercase tracking-[0.22em] text-white">
                            Founder · HiredNext
                        </div>
                    </div>
                </div>

                <div class="relative flex flex-col justify-center p-8 md:p-12 lg:p-14 xl:p-16">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="h-px w-10 bg-gold"></span>
                        <span class="text-gold text-[11px] font-black uppercase tracking-[0.3em]">Founder perspective</span>
                    </div>

                    <h2 class="text-3xl md:text-4xl lg:text-[2.75rem] font-serif font-bold text-white leading-[1.08] mb-6">Recruitment is still a judgement business.</h2>
                    <p class="text-lg md:text-xl text-white/72 leading-relaxed mb-7 max-w-3xl">“Technology should help us see more clearly and move faster. It should not replace the responsibility a recruiter has when recommending one person over another.”</p>

                    <div class="flex items-end justify-between gap-6 flex-wrap border-b border-white/10 pb-6 mb-6">
                        <div>
                            <div class="text-lg font-extrabold text-white">Taru Shikha</div>
                            <div class="text-sm text-white/55 mt-1">Founder, HiredNext Recruitment</div>
                        </div>
                        <div class="flex flex-wrap gap-x-5 gap-y-2 text-[10px] uppercase tracking-[0.18em] font-bold text-white/45">
                            <span>Executive Search</span>
                            <span>Recruitment Intelligence</span>
                            <span>Human-led · AI-assisted</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="<?= base_url('about/taru-shikha') ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-full bg-accent text-white font-extrabold text-sm shadow-lg shadow-accent/10 hover:-translate-y-0.5 transition-transform">Founder profile</a>
                        <?php if ($mediaAuthority): ?>
                            <a href="<?= esc($mediaAuthority->founderLinkedIn) ?>" target="_blank" rel="noopener noreferrer external" class="inline-flex items-center justify-center px-5 py-2.5 rounded-full border border-white/20 bg-white/5 text-white font-bold text-sm hover:bg-white/10 transition-colors">Taru on LinkedIn ↗</a>
                            <a href="<?= esc($mediaAuthority->companyLinkedIn) ?>" target="_blank" rel="noopener noreferrer external" class="inline-flex items-center justify-center px-5 py-2.5 rounded-full border border-white/20 bg-white/5 text-white font-bold text-sm hover:bg-white/10 transition-colors">HiredNext on LinkedIn ↗</a>
                        <?php endif; ?>
                    </div>
                </div>
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