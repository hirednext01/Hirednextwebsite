<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$page = $page ?? [];
$related = $related ?? [];
$comparison = $page['comparison'] ?? [];
$questions = $page['questions'] ?? [];
?>
<section class="relative overflow-hidden bg-primary pt-32 pb-20 text-white">
    <div class="absolute -right-24 -top-28 h-96 w-96 rounded-full bg-accent/15 blur-3xl"></div>
    <div class="relative z-10 mx-auto max-w-[1120px] px-4 sm:px-8">
        <a href="<?= base_url('career-intelligence') ?>" class="text-sm font-bold text-white/65 hover:text-white">← Career Intelligence</a>
        <div class="mt-7 text-xs font-black uppercase tracking-[0.24em] text-gold"><?= esc($page['eyebrow'] ?? 'Career Intelligence') ?></div>
        <h1 class="mt-4 max-w-5xl font-serif text-4xl font-bold leading-tight md:text-6xl"><?= esc($page['title'] ?? '') ?></h1>
        <div class="mt-6 flex flex-wrap gap-x-5 gap-y-2 text-sm text-white/55">
            <span>Reviewed by Taru Shikha · Founder &amp; CEO, HiredNext</span>
            <span>Updated <?= esc(date('j F Y', strtotime((string)$updatedOn))) ?></span>
        </div>
    </div>
</section>

<section class="bg-white py-12">
    <div class="mx-auto max-w-[980px] px-4 sm:px-8">
        <div class="rounded-[1.75rem] border border-primary/10 bg-primary/5 p-7 md:p-9">
            <div class="text-xs font-black uppercase tracking-[0.22em] text-accent">Quick answer</div>
            <p class="mt-4 text-lg leading-relaxed text-gray-800 md:text-xl"><?= esc($page['short_answer'] ?? '') ?></p>
        </div>
        <div class="mt-5 text-sm leading-relaxed text-gray-500">
            <strong class="text-primary">Best for:</strong> <?= esc($page['intent'] ?? '') ?>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-16">
    <div class="mx-auto max-w-[980px] px-4 sm:px-8">
        <div class="rounded-[1.75rem] border border-accent/20 bg-white p-7 md:p-9 shadow-sm">
            <div class="text-xs font-black uppercase tracking-[0.22em] text-accent">What HiredNext sees</div>
            <h2 class="mt-3 font-serif text-3xl font-bold text-primary">The recruiter-side pattern behind this question</h2>
            <p class="mt-5 text-lg leading-relaxed text-gray-700"><?= esc($page['hirednext_sees'] ?? '') ?></p>
        </div>
    </div>
</section>

<?php foreach (($page['sections'] ?? []) as $index => $section): ?>
<section class="<?= $index % 2 === 0 ? 'bg-white' : 'bg-[#f6f0e7]' ?> py-16">
    <div class="mx-auto grid max-w-[1080px] gap-8 px-4 sm:px-8 lg:grid-cols-[.9fr_1.1fr]">
        <div>
            <div class="text-xs font-black uppercase tracking-[0.18em] text-accent">0<?= $index + 1 ?></div>
            <h2 class="mt-3 font-serif text-3xl font-bold text-primary md:text-4xl"><?= esc($section['title'] ?? '') ?></h2>
        </div>
        <div>
            <p class="text-lg leading-relaxed text-gray-700"><?= esc($section['body'] ?? '') ?></p>
            <?php if (!empty($section['points'])): ?>
            <div class="mt-6 grid gap-3">
                <?php foreach ($section['points'] as $point): ?>
                <div class="flex gap-3 rounded-xl border border-primary/10 bg-white/80 px-5 py-4 text-sm leading-relaxed text-gray-700">
                    <span class="font-black text-accent">→</span><span><?= esc($point) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>

<?php if (!empty($comparison['rows'])): ?>
<section class="bg-primary py-16 text-white">
    <div class="mx-auto max-w-[1080px] px-4 sm:px-8">
        <div class="max-w-3xl">
            <div class="text-xs font-black uppercase tracking-[0.2em] text-gold">Decision table</div>
            <h2 class="mt-3 font-serif text-3xl font-bold md:text-4xl">A faster way to compare the choices</h2>
        </div>
        <div class="mt-8 overflow-x-auto rounded-2xl border border-white/15">
            <table class="min-w-full border-collapse text-left text-sm">
                <thead class="bg-white/10">
                    <tr>
                        <?php foreach (($comparison['headers'] ?? []) as $header): ?>
                        <th class="px-5 py-4 font-black text-white"><?= esc($header) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comparison['rows'] as $row): ?>
                    <tr class="border-t border-white/10">
                        <?php foreach ($row as $cell): ?>
                        <td class="px-5 py-4 align-top leading-relaxed text-white/80"><?= esc($cell) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($questions)): ?>
<section class="bg-white py-16">
    <div class="mx-auto max-w-[900px] px-4 sm:px-8">
        <div class="text-center">
            <div class="text-xs font-black uppercase tracking-[0.2em] text-accent">Questions people ask</div>
            <h2 class="mt-3 font-serif text-3xl font-bold text-primary">Clear answers without the sales fog</h2>
        </div>
        <div class="mt-8 space-y-3">
            <?php foreach ($questions as $item): ?>
            <details class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <summary class="cursor-pointer font-bold text-primary"><?= esc($item['q'] ?? '') ?></summary>
                <p class="mt-3 text-sm leading-relaxed text-gray-600"><?= esc($item['a'] ?? '') ?></p>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="bg-[#f6f0e7] py-16">
    <div class="mx-auto max-w-[1080px] px-4 sm:px-8">
        <div class="grid gap-6 lg:grid-cols-[1.1fr_.9fr] lg:items-center">
            <div>
                <div class="text-xs font-black uppercase tracking-[0.2em] text-accent">Useful next step</div>
                <h2 class="mt-3 font-serif text-3xl font-bold text-primary">Turn the insight into a stronger professional narrative.</h2>
                <p class="mt-4 max-w-2xl leading-relaxed text-gray-600">HiredNext career services are designed for experienced professionals who want clearer evidence, stronger positioning and documents or profiles they can defend in real hiring conversations.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row lg:justify-end">
                <?php if (!empty($page['primary_cta'])): ?><a href="<?= base_url($page['primary_cta']['url']) ?>" class="inline-flex justify-center rounded-full bg-accent px-6 py-3.5 font-black text-white"><?= esc($page['primary_cta']['label']) ?></a><?php endif; ?>
                <?php if (!empty($page['secondary_cta'])): ?><a href="<?= base_url($page['secondary_cta']['url']) ?>" class="inline-flex justify-center rounded-full border border-primary/20 bg-white px-6 py-3.5 font-black text-primary"><?= esc($page['secondary_cta']['label']) ?></a><?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16">
    <div class="mx-auto max-w-[1080px] px-4 sm:px-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <div class="text-xs font-black uppercase tracking-[0.2em] text-accent">Related career intelligence</div>
                <h2 class="mt-2 font-serif text-3xl font-bold text-primary">Keep building the evidence around your career.</h2>
            </div>
            <a href="<?= base_url('career-intelligence') ?>" class="text-sm font-black text-primary underline underline-offset-4">View the complete hub</a>
        </div>
        <div class="mt-8 grid gap-5 md:grid-cols-2">
            <?php foreach ($related as $item): ?>
            <a href="<?= base_url($item['path']) ?>" class="rounded-2xl border border-gray-200 p-6 transition hover:border-primary hover:shadow-md">
                <h3 class="font-serif text-xl font-bold text-primary"><?= esc($item['title']) ?></h3>
                <p class="mt-3 text-sm leading-relaxed text-gray-600"><?= esc($item['description']) ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="border-t border-gray-100 bg-white py-10">
    <div class="mx-auto max-w-[980px] px-4 text-sm leading-relaxed text-gray-500 sm:px-8">
        <strong class="text-primary">Editorial note:</strong> Reviewed by Taru Shikha, Founder &amp; CEO of HiredNext Recruitment. HiredNext works with hiring managers and experienced candidates across leadership, specialist and mid-senior mandates. Examples describe recurring recruiter-side patterns; they are not guarantees of employer behaviour or hiring outcomes.
    </div>
</section>

<?= $this->endSection() ?>
