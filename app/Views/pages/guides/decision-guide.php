<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$guide = $guide ?? [];
$criteria = $guide['criteria'] ?? [];
$faq = $guide['faq'] ?? [];
$relatedLinks = $guide['related_links'] ?? [];
$guideSlug = service('uri')->getSegment(2) ?? '';
$boardAuthorityConfig = config('BoardAuthority');
$boardAuthority = $boardAuthorityConfig->guides[$guideSlug] ?? [];
$authorityInsights = $boardAuthority['insights'] ?? [];
$authorityMatrix = $boardAuthority['matrix'] ?? [];
$authorityMistakes = $boardAuthority['mistakes'] ?? [];
$mandateEvidenceConfig = config('MandateEvidence');
$caseEvidence = $mandateEvidenceConfig ? array_values($mandateEvidenceConfig->casesForGuide($guideSlug)) : [];
$practiceEvidence = $mandateEvidenceConfig ? array_values($mandateEvidenceConfig->practicesForGuide($guideSlug)) : [];
$practiceEvidence = array_slice($practiceEvidence, 0, 3);
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

            <?php if (!empty($boardAuthority)): ?>
                <section class="mb-12 rounded-[2rem] bg-[#071f3d] text-white p-7 md:p-10 overflow-hidden relative">
                    <div class="absolute -right-20 -top-20 w-56 h-56 rounded-full border border-white/10"></div>
                    <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full border border-white/10"></div>
                    <div class="relative">
                        <div class="text-[10px] uppercase tracking-[0.28em] text-gold font-black mb-4"><?= esc($boardAuthority['label'] ?? 'HiredNext Point of View') ?></div>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold leading-tight mb-5"><?= esc($boardAuthority['headline'] ?? '') ?></h2>
                        <p class="text-white/75 text-lg leading-relaxed"><?= esc($boardAuthority['thesis'] ?? '') ?></p>
                    </div>
                </section>

                <?php if (!empty($authorityInsights)): ?>
                    <section class="mb-14">
                        <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">What changes the decision</div>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3">The part most hiring discussions miss</h2>
                        <p class="text-gray-500 leading-relaxed mb-7 max-w-3xl">These are not checklist items. They are the points at which a senior search usually becomes more intelligent — or quietly starts wasting time.</p>
                        <div class="grid gap-5">
                            <?php foreach ($authorityInsights as $insight): ?>
                                <div class="rounded-2xl border border-gray-200 p-6 md:p-7 bg-white">
                                    <h3 class="text-xl md:text-2xl font-serif font-bold text-primary mb-3"><?= esc($insight['title'] ?? '') ?></h3>
                                    <p class="text-gray-600 leading-relaxed"><?= esc($insight['text'] ?? '') ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <?php if (!empty($authorityMatrix)): ?>
                    <section class="mb-14">
                        <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Decision framework</div>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3"><?= esc($boardAuthority['matrix_title'] ?? 'Decision matrix') ?></h2>
                        <p class="text-gray-600 leading-relaxed mb-7"><?= esc($boardAuthority['matrix_intro'] ?? '') ?></p>
                        <div class="overflow-x-auto rounded-2xl border border-gray-200">
                            <table class="w-full min-w-[760px] text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-5 py-4 text-xs uppercase tracking-wider text-gray-500">Dimension</th>
                                        <th class="px-5 py-4 text-xs uppercase tracking-wider text-gray-500">Lower-complexity signal</th>
                                        <th class="px-5 py-4 text-xs uppercase tracking-wider text-gray-500">Higher-complexity signal</th>
                                        <th class="px-5 py-4 text-xs uppercase tracking-wider text-gray-500">Hiring implication</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($authorityMatrix as $row): ?>
                                        <tr class="border-t border-gray-100 align-top">
                                            <td class="px-5 py-5 font-black text-primary"><?= esc($row['dimension'] ?? '') ?></td>
                                            <td class="px-5 py-5 text-sm text-gray-600 leading-relaxed"><?= esc($row['low'] ?? '') ?></td>
                                            <td class="px-5 py-5 text-sm text-gray-600 leading-relaxed"><?= esc($row['high'] ?? '') ?></td>
                                            <td class="px-5 py-5 text-sm font-semibold text-primary leading-relaxed"><?= esc($row['implication'] ?? '') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                <?php endif; ?>

                <?php if (!empty($authorityMistakes)): ?>
                    <section class="mb-14 rounded-2xl border border-red-100 bg-red-50/40 p-7 md:p-9">
                        <div class="text-[10px] uppercase tracking-[0.28em] text-red-700 font-black mb-3">Senior hiring failure patterns</div>
                        <h2 class="text-3xl font-serif font-bold text-primary mb-6"><?= esc($boardAuthority['mistakes_title'] ?? 'What experienced employers still get wrong') ?></h2>
                        <div class="space-y-4">
                            <?php foreach ($authorityMistakes as $mistake): ?>
                                <div class="flex gap-4 items-start">
                                    <div class="mt-1 w-7 h-7 rounded-full bg-white border border-red-100 flex items-center justify-center text-red-700 font-black shrink-0">!</div>
                                    <p class="text-gray-700 leading-relaxed"><?= esc($mistake) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <section class="mb-14 rounded-2xl border-l-4 border-accent bg-gray-50 p-7 md:p-9">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">HiredNext advisory position</div>
                    <h2 class="text-3xl font-serif font-bold text-primary mb-4"><?= esc($boardAuthority['hirednext_title'] ?? 'Why this is the HiredNext point of view') ?></h2>
                    <p class="text-gray-700 leading-relaxed text-lg"><?= esc($boardAuthority['hirednext_text'] ?? '') ?></p>
                </section>
            <?php endif; ?>

            <?php if (!empty($caseEvidence) || !empty($practiceEvidence)): ?>
                <section class="mb-14">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Evidence from the work</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3">Where HiredNext adds value after the search begins</h2>
                    <p class="text-gray-600 leading-relaxed mb-8 max-w-3xl">A case is shown as a case only when there is a specific confirmed outcome. The other examples below are recurring HiredNext operating practices — how we work when judgement, candidate conviction or search stewardship changes the decision.</p>

                    <?php foreach ($caseEvidence as $case): ?>
                        <article class="rounded-[1.75rem] border border-gray-200 overflow-hidden mb-7">
                            <div class="bg-[#071f3d] text-white p-7 md:p-8">
                                <div class="text-[10px] uppercase tracking-[0.24em] text-gold font-black mb-3">Confirmed anonymised case · <?= esc($case['role'] ?? 'Leadership') ?></div>
                                <h3 class="text-2xl md:text-3xl font-serif font-bold mb-3"><?= esc($case['title'] ?? '') ?></h3>
                                <p class="text-white/70 leading-relaxed"><?= esc($case['context'] ?? '') ?></p>
                            </div>
                            <div class="p-7 md:p-8 grid md:grid-cols-2 gap-6">
                                <div>
                                    <div class="text-[10px] uppercase tracking-[0.20em] text-gray-400 font-black mb-2">What HiredNext saw</div>
                                    <p class="text-gray-700 leading-relaxed"><?= esc($case['what_we_saw'] ?? '') ?></p>
                                </div>
                                <div>
                                    <div class="text-[10px] uppercase tracking-[0.20em] text-gray-400 font-black mb-2">Result</div>
                                    <p class="text-gray-700 leading-relaxed"><?= esc($case['result'] ?? '') ?></p>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>

                    <?php if (!empty($practiceEvidence)): ?>
                        <div class="grid md:grid-cols-3 gap-5">
                            <?php foreach ($practiceEvidence as $practice): ?>
                                <article class="rounded-2xl border border-gray-200 p-6 bg-white">
                                    <div class="text-[10px] uppercase tracking-[0.20em] text-accent font-black mb-3"><?= esc($practice['category'] ?? 'Search practice') ?></div>
                                    <h3 class="text-xl font-serif font-bold text-primary mb-4"><?= esc($practice['title'] ?? '') ?></h3>
                                    <p class="text-sm text-gray-600 leading-relaxed mb-5"><?= esc($practice['how_hirednext_works'] ?? '') ?></p>
                                    <p class="text-sm font-semibold text-primary leading-relaxed border-t border-gray-100 pt-4"><?= esc($practice['decision_value'] ?? '') ?></p>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mt-7">
                        <a href="<?= base_url('mandate-stories') ?>" class="inline-flex items-center font-black text-primary hover:text-accent">See the full HiredNext mandate stories & search evidence →</a>
                    </div>
                </section>
            <?php endif; ?>

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
                    <a href="<?= base_url('mandate-stories') ?>" class="inline-flex px-5 py-3 rounded-xl bg-white text-primary font-black text-sm">See mandate stories</a>
                    <a href="<?= base_url('testimonials') ?>" class="inline-flex px-5 py-3 rounded-xl border border-white/20 text-white font-black text-sm">See recommendations</a>
                    <a href="<?= base_url('press-media') ?>" class="inline-flex px-5 py-3 rounded-xl border border-white/20 text-white font-black text-sm">See media coverage</a>
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
            <?php if (!empty($boardAuthority)): ?>
                <div class="rounded-2xl bg-[#071f3d] text-white p-6">
                    <div class="text-[10px] uppercase tracking-[0.26em] text-gold font-black mb-3">For CEOs, CHROs & boards</div>
                    <p class="text-sm text-white/75 leading-relaxed">Use the HiredNext framework on this page to pressure-test the mandate before comparing CVs or recruiter fees.</p>
                </div>
            <?php endif; ?>

            <div class="rounded-2xl border border-accent/20 bg-accent/5 p-6">
                <div class="text-[10px] uppercase tracking-[0.26em] text-accent font-black mb-3">Search evidence</div>
                <p class="text-sm text-gray-700 leading-relaxed mb-4">Read the complete case evidence separately from the recurring practices HiredNext uses during difficult searches.</p>
                <a class="font-black text-primary hover:text-accent" href="<?= base_url('mandate-stories') ?>">Mandate stories & search evidence →</a>
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
