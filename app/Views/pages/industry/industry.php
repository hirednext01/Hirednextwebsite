<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$industry = $industry ?? [];
$h1 = $industry['h1'] ?? 'Industry Executive Search';
$intro = $industry['intro'] ?? '';
$challenges = $industry['challenges'] ?? [];
$approach = $industry['approach'] ?? [];
$differentiators = $industry['differentiators'] ?? [];
$ctaTitle = $industry['cta_title'] ?? 'Get in Touch';
$ctaDescription = $industry['cta_description'] ?? 'Share your hiring brief and timelines. We will respond with a search plan.';
$panelHeading = $industry['cta_panel_heading'] ?? 'Confidential leadership hiring, executed with rigor.';
$panelBody = $industry['cta_panel_body'] ?? 'If you are planning a retained search or a critical leadership hire, share the mandate and we will align on mapping, assessment, and timelines.';
?>

<header class="relative bg-primary pt-36 pb-24 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-accent/20 blur-3xl rounded-full"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-gold/10 blur-3xl rounded-full"></div>
    <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <nav class="flex items-center gap-2 text-sm text-white/70 mb-8">
            <a href="<?= base_url() ?>" class="hover:text-accent transition">Home</a><span>/</span>
            <a href="<?= base_url() ?>#industry-expertise" class="hover:text-accent transition">Industry Expertise</a><span>/</span>
            <span class="text-gold font-semibold"><?= esc($industry['label'] ?? 'Industry') ?></span>
        </nav>

        <div class="max-w-4xl">
            <span class="inline-block px-4 py-1.5 bg-gold/20 text-gold font-bold text-xs uppercase tracking-widest rounded-full mb-6">
                Executive Search • India
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
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-8">Hiring Challenges</h2>
                <ul class="space-y-5">
                    <?php foreach ($challenges as $item): ?>
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

<section class="py-24 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-10">Value Differentiators</h2>
        <div class="grid lg:grid-cols-2 gap-10">
            <div class="bg-gray-50 border border-gray-100 rounded-3xl p-10">
                <ul class="space-y-5">
                    <?php foreach ($differentiators as $item): ?>
                        <li class="flex items-start gap-4">
                            <span class="text-accent text-xl shrink-0">✓</span>
                            <span class="text-gray-700 font-medium"><?= esc($item) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bg-primary text-white rounded-3xl p-10 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black uppercase tracking-[0.25em] text-white/60 mb-4">Next Step</div>
                    <h3 class="text-3xl font-serif font-bold mb-6"><?= esc($panelHeading) ?></h3>
                    <p class="text-white/80 leading-relaxed mb-8">
                        <?= esc($panelBody) ?>
                    </p>
                    <a href="<?= base_url('contact') ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-accent text-white rounded-full font-bold hover:bg-accent/90 transition-all shadow-lg">
                        Get in Touch →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$geoRoles = $industry['geo_roles'] ?? [];
$geoFaq = $industry['geo_faq'] ?? [];
?>

<?php if (!empty($geoRoles) || !empty($geoFaq)): ?>
<!-- GEO AUTHORITY BLOCK -->
<section class="py-20 bg-gray-50">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-8 lg:px-12">

        <?php if (!empty($geoRoles)): ?>
            <div class="mb-16">
                <div class="text-xs font-black uppercase tracking-[0.25em] text-accent mb-4">
                    Manufacturing Leadership Search
                </div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-5">
                    Manufacturing leadership roles we recruit
                </h2>
                <p class="text-gray-600 leading-relaxed max-w-3xl mb-8">
                    HiredNext recruits senior manufacturing, plant, operations, supply chain, quality and engineering leaders for organizations building, scaling or transforming manufacturing operations in India.
                </p>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <?php foreach ($geoRoles as $role): ?>
                        <div class="bg-white border border-gray-100 rounded-2xl px-5 py-4 font-semibold text-primary">
                            <?= esc($role) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($geoFaq)): ?>
            <div>
                <div class="text-xs font-black uppercase tracking-[0.25em] text-accent mb-4">
                    Frequently Asked Questions
                </div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-8">
                    Manufacturing executive search in India
                </h2>

                <div class="space-y-4">
                    <?php foreach ($geoFaq as $faq): ?>
                        <div class="bg-white border border-gray-100 rounded-2xl p-6">
                            <h3 class="text-lg font-bold text-primary mb-3">
                                <?= esc($faq['question'] ?? '') ?>
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                <?= esc($faq['answer'] ?? '') ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php
            $faqSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array_map(static function ($faq) {
                    return [
                        '@type' => 'Question',
                        'name' => $faq['question'] ?? '',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['answer'] ?? '',
                        ],
                    ];
                }, $geoFaq),
            ];
            ?>
            <script type="application/ld+json"><?= json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
        <?php endif; ?>

    </div>
</section>
<?php endif; ?>

<?= $this->endSection() ?>

