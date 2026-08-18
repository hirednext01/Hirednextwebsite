<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="relative pt-36 pb-20 bg-primary text-white overflow-hidden">
    <div class="absolute -top-32 -right-24 w-96 h-96 bg-accent/15 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -left-24 w-96 h-96 bg-gold/10 rounded-full blur-3xl"></div>
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/15 rounded-full text-xs uppercase tracking-[0.25em] font-bold mb-6">Current Employer Mandates</div>
            <h1 class="text-5xl md:text-7xl font-serif font-bold leading-tight mb-6">Jobs in India – Leadership, Technology & Specialist Roles</h1>
            <p class="text-lg md:text-xl text-white/75 max-w-3xl leading-relaxed">Explore active employer mandates managed by HiredNext across locations, industries and seniority levels in India. These are client opportunities unless a role is explicitly identified as an internal HiredNext vacancy.</p>
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
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">Current jobs managed by HiredNext</h2>
            </div>
            <?php if ($hasFilters): ?>
                <div class="hidden md:block text-sm text-gray-500">Filters are applied to the live job database.</div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4" id="jobsGrid">
            <?php if (!empty($jobs)): ?>
                <?php foreach ($jobs as $job): ?>
                    <article class="bg-white border border-gray-200 rounded-xl p-4 md:p-5 hover:border-primary/30 hover:shadow-md transition-all flex flex-col job-card">
                        <div class="flex flex-wrap items-center gap-1.5 mb-3">
                            <span class="px-2 py-0.5 rounded-full bg-orange-50 text-accent text-[10px] font-black uppercase tracking-widest"><?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'full-time'))) ?></span>
                            <?php if (!empty($job['department'])): ?><span class="px-2 py-0.5 rounded-full bg-blue-50 text-primary text-[10px] font-bold"><?= esc($job['department']) ?></span><?php endif; ?>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-primary leading-snug mb-2"><a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>" class="hover:text-accent transition"><?= esc($job['title'] ?? '') ?></a></h3>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500 mb-3">
                            <?php if (!empty($job['location'])): ?><div class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg><span class="text-gray-700 font-medium"><?= esc($job['location']) ?></span></div><?php endif; ?>
                            <?php if (!empty($job['experience'])): ?><div class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5v10a2 2 0 002 2z"/></svg><span class="text-gray-700 font-medium"><?= esc($job['experience']) ?></span></div><?php endif; ?>
                        </div>
                        <div class="text-xs text-gray-400 line-clamp-2 mb-3 leading-relaxed job-richtext"><?= strip_tags($job['description'] ?? '') ?></div>
                        <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between gap-3">
                            <span class="text-[11px] text-gray-400"><?= !empty($job['created_at']) ? esc(date('M d', strtotime($job['created_at']))) : '' ?></span>
                            <a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>" class="inline-flex items-center text-xs font-bold text-primary hover:text-accent transition">View role →</a>
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
                <div class="text-xs font-black uppercase tracking-widest text-accent mb-3">Hiring & Search Authority</div>
                <h3 class="text-2xl font-serif font-bold text-primary mb-3">Hiring senior talent in India?</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-5">Review HiredNext’s India recruitment-partner guide or explore our dedicated GCC hiring capability page.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="<?= base_url('top-recruitment-company-india') ?>" class="inline-flex text-primary font-bold hover:text-accent transition">Recruitment company guide →</a>
                    <a href="<?= base_url('industry/global-capability-centres-hiring-india') ?>" class="inline-flex text-primary font-bold hover:text-accent transition">GCC recruitment India →</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>