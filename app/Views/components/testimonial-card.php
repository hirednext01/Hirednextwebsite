<?php
$item = $item ?? [];
$index = $index ?? 0;
$relationship = $relationship ?? 'employer';
$tone = $tone ?? 'light';
$knownRoleCompany = $knownRoleCompany ?? [];

$rating = (int)($item['rating'] ?? 0);
$proofType = $item['proof_type'] ?? $item['industry'] ?? $item['category'] ?? $item['project_type'] ?? 'Recruitment Feedback';
$headline = $item['headline'] ?? $item['title'] ?? $proofType;
$quote = $item['review'] ?? $item['comment'] ?? $item['review_text'] ?? $item['content'] ?? $item['testimonial'] ?? $item['message'] ?? '';
$name = $item['client_name'] ?? $item['name'] ?? ($relationship === 'placed_candidate' ? 'Placed candidate' : 'Hiring leader');
$role = trim((string)($item['designation'] ?? $item['role'] ?? $item['client_position'] ?? $item['location'] ?? ''));
$company = trim((string)($item['company'] ?? $item['organization'] ?? $item['client_company'] ?? ''));
if ($company === '' && isset($knownRoleCompany[$role])) {
    [$role, $company] = $knownRoleCompany[$role];
}

$sourceLabel = trim((string)($item['source_label'] ?? ''));
$sourceUrl = trim((string)($item['source_url'] ?? ''));
$linkedinUrl = trim((string)($item['linkedin_url'] ?? ''));
$helpReceived = trim((string)($item['help_received'] ?? ''));
$placementRole = trim((string)($item['placement_role'] ?? ''));
$placementLocation = trim((string)($item['placement_location'] ?? ''));
$placementYear = trim((string)($item['placement_year'] ?? ''));
$isCandidate = $relationship === 'placed_candidate';
$isDark = $tone === 'dark' && $index === 0;
$isWarm = $tone === 'warm' && $index === 0;

$cardClasses = $isDark
    ? 'bg-[#0a2b53] border-[#0a2b53] text-white'
    : ($isWarm ? 'bg-[#fff8ea] border-[#ead9b3] text-primary' : 'bg-white border-[#ece7dd] text-primary');
$mutedClasses = $isDark ? 'text-white/78' : 'text-gray-600';
$borderClasses = $isDark ? 'border-white/12' : 'border-[#ece7dd]';
?>

<article class="testimonial-luxe-card group relative overflow-hidden rounded-[1.75rem] border <?= $cardClasses ?> p-7 md:p-9 transition-all duration-500 hover:-translate-y-1">
    <?php if ($isDark): ?>
        <div class="absolute -top-24 -right-20 w-64 h-64 rounded-full bg-accent/10 blur-3xl"></div>
    <?php elseif ($isWarm): ?>
        <div class="absolute -top-24 -right-20 w-64 h-64 rounded-full bg-gold/15 blur-3xl"></div>
    <?php endif; ?>

    <div class="relative z-10 h-full flex flex-col">
        <div class="flex items-start justify-between gap-5 mb-8">
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1.5 rounded-full border <?= $isDark ? 'border-white/15 bg-white/5 text-white/65' : 'border-primary/10 bg-primary/[0.035] text-primary/65' ?> text-[9px] uppercase tracking-[0.18em] font-black">
                    <?= esc($isCandidate ? 'Placed candidate' : ($relationship === 'candidate_professional' ? 'Professional recommendation' : $proofType)) ?>
                </span>

                <?php if ($sourceUrl !== ''): ?>
                    <span class="px-3 py-1.5 rounded-full border <?= $isDark ? 'border-gold/25 bg-gold/10 text-gold' : 'border-[#e8dcc0] bg-[#fbf6e9] text-[#8b6d24]' ?> text-[9px] uppercase tracking-[0.18em] font-black">Public source</span>
                <?php elseif ($isCandidate): ?>
                    <span class="px-3 py-1.5 rounded-full border border-gray-200 bg-white/70 text-gray-500 text-[9px] uppercase tracking-[0.18em] font-black">Submitted to HiredNext</span>
                <?php elseif ($rating > 0): ?>
                    <span class="text-gold text-xs" aria-label="<?= esc((string)$rating) ?> out of 5 rating"><?php for ($i = 1; $i <= 5; $i++): ?><?= $i <= $rating ? '★' : '☆' ?><?php endfor; ?></span>
                <?php endif; ?>
            </div>

            <div class="testimonial-quote-mark text-6xl md:text-7xl <?= $isDark ? 'text-gold/65' : 'text-accent/30' ?> select-none" aria-hidden="true">“</div>
        </div>

        <?php if ($headline !== $proofType && !$isCandidate): ?>
            <h3 class="text-lg md:text-xl font-serif font-bold <?= $isDark ? 'text-white' : 'text-primary' ?> mb-3"><?= esc($headline) ?></h3>
        <?php endif; ?>

        <?php if ($isCandidate && ($placementRole !== '' || $placementLocation !== '' || $placementYear !== '')): ?>
            <div class="rounded-xl border <?= $isDark ? 'border-white/10 bg-white/5' : 'border-[#ead9b3] bg-white/55' ?> px-4 py-3 mb-5">
                <div class="text-[9px] uppercase tracking-[0.2em] <?= $isDark ? 'text-gold' : 'text-[#8b6d24]' ?> font-black mb-1">Placement through HiredNext</div>
                <div class="text-sm font-bold <?= $isDark ? 'text-white/85' : 'text-primary' ?>">
                    <?= esc(implode(' · ', array_filter([$placementRole, $placementLocation, $placementYear]))) ?>
                </div>
            </div>
        <?php elseif ($helpReceived !== ''): ?>
            <div class="text-[10px] font-black uppercase tracking-[0.2em] <?= $isDark ? 'text-gold' : 'text-accent' ?> mb-4"><?= esc($helpReceived) ?></div>
        <?php endif; ?>

        <blockquote class="text-[16px] md:text-[17px] <?= $mutedClasses ?> leading-[1.8] mb-8">
            <?= esc($quote) ?>
        </blockquote>

        <div class="mt-auto pt-6 border-t <?= $borderClasses ?> flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
            <div class="min-w-0">
                <div class="testimonial-person-name text-xl md:text-2xl font-bold <?= $isDark ? 'text-white' : 'text-primary' ?> leading-tight"><?= esc($name) ?></div>
                <?php if (!$isCandidate && $role !== ''): ?>
                    <div class="mt-2 text-[10px] md:text-[11px] uppercase tracking-[0.18em] font-extrabold <?= $isDark ? 'text-gold/85' : 'text-accent' ?> leading-relaxed"><?= esc($role) ?></div>
                <?php elseif ($isCandidate): ?>
                    <div class="mt-2 text-[10px] md:text-[11px] uppercase tracking-[0.18em] font-extrabold <?= $isDark ? 'text-gold/85' : 'text-accent' ?> leading-relaxed">Client name withheld</div>
                <?php endif; ?>
                <?php if ($company !== '' && !$isCandidate): ?>
                    <div class="mt-1.5 text-sm font-semibold <?= $isDark ? 'text-white/55' : 'text-primary/55' ?> leading-relaxed"><?= esc($company) ?></div>
                <?php endif; ?>
            </div>

            <div class="shrink-0">
                <?php if ($sourceUrl !== ''): ?>
                    <a href="<?= esc($sourceUrl) ?>" target="_blank" rel="noopener noreferrer external" class="inline-flex items-center gap-2 text-xs font-extrabold <?= $isDark ? 'text-gold hover:text-white' : 'text-accent hover:text-primary' ?> transition-colors" aria-label="View public source for <?= esc($name) ?>">
                        View <?= esc($sourceLabel ?: 'public source') ?> <span aria-hidden="true">↗</span>
                    </a>
                <?php elseif ($isCandidate && $linkedinUrl !== ''): ?>
                    <a href="<?= esc($linkedinUrl) ?>" target="_blank" rel="noopener noreferrer external" class="inline-flex items-center gap-2 text-xs font-extrabold text-primary hover:text-accent transition-colors" aria-label="View LinkedIn profile for <?= esc($name) ?>">
                        LinkedIn profile <span aria-hidden="true">↗</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
