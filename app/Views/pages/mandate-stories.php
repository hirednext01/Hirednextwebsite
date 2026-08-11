<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$cases = $cases ?? [];
$practices = $practices ?? [];
$roleContexts = $roleContexts ?? [];
?>

<section class="bg-primary text-white pt-32 pb-16">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-4xl">
            <div class="text-accent text-xs font-black uppercase tracking-[0.28em] mb-4">Mandate Stories & Search Evidence</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-6">The work that happens between a CV and a joining decision.</h1>
            <p class="text-xl text-white/75 leading-relaxed max-w-3xl">HiredNext earns its place in difficult searches by interpreting what a profile really means, challenging the brief when necessary, creating candidate conviction, protecting senior hires through complex processes and helping both sides make the better decision.</p>
            <div class="mt-7 text-xs uppercase tracking-[0.18em] text-white/45">Updated <?= esc(date('d M Y', strtotime($updatedOn ?? date('Y-m-d')))) ?> · HiredNext Recruitment</div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid lg:grid-cols-[1fr_320px] gap-12 items-start">
            <main>
                <section class="mb-16">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">What we have worked across</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-5">Different roles. The same question: where does HiredNext improve the decision?</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-7">Our mandate experience spans leadership, specialist and hard-to-fill hiring. The role title matters less than the point at which judgement, market interpretation or candidate conviction materially changes the outcome.</p>
                    <div class="flex flex-wrap gap-3">
                        <?php foreach ($roleContexts as $context): ?>
                            <span class="rounded-full border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-bold text-primary"><?= esc($context) ?></span>
                        <?php endforeach; ?>
                    </div>
                </section>

                <?php if (!empty($cases)): ?>
                    <section class="mb-16">
                        <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Confirmed anonymised case</div>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-8">A real mandate where judgement changed the outcome</h2>

                        <?php foreach ($cases as $case): ?>
                            <article class="rounded-[2rem] border border-gray-200 overflow-hidden bg-white shadow-sm">
                                <div class="bg-[#071f3d] text-white p-7 md:p-10">
                                    <div class="text-[10px] uppercase tracking-[0.24em] text-gold font-black mb-3"><?= esc($case['role'] ?? 'Leadership') ?> · <?= esc($case['context'] ?? '') ?></div>
                                    <h3 class="text-3xl md:text-4xl font-serif font-bold leading-tight mb-4"><?= esc($case['title'] ?? '') ?></h3>
                                    <p class="text-white/70 text-lg leading-relaxed"><?= esc($case['why_it_matters'] ?? '') ?></p>
                                </div>
                                <div class="p-7 md:p-10 space-y-8">
                                    <div>
                                        <div class="text-[10px] uppercase tracking-[0.24em] text-gray-400 font-black mb-2">The mandate</div>
                                        <p class="text-gray-700 leading-relaxed text-lg"><?= esc($case['mandate'] ?? '') ?></p>
                                    </div>
                                    <div>
                                        <div class="text-[10px] uppercase tracking-[0.24em] text-gray-400 font-black mb-2">What HiredNext saw</div>
                                        <p class="text-gray-700 leading-relaxed text-lg"><?= esc($case['what_we_saw'] ?? '') ?></p>
                                    </div>
                                    <div>
                                        <div class="text-[10px] uppercase tracking-[0.24em] text-gray-400 font-black mb-2">What HiredNext did</div>
                                        <p class="text-gray-700 leading-relaxed text-lg"><?= esc($case['what_we_did'] ?? '') ?></p>
                                    </div>
                                    <div class="rounded-2xl border border-accent/20 bg-accent/5 p-6">
                                        <div class="text-[10px] uppercase tracking-[0.24em] text-accent font-black mb-2">Result</div>
                                        <p class="text-primary font-semibold leading-relaxed text-lg"><?= esc($case['result'] ?? '') ?></p>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>

                <?php if (!empty($practices)): ?>
                    <section class="mb-16">
                        <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">How HiredNext works</div>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Where search value appears after sourcing begins</h2>
                        <p class="text-lg text-gray-600 leading-relaxed mb-9 max-w-3xl">These are recurring HiredNext operating practices, not individual case studies. They describe the points where we actively shape a senior or difficult search.</p>

                        <div class="grid md:grid-cols-2 gap-6">
                            <?php foreach ($practices as $practice): ?>
                                <article class="rounded-2xl border border-gray-200 p-7 bg-white">
                                    <div class="text-[10px] uppercase tracking-[0.22em] text-accent font-black mb-3"><?= esc($practice['category'] ?? 'Search practice') ?></div>
                                    <h3 class="text-2xl font-serif font-bold text-primary mb-4"><?= esc($practice['title'] ?? '') ?></h3>
                                    <div class="mb-5">
                                        <div class="text-[10px] uppercase tracking-[0.20em] text-gray-400 font-black mb-2">When it matters</div>
                                        <p class="text-gray-600 leading-relaxed"><?= esc($practice['when_it_matters'] ?? '') ?></p>
                                    </div>
                                    <div class="mb-5">
                                        <div class="text-[10px] uppercase tracking-[0.20em] text-gray-400 font-black mb-2">How we work</div>
                                        <p class="text-gray-700 leading-relaxed"><?= esc($practice['how_hirednext_works'] ?? '') ?></p>
                                    </div>
                                    <div class="border-t border-gray-100 pt-5">
                                        <div class="text-[10px] uppercase tracking-[0.20em] text-gray-400 font-black mb-2">Why it changes the decision</div>
                                        <p class="font-semibold text-primary leading-relaxed"><?= esc($practice['decision_value'] ?? '') ?></p>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <section class="rounded-[2rem] bg-primary text-white p-8 md:p-10">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-gold font-black mb-3">The point</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold mb-5">A difficult mandate needs more than candidate access.</h2>
                    <p class="text-white/75 text-lg leading-relaxed mb-7">The value is in seeing what others miss, explaining why it matters, keeping the right person engaged and being willing to tell either side when the assumption, level, offer or move does not make sense.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="<?= base_url('services/clients') ?>" class="inline-flex px-5 py-3 rounded-xl bg-white text-primary font-black text-sm">Discuss a hiring mandate</a>
                        <a href="<?= base_url('guides/executive-search-firm-india') ?>" class="inline-flex px-5 py-3 rounded-xl border border-white/20 text-white font-black text-sm">Read the Executive Search guide</a>
                    </div>
                </section>

                <p class="mt-6 text-xs text-gray-400 leading-relaxed"><?= esc($scopeNote ?? '') ?></p>
            </main>

            <aside class="lg:sticky lg:top-28 space-y-5">
                <div class="rounded-2xl bg-[#071f3d] text-white p-6">
                    <div class="text-[10px] uppercase tracking-[0.26em] text-gold font-black mb-3">Proof behind the work</div>
                    <p class="text-sm text-white/75 leading-relaxed">Mandate stories show how HiredNext works. External recommendations and media provide separate public proof of reputation and expertise.</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6">
                    <div class="text-[10px] uppercase tracking-[0.26em] text-gray-400 font-black mb-4">Independent proof</div>
                    <div class="space-y-3 text-sm">
                        <a class="block font-bold text-primary hover:text-accent" href="<?= base_url('testimonials') ?>">Client & candidate recommendations →</a>
                        <a class="block font-bold text-primary hover:text-accent" href="<?= base_url('press-media') ?>">Press & expert commentary →</a>
                        <a class="block font-bold text-primary hover:text-accent" href="<?= base_url('about/taru-shikha') ?>">Founder profile →</a>
                        <a class="block font-bold text-primary hover:text-accent" href="<?= base_url('hiring-intelligence') ?>">Hiring intelligence →</a>
                    </div>
                </div>

                <div class="rounded-2xl bg-accent/10 border border-accent/20 p-6">
                    <div class="text-[10px] uppercase tracking-[0.26em] text-accent font-black mb-3">Senior or difficult role?</div>
                    <p class="text-sm text-gray-700 leading-relaxed mb-4">Share the mandate. HiredNext can help determine whether the issue is sourcing, market scarcity, role calibration, candidate conviction or the hiring process itself.</p>
                    <a href="<?= base_url('services/clients') ?>" class="font-black text-primary hover:text-accent">Employer services →</a>
                </div>
            </aside>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
