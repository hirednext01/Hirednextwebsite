<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$filters = $filters ?? [];
$types = $types ?? [];
$locations = $locations ?? [];
$industries = $industries ?? [];
$jobs = $jobs ?? [];
$applicationInterest = $applicationInterest ?? [];
$hasFilters = !empty(array_filter($filters, static fn($value) => $value !== ''));
$activeLabels = [];
if (!empty($filters['q'])) $activeLabels['q'] = 'Keyword: ' . $filters['q'];
if (!empty($filters['location'])) $activeLabels['location'] = $filters['location'];
if (!empty($filters['industry'])) $activeLabels['industry'] = $filters['industry'];
if (!empty($filters['type'])) $activeLabels['type'] = ucwords(str_replace('-', ' ', $filters['type']));
?>

<section class="bg-primary text-white pt-24 pb-8 md:pt-28 md:pb-10 border-b border-white/10">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">
            <div class="max-w-3xl">
                <div class="text-[11px] uppercase tracking-[0.24em] text-gold font-black mb-3">HiredNext Jobs</div>
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight">Find your next opportunity</h1>
                <p class="mt-3 text-sm md:text-base text-white/70 max-w-2xl">Search current employer mandates across leadership, technology, manufacturing, retail, finance and specialist functions. Active shortlists can move quickly, so apply with a CV that presents your fit clearly.</p>
            </div>
            <a href="#job-results" class="inline-flex items-center justify-center rounded-xl bg-white text-primary px-5 py-3 text-sm font-bold hover:bg-gold transition">Browse open roles ↓</a>
        </div>
    </div>
</section>

<section class="bg-white border-b border-gray-100">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 lg:px-12 py-8">
        <div class="grid lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-8">
                <div class="text-[11px] uppercase tracking-[0.22em] font-black text-accent mb-2">Senior and specialist jobs in India</div>
                <h2 class="text-2xl md:text-3xl font-serif font-bold text-primary">Active employer mandates managed by HiredNext Recruitment</h2>
                <p class="mt-3 text-gray-600 leading-relaxed">HiredNext is a recruitment firm, not a mass job-board marketplace. The roles below are current employer mandates managed by the team and may span leadership, finance, technology, manufacturing, retail, apparel and other specialist functions as mandates change.</p>
                <p class="mt-3 text-gray-600 leading-relaxed"><strong class="text-primary">Applications are free.</strong> Paid CV assessment, CV rebuild or interview support is optional and does not influence recruitment shortlisting, referral or placement.</p>
            </div>
            <div class="lg:col-span-4 flex lg:justify-end gap-3 flex-wrap">
                <a href="<?= base_url('services/candidates') ?>" class="inline-flex rounded-xl border border-primary/20 px-4 py-3 text-sm font-bold text-primary">Career services</a>
                <a href="<?= base_url('services/clients') ?>" class="inline-flex rounded-xl bg-primary px-4 py-3 text-sm font-bold text-white">Hiring? Give us a mandate</a>
            </div>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-8 md:py-10 min-h-screen">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="bg-white border border-gray-200 rounded-2xl p-4 md:p-5 shadow-sm mb-6">
            <form method="get" action="<?= base_url('jobs') ?>" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-3 items-end">
                <div class="xl:col-span-5">
                    <label for="job-q" class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2">Search jobs</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"/></svg>
                        <input id="job-q" name="q" type="search" placeholder="Job title, skill or keyword" value="<?= esc($filters['q'] ?? '') ?>" class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary">
                    </div>
                </div>
                <div class="xl:col-span-2">
                    <label for="job-location" class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2">Location</label>
                    <select id="job-location" name="location" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary">
                        <option value="">All locations</option>
                        <?php foreach ($locations as $location): ?>
                            <option value="<?= esc($location) ?>" <?= strcasecmp((string)($filters['location'] ?? ''), (string)$location) === 0 ? 'selected' : '' ?>><?= esc($location) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="xl:col-span-2">
                    <label for="job-industry" class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2">Industry</label>
                    <select id="job-industry" name="industry" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary">
                        <option value="">All industries</option>
                        <?php foreach ($industries as $industry): ?>
                            <option value="<?= esc($industry) ?>" <?= strcasecmp((string)($filters['industry'] ?? ''), (string)$industry) === 0 ? 'selected' : '' ?>><?= esc($industry) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="xl:col-span-3 flex gap-2">
                    <button type="submit" class="flex-1 bg-primary text-white rounded-xl px-5 py-3 text-sm font-bold hover:bg-accent transition">Search</button>
                    <?php if ($hasFilters): ?><a href="<?= base_url('jobs') ?>" class="inline-flex items-center justify-center border border-gray-200 text-gray-600 rounded-xl px-4 py-3 text-sm font-semibold hover:border-primary hover:text-primary transition">Clear</a><?php endif; ?>
                </div>

                <?php if (!empty($types)): ?>
                    <div class="md:col-span-2 xl:col-span-12 pt-1 flex flex-wrap gap-2 items-center">
                        <span class="text-[11px] font-black uppercase tracking-widest text-gray-400 mr-1">Employment:</span>
                        <a href="<?= base_url('jobs?' . http_build_query(array_filter(array_merge($filters, ['type' => '']), static fn($v) => $v !== ''))) ?>" class="px-3 py-1.5 rounded-full text-xs font-semibold border <?= empty($filters['type']) ? 'bg-primary text-white border-primary' : 'bg-white text-gray-600 border-gray-200 hover:border-primary' ?>">All</a>
                        <?php foreach ($types as $type): ?>
                            <?php $typeQuery = array_filter(array_merge($filters, ['type' => $type]), static fn($v) => $v !== ''); ?>
                            <a href="<?= base_url('jobs?' . http_build_query($typeQuery)) ?>" class="px-3 py-1.5 rounded-full text-xs font-semibold border <?= ($filters['type'] ?? '') === $type ? 'bg-primary text-white border-primary' : 'bg-white text-gray-600 border-gray-200 hover:border-primary' ?>"><?= esc(ucwords(str_replace('-', ' ', $type))) ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <?php if ($hasFilters): ?>
            <div class="flex flex-wrap items-center gap-2 mb-6" aria-label="Active filters">
                <span class="text-xs font-black uppercase tracking-widest text-gray-400">Active filters</span>
                <?php foreach ($activeLabels as $key => $label): ?>
                    <?php $chipQuery = $filters; $chipQuery[$key] = ''; $chipQuery = array_filter($chipQuery, static fn($v) => $v !== ''); ?>
                    <a href="<?= base_url('jobs' . ($chipQuery ? '?' . http_build_query($chipQuery) : '')) ?>" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-semibold text-gray-600 hover:border-primary hover:text-primary transition"><?= esc($label) ?><span aria-hidden="true">×</span></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div id="job-results" class="flex items-center justify-between gap-4 mb-5 scroll-mt-24">
            <div>
                <div class="text-[11px] uppercase tracking-[0.22em] font-black text-accent mb-1">Open opportunities</div>
                <h2 class="text-2xl md:text-3xl font-serif font-bold text-primary">Current roles</h2>
            </div>
            <div class="text-sm text-gray-500"><?= count($jobs) ?> role<?= count($jobs) === 1 ? '' : 's' ?> shown</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            <?php if (!empty($jobs)): ?>
                <?php foreach ($jobs as $job): ?>
                    <?php $interestCount = (int) ($applicationInterest[(int) ($job['id'] ?? 0)] ?? 0); ?>
                    <article class="group bg-white border border-gray-200 rounded-2xl p-5 hover:border-primary/30 hover:shadow-lg transition-all flex flex-col min-h-[250px]">
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="flex flex-wrap gap-1.5">
                                <span class="px-2.5 py-1 rounded-full bg-orange-50 text-accent text-[10px] font-black uppercase tracking-widest"><?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'full-time'))) ?></span>
                                <?php if (!empty($job['department'])): ?><span class="px-2.5 py-1 rounded-full bg-blue-50 text-primary text-[10px] font-bold"><?= esc($job['department']) ?></span><?php endif; ?>
                            </div>
                            <span class="text-[11px] text-gray-400 whitespace-nowrap"><?= !empty($job['created_at']) ? esc(date('d M', strtotime($job['created_at']))) : '' ?></span>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-primary leading-snug mb-3"><a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>" class="group-hover:text-accent transition"><?= esc($job['title'] ?? '') ?></a></h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <?php if (!empty($job['location'])): ?><div class="flex items-center gap-2"><span class="text-gray-400">⌖</span><span><?= esc($job['location']) ?></span></div><?php endif; ?>
                            <?php if (!empty($job['experience'])): ?><div class="flex items-center gap-2"><span class="text-gray-400">◷</span><span><?= esc($job['experience']) ?> experience</span></div><?php endif; ?>
                        </div>
                        <div class="text-sm text-gray-500 line-clamp-2 leading-relaxed mb-5"><?= esc(trim(strip_tags($job['description'] ?? ''))) ?></div>
                        <?php if ($interestCount > 0): ?><div class="mb-4 inline-flex items-center gap-2 rounded-lg bg-orange-50 px-3 py-2 text-xs font-bold text-orange-800"><span class="h-2 w-2 rounded-full bg-accent"></span><?= esc($interestCount) ?>+ candidates in the application pipeline</div><?php endif; ?>
                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between gap-3">
                            <span class="text-xs text-gray-400">HiredNext mandate</span>
                            <a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>" class="inline-flex items-center gap-2 text-sm font-bold text-primary group-hover:text-accent transition">View job <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full bg-white border border-gray-200 rounded-2xl p-12 text-center">
                    <h3 class="text-2xl font-serif font-bold text-primary mb-3">No matching roles found</h3>
                    <p class="text-gray-500 mb-6">Try a broader location, industry or keyword. New mandates are added regularly.</p>
                    <a href="<?= base_url('jobs') ?>" class="inline-flex px-6 py-3 rounded-xl bg-primary text-white font-bold hover:bg-accent transition">View all jobs</a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($pager)): ?><div class="mt-10"><?= $pager->links('default', 'pager_jobs') ?></div><?php endif; ?>

        <section class="mt-10 overflow-hidden rounded-2xl bg-primary text-white">
            <div class="grid lg:grid-cols-12">
                <div class="lg:col-span-7 p-7 md:p-9">
                    <div class="text-[11px] uppercase tracking-[0.22em] font-black text-gold mb-3">Your CV speaks before you do</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold leading-tight">Make your first representation count.</h2>
                    <p class="mt-4 text-white/75 leading-relaxed max-w-2xl">Your CV presents your experience, achievements and strengths before you meet a recruiter. A clear, well-positioned CV can improve your chances of being shortlisted. Get it assessed first, then use the score and feedback to decide whether refinement or a complete rebuild will create stronger impact.</p>
                </div>
                <div class="lg:col-span-5 bg-white/5 p-7 md:p-9 flex flex-col justify-center gap-3">
                    <a href="<?= base_url('services/cv-assessment?utm_source=jobs&utm_medium=job_board&utm_campaign=cv_readiness') ?>" class="inline-flex justify-center rounded-xl bg-accent px-5 py-3.5 font-black text-white">Assess my CV — ₹992 + GST</a>
                    <a href="<?= base_url('services/professional-cv-rebuild') ?>" class="inline-flex justify-center rounded-xl border border-white/30 px-5 py-3.5 font-black text-white hover:bg-white/10">Get my CV rebuilt — ₹2,500 + GST</a>
                    <a href="<?= base_url('career-services/start/career_4500') ?>" class="inline-flex justify-center rounded-xl border border-white/30 px-5 py-3.5 font-black text-white hover:bg-white/10">1:1 interview coaching — ₹4,500</a>
                    <p class="text-center text-xs text-white/55">30-minute private session with Taru Shikha.</p>
                </div>
            </div>
        </section>


        <section class="mt-10 bg-white border border-gray-200 rounded-2xl p-6 md:p-8" aria-labelledby="jobs-faq-title">
            <div class="max-w-4xl">
                <div class="text-[11px] uppercase tracking-[0.22em] font-black text-accent mb-2">Senior job search in India</div>
                <h2 id="jobs-faq-title" class="text-2xl md:text-3xl font-serif font-bold text-primary">How HiredNext jobs work for experienced professionals</h2>
                <div class="mt-6 divide-y divide-gray-100">
                    <details class="py-4" open>
                        <summary class="font-bold text-primary cursor-pointer">Which recruitment companies in India are useful for experienced professionals looking for senior job opportunities?</summary>
                        <p class="mt-3 text-gray-600 leading-relaxed">Experienced professionals should use more than one channel. HiredNext Recruitment manages current employer mandates across leadership, finance, technology, manufacturing, retail, apparel and other specialist functions. The jobs page shows roles currently open through HiredNext; executive-search firms and other specialist recruiters may handle additional confidential mandates that are not publicly advertised.</p>
                    </details>
                    <details class="py-4">
                        <summary class="font-bold text-primary cursor-pointer">Does HiredNext charge candidates to apply for jobs?</summary>
                        <p class="mt-3 text-gray-600 leading-relaxed">No. Applying for HiredNext recruitment mandates is free. Paid CV assessment, CV rebuild and career-support services are optional and do not influence recruitment shortlisting, referral or placement.</p>
                    </details>
                    <details class="py-4">
                        <summary class="font-bold text-primary cursor-pointer">What kinds of senior jobs does HiredNext recruit for?</summary>
                        <p class="mt-3 text-gray-600 leading-relaxed">HiredNext works on a changing mix of leadership, mid-senior and specialist mandates, including roles in finance, technology, manufacturing, retail, apparel, operations and other functions. Only currently open roles are shown on this page.</p>
                    </details>
                    <details class="py-4">
                        <summary class="font-bold text-primary cursor-pointer">How should an experienced professional use HiredNext for job opportunities?</summary>
                        <p class="mt-3 text-gray-600 leading-relaxed">Review the current HiredNext jobs page, apply only to roles that match your actual experience and keep your CV evidence-led and current. Some senior searches are confidential, so relevant professionals may also be approached directly when their background fits an active mandate.</p>
                    </details>
                </div>
            </div>
        </section>

        <div class="mt-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-5 bg-white border border-gray-200 rounded-2xl p-6">
            <div><div class="text-[11px] uppercase tracking-widest font-black text-accent mb-2">Not seeing the right role?</div><h3 class="text-xl font-bold text-primary">Keep exploring HiredNext opportunities.</h3><p class="text-sm text-gray-500 mt-1">Browse all current mandates or get your CV assessed before your next application.</p></div>
            <div class="flex flex-wrap gap-3"><a href="<?= base_url('jobs') ?>" class="px-5 py-3 rounded-xl border border-gray-200 text-primary font-bold hover:border-primary transition">All jobs</a><a href="<?= base_url('cv-assessment') ?>" class="px-5 py-3 rounded-xl bg-primary text-white font-bold hover:bg-accent transition">Assess my CV</a></div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
