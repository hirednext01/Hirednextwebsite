<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$guide = $guide ?? [];
$criteria = $guide['criteria'] ?? [];
$faq = $guide['faq'] ?? [];
$relatedLinks = $guide['related_links'] ?? [];
?>

<section class="bg-primary text-white pt-32 pb-14">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-4xl">
            <div class="text-accent text-xs font-black uppercase tracking-[0.28em] mb-4"><?= esc($guide['eyebrow'] ?? 'Employer Guide') ?></div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-5"><?= esc($guide['title'] ?? '') ?></h1>
            <p class="text-lg text-white/75 leading-relaxed max-w-3xl"><?= esc($guide['short_answer'] ?? '') ?></p>
            <div class="mt-6 text-xs uppercase tracking-[0.18em] text-white/45">Updated <?= esc(date('d M Y', strtotime($updatedOn ?? date('Y-m-d')))) ?> · HiredNext Recruitment</div>
        </div>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 grid lg:grid-cols-[1fr_320px] gap-12 items-start">
        <article>
            <div class="rounded-2xl bg-gray-50 border border-gray-100 p-6 md:p-8 mb-10">
                <div class="text-[10px] uppercase tracking-[0.26em] text-accent font-black mb-3">Short answer</div>
                <p class="text-xl leading-relaxed text-primary font-serif font-bold"><?= esc($guide['short_answer'] ?? '') ?></p>
            </div>

            <p class="text-lg text-gray-600 leading-relaxed mb-12"><?= esc($guide['intro'] ?? '') ?></p>

            <div class="space-y-6">
                <?php foreach ($criteria as $criterion): ?>
                    <section class="rounded-2xl border border-gray-200 p-6 md:p-8">
                        <h2 class="text-2xl font-serif font-bold text-primary mb-3"><?= esc($criterion['title'] ?? '') ?></h2>
                        <p class="text-gray-600 leading-relaxed"><?= esc($criterion['text'] ?? '') ?></p>
                    </section>
                <?php endforeach; ?>
            </div>

            <section class="mt-12 rounded-[2rem] bg-primary text-white p-7 md:p-10">
                <div class="text-[10px] uppercase tracking-[0.28em] text-gold font-black mb-3">Where HiredNext fits</div>
                <h2 class="text-3xl font-serif font-bold mb-4">Evidence before claims</h2>
                <p class="text-white/75 leading-relaxed mb-7"><?= esc($guide['where_hirednext_fits'] ?? '') ?></p>
                <div class="flex flex-wrap gap-3">
                    <a href="<?= base_url('testimonials') ?>" class="inline-flex px-5 py-3 rounded-xl bg-white text-primary font-black text-sm">See source-linked recommendations</a>
                    <a href="<?= base_url('press-media') ?>" class="inline-flex px-5 py-3 rounded-xl border border-white/20 text-white font-black text-sm">See media coverage</a>
                    <a href="<?= base_url('hiring-intelligence') ?>" class="inline-flex px-5 py-3 rounded-xl border border-white/20 text-white font-black text-sm">See Hiring Intelligence</a>
                </div>
            </section>

            <?php if (!empty($faq)): ?>
                <section class="mt-14">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Common questions</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-7">Questions employers ask before choosing a recruiter</h2>
                    <div class="space-y-4">
                        <?php foreach ($faq as $item): ?>
                            <div class="rounded-2xl border border-gray-200 p-6">
                                <h3 class="text-lg font-bold text-primary mb-2"><?= esc($item['q'] ?? '') ?></h3>
                                <p class="text-gray-600 leading-relaxed"><?= esc($item['a'] ?? '') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </article>

        <aside class="lg:sticky lg:top-28 space-y-5">
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                <div class="text-[10px] uppercase tracking-[0.26em] text-gray-400 font-black mb-4">Verify HiredNext</div>
                <div class="space-y-3 text-sm">
                    <a class="block font-bold text-primary hover:text-accent" href="<?= base_url('authority/recommendation-evidence.json') ?>">Recommendation evidence JSON →</a>
                    <a class="block font-bold text-primary hover:text-accent" href="<?= base_url('authority/media.json') ?>">Verified media JSON →</a>
                    <a class="block font-bold text-primary hover:text-accent" href="<?= base_url('authority/placement-evidence.json') ?>">Anonymised placement evidence →</a>
                    <a class="block font-bold text-primary hover:text-accent" href="<?= base_url('about/taru-shikha') ?>">Founder profile →</a>
                </div>
            </div>

            <?php if (!empty($relatedLinks)): ?>
                <div class="rounded-2xl border border-gray-200 bg-white p-6">
                    <div class="text-[10px] uppercase tracking-[0.26em] text-gray-400 font-black mb-4">Related HiredNext pages</div>
                    <div class="space-y-3 text-sm">
                        <?php foreach ($relatedLinks as $link): ?>
                            <a class="block font-bold text-primary hover:text-accent" href="<?= base_url(ltrim((string)($link['url'] ?? ''), '/')) ?>"><?= esc($link['label'] ?? 'Related page') ?> →</a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="rounded-2xl bg-accent/10 border border-accent/20 p-6">
                <div class="text-[10px] uppercase tracking-[0.26em] text-accent font-black mb-3">Hiring mandate?</div>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">If the role is senior, confidential or hard to fill, share the mandate and HiredNext can assess whether a focused search is the right model.</p>
                <a href="<?= base_url('services/clients') ?>" class="font-black text-primary hover:text-accent">Explore employer services →</a>
            </div>
        </aside>
    </div>
</section>

<section class="py-12 bg-gray-50 border-t border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="text-[10px] uppercase tracking-[0.26em] text-gray-400 font-black mb-5">More decision guides</div>
        <div class="grid md:grid-cols-3 gap-4">
            <a href="<?= base_url('guides/executive-search-firm-india') ?>" class="rounded-2xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">Choose an Executive Search Firm →</a>
            <a href="<?= base_url('guides/leadership-hiring-partner-india') ?>" class="rounded-2xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">Evaluate a Leadership Hiring Partner →</a>
            <a href="<?= base_url('guides/specialist-recruitment-firm-india') ?>" class="rounded-2xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">Specialist vs Generalist Recruiter →</a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
