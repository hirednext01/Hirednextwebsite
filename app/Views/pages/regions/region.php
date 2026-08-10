<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$region = $region ?? [];
$h1 = $region['h1'] ?? 'Leadership Hiring';
$intro = $region['intro'] ?? '';
$focus = $region['focus'] ?? [];
$approach = $region['approach'] ?? [];
$ctaTitle = $region['cta_title'] ?? 'Get in Touch';
$ctaDescription = $region['cta_description'] ?? 'Share your hiring brief and timelines. We will respond with a search plan.';
?>

<header class="relative bg-primary pt-36 pb-24 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-accent/20 blur-3xl rounded-full"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-gold/10 blur-3xl rounded-full"></div>
    <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <nav class="flex items-center gap-2 text-sm text-white/70 mb-8">
            <a href="<?= base_url() ?>" class="hover:text-accent transition">Home</a><span>/</span>
            <a href="<?= base_url() ?>#leadership-hiring" class="hover:text-accent transition">Leadership Hiring</a><span>/</span>
            <span class="text-gold font-semibold"><?= esc($region['label'] ?? 'Region') ?></span>
        </nav>

        <div class="max-w-4xl">
            <span class="inline-block px-4 py-1.5 bg-gold/20 text-gold font-bold text-xs uppercase tracking-widest rounded-full mb-6">
                CXO • Mid-Senior • Confidential
            </span>
            <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">
                <?= esc($h1) ?>
            </h1>
            <?php if (!empty($intro)): ?>
                <p class="text-lg text-white/80 max-w-3xl leading-relaxed">
                    <?= esc($intro) ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</header>

<section class="py-24 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-3 gap-12 items-start">
            <div class="lg:col-span-2">
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-8">Hiring Focus</h2>
                <ul class="space-y-5">
                    <?php foreach ($focus as $item): ?>
                        <li class="flex items-start gap-4">
                            <span class="text-accent text-xl shrink-0">✓</span>
                            <span class="text-gray-700 font-medium"><?= esc($item) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <aside class="bg-gray-50 border border-gray-100 rounded-3xl p-8">
                <div class="text-[10px] font-black uppercase tracking-[0.25em] text-gray-500 mb-3">Get Started</div>
                <p class="text-gray-700 font-semibold mb-6">
                    <?= esc($ctaDescription) ?>
                </p>
                <a href="<?= base_url('contact') ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white rounded-full font-bold hover:bg-accent transition-all shadow-lg">
                    <?= esc($ctaTitle) ?> →
                </a>
            </aside>
        </div>
    </div>
</section>

<section class="py-24 bg-gray-50">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-10">Our Search Approach</h2>
        <div class="grid md:grid-cols-2 gap-10">
            <?php foreach ($approach as $idx => $step): ?>
                <div class="group bg-white p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6"><?= str_pad((string)($idx + 1), 2, '0', STR_PAD_LEFT) ?></div>
                    <p class="text-gray-600 leading-relaxed"><?= esc($step) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-primary text-white text-center relative overflow-hidden">
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>
    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-8 lg:px-12">
        <h2 class="text-4xl md:text-5xl font-serif font-bold mb-8">Get leadership hiring done with discretion and speed.</h2>
        <p class="text-xl text-white/80 mb-10">
            Share the mandate and constraints. We respond with mapping approach, evaluation steps, and timelines.
        </p>
        <a href="<?= base_url('contact') ?>" class="inline-block px-12 py-5 bg-accent rounded-full font-bold shadow-xl hover:bg-accent/90 hover:-translate-y-1 transition-all">
            Get in Touch
        </a>
    </div>
</section>

<?= $this->endSection() ?>

