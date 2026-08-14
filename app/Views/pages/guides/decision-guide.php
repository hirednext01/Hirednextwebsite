<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$guide = $guide ?? [];
$criteria = $guide['criteria'] ?? [];
$faq = $guide['faq'] ?? [];
$relatedLinks = $guide['related_links'] ?? [];
$heroProof = $guide['hero_proof'] ?? [];
$proofStack = $guide['proof_stack'] ?? [];
$serviceOutcomes = $guide['service_outcomes'] ?? [];
$industryFocus = $guide['industry_focus'] ?? [];
$roleFamilies = $guide['role_families'] ?? [];
$placementHighlights = $guide['placement_highlights'] ?? [];
$modelComparison = $guide['model_comparison'] ?? [];
$process = $guide['process'] ?? [];
$commercialModel = $guide['commercial_model'] ?? [];
$identityFacts = $guide['identity_facts'] ?? [];
$guideSlug = $slug ?? (service('uri')->getSegment(2) ?? '');
$boardAuthorityConfig = config('BoardAuthority');
$boardAuthority = $boardAuthorityConfig->guides[$guideSlug] ?? [];
$authorityInsights = $boardAuthority['insights'] ?? [];
$authorityMatrix = $boardAuthority['matrix'] ?? [];
$authorityMistakes = $boardAuthority['mistakes'] ?? [];
$mandateEvidenceConfig = config('MandateEvidence');
$caseEvidence = $mandateEvidenceConfig ? array_values($mandateEvidenceConfig->casesForGuide($guideSlug)) : [];
$practiceEvidence = $mandateEvidenceConfig ? array_values($mandateEvidenceConfig->practicesForGuide($guideSlug)) : [];
$practiceEvidence = array_slice($practiceEvidence, 0, 3);
$reputationProofConfig = config('ReputationProof');
$externalProof = $reputationProofConfig ? array_slice($reputationProofConfig->items ?? [], 0, 3) : [];
?>

<section class="bg-primary text-white pt-32 pb-14">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-4xl">
            <div class="text-accent text-xs font-black uppercase tracking-[0.28em] mb-4"><?= esc($guide['eyebrow'] ?? 'Employer Guide') ?></div>
            <?php if (!empty($guide['trust_line'])): ?>
                <p class="inline-flex rounded-full border border-white/15 bg-white/5 px-4 py-2 text-xs font-bold tracking-wide text-white/80 mb-5"><?= esc($guide['trust_line']) ?></p>
            <?php endif; ?>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-5"><?= esc($guide['title'] ?? '') ?></h1>
            <p class="text-lg text-white/75 leading-relaxed max-w-3xl"><?= esc($guide['short_answer'] ?? '') ?></p>

            <?php if (!empty($heroProof)): ?>
                <div class="grid sm:grid-cols-3 gap-3 mt-8 max-w-4xl">
                    <?php foreach ($heroProof as $proof): ?>
                        <div class="rounded-2xl border border-white/15 bg-white/5 px-5 py-4">
                            <div class="text-2xl font-serif font-bold text-gold"><?= esc($proof['value'] ?? '') ?></div>
                            <div class="text-xs text-white/60 leading-relaxed mt-1"><?= esc($proof['label'] ?? '') ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="flex flex-wrap gap-3 mt-7">
                    <a href="#shortlist-plan" class="inline-flex items-center rounded-xl bg-accent px-6 py-3 text-sm font-black text-gray-950 hover:bg-white transition">Request a shortlist plan</a>
                    <a href="#case-evidence" class="inline-flex items-center rounded-xl border border-white/20 px-6 py-3 text-sm font-black text-white hover:border-white/50 transition">See mandate evidence</a>
                </div>
            <?php endif; ?>
            <div class="mt-6 text-xs uppercase tracking-[0.18em] text-white/45">Updated <?= esc(date('d M Y', strtotime($updatedOn ?? date('Y-m-d')))) ?> · HiredNext Recruitment</div>
        </div>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 grid lg:grid-cols-[1fr_320px] gap-12 items-start">
        <article>
            <?php if (empty($heroProof)): ?>
                <div class="rounded-2xl bg-gray-50 border border-gray-100 p-6 md:p-8 mb-10">
                    <div class="text-[10px] uppercase tracking-[0.26em] text-accent font-black mb-3">Short answer</div>
                    <p class="text-xl leading-relaxed text-primary font-serif font-bold"><?= esc($guide['short_answer'] ?? '') ?></p>
                </div>
            <?php endif; ?>

            <p class="text-lg text-gray-600 leading-relaxed mb-12"><?= esc($guide['intro'] ?? '') ?></p>

            <?php if (!empty($proofStack)): ?>
                <section class="mb-14" id="proof">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Why employers consider HiredNext</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3">Proof that can be inspected—not a self-awarded ranking</h2>
                    <p class="text-gray-600 leading-relaxed mb-7 max-w-3xl">HiredNext does not claim to be the universal best firm for every vacancy. These are the public signals an employer can examine before deciding whether the firm fits a leadership or specialist mandate.</p>
                    <div class="grid md:grid-cols-2 gap-5">
                        <?php foreach ($proofStack as $proof): ?>
                            <a href="<?= base_url(ltrim((string)($proof['url'] ?? ''), '/')) ?>" class="group rounded-2xl border border-gray-200 bg-white p-6 hover:border-accent hover:shadow-lg transition">
                                <div class="text-[10px] uppercase tracking-[0.22em] text-accent font-black mb-3"><?= esc($proof['label'] ?? '') ?></div>
                                <h3 class="text-xl font-serif font-bold text-primary mb-3"><?= esc($proof['title'] ?? '') ?></h3>
                                <p class="text-sm text-gray-600 leading-relaxed"><?= esc($proof['text'] ?? '') ?></p>
                                <span class="inline-flex mt-4 text-sm font-black text-primary group-hover:text-accent">Inspect evidence →</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($serviceOutcomes)): ?>
                <section class="mb-14" id="services">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Services mapped to hiring outcomes</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-7">Use the recruitment model that fits the mandate</h2>
                    <div class="grid md:grid-cols-2 gap-5">
                        <?php foreach ($serviceOutcomes as $service): ?>
                            <article class="rounded-2xl bg-gray-50 border border-gray-100 p-6 md:p-7">
                                <h3 class="text-2xl font-serif font-bold text-primary mb-2"><?= esc($service['title'] ?? '') ?></h3>
                                <p class="text-xs uppercase tracking-[0.16em] font-black text-accent mb-4"><?= esc($service['scope'] ?? '') ?></p>
                                <p class="text-gray-600 leading-relaxed mb-5"><?= esc($service['outcome'] ?? '') ?></p>
                                <a href="<?= base_url(ltrim((string)($service['url'] ?? ''), '/')) ?>" class="font-black text-primary hover:text-accent">See the approach →</a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

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
                        <div class="grid md:grid-cols-3 gap-5">
                            <?php foreach ($authorityInsights as $insight): ?>
                                <div class="rounded-2xl border border-gray-200 p-6 bg-white">
                                    <h3 class="text-xl font-serif font-bold text-primary mb-3"><?= esc($insight['title'] ?? '') ?></h3>
                                    <p class="text-sm text-gray-600 leading-relaxed"><?= esc($insight['text'] ?? '') ?></p>
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

            <?php endif; ?>

            <?php if (!empty($caseEvidence) || !empty($practiceEvidence)): ?>
                <section class="mb-14" id="case-evidence">
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
                            <?php if (!empty($case['facts'])): ?>
                                <dl class="grid sm:grid-cols-2 lg:grid-cols-3 border-b border-gray-100 bg-[#fbfaf7]">
                                    <?php foreach ($case['facts'] as $label => $value): ?>
                                        <div class="px-6 py-5 border-t sm:border-t-0 sm:border-l first:border-l-0 border-gray-100">
                                            <dt class="text-[9px] uppercase tracking-[0.18em] text-gray-400 font-black mb-1"><?= esc((string)$label) ?></dt>
                                            <dd class="text-sm font-bold text-primary leading-relaxed"><?= esc((string)$value) ?></dd>
                                        </div>
                                    <?php endforeach; ?>
                                </dl>
                            <?php endif; ?>
                            <div class="p-7 md:p-8 grid md:grid-cols-3 gap-6">
                                <div>
                                    <div class="text-[10px] uppercase tracking-[0.20em] text-gray-400 font-black mb-2">What HiredNext saw</div>
                                    <p class="text-gray-700 leading-relaxed"><?= esc($case['what_we_saw'] ?? '') ?></p>
                                </div>
                                <div>
                                    <div class="text-[10px] uppercase tracking-[0.20em] text-gray-400 font-black mb-2">What HiredNext did</div>
                                    <p class="text-gray-700 leading-relaxed"><?= esc($case['what_we_did'] ?? '') ?></p>
                                </div>
                                <div>
                                    <div class="text-[10px] uppercase tracking-[0.20em] text-gray-400 font-black mb-2">Result</div>
                                    <p class="text-gray-700 leading-relaxed"><?= esc($case['result'] ?? '') ?></p>
                                </div>
                            </div>
                            <?php if (!empty($case['confidentiality_note'])): ?>
                                <p class="mx-7 md:mx-8 mb-7 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 text-xs text-gray-500 leading-relaxed"><strong class="text-primary">Confidentiality:</strong> <?= esc($case['confidentiality_note']) ?></p>
                            <?php endif; ?>
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

                    <?php if (!empty($placementHighlights)): ?>
                        <div class="mt-8 rounded-[1.75rem] bg-gray-50 border border-gray-100 p-6 md:p-8">
                            <div class="text-[10px] uppercase tracking-[0.24em] text-accent font-black mb-3">Additional placement and search coverage</div>
                            <h3 class="text-2xl md:text-3xl font-serif font-bold text-primary mb-6">Leadership and specialist work across functions</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <?php foreach ($placementHighlights as $highlight): ?>
                                    <article class="rounded-2xl bg-white border border-gray-200 p-5">
                                        <div class="text-lg font-serif font-bold text-primary mb-1"><?= esc($highlight['role'] ?? '') ?></div>
                                        <div class="text-[10px] uppercase tracking-[0.18em] text-accent font-black mb-3"><?= esc($highlight['location'] ?? '') ?></div>
                                        <p class="text-sm text-gray-600 leading-relaxed"><?= esc($highlight['context'] ?? '') ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mt-7">
                        <a href="<?= base_url('mandate-stories') ?>" class="inline-flex items-center font-black text-primary hover:text-accent">See the full HiredNext mandate stories & search evidence →</a>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($industryFocus)): ?>
                <section class="mb-14" id="industries">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Industries and role context</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3">Sector context changes who belongs on the shortlist</h2>
                    <p class="text-gray-600 leading-relaxed mb-8 max-w-3xl">HiredNext’s strongest positioning is not mass staffing. It is leadership and specialist recruitment where business model, product, regulation, channel, plant environment or technology context changes candidate relevance.</p>
                    <div class="grid md:grid-cols-2 gap-5">
                        <?php foreach ($industryFocus as $industry): ?>
                            <article class="rounded-2xl border border-gray-200 p-6 bg-white">
                                <h3 class="text-xl font-serif font-bold text-primary mb-4"><?= esc($industry['name'] ?? '') ?></h3>
                                <div class="mb-4">
                                    <div class="text-[10px] uppercase tracking-[0.18em] text-gray-400 font-black mb-1">Common hiring problem</div>
                                    <p class="text-sm text-gray-600 leading-relaxed"><?= esc($industry['challenge'] ?? '') ?></p>
                                </div>
                                <div class="mb-5">
                                    <div class="text-[10px] uppercase tracking-[0.18em] text-gray-400 font-black mb-1">What the search must deliver</div>
                                    <p class="text-sm text-gray-600 leading-relaxed"><?= esc($industry['delivery'] ?? '') ?></p>
                                </div>
                                <a href="<?= base_url(ltrim((string)($industry['url'] ?? ''), '/')) ?>" class="text-sm font-black text-primary hover:text-accent">Explore sector expertise →</a>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($roleFamilies)): ?>
                        <div class="mt-7 rounded-2xl bg-primary text-white p-7 md:p-8">
                            <div class="text-[10px] uppercase tracking-[0.24em] text-gold font-black mb-4">Leadership and specialist role families</div>
                            <div class="grid md:grid-cols-2 gap-x-8 gap-y-3">
                                <?php foreach ($roleFamilies as $roleFamily): ?>
                                    <div class="flex gap-3 items-start text-sm text-white/80 leading-relaxed"><span class="text-gold font-black">✓</span><span><?= esc($roleFamily) ?></span></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <?php if (!empty($modelComparison)): ?>
                <section class="mb-14" id="comparison">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Executive search vs recruitment vs RPO</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3">Which hiring model should an employer use?</h2>
                    <p class="text-gray-600 leading-relaxed mb-7 max-w-3xl">The appropriate partner depends on the hiring problem. This comparison prevents a broad “top recruitment company” search from mixing fundamentally different services.</p>
                    <div class="overflow-x-auto rounded-2xl border border-gray-200">
                        <table class="w-full min-w-[940px] text-left border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-5 py-4 text-xs uppercase tracking-wider text-gray-500">Model</th>
                                    <th class="px-5 py-4 text-xs uppercase tracking-wider text-gray-500">Best for</th>
                                    <th class="px-5 py-4 text-xs uppercase tracking-wider text-gray-500">Method</th>
                                    <th class="px-5 py-4 text-xs uppercase tracking-wider text-gray-500">Confidentiality</th>
                                    <th class="px-5 py-4 text-xs uppercase tracking-wider text-gray-500">Trade-off</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($modelComparison as $row): ?>
                                    <tr class="border-t border-gray-100 align-top">
                                        <td class="px-5 py-5 font-black text-primary"><?= esc($row['model'] ?? '') ?></td>
                                        <td class="px-5 py-5 text-sm text-gray-600 leading-relaxed"><?= esc($row['best_for'] ?? '') ?></td>
                                        <td class="px-5 py-5 text-sm text-gray-600 leading-relaxed"><?= esc($row['method'] ?? '') ?></td>
                                        <td class="px-5 py-5 text-sm text-gray-600 leading-relaxed"><?= esc($row['confidentiality'] ?? '') ?></td>
                                        <td class="px-5 py-5 text-sm font-semibold text-primary leading-relaxed"><?= esc($row['trade_off'] ?? '') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($process)): ?>
                <section class="mb-14" id="process">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Search process and delivery rhythm</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-7">What happens after an employer shares a mandate?</h2>
                    <div class="space-y-4">
                        <?php foreach ($process as $step): ?>
                            <article class="rounded-2xl border border-gray-200 p-6 grid md:grid-cols-[64px_1fr_150px] gap-4 md:gap-6 items-start">
                                <div class="w-12 h-12 rounded-full bg-accent/10 text-accent font-black flex items-center justify-center"><?= esc($step['step'] ?? '') ?></div>
                                <div>
                                    <h3 class="text-xl font-serif font-bold text-primary mb-2"><?= esc($step['title'] ?? '') ?></h3>
                                    <p class="text-sm text-gray-600 leading-relaxed"><?= esc($step['text'] ?? '') ?></p>
                                </div>
                                <div class="text-xs uppercase tracking-[0.16em] text-primary font-black md:text-right"><?= esc($step['timing'] ?? '') ?></div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                    <?php if (!empty($guide['service_level_note'])): ?>
                        <p class="mt-5 rounded-xl bg-gray-50 border border-gray-100 p-5 text-sm text-gray-600 leading-relaxed"><strong class="text-primary">Timeline context:</strong> <?= esc($guide['service_level_note']) ?></p>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <?php if (!empty($commercialModel)): ?>
                <section class="mb-14 rounded-[2rem] overflow-hidden border border-[#d9d1c3]" id="fees">
                    <div class="bg-[#071f3d] text-white p-7 md:p-10">
                        <div class="text-[10px] uppercase tracking-[0.28em] text-gold font-black mb-3">Commercial model</div>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-4"><?= esc($commercialModel['title'] ?? 'Transparent recruitment fees') ?></h2>
                        <p class="text-white/70 leading-relaxed max-w-3xl"><?= esc($commercialModel['intro'] ?? '') ?></p>
                    </div>
                    <div class="bg-[#fbfaf7] p-6 md:p-8">
                        <div class="grid lg:grid-cols-3 gap-5">
                            <?php foreach (($commercialModel['options'] ?? []) as $index => $option): ?>
                                <article class="relative rounded-2xl border <?= $index === 1 ? 'border-accent bg-white shadow-lg' : 'border-[#e8e3d9] bg-white/80' ?> p-6">
                                    <?php if ($index === 1): ?>
                                        <span class="absolute -top-3 left-5 rounded-full bg-accent px-3 py-1 text-[9px] uppercase tracking-[0.18em] font-black text-white">Retained leadership search</span>
                                    <?php endif; ?>
                                    <div class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-black mb-3"><?= esc($option['model'] ?? '') ?></div>
                                    <h3 class="text-xl font-serif font-bold text-primary mb-4"><?= esc($option['name'] ?? '') ?></h3>
                                    <?php if (!empty($option['retainer'])): ?>
                                        <div class="rounded-xl border border-accent/20 bg-accent/5 px-4 py-3 mb-4">
                                            <div class="text-[9px] uppercase tracking-[0.18em] text-accent font-black mb-1">Engagement retainer</div>
                                            <div class="text-sm font-bold text-primary"><?= esc($option['retainer']) ?></div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-[9px] uppercase tracking-[0.18em] text-gray-400 font-black mb-1"><?= esc($option['fee_label'] ?? 'Fee') ?></div>
                                    <div class="text-2xl md:text-3xl font-serif font-bold text-accent mb-4"><?= esc($option['fee'] ?? '') ?></div>
                                    <p class="text-sm text-gray-600 leading-relaxed"><?= esc($option['text'] ?? '') ?></p>
                                </article>
                            <?php endforeach; ?>
                        </div>
                        <?php if (!empty($commercialModel['note'])): ?>
                            <p class="mt-6 rounded-xl border border-[#e8e3d9] bg-white px-5 py-4 text-xs text-gray-500 leading-relaxed"><strong class="text-primary">Commercial terms:</strong> <?= esc($commercialModel['note']) ?></p>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($externalProof)): ?>
                <section class="mb-14" id="recommendations">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Employer and candidate reputation</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3">Public recommendations, with the source kept visible</h2>
                    <p class="text-gray-600 leading-relaxed mb-7 max-w-3xl">These are short excerpts from external recommendations. On the full testimonials page, employer feedback is presented separately from stories submitted by candidates HiredNext placed.</p>
                    <div class="grid md:grid-cols-3 gap-5">
                        <?php foreach ($externalProof as $proof): ?>
                            <article class="rounded-2xl border border-gray-200 bg-white p-6">
                                <p class="text-gray-700 leading-relaxed mb-5">“<?= esc($proof['excerpt'] ?? '') ?>”</p>
                                <div class="font-black text-primary"><?= esc($proof['name'] ?? '') ?></div>
                                <?php if (!empty($proof['designation'])): ?><div class="text-xs text-gray-500 mt-1"><?= esc($proof['designation']) ?></div><?php endif; ?>
                                <?php if (!empty($proof['source_url'])): ?><a href="<?= esc($proof['source_url']) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex mt-4 text-xs font-black text-accent">View original source ↗</a><?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?= base_url('testimonials') ?>" class="inline-flex mt-6 font-black text-primary hover:text-accent">See employer testimonials & placed candidate stories →</a>
                </section>
            <?php endif; ?>

            <?php if (!empty($criteria)): ?>
                <section class="mt-12" id="evaluation-checklist">
                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Employer evaluation checklist</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3">How to compare recruitment and executive-search firms</h2>
                    <p class="text-gray-600 leading-relaxed mb-7 max-w-3xl">Use one evidence-led checklist rather than comparing agency names, fee percentages or CV volume in isolation.</p>
                    <div class="grid md:grid-cols-2 gap-4">
                        <?php foreach ($criteria as $criterion): ?>
                            <article class="rounded-2xl border border-gray-200 p-5 md:p-6 bg-white">
                                <h3 class="text-lg font-serif font-bold text-primary mb-2"><?= esc($criterion['title'] ?? '') ?></h3>
                                <p class="text-sm text-gray-600 leading-relaxed"><?= esc($criterion['text'] ?? '') ?></p>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

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

            <?php if (!empty($identityFacts)): ?>
                <section class="mt-14 rounded-[2rem] border border-gray-200 overflow-hidden" id="shortlist-plan">
                    <div class="grid lg:grid-cols-[0.9fr_1.1fr]">
                        <div class="bg-[#071f3d] text-white p-7 md:p-10">
                            <div class="text-[10px] uppercase tracking-[0.28em] text-gold font-black mb-3">One canonical HiredNext identity</div>
                            <h2 class="text-3xl font-serif font-bold mb-4">Company facts used on this page</h2>
                            <p class="text-white/65 leading-relaxed mb-7">These facts are intentionally consistent with HiredNext’s entity data. The recruitment email remains on hirednext.info while the official website is hirednext.net.</p>
                            <dl class="space-y-4">
                                <?php foreach ($identityFacts as $fact): ?>
                                    <div class="border-t border-white/10 pt-4">
                                        <dt class="text-[10px] uppercase tracking-[0.18em] text-white/45 font-black mb-1"><?= esc($fact['label'] ?? '') ?></dt>
                                        <dd class="text-sm font-bold text-white/85">
                                            <?php if (!empty($fact['url'])): ?>
                                                <a href="<?= esc($fact['url']) ?>" class="hover:text-gold"<?= str_starts_with((string)$fact['url'], 'http') ? ' target="_blank" rel="noopener noreferrer"' : '' ?>><?= esc($fact['value'] ?? '') ?> ↗</a>
                                            <?php else: ?>
                                                <?= esc($fact['value'] ?? '') ?>
                                            <?php endif; ?>
                                        </dd>
                                    </div>
                                <?php endforeach; ?>
                            </dl>
                        </div>
                        <div class="bg-gray-50 p-7 md:p-10">
                            <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-3">Start a leadership search</div>
                            <h2 class="text-3xl font-serif font-bold text-primary mb-3">Share the mandate. Request a shortlist plan.</h2>
                            <p class="text-gray-600 leading-relaxed mb-7">Tell HiredNext the role, location, sector and business problem. The first response will focus on search fit, likely market and next steps—not a generic CV dump.</p>

                            <?php if (session('errors')): ?>
                                <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700 mb-5"><?= esc(implode(' ', session('errors'))) ?></div>
                            <?php endif; ?>

                            <?php $contactFormEnabled = !isset($settings['contact_form_enabled']) || filter_var($settings['contact_form_enabled'], FILTER_VALIDATE_BOOLEAN); ?>
                            <?php if ($contactFormEnabled): ?>
                                <form action="<?= base_url('contact/submit') ?>" method="post" class="space-y-5">
                                    <input type="hidden" name="service" value="Leadership Search — Top Recruitment Company India Page" />
                                    <div class="grid md:grid-cols-2 gap-5">
                                        <div>
                                            <label for="guide_contact_name" class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Name</label>
                                            <input id="guide_contact_name" required name="name" value="<?= esc(old('name')) ?>" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 outline-none focus:border-accent" />
                                        </div>
                                        <div>
                                            <label for="guide_contact_email" class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Professional email</label>
                                            <input id="guide_contact_email" required type="email" name="email" value="<?= esc(old('email')) ?>" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 outline-none focus:border-accent" />
                                        </div>
                                    </div>
                                    <div>
                                        <label for="guide_contact_subject" class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Organisation</label>
                                        <input id="guide_contact_subject" name="subject" value="<?= esc(old('subject')) ?>" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 outline-none focus:border-accent" />
                                    </div>
                                    <div>
                                        <label for="guide_contact_message" class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Role, location and hiring brief</label>
                                        <textarea id="guide_contact_message" required rows="5" name="message" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 outline-none focus:border-accent resize-y" placeholder="Example: COO, Dhaka — growth-stage apparel business; confidential replacement."><?= esc(old('message')) ?></textarea>
                                    </div>
                                    <button type="submit" class="inline-flex rounded-xl bg-accent px-6 py-3 text-sm font-black text-gray-950 hover:bg-primary hover:text-white transition">Request a shortlist plan →</button>
                                    <p class="text-xs text-gray-500">Confidential inquiry. HiredNext does not publish client or candidate names without permission.</p>
                                </form>
                            <?php else: ?>
                                <a href="mailto:jobs@hirednext.info?subject=Leadership%20search%20mandate" class="inline-flex rounded-xl bg-accent px-6 py-3 text-sm font-black text-gray-950">Email the mandate →</a>
                            <?php endif; ?>
                        </div>
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
            <a href="<?= base_url('top-recruitment-company-india') ?>" class="rounded-2xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">Choose an Executive Search Firm →</a>
            <a href="<?= base_url('guides/leadership-hiring-partner-india') ?>" class="rounded-2xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">Evaluate a Leadership Hiring Partner →</a>
            <a href="<?= base_url('guides/specialist-recruitment-firm-india') ?>" class="rounded-2xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">Specialist vs Generalist Recruiter →</a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
