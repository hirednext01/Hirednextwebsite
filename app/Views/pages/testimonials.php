<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min';
$items = $testimonials ?? [];
?>

<header class="bg-primary text-white pt-28 pb-12 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[360px] h-[360px] bg-accent/12 rounded-full blur-[110px] -mr-28 -mt-28"></div>
    <div class="max-w-[1180px] mx-auto px-6 relative z-10">
        <div class="max-w-4xl">
            <div class="text-gold text-[11px] font-black uppercase tracking-[0.28em] mb-3">Testimonials & Recommendations</div>
            <h1 class="text-4xl md:text-5xl font-serif font-bold leading-tight mb-4">What people say about HiredNext</h1>
            <p class="text-base md:text-lg text-white/70 leading-relaxed max-w-3xl">Public LinkedIn recommendations, employer endorsements and candidate feedback — with source links wherever public proof is available.</p>
        </div>
    </div>
</header>

<section class="bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="text-[10px] uppercase tracking-[0.22em] text-accent font-black mb-1">Your story matters</div>
            <p class="text-sm md:text-base text-gray-600">Did HiredNext help you get hired or move your career forward? Tell us about the journey.</p>
        </div>
        <a href="<?= base_url('testimonials/share') ?>" class="shrink-0 inline-flex justify-center px-6 py-3 rounded-xl bg-primary text-white font-extrabold text-sm hover:bg-accent transition">Leave a testimonial →</a>
    </div>
</section>

<section class="py-12 md:py-16 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div class="max-w-3xl">
                <div class="text-accent text-[10px] font-black uppercase tracking-[0.25em] mb-2">Recruitment reputation</div>
                <h2 class="text-2xl md:text-3xl font-serif font-bold text-primary">Evidence from people, partners and professionals</h2>
            </div>
            <p class="text-sm text-gray-500 max-w-md">Public recommendations link to their source. Directly submitted testimonials are clearly identified as HiredNext submissions.</p>
        </div>

        <div id="testimonialGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <?php
                    $rating = (int)($item['rating'] ?? 0);
                    $proofType = $item['proof_type'] ?? $item['industry'] ?? $item['category'] ?? $item['project_type'] ?? 'Recruitment Feedback';
                    $headline = $item['headline'] ?? $item['title'] ?? $proofType;
                    $quote = $item['review'] ?? $item['comment'] ?? $item['review_text'] ?? $item['content'] ?? $item['testimonial'] ?? $item['message'] ?? '';
                    $name = $item['client_name'] ?? $item['name'] ?? 'Client';
                    $role = trim((string)($item['designation'] ?? $item['role'] ?? $item['client_position'] ?? ''));
                    $company = trim((string)($item['company'] ?? $item['organization'] ?? $item['client_company'] ?? ''));
                    $sourceLabel = trim((string)($item['source_label'] ?? ''));
                    $sourceUrl = trim((string)($item['source_url'] ?? ''));
                    $linkedinUrl = trim((string)($item['linkedin_url'] ?? ''));
                    $submittedVia = trim((string)($item['submitted_via'] ?? ''));
                    $helpReceived = trim((string)($item['help_received'] ?? ''));
                    $isCandidateSubmission = $submittedVia === 'candidate_testimonial_form';
                    ?>
                    <article class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col">
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            <span class="px-3 py-1 rounded-full bg-primary/5 text-[10px] uppercase tracking-[0.14em] font-black text-primary"><?= esc($proofType) ?></span>
                            <?php if ($sourceUrl !== ''): ?>
                                <span class="px-3 py-1 rounded-full bg-green-50 text-[10px] uppercase tracking-[0.14em] font-black text-green-700">Public source</span>
                            <?php elseif ($isCandidateSubmission): ?>
                                <span class="px-3 py-1 rounded-full bg-gray-100 text-[10px] uppercase tracking-[0.14em] font-black text-gray-500">Submitted to HiredNext</span>
                            <?php elseif ($rating > 0): ?>
                                <span class="text-accent text-xs" aria-label="<?= esc((string)$rating) ?> out of 5 rating"><?php for ($i = 1; $i <= 5; $i++): ?><?= $i <= $rating ? '★' : '☆' ?><?php endfor; ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if ($headline !== $proofType): ?><h3 class="text-lg font-bold text-primary mb-3"><?= esc($headline) ?></h3><?php endif; ?>
                        <?php if ($helpReceived !== ''): ?><div class="text-xs font-bold text-accent mb-3"><?= esc($helpReceived) ?></div><?php endif; ?>
                        <p class="text-[15px] text-gray-600 leading-relaxed mb-6">“<?= esc($quote) ?>”</p>

                        <div class="mt-auto pt-5 border-t border-gray-100">
                            <div class="font-extrabold text-primary text-sm"><?= esc($name) ?></div>
                            <?php if ($role !== '' || $company !== ''): ?>
                                <div class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    <?= esc($role) ?><?= $role !== '' && $company !== '' ? ' · ' : '' ?><?= esc($company) ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-4 flex flex-wrap gap-3">
                                <?php if ($sourceUrl !== ''): ?>
                                    <a href="<?= esc($sourceUrl) ?>" target="_blank" rel="noopener noreferrer external" class="text-xs font-extrabold text-accent">View <?= esc($sourceLabel ?: 'public source') ?> →</a>
                                <?php elseif ($isCandidateSubmission && $linkedinUrl !== ''): ?>
                                    <a href="<?= esc($linkedinUrl) ?>" target="_blank" rel="noopener noreferrer external" class="text-xs font-extrabold text-primary">LinkedIn profile →</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="md:col-span-2 xl:col-span-3 bg-white border border-gray-200 rounded-2xl p-10 text-center text-gray-500">Testimonials will appear here once available.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-14 text-center bg-white border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Hiring a critical role?</h2>
        <p class="text-gray-500 mb-7">Speak directly with HiredNext about executive search, leadership hiring or a difficult specialist mandate in India.</p>
        <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-8 py-4 bg-primary text-white rounded-xl font-extrabold hover:bg-accent transition">Book a 30-Min Call →</a>
    </div>
</section>

<?= $this->endSection() ?>
