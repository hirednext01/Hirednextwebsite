<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$eyebrow = $eyebrow ?? 'HiredNext Career Services';
$headline = $headline ?? '';
$intro = $intro ?? '';
$price = $price ?? '';
$priceNote = $priceNote ?? '';
$ctaLabel = $ctaLabel ?? 'Start now';
$ctaUrl = $ctaUrl ?? base_url('services/candidates');
$forWhom = $forWhom ?? [];
$deliverables = $deliverables ?? [];
$faq = $faq ?? [];
$quickAnswer = $quickAnswer ?? '';
$whyHiredNext = $whyHiredNext ?? [];
$authorityLinks = $authorityLinks ?? [];
$showRebuildTestimonials = $showRebuildTestimonials ?? false;
?>

<section class="relative pt-32 pb-20 bg-primary text-white overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent/15 rounded-full blur-3xl"></div>
    <div class="max-w-[1100px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="max-w-4xl">
            <div class="text-gold text-xs font-black uppercase tracking-[0.25em] mb-5"><?= esc($eyebrow) ?></div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight"><?= esc($headline) ?></h1>
            <p class="text-lg md:text-xl text-white/80 leading-relaxed max-w-3xl mt-6"><?= esc($intro) ?></p>
            <div class="flex flex-col sm:flex-row gap-4 mt-8 items-start sm:items-center">
                <a href="<?= esc($ctaUrl) ?>" class="inline-flex justify-center rounded-full bg-accent px-8 py-4 font-black text-white"><?= esc($ctaLabel) ?></a>
                <div>
                    <div class="text-2xl font-black"><?= esc($price) ?></div>
                    <div class="text-sm text-white/60"><?= esc($priceNote) ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($quickAnswer !== ''): ?>
<section class="py-10 bg-white">
    <div class="max-w-[980px] mx-auto px-4 sm:px-8">
        <div class="rounded-[1.75rem] border border-primary/10 bg-primary/5 p-7 md:p-9">
            <div class="text-accent text-xs font-black uppercase tracking-[0.22em]">Quick answer</div>
            <p class="mt-4 text-lg md:text-xl leading-relaxed text-gray-800"><?= esc($quickAnswer) ?></p>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="py-16 bg-white">
    <div class="max-w-[1100px] mx-auto px-4 sm:px-8 grid lg:grid-cols-2 gap-10">
        <div>
            <div class="text-accent text-xs font-black uppercase tracking-[0.2em] mb-3">Who this is for</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">Use this service when it solves the actual problem.</h2>
            <div class="mt-6 space-y-3">
                <?php foreach ($forWhom as $item): ?>
                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-700"><?= esc($item) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <div>
            <div class="text-accent text-xs font-black uppercase tracking-[0.2em] mb-3">What you receive</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">A defined deliverable, not vague career advice.</h2>
            <div class="mt-6 space-y-3">
                <?php foreach ($deliverables as $item): ?>
                    <div class="flex gap-3 rounded-xl border border-primary/10 bg-white px-5 py-4 shadow-sm"><span class="text-accent font-black">✓</span><span class="text-gray-700"><?= esc($item) ?></span></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($whyHiredNext)): ?>
<section class="py-16 bg-primary text-white">
    <div class="max-w-[1100px] mx-auto px-4 sm:px-8 grid lg:grid-cols-[.8fr_1.2fr] gap-8 items-start">
        <div>
            <div class="text-gold text-xs font-black uppercase tracking-[0.2em]">Why HiredNext</div>
            <h2 class="mt-3 text-3xl md:text-4xl font-serif font-bold">CV writing informed by the hiring side of the table.</h2>
        </div>
        <div class="grid gap-3">
            <?php foreach ($whyHiredNext as $item): ?>
            <div class="rounded-xl border border-white/15 bg-white/5 px-5 py-4 text-white/85"><?= esc($item) ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($authorityLinks)): ?>
<section class="py-12 bg-white">
    <div class="max-w-[1100px] mx-auto px-4 sm:px-8">
        <div class="text-accent text-xs font-black uppercase tracking-[0.2em]">Before you choose a provider</div>
        <h2 class="mt-2 text-3xl font-serif font-bold text-primary">Compare the service, the process and the evidence.</h2>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            <?php foreach ($authorityLinks as $link): ?>
            <a href="<?= base_url($link['url']) ?>" class="rounded-2xl border border-gray-200 p-5 font-bold text-primary hover:border-accent hover:shadow-md"><?= esc($link['label']) ?> →</a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($showRebuildTestimonials): ?>
<?= view('pages/services/_cv-rebuild-testimonials') ?>
<?php endif; ?>

<section class="py-16 bg-[#f6f0e7]">
    <div class="max-w-[1100px] mx-auto px-4 sm:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <div class="text-accent text-xs font-black uppercase tracking-[0.2em]">HiredNext service ladder</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mt-3">Choose the service that matches the problem</h2>
            <p class="text-gray-600 mt-3">You do not need to buy every service. Move up only when the extra work is genuinely useful.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach ([
                ['CV Assessment','₹992 + GST','services/cv-assessment'],
                ['ATS CV Optimisation','₹999','services/ats-cv-optimisation'],
                ['Professional CV Rebuild','₹2,500 + GST','services/professional-cv-rebuild'],
                ['Assessment + Rebuild','₹3,317.40 + GST','services/cv-assessment-rebuild-bundle'],
                ['Executive CV','₹6,999','services/executive-cv'],
                ['LinkedIn Leadership','₹8,999 + GST','services/linkedin-leadership-positioning'],
                ['Interview Coaching','₹4,500','services/interview-coaching'],
            ] as $service): ?>
                <a href="<?= base_url($service[2]) ?>" class="rounded-2xl border border-gray-200 bg-white p-5 hover:border-primary hover:shadow-md transition">
                    <div class="text-xs font-black text-accent"><?= esc($service[1]) ?></div>
                    <div class="text-lg font-serif font-bold text-primary mt-2"><?= esc($service[0]) ?></div>
                </a>
            <?php endforeach; ?>
        </div>
        <p class="text-xs text-gray-500 text-center mt-6">A clearer CV and stronger positioning can make relevant career evidence easier to recognise. Hiring outcomes still depend on the role, the employer and the wider selection process.</p>
    </div>
</section>

<?php if (!empty($faq)): ?>
<section class="py-16 bg-white">
    <div class="max-w-[900px] mx-auto px-4 sm:px-8">
        <div class="text-center mb-8"><h2 class="text-3xl font-serif font-bold text-primary">Common questions</h2></div>
        <div class="space-y-3">
            <?php foreach ($faq as $item): ?>
                <details class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                    <summary class="font-bold text-primary cursor-pointer"><?= esc($item['q'] ?? '') ?></summary>
                    <p class="mt-3 text-gray-600 leading-relaxed"><?= esc($item['a'] ?? '') ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?= $this->endSection() ?>
