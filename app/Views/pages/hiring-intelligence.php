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

<section class="py-16 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-3xl mb-9">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Selected evidence</div>
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
