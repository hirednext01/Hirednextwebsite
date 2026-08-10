<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="relative pt-36 pb-20 bg-primary text-white overflow-hidden">
    <div class="absolute -top-32 -right-24 w-96 h-96 bg-accent/15 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -left-24 w-96 h-96 bg-gold/10 rounded-full blur-3xl"></div>
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/15 rounded-full text-xs uppercase tracking-[0.25em] font-bold mb-6">Current Opportunities</div>
            <h1 class="text-5xl md:text-7xl font-serif font-bold leading-tight mb-6">Find the right role, not just another opening.</h1>
            <p class="text-lg md:text-xl text-white/75 max-w-3xl leading-relaxed">Explore active HiredNext mandates across locations, industries and seniority levels. Use the filters to get straight to the roles relevant to you.</p>
        </div>
    </div>
</header>

<section class="py-16 md:py-20 bg-gray-50">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 lg:px-12">
        <?php
        $filters = $filters ?? [];
        $types = $types ?? [];
        $locations = $locations ?? [];
        $industries = $industries ?? [];
        $hasFilters = !empty(array_filter($filters ?? [], static fn($value) => $value !== ''));
        ?>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 md:p-6 shadow-sm mb-10">
            <form method="get" action="<?= base_url('jobs') ?>" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4 items-end">
                <div class="xl:col-span-2">
                    <label for="job-q" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Keyword</label>
                    <input id="job-q" name="q" type="search" placeholder="Job title, skill or keyword" value="<?= esc($filters['q'] ?? '') ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/15 focus:border-primary">
                </div>
                <div>
                    <label for="job-location" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Location</label>
                    <select id="job-location" name="location" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/15 focus:border-primary">
                        <option value="">All Locations</option>
                        <?php foreach ($locations as $location): ?>
                            <option value="<?= esc($location) ?>" <?= strcasecmp((string)($filters['location'] ?? ''), (string)$location) === 0 ? 'selected' : '' ?>><?= esc($location) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="job-industry" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Industry</label>
                    <select id="job-industry" name="industry" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/15 focus:border-primary">
                        <option value="">All Industries</option>
                        <?php foreach ($industries as $industry): ?>
                            <option value="<?= esc($industry) ?>" <?= strcasecmp((string)($filters['industry'] ?? ''), (string)$industry) === 0 ? 'selected' : '' ?>><?= esc($industry) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-primary text-white rounded-xl px-5 py-3 text-sm font-bold hover:bg-accent transition">Search Jobs</button>
                    <?php if ($hasFilters): ?>
                        <a href="<?= base_url('jobs') ?>" class="inline-flex items-center justify-center border border-gray-200 text-gray-600 rounded-xl px-4 py-3 text-sm font-semibold hover:border-primary hover:text-primary transition" aria-label="Clear filters">Clear</a>
                    <?php endif; ?>
                </div>
                <?php if (!empty($types)): ?>
                    <div class="md:col-span-2 xl:col-span-5 pt-1 flex flex-wrap gap-2">
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-400 mr-1 self-center">Type:</span>
                        <a href="<?= base_url('jobs?' . http_build_query(array_filter(array_merge($filters, ['type' => '']), static fn($v) => $v !== ''))) ?>" class="px-3 py-1.5 rounded-full text-xs font-semibold border <?= empty($filters['type']) ? 'bg-primary text-white border-primary' : 'bg-white text-gray-600 border-gray-200 hover:border-primary' ?>">All</a>
                        <?php foreach ($types as $type): ?>
                            <?php $typeQuery = array_filter(array_merge($filters, ['type' => $type]), static fn($v) => $v !== ''); ?>
                            <a href="<?= base_url('jobs?' . http_build_query($typeQuery)) ?>" class="px-3 py-1.5 rounded-full text-xs font-semibold border <?= ($filters['type'] ?? '') === $type ? 'bg-primary text-white border-primary' : 'bg-white text-gray-600 border-gray-200 hover:border-primary' ?>"><?= esc(ucwords(str_replace('-', ' ', $type))) ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="flex items-end justify-between gap-6 mb-8">
            <div>
                <div class="text-xs uppercase tracking-[0.22em] font-bold text-accent mb-2">Open roles</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">Opportunities selected for you</h2>
            </div>
            <?php if ($hasFilters): ?>
                <div class="hidden md:block text-sm text-gray-500">Filters are applied to the live job database.</div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5" id="jobsGrid">
            <?php if (!empty($jobs)): ?>
                <?php foreach ($jobs as $job): ?>
                    <article class="bg-white border border-gray-200 rounded-2xl p-6 hover:border-primary/30 hover:shadow-md transition-all flex flex-col min-h-[300px] job-card">
                        <div class="flex flex-wrap items-center gap-2 mb-5">
                            <span class="px-2.5 py-1 rounded-full bg-orange-50 text-accent text-[11px] font-black uppercase tracking-widest"><?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'full-time'))) ?></span>
                            <?php if (!empty($job['department'])): ?><span class="px-2.5 py-1 rounded-full bg-blue-50 text-primary text-[11px] font-bold"><?= esc($job['department']) ?></span><?php endif; ?>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-primary leading-snug mb-4"><a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>" class="hover:text-accent transition"><?= esc($job['title'] ?? '') ?></a></h3>
                        <div class="space-y-2 text-sm text-gray-500 mb-5">
                            <?php if (!empty($job['location'])): ?><div class="flex items-center gap-2"><span class="text-gray-400">Location</span><strong class="font-semibold text-gray-700"><?= esc($job['location']) ?></strong></div><?php endif; ?>
                            <?php if (!empty($job['experience'])): ?><div class="flex items-center gap-2"><span class="text-gray-400">Experience</span><strong class="font-semibold text-gray-700"><?= esc($job['experience']) ?></strong></div><?php endif; ?>
                        </div>
                        <div class="prose prose-sm max-w-none text-gray-500 line-clamp-3 job-richtext mb-6"><?= $job['description'] ?? '' ?></div>
                        <div class="mt-auto pt-5 border-t border-gray-100 flex items-center justify-between gap-4">
                            <span class="text-xs text-gray-400"><?= !empty($job['created_at']) ? 'Posted ' . esc(date('M d, Y', strtotime($job['created_at']))) : '' ?></span>
                            <a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>" class="inline-flex items-center text-sm font-bold text-primary hover:text-accent transition">View role <span class="ml-2">→</span></a>
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

        <?php if (!empty($pager)): ?>
            <div class="mt-10"><?= $pager->links('default', 'pager_jobs') ?></div>
        <?php endif; ?>

        <div class="mt-14 grid md:grid-cols-2 gap-5">
            <div class="bg-primary text-white rounded-2xl p-7 md:p-8">
                <div class="text-xs font-black uppercase tracking-widest text-gold mb-3">Before you apply</div>
                <h3 class="text-2xl font-serif font-bold mb-3">Not sure your CV is strong enough?</h3>
                <p class="text-white/70 text-sm leading-relaxed mb-5">Get a free CV assessment in 7–10 days, or choose the ₹599 priority review for a detailed assessment within 12 hours.</p>
                <a href="<?= base_url('cv-assessment') ?>" class="inline-flex px-5 py-3 rounded-xl bg-white text-primary font-bold hover:bg-accent hover:text-white transition">Assess your CV →</a>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-7 md:p-8">
                <div class="text-xs font-black uppercase tracking-widest text-accent mb-3">HiredNext Insights</div>
                <h3 class="text-2xl font-serif font-bold text-primary mb-3">Research the role before you move.</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-5">Explore hiring insights, role guidance and industry knowledge from HiredNext.</p>
                <a href="<?= base_url('insights') ?>" class="inline-flex text-primary font-bold hover:text-accent transition">Explore insights →</a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
