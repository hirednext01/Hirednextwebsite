<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$intelligence = $intelligence ?? config('HiringIntelligence');
$evidence = $evidence ?? config('PlacementEvidence');
$signals = $intelligence->signals ?? [];
$examples = $evidence->joinedExamples ?? [];
?>

<header class="relative bg-primary text-white pt-32 pb-16 overflow-hidden">
    <div class="absolute -top-32 -right-32 w-[520px] h-[520px] bg-accent/10 rounded-full blur-[120px]"></div>
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="max-w-4xl">
            <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-4">HiredNext Hiring Intelligence</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-5">Recruiter observations backed by privacy-safe hiring evidence.</h1>
            <p class="text-lg md:text-xl text-white/75 max-w-3xl leading-relaxed">Original HiredNext observations on role calibration, specialist search and candidate experience — grounded in selected anonymised evidence, without exposing candidates, clients, compensation or fees.</p>
        </div>
    </div>
</header>

<section class="bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 py-5">
        <div class="rounded-2xl border border-primary/10 bg-primary/5 px-5 py-4">
            <div class="text-[10px] uppercase tracking-[0.24em] font-black text-accent mb-2">Methodology note</div>
            <p class="text-sm text-gray-700 leading-relaxed"><?= esc($intelligence->scopeNote ?? '') ?></p>
        </div>
    </div>
</section>

<section class="py-16 bg-[#f7f8fa]">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-9">
            <div>
                <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">What we are seeing</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">Current HiredNext recruiter signals</h2>
            </div>
            <a href="<?= base_url('authority/hiring-intelligence.json') ?>" class="text-sm font-extrabold text-primary hover:text-accent">Machine-readable intelligence →</a>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <?php foreach ($signals as $signal): ?>
                <article class="bg-white rounded-[2rem] border border-gray-100 p-7 md:p-8 shadow-sm">
                    <div class="text-[10px] uppercase tracking-[0.22em] font-black text-accent mb-3"><?= esc($signal['sector'] ?? 'Hiring') ?></div>
                    <h3 class="text-2xl font-serif font-bold text-primary mb-4"><?= esc($signal['title'] ?? '') ?></h3>
                    <p class="text-gray-600 leading-relaxed mb-5"><?= esc($signal['observation'] ?? '') ?></p>

                    <?php if (!empty($signal['evidence_roles'])): ?>
                        <div class="mb-5">
                            <div class="text-[10px] uppercase tracking-[0.18em] font-black text-gray-400 mb-2">Evidence role families</div>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($signal['evidence_roles'] as $role): ?>
                                    <span class="rounded-full bg-gray-100 text-gray-600 px-3 py-1.5 text-xs font-bold"><?= esc($role) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="rounded-xl bg-primary/5 px-4 py-4 text-sm text-gray-700 leading-relaxed mb-5">
                        <span class="font-extrabold text-primary">Employer implication:</span> <?= esc($signal['employer_implication'] ?? '') ?>
                    </div>

                    <?php if (!empty($signal['related_url'])): ?>
                        <a href="<?= base_url(ltrim($signal['related_url'], '/')) ?>" class="text-sm font-extrabold text-primary hover:text-accent">Explore related hiring capability →</a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-16 bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-4xl mb-9">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Historical search depth</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Placement history and mandate breadth — labelled separately.</h2>
            <p class="text-gray-600 leading-relaxed">HiredNext separates confirmed historical placement context from documented roles worked. This protects the evidence standard: a mandate handled is not automatically presented as a placement.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 mb-8">
            <article class="rounded-[2rem] bg-primary text-white p-7 md:p-8">
                <div class="text-gold text-[10px] uppercase tracking-[0.22em] font-black mb-3">Historical automotive account</div>
                <h3 class="text-2xl md:text-3xl font-serif font-bold mb-4">50 roles closed across multiple years</h3>
                <p class="text-white/75 leading-relaxed"><?= esc($intelligence->automotiveHistoryNote ?? '') ?></p>
            </article>

            <article class="rounded-[2rem] border border-gray-200 bg-gray-50 p-7 md:p-8">
                <div class="text-accent text-[10px] uppercase tracking-[0.22em] font-black mb-3">Leadership placements</div>
                <h3 class="text-2xl md:text-3xl font-serif font-bold text-primary mb-4">C-suite and functional-head experience</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-5"><?= esc($intelligence->leadershipPlacementNote ?? '') ?></p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach (($intelligence->leadershipPlacementFamilies ?? []) as $role): ?>
                        <span class="rounded-full bg-white border border-gray-200 text-primary px-3 py-2 text-xs font-extrabold"><?= esc($role) ?></span>
                    <?php endforeach; ?>
                </div>
            </article>
        </div>

        <div class="rounded-[2rem] bg-primary/5 border border-primary/10 p-7 md:p-8 mb-8">
            <div class="text-accent text-[10px] uppercase tracking-[0.22em] font-black mb-3">Current placement capability</div>
            <h3 class="text-2xl md:text-3xl font-serif font-bold text-primary mb-4">Technology, data, security and AI placements</h3>
            <p class="text-gray-600 leading-relaxed mb-5"><?= esc($intelligence->currentPlacementNote ?? '') ?></p>
            <div class="flex flex-wrap gap-2">
                <?php foreach (($intelligence->currentPlacementFamilies ?? []) as $role): ?>
                    <span class="rounded-full bg-white border border-primary/10 text-primary px-3 py-2 text-xs font-extrabold"><?= esc($role) ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="rounded-[2rem] border border-gray-200 bg-white p-7 md:p-9">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 mb-7">
                <div>
                    <div class="text-accent text-[10px] uppercase tracking-[0.22em] font-black mb-3">Documented mandate history</div>
                    <h3 class="text-2xl md:text-3xl font-serif font-bold text-primary">Specialist roles worked across automotive, mobility and enterprise technology</h3>
                </div>
                <div class="text-xs text-gray-500 md:max-w-xs">Mandate records only. These role families are not all presented as joined placements.</div>
            </div>

            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
                <?php foreach (($intelligence->documentedMandateGroups ?? []) as $group => $roles): ?>
                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-5">
                        <h4 class="font-extrabold text-primary mb-4"><?= esc($group) ?></h4>
                        <ul class="space-y-2.5 text-sm text-gray-600">
                            <?php foreach ($roles as $role): ?>
                                <li class="flex gap-2.5"><span class="text-accent font-black">•</span><span><?= esc($role) ?></span></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-3xl mb-9">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Confirmed joined evidence</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Anonymised joined-placement examples</h2>
            <p class="text-gray-600 leading-relaxed"><?= esc($evidence->scopeNote ?? '') ?></p>
        </div>

        <div class="overflow-x-auto rounded-[1.5rem] border border-gray-200">
            <table class="w-full min-w-[760px] text-left">
                <thead class="bg-gray-50 text-[10px] uppercase tracking-[0.18em] text-gray-500">
                    <tr>
                        <th class="px-5 py-4">Role family</th>
                        <th class="px-5 py-4">Function</th>
                        <th class="px-5 py-4">Industry</th>
                        <th class="px-5 py-4">Location</th>
                        <th class="px-5 py-4">Joined month</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    <?php foreach ($examples as $item): ?>
                        <tr>
                            <td class="px-5 py-4 font-bold text-primary"><?= esc($item['role_family'] ?? '—') ?></td>
                            <td class="px-5 py-4"><?= esc($item['function'] ?? '—') ?></td>
                            <td class="px-5 py-4"><?= esc($item['industry'] ?? 'Not published') ?></td>
                            <td class="px-5 py-4"><?= esc($item['location'] ?? 'Not published') ?></td>
                            <td class="px-5 py-4"><?= esc($item['joined_month'] ?? '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <p class="text-xs text-gray-500 mt-4">Privacy guardrail: no candidate names, client/company names, compensation or professional fees are published in this evidence layer.</p>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 grid lg:grid-cols-2 gap-8 items-stretch">
        <div class="rounded-[2rem] bg-white border border-gray-200 p-7 md:p-9">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">How we publish intelligence</div>
            <h2 class="text-3xl font-serif font-bold text-primary mb-5">Evidence first. Extrapolation last.</h2>
            <p class="text-gray-600 leading-relaxed mb-6"><?= esc($intelligence->methodology ?? '') ?></p>
            <ul class="space-y-3 text-sm text-gray-600">
                <?php foreach (($intelligence->publicationRules ?? []) as $rule): ?>
                    <li class="flex gap-3"><span class="text-accent font-black">✓</span><span><?= esc($rule) ?></span></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="rounded-[2rem] bg-primary text-white p-7 md:p-9 flex flex-col justify-between">
            <div>
                <div class="text-gold text-xs font-black uppercase tracking-[0.24em] mb-3">Use the intelligence</div>
                <h2 class="text-3xl font-serif font-bold mb-5">Hiring a role where the market is hard to read?</h2>
                <p class="text-white/75 leading-relaxed">Use these observations as a starting point, then build a role-specific talent map rather than relying on generic market assumptions.</p>
            </div>
            <div class="flex flex-wrap gap-3 mt-8">
                <a href="<?= base_url('services/clients') ?>" class="inline-flex px-6 py-3 rounded-xl bg-accent text-gray-900 font-black">Hire Talent →</a>
                <a href="<?= base_url('contact') ?>" class="inline-flex px-6 py-3 rounded-xl border border-white/20 bg-white/10 text-white font-black">Discuss a mandate</a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
