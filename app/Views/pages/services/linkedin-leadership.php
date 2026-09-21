<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$plan = $plan ?? [];
?>

<section class="relative overflow-hidden bg-primary pt-32 pb-24 text-white">
    <div class="absolute -top-28 -right-20 h-96 w-96 rounded-full bg-accent/15 blur-3xl"></div>
    <div class="relative z-10 mx-auto grid max-w-[1180px] gap-12 px-4 sm:px-8 lg:grid-cols-[1.12fr_.88fr] lg:items-center">
        <div>
            <div class="mb-5 text-xs font-black uppercase tracking-[0.28em] text-gold">LinkedIn Leadership Positioning</div>
            <h1 class="max-w-4xl font-serif text-4xl font-bold leading-tight md:text-6xl">Your LinkedIn profile is often read before you enter the room.</h1>
            <p class="mt-6 max-w-3xl text-lg leading-relaxed text-white/80">Senior hiring teams, executive-search professionals, founders, investors, clients and industry peers use LinkedIn to understand who you are before a conversation begins. HiredNext helps rebuild that narrative so your leadership scope, evidence and point of view are easier to recognise.</p>

            <div class="mt-8 flex flex-wrap items-end gap-5">
                <div>
                    <div class="text-sm font-bold uppercase tracking-wider text-white/50">Regular service value</div>
                    <div class="mt-1 text-2xl font-black text-white/55 line-through">₹17,500 + GST</div>
                </div>
                <div class="rounded-2xl border border-gold/30 bg-white/10 px-5 py-4">
                    <div class="text-xs font-black uppercase tracking-[0.2em] text-gold">Campaign price</div>
                    <div class="mt-1 text-4xl font-black">₹8,999 + GST</div>
                    <div class="mt-1 text-sm text-white/65">₹10,619 payable including GST, rounded to the nearest rupee</div>
                </div>
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="<?= base_url('career-services/start/linkedin_8999') ?>" class="inline-flex justify-center rounded-full bg-accent px-8 py-4 font-black text-white">Build My LinkedIn Leadership Narrative</a>
                <a href="#what-we-rebuild" class="inline-flex justify-center rounded-full border border-white/20 px-8 py-4 font-black text-white">See What We Rebuild</a>
            </div>
        </div>

        <aside class="rounded-[2rem] border border-white/15 bg-white/10 p-7 shadow-2xl backdrop-blur">
            <div class="text-xs font-black uppercase tracking-[0.22em] text-gold">Confidential by design</div>
            <h2 class="mt-3 font-serif text-3xl font-bold">Your career story stays yours.</h2>
            <p class="mt-4 leading-relaxed text-white/75">A standard HiredNext NDA is shared before the assessment round. Profile materials, assessment answers and strategic positioning inputs are kept within the delivery team and are not shared externally for this service without your consent.</p>
            <div class="mt-6 grid gap-3 text-sm">
                <div class="rounded-xl border border-white/10 bg-white/5 p-4">✓ Senior LinkedIn specialist panel</div>
                <div class="rounded-xl border border-white/10 bg-white/5 p-4">✓ Deep analytical assessment round</div>
                <div class="rounded-xl border border-white/10 bg-white/5 p-4">✓ Leadership narrative architecture</div>
                <div class="rounded-xl border border-white/10 bg-white/5 p-4">✓ Human review before final handover</div>
            </div>
        </aside>
    </div>
</section>

<section class="bg-white py-20">
    <div class="mx-auto max-w-[1180px] px-4 sm:px-8">
        <div class="mx-auto max-w-4xl text-center">
            <div class="text-xs font-black uppercase tracking-[0.24em] text-accent">Why LinkedIn positioning matters</div>
            <h2 class="mt-3 font-serif text-3xl font-bold text-primary md:text-5xl">A senior profile is not an online CV. It is a public leadership narrative.</h2>
            <p class="mt-5 text-lg leading-relaxed text-gray-600">LinkedIn is where people form an impression of your level, relevance and credibility—sometimes before they ever ask for your CV. The right profile helps the reader understand the arc of your career rather than decode a list of job titles.</p>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ([
                ['Executive search & hiring teams','Search consultants and hiring leaders use LinkedIn to map talent, validate career progression and identify relevant senior professionals.'],
                ['Founders, boards & investors','Leadership appointments increasingly begin with quiet research. Your public profile can shape whether a conversation starts at all.'],
                ['Clients & strategic partners','A senior profile also communicates expertise, credibility and the problems you are trusted to solve outside a formal job search.'],
                ['Industry peers','Your positioning influences invitations, referrals, speaking opportunities and the professional network that forms around you.'],
                ['Recruiter search visibility','Clear role language, expertise and career evidence can make your profile easier to discover for relevant searches.'],
                ['Your future narrative','The strongest profile explains not only what you have done, but what your body of work says about the leader you are becoming.'],
            ] as $item): ?>
            <article class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                <h3 class="text-xl font-bold text-primary"><?= esc($item[0]) ?></h3>
                <p class="mt-3 leading-relaxed text-gray-600"><?= esc($item[1]) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="bg-[#f6f0e7] py-20" id="what-we-rebuild">
    <div class="mx-auto grid max-w-[1180px] gap-12 px-4 sm:px-8 lg:grid-cols-[.92fr_1.08fr] lg:items-start">
        <div>
            <div class="text-xs font-black uppercase tracking-[0.24em] text-accent">The assessment round</div>
            <h2 class="mt-3 font-serif text-3xl font-bold text-primary md:text-5xl">We go deeper than “make my About section better.”</h2>
            <p class="mt-5 text-lg leading-relaxed text-gray-600">The engagement starts with analytical questions designed to understand the leadership story behind the chronology: the mandates you were trusted with, the scale you handled, the decisions you made, the outcomes you influenced, and the direction you want the market to associate with your name.</p>
            <div class="mt-7 space-y-3 text-sm text-gray-700">
                <?php foreach ([
                    'What do you want to be known for at this stage of your career?',
                    'Which mandates changed the trajectory of a business, function or team?',
                    'Where is your real leadership scale hidden behind a modest title?',
                    'Which achievements are commercially important but poorly explained today?',
                    'Who should discover you—and what should they understand within the first 20 seconds?',
                    'What future roles, sectors, boards, clients or geographies should the profile support?',
                ] as $q): ?>
                <div class="rounded-xl border border-primary/10 bg-white px-5 py-4"><span class="mr-2 font-black text-accent">→</span><?= esc($q) ?></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <?php foreach ([
                ['Headline strategy','A headline that communicates level, functional identity and relevant authority—not a string of generic keywords.'],
                ['About narrative','A concise leadership story that makes career logic, operating scale and professional point of view easier to understand.'],
                ['Experience architecture','Reframe major roles around mandates, decisions, scope and evidence rather than copying the CV into LinkedIn.'],
                ['Featured & proof','Identify what should be surfaced as proof: case studies, interviews, articles, talks, projects or selected work.'],
                ['Skills & discoverability','Calibrate skills and role language so the profile is aligned to the work you actually want to be discovered for.'],
                ['Authority roadmap','Define practical themes you can speak about consistently so your public presence reinforces the positioning.'],
            ] as $item): ?>
            <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-bold text-primary"><?= esc($item[0]) ?></h3>
                <p class="mt-3 text-sm leading-relaxed text-gray-600"><?= esc($item[1]) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="bg-white py-20">
    <div class="mx-auto max-w-[1180px] px-4 sm:px-8">
        <div class="mx-auto max-w-4xl text-center">
            <div class="text-xs font-black uppercase tracking-[0.24em] text-accent">Illustrative transformation preview</div>
            <h2 class="mt-3 font-serif text-3xl font-bold text-primary md:text-5xl">See how stronger positioning changes perception.</h2>
            <p class="mt-4 text-gray-600">The profile below is a deliberately anonymised, illustrative example of the design and positioning direction—not a claim that every profile will generate the sample metrics shown.</p>
        </div>

        <div class="mt-10 overflow-hidden rounded-[2rem] border border-primary/15 bg-[#f8fafc] shadow-2xl">
            <div class="grid lg:grid-cols-[1fr_320px]">
                <div class="p-5 md:p-8">
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <div class="flex items-center gap-3 border-b border-gray-200 bg-[#f3f6f8] px-5 py-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded bg-[#0a66c2] text-xl font-black text-white">in</div>
                            <div class="h-9 flex-1 rounded-full bg-white"></div>
                            <div class="hidden gap-5 text-[10px] font-bold text-gray-500 md:flex"><span>Home</span><span>My Network</span><span>Jobs</span><span>Messaging</span></div>
                        </div>
                        <div class="relative h-44 bg-gradient-to-r from-[#112f4c] via-[#31556f] to-[#9d7b45]">
                            <div class="absolute inset-0 opacity-30 blur-sm" style="background:radial-gradient(circle at 30% 40%,#fff 0,transparent 20%),radial-gradient(circle at 70% 60%,#c9a86a 0,transparent 22%)"></div>
                            <div class="absolute bottom-5 right-6 text-right text-xs font-black uppercase tracking-[0.25em] text-white/80">Leadership builds<br>brighter tomorrows</div>
                        </div>
                        <div class="relative px-6 pb-7">
                            <div class="-mt-14 h-28 w-28 rounded-full border-4 border-white bg-gray-300 shadow-lg" style="filter:blur(6px)"></div>
                            <div class="mt-4 max-w-3xl">
                                <div class="h-6 w-48 rounded bg-gray-300" style="filter:blur(4px)"></div>
                                <p class="mt-3 text-lg font-semibold text-gray-800">Transforming businesses through people, innovation and purpose.</p>
                                <p class="mt-1 text-sm text-gray-500">Board Advisor · Former C-Suite Executive · Strategic Growth · Leadership</p>
                            </div>
                            <div class="mt-7 grid gap-4 md:grid-cols-[1.15fr_.85fr]">
                                <div class="rounded-xl border border-gray-200 p-5">
                                    <div class="font-black text-gray-800">About</div>
                                    <p class="mt-3 text-sm leading-relaxed text-gray-600">A focused executive narrative connecting scale, transformation, commercial impact and leadership philosophy—written so the reader understands the value of the career rather than only the chronology.</p>
                                </div>
                                <div class="rounded-xl border border-gray-200 p-5">
                                    <div class="font-black text-gray-800">Featured leadership proof</div>
                                    <div class="mt-3 h-20 rounded-lg bg-gray-100" style="filter:blur(2px)"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="bg-primary p-7 text-white md:p-9">
                    <div class="text-xs font-black uppercase tracking-[0.22em] text-gold">Illustrative visibility panel</div>
                    <h3 class="mt-3 font-serif text-3xl font-bold">The kind of attention a stronger presence is built to support.</h3>
                    <div class="mt-8 space-y-6">
                        <div class="border-b border-white/15 pb-5"><div class="text-4xl font-black text-gold">50K+</div><div class="mt-1 text-sm text-white/70">illustrative impressions</div></div>
                        <div class="border-b border-white/15 pb-5"><div class="text-4xl font-black text-gold">20K+</div><div class="mt-1 text-sm text-white/70">illustrative likes / engagements</div></div>
                        <div class="border-b border-white/15 pb-5"><div class="text-4xl font-black text-gold">8K+</div><div class="mt-1 text-sm text-white/70">illustrative profile views</div></div>
                        <div><div class="text-xl font-black text-white">Stronger recruiter visibility</div><div class="mt-1 text-sm text-white/60">through clearer positioning and relevant authority</div></div>
                    </div>
                    <p class="mt-8 text-xs leading-relaxed text-white/45">Illustrative only. These figures are not a guaranteed outcome and are not presented as verified results for a named HiredNext client.</p>
                </aside>
            </div>
        </div>
    </div>
</section>

<section class="bg-primary py-20 text-white">
    <div class="mx-auto max-w-[1180px] px-4 sm:px-8">
        <div class="grid gap-10 lg:grid-cols-[1fr_.85fr] lg:items-center">
            <div>
                <div class="text-xs font-black uppercase tracking-[0.24em] text-gold">Senior specialist panel</div>
                <h2 class="mt-3 font-serif text-3xl font-bold md:text-5xl">Strategy first. Writing second.</h2>
                <p class="mt-5 max-w-3xl text-lg leading-relaxed text-white/75">Senior LinkedIn specialists work on the positioning and planning with HiredNext. The goal is not to make every profile sound impressive. It is to make the right leadership evidence, language and direction visible without exaggerating what the career actually contains.</p>
            </div>
            <div class="rounded-[2rem] border border-white/15 bg-white/5 p-7">
                <div class="text-sm font-black text-gold">WHAT YOU RECEIVE</div>
                <ul class="mt-5 space-y-3 text-sm text-white/85">
                    <li>✓ Deep analytical assessment questionnaire</li>
                    <li>✓ Leadership positioning and audience strategy</li>
                    <li>✓ Headline and About narrative architecture</li>
                    <li>✓ Experience-section rewriting framework</li>
                    <li>✓ Featured, skills and proof recommendations</li>
                    <li>✓ Authority/content themes for future visibility</li>
                    <li>✓ Senior specialist review</li>
                    <li>✓ Standard NDA before the assessment round</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-20">
    <div class="mx-auto max-w-[980px] px-4 text-center sm:px-8">
        <div class="text-xs font-black uppercase tracking-[0.24em] text-accent">Campaign access</div>
        <h2 class="mt-3 font-serif text-4xl font-bold text-primary md:text-5xl">Build the profile that represents the leader you have become.</h2>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-5">
            <div class="text-xl font-black text-gray-400 line-through">₹17,500 + GST</div>
            <div class="text-4xl font-black text-primary">₹8,999 + GST</div>
        </div>
        <p class="mt-3 text-sm text-gray-500">Campaign saving: ₹8,501 before GST · ₹10,619 payable including GST, rounded to the nearest rupee.</p>
        <a href="<?= base_url('career-services/start/linkedin_8999') ?>" class="mt-8 inline-flex rounded-full bg-accent px-9 py-4 font-black text-white">Start My LinkedIn Leadership Positioning</a>
        <p class="mx-auto mt-5 max-w-2xl text-xs leading-relaxed text-gray-500">Profile positioning can improve clarity, discoverability and professional presentation. Reach, engagement, opportunities and hiring outcomes depend on many factors and are not guaranteed.</p>
    </div>
</section>


<section class="bg-[#f6f0e7] py-16">
    <div class="mx-auto max-w-[1100px] px-4 sm:px-8">
        <div class="text-xs font-black uppercase tracking-[0.22em] text-accent">Career intelligence</div>
        <h2 class="mt-3 font-serif text-3xl font-bold text-primary">Understand the strategy before you rebuild the profile.</h2>
        <div class="mt-7 grid gap-4 md:grid-cols-2">
            <a href="<?= base_url('guides/linkedin-profile-optimisation-india') ?>" class="rounded-2xl border border-primary/10 bg-white p-6 hover:border-primary hover:shadow-md"><strong class="text-primary">LinkedIn Profile Optimisation in India</strong><p class="mt-2 text-sm text-gray-600">What senior professionals should fix first across headline, About, experience, proof and discoverability.</p></a>
            <a href="<?= base_url('guides/executive-linkedin-profile-india') ?>" class="rounded-2xl border border-primary/10 bg-white p-6 hover:border-primary hover:shadow-md"><strong class="text-primary">Executive LinkedIn Profile in India</strong><p class="mt-2 text-sm text-gray-600">How CXO, VP and Director profiles should communicate mandate, scale and leadership evidence.</p></a>
        </div>
        <a href="<?= base_url('career-intelligence') ?>" class="mt-6 inline-flex text-sm font-black text-primary underline underline-offset-4">View all HiredNext Career Intelligence →</a>
    </div>
</section>

<?= $this->endSection() ?>
