<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min';
$items = $testimonials ?? [];
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
                    Recommendations from hiring leaders, clients and professionals who have worked with HiredNext — with public source links wherever independent proof is available.
                </p>
            </div>

            <div class="lg:col-span-4 lg:pl-8">
                <div class="border-l border-white/15 pl-6 py-1">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-white/45 font-black mb-2">Published proof</div>
                    <div class="flex items-end gap-3 mb-3">
                        <span class="text-4xl font-serif text-white"><?= esc((string)$publishedCount) ?></span>
                        <span class="text-sm text-white/55 pb-1">stories & recommendations</span>
                    </div>
                    <p class="text-xs text-white/45 leading-relaxed">Public recommendations remain linked to their original source. Candidate-submitted stories are clearly identified.</p>
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
                <div class="text-[10px] uppercase tracking-[0.24em] text-primary/55 font-black mb-1">Your experience belongs here too</div>
                <p class="text-sm md:text-base text-gray-600 leading-relaxed">If HiredNext helped with a role, a career move or a difficult hiring mandate, share the journey. Every submission is reviewed before publication.</p>
            </div>
        </div>
        <a href="<?= base_url('testimonials/share') ?>" class="shrink-0 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-primary text-white font-extrabold text-sm hover:bg-accent transition-colors duration-300">
            Share your story <span aria-hidden="true">↗</span>
        </a>
    </div>
</section>

<section class="py-14 md:py-20 bg-[#fbfaf7]">
    <div class="max-w-[1180px] mx-auto px-6">
        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 mb-10 md:mb-14 items-end">
            <div class="lg:col-span-8">
                <div class="text-accent text-[10px] font-black uppercase tracking-[0.3em] mb-3">Source-linked reputation</div>
                <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary leading-tight">Proof should feel personal.<br><span class="text-primary/45">And remain verifiable.</span></h2>
            </div>
            <div class="lg:col-span-4">
                <p class="text-sm text-gray-500 leading-relaxed">We do not turn candidate submissions into third-party reviews. Public-source recommendations are labeled separately from stories submitted directly to HiredNext.</p>
            </div>
        </div>

        <div id="testimonialGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $index => $item): ?>
                    <?php
                    $rating = (int)($item['rating'] ?? 0);
                    $proofType = $item['proof_type'] ?? $item['industry'] ?? $item['category'] ?? $item['project_type'] ?? 'Recruitment Feedback';
                    $headline = $item['headline'] ?? $item['title'] ?? $proofType;
                    $quote = $item['review'] ?? $item['comment'] ?? $item['review_text'] ?? $item['content'] ?? $item['testimonial'] ?? $item['message'] ?? '';
                    $name = $item['client_name'] ?? $item['name'] ?? 'Client';
                    $role = trim((string)($item['designation'] ?? $item['role'] ?? $item['client_position'] ?? $item['location'] ?? ''));
                    $company = trim((string)($item['company'] ?? $item['organization'] ?? $item['client_company'] ?? ''));
                    if ($company === '' && isset($knownRoleCompany[$role])) {
                        [$role, $company] = $knownRoleCompany[$role];
                    }
                    $sourceLabel = trim((string)($item['source_label'] ?? ''));
                    $sourceUrl = trim((string)($item['source_url'] ?? ''));
                    $linkedinUrl = trim((string)($item['linkedin_url'] ?? ''));
                    $submittedVia = trim((string)($item['submitted_via'] ?? ''));
                    $helpReceived = trim((string)($item['help_received'] ?? ''));
                    $isCandidateSubmission = $submittedVia === 'candidate_testimonial_form';
                    $isDark = $index === 0;
                    ?>

                    <article class="testimonial-luxe-card group relative overflow-hidden rounded-[1.75rem] border <?= $isDark ? 'bg-[#0a2b53] border-[#0a2b53] text-white' : 'bg-white border-[#ece7dd] text-primary' ?> p-7 md:p-9 transition-all duration-500 hover:-translate-y-1">
                        <?php if ($isDark): ?>
                            <div class="absolute -top-24 -right-20 w-64 h-64 rounded-full bg-accent/10 blur-3xl"></div>
                        <?php endif; ?>

                        <div class="relative z-10 h-full flex flex-col">
                            <div class="flex items-start justify-between gap-5 mb-8">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-3 py-1.5 rounded-full border <?= $isDark ? 'border-white/15 bg-white/5 text-white/65' : 'border-primary/10 bg-primary/[0.035] text-primary/65' ?> text-[9px] uppercase tracking-[0.18em] font-black"><?= esc($proofType) ?></span>

                                    <?php if ($sourceUrl !== ''): ?>
                                        <span class="px-3 py-1.5 rounded-full border <?= $isDark ? 'border-gold/25 bg-gold/10 text-gold' : 'border-[#e8dcc0] bg-[#fbf6e9] text-[#8b6d24]' ?> text-[9px] uppercase tracking-[0.18em] font-black">Source verified</span>
                                    <?php elseif ($isCandidateSubmission): ?>
                                        <span class="px-3 py-1.5 rounded-full border <?= $isDark ? 'border-white/10 bg-white/5 text-white/50' : 'border-gray-200 bg-gray-50 text-gray-500' ?> text-[9px] uppercase tracking-[0.18em] font-black">Candidate submitted</span>
                                    <?php elseif ($rating > 0): ?>
                                        <span class="text-gold text-xs" aria-label="<?= esc((string)$rating) ?> out of 5 rating"><?php for ($i = 1; $i <= 5; $i++): ?><?= $i <= $rating ? '★' : '☆' ?><?php endfor; ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="testimonial-quote-mark text-6xl md:text-7xl <?= $isDark ? 'text-gold/65' : 'text-accent/30' ?> select-none" aria-hidden="true">“</div>
                            </div>

                            <?php if ($headline !== $proofType): ?>
                                <h3 class="text-lg md:text-xl font-serif font-bold <?= $isDark ? 'text-white' : 'text-primary' ?> mb-3"><?= esc($headline) ?></h3>
                            <?php endif; ?>

                            <?php if ($helpReceived !== ''): ?>
                                <div class="text-[10px] font-black uppercase tracking-[0.2em] <?= $isDark ? 'text-gold' : 'text-accent' ?> mb-4"><?= esc($helpReceived) ?></div>
                            <?php endif; ?>

                            <blockquote class="text-[16px] md:text-[17px] <?= $isDark ? 'text-white/78' : 'text-gray-600' ?> leading-[1.8] mb-8">
                                <?= esc($quote) ?>
                            </blockquote>

                            <div class="mt-auto pt-6 border-t <?= $isDark ? 'border-white/12' : 'border-[#ece7dd]' ?> flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
                                <div class="min-w-0">
                                    <div class="testimonial-person-name text-xl md:text-2xl font-bold <?= $isDark ? 'text-white' : 'text-primary' ?> leading-tight"><?= esc($name) ?></div>
                                    <?php if ($role !== ''): ?>
                                        <div class="mt-2 text-[10px] md:text-[11px] uppercase tracking-[0.18em] font-extrabold <?= $isDark ? 'text-gold/85' : 'text-accent' ?> leading-relaxed"><?= esc($role) ?></div>
                                    <?php endif; ?>
                                    <?php if ($company !== ''): ?>
                                        <div class="mt-1.5 text-sm font-semibold <?= $isDark ? 'text-white/55' : 'text-primary/55' ?> leading-relaxed"><?= esc($company) ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="shrink-0">
                                    <?php if ($sourceUrl !== ''): ?>
                                        <a href="<?= esc($sourceUrl) ?>" target="_blank" rel="noopener noreferrer external" class="inline-flex items-center gap-2 text-xs font-extrabold <?= $isDark ? 'text-gold hover:text-white' : 'text-accent hover:text-primary' ?> transition-colors" aria-label="View public source for <?= esc($name) ?>">
                                            View <?= esc($sourceLabel ?: 'public source') ?> <span aria-hidden="true">↗</span>
                                        </a>
                                    <?php elseif ($isCandidateSubmission && $linkedinUrl !== ''): ?>
                                        <a href="<?= esc($linkedinUrl) ?>" target="_blank" rel="noopener noreferrer external" class="inline-flex items-center gap-2 text-xs font-extrabold <?= $isDark ? 'text-white/70 hover:text-white' : 'text-primary hover:text-accent' ?> transition-colors" aria-label="View LinkedIn profile for <?= esc($name) ?>">
                                            LinkedIn profile <span aria-hidden="true">↗</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="lg:col-span-2 bg-white border border-[#ece7dd] rounded-[1.75rem] p-12 text-center">
                    <div class="font-serif text-3xl text-primary mb-3">Stories are being curated.</div>
                    <p class="text-gray-500">Published recommendations and candidate stories will appear here once reviewed.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

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
