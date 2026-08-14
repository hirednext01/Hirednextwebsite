<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min';
$items = $testimonials ?? [];
$employerItems = $employerTestimonials ?? [];
$placedCandidateItems = $placedCandidateTestimonials ?? [];
$professionalItems = $professionalTestimonials ?? [];
$publishedCount = count($items);
$knownRoleCompany = [
    'CEO, Stellar Manufacturing' => ['CEO', 'Stellar Manufacturing'],
    'Senior Director, Marriott International' => ['Senior Director', 'Marriott International'],
    'Country Head, Mirza Bangla' => ['Country Head', 'Mirza Bangla'],
    'Founder, Meeraki Bizz' => ['Founder', 'Meeraki Bizz'],
    'Senior Consultant, Capgemini' => ['Senior Consultant', 'Capgemini'],
];
?>

<style>
    .testimonial-luxe-card {
        box-shadow: 0 18px 55px rgba(12, 52, 102, 0.07);
    }
    .testimonial-luxe-card:hover {
        box-shadow: 0 28px 70px rgba(12, 52, 102, 0.12);
    }
    .testimonial-quote-mark {
        font-family: 'DM Serif Display', serif;
        line-height: .65;
    }
    .testimonial-person-name {
        font-family: 'DM Serif Display', serif;
        letter-spacing: -0.015em;
    }
</style>

<header class="relative overflow-hidden bg-[#071f3d] text-white pt-28 pb-14 md:pb-16">
    <div class="absolute inset-0 opacity-40" style="background: radial-gradient(circle at 80% 10%, rgba(255,78,22,.20), transparent 34%), radial-gradient(circle at 5% 90%, rgba(212,175,55,.14), transparent 32%);"></div>
    <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-white/25 to-transparent"></div>

    <div class="max-w-[1180px] mx-auto px-6 relative z-10">
        <div class="grid lg:grid-cols-12 gap-10 items-end">
            <div class="lg:col-span-8">
                <div class="inline-flex items-center gap-3 text-gold text-[10px] font-black uppercase tracking-[0.34em] mb-5">
                    <span class="w-8 h-px bg-gold/70"></span>
                    Reputation, in their words
                </div>
                <h1 class="text-4xl md:text-6xl font-serif font-bold leading-[1.03] max-w-4xl mb-5">
                    Senior voices.<br><span class="text-white/65">Real recruitment experiences.</span>
                </h1>
                <p class="text-base md:text-lg text-white/65 leading-relaxed max-w-3xl">
                    Employer recommendations and placed-candidate stories are presented as two different kinds of evidence — clearly labelled, never blended together.
                </p>
            </div>

            <div class="lg:col-span-4 lg:pl-8">
                <div class="border-l border-white/15 pl-6 py-1">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-white/45 font-black mb-2">Published proof</div>
                    <div class="grid grid-cols-2 gap-5 mb-3">
                        <div>
                            <span class="block text-3xl font-serif text-white"><?= esc((string)count($employerItems)) ?></span>
                            <span class="text-[10px] uppercase tracking-[0.16em] text-white/45">Employer voices</span>
                        </div>
                        <div>
                            <span class="block text-3xl font-serif text-gold"><?= esc((string)count($placedCandidateItems)) ?></span>
                            <span class="text-[10px] uppercase tracking-[0.16em] text-white/45">Placed candidates</span>
                        </div>
                    </div>
                    <p class="text-xs text-white/45 leading-relaxed"><?= esc((string)$publishedCount) ?> published recommendations and stories in total. Public sources remain linked wherever available.</p>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="bg-[#f7f5f0] border-b border-[#e8e3d9]">
    <div class="max-w-[1180px] mx-auto px-6 py-6 md:py-7 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
        <div class="flex items-start gap-4 max-w-3xl">
            <div class="mt-1 w-9 h-9 rounded-full border border-[#d9d1c3] bg-white flex items-center justify-center text-accent font-serif text-xl shrink-0">“</div>
            <div>
                <div class="text-[10px] uppercase tracking-[0.24em] text-primary/55 font-black mb-1">Placed through HiredNext?</div>
                <p class="text-sm md:text-base text-gray-600 leading-relaxed">Share the candidate side of the placement—the opportunity, interviews, decision, offer and transition. Every submission is reviewed before publication.</p>
            </div>
        </div>
        <a href="<?= base_url('testimonials/share') ?>" class="shrink-0 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-primary text-white font-extrabold text-sm hover:bg-accent transition-colors duration-300">
            Share your placement story <span aria-hidden="true">↗</span>
        </a>
    </div>
</section>

<section class="py-10 bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-4">
            <a href="#employer-testimonials" class="group rounded-2xl border border-gray-200 p-5 flex items-center justify-between gap-5 hover:border-accent transition">
                <div>
                    <div class="text-[10px] uppercase tracking-[0.22em] text-accent font-black mb-1">For employers</div>
                    <div class="text-xl font-serif font-bold text-primary">What clients and hiring leaders say</div>
                </div>
                <span class="text-2xl text-primary/30 group-hover:text-accent">↓</span>
            </a>
            <a href="#placed-candidate-stories" class="group rounded-2xl border border-[#ead9b3] bg-[#fffaf0] p-5 flex items-center justify-between gap-5 hover:border-gold transition">
                <div>
                    <div class="text-[10px] uppercase tracking-[0.22em] text-[#8b6d24] font-black mb-1">For candidates</div>
                    <div class="text-xl font-serif font-bold text-primary">Stories from people HiredNext placed</div>
                </div>
                <span class="text-2xl text-[#8b6d24]/40 group-hover:text-[#8b6d24]">↓</span>
            </a>
        </div>
    </div>
</section>

<section id="employer-testimonials" class="py-14 md:py-20 bg-[#fbfaf7] scroll-mt-24">
    <div class="max-w-[1180px] mx-auto px-6">
        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 mb-10 md:mb-14 items-end">
            <div class="lg:col-span-8">
                <div class="text-accent text-[10px] font-black uppercase tracking-[0.3em] mb-3">Clients and hiring leaders</div>
                <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary leading-tight">What employers say about<br><span class="text-primary/45">candidate quality and delivery.</span></h2>
            </div>
            <div class="lg:col-span-4">
                <p class="text-sm text-gray-500 leading-relaxed">These recommendations describe the employer side of HiredNext’s work. Public-source recommendations link back to the original source.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <?php if (!empty($employerItems)): ?>
                <?php foreach ($employerItems as $index => $item): ?>
                    <?= view('components/testimonial-card', ['item' => $item, 'index' => $index, 'relationship' => 'employer', 'tone' => 'dark', 'knownRoleCompany' => $knownRoleCompany]) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="lg:col-span-2 bg-white border border-[#ece7dd] rounded-[1.75rem] p-12 text-center">
                    <div class="font-serif text-3xl text-primary mb-3">Employer recommendations are being curated.</div>
                    <p class="text-gray-500">Approved client and hiring-leader feedback will appear here.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="placed-candidate-stories" class="py-14 md:py-20 bg-[#f7f5f0] border-y border-[#e8e3d9] scroll-mt-24">
    <div class="max-w-[1180px] mx-auto px-6">
        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 mb-10 md:mb-14 items-end">
            <div class="lg:col-span-8">
                <div class="text-[#8b6d24] text-[10px] font-black uppercase tracking-[0.3em] mb-3">Placed candidate stories</div>
                <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary leading-tight">The career move,<br><span class="text-primary/45">in the candidate’s own words.</span></h2>
            </div>
            <div class="lg:col-span-4">
                <p class="text-sm text-gray-500 leading-relaxed">These stories come from professionals HiredNext helped place. They are submitted directly, reviewed before publication and never presented as independent ratings.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <?php if (!empty($placedCandidateItems)): ?>
                <?php foreach ($placedCandidateItems as $index => $item): ?>
                    <?= view('components/testimonial-card', ['item' => $item, 'index' => $index, 'relationship' => 'placed_candidate', 'tone' => 'warm', 'knownRoleCompany' => $knownRoleCompany]) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="lg:col-span-2 rounded-[1.75rem] border border-[#ead9b3] bg-[#fffaf0] p-8 md:p-12 grid md:grid-cols-[1fr_auto] gap-8 items-center">
                    <div>
                        <div class="font-serif text-3xl text-primary mb-3">This collection starts with the people we placed.</div>
                        <p class="text-gray-600 leading-relaxed max-w-2xl">If HiredNext helped you join a role, share what made the opportunity relevant and how the search, interviews, decision or transition was handled.</p>
                    </div>
                    <a href="<?= base_url('testimonials/share') ?>" class="inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-black text-white hover:bg-accent transition">Share your placement story →</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (!empty($professionalItems)): ?>
    <section class="py-14 bg-white">
        <div class="max-w-[1180px] mx-auto px-6">
            <div class="mb-9 max-w-3xl">
                <div class="text-accent text-[10px] font-black uppercase tracking-[0.3em] mb-3">Additional public recommendations</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">Professional and career-support feedback</h2>
                <p class="text-gray-500 mt-3 leading-relaxed">These recommendations remain visible but are not represented as confirmed HiredNext placement stories.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                <?php foreach ($professionalItems as $index => $item): ?>
                    <?= view('components/testimonial-card', ['item' => $item, 'index' => $index, 'relationship' => 'candidate_professional', 'tone' => 'light', 'knownRoleCompany' => $knownRoleCompany]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="relative overflow-hidden py-16 md:py-20 bg-[#071f3d] text-white">
    <div class="absolute -right-24 -bottom-32 w-96 h-96 rounded-full bg-accent/10 blur-[110px]"></div>
    <div class="max-w-[1180px] mx-auto px-6 relative z-10">
        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            <div class="lg:col-span-8">
                <div class="text-gold text-[10px] font-black uppercase tracking-[0.3em] mb-3">A critical hire deserves senior attention</div>
                <h2 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4">Need a search partner who will challenge the brief, not just send CVs?</h2>
                <p class="text-white/60 max-w-3xl leading-relaxed">Speak directly with HiredNext about executive search, leadership hiring or a difficult specialist mandate in India.</p>
            </div>
            <div class="lg:col-span-4 lg:text-right">
                <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-3 px-7 py-4 rounded-full bg-accent text-white font-extrabold hover:bg-white hover:text-primary transition-colors duration-300">
                    Book a 30-Min Call <span aria-hidden="true">↗</span>
                </a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
