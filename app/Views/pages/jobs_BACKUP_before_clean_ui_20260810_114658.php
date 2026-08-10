<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="hero-services relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden text-white">
    <div class="hero-overlay"></div>
    <div class="hero-sheen"></div>
    <div class="hero-noise"></div>

    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10 text-center">
        <div
            class="reveal reveal-up inline-flex items-center gap-3 px-5 py-2 bg-white/10 border border-white/15 rounded-full text-[11px] uppercase tracking-[0.35em] font-bold mb-8">
            <span class="h-2 w-2 rounded-full bg-accent shadow-[0_0_12px_rgba(255,78,22,0.8)]"></span>
            Careers
        </div>
        <h1 class="reveal reveal-up text-5xl md:text-7xl font-bold font-serif mb-8 leading-tight">
            Join the HiredNext <span class="text-accent">Team</span>
        </h1>
        <p class="reveal reveal-up text-lg md:text-2xl text-white/80 max-w-3xl mx-auto leading-relaxed">
            Explore open roles and help shape leadership teams across industries.
        </p>
        <div class="reveal reveal-up mt-10 flex flex-wrap justify-center gap-6 text-xs uppercase tracking-[0.3em] text-white/60">
            <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-gold"></span> Leadership</span>
            <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-accent"></span> Growth</span>
            <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-white"></span> Impact</span>
        </div>
    </div>
</header>

<section class="py-24 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10" id="jobsGrid">
                    <?php if (!empty($jobs)): ?>
                        <?php foreach ($jobs as $job): ?>
                            <div class="bg-gray-50 border border-gray-100 rounded-3xl p-8 hover:shadow-2xl transition-all job-card"
                                 data-title="<?= esc(strtolower($job['title'] ?? '')) ?>"
                                 data-location="<?= esc(strtolower($job['location'] ?? '')) ?>"
                                 data-type="<?= esc(strtolower($job['type'] ?? '')) ?>"
                                 data-department="<?= esc(strtolower($job['department'] ?? '')) ?>">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold uppercase tracking-widest text-accent">
                                <?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'full-time'))) ?>
                            </span>
                            <span class="text-xs font-bold text-gray-400">
                                <?= esc($job['location'] ?? '') ?>
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-primary mb-4">
                            <?= esc($job['title'] ?? '') ?>
                        </h3>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 uppercase tracking-widest mb-4">
                            <span>Posted <?= !empty($job['created_at']) ? esc(date('M d, Y', strtotime($job['created_at']))) : '' ?></span>
                            <?php if (!empty($job['experience'])): ?>
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-300"></span>
                                <span><?= esc($job['experience']) ?> Experience</span>
                            <?php endif; ?>
                        </div>
                        <div class="prose prose-sm max-w-none text-gray-600 mb-6 line-clamp-4 job-richtext">
                            <?= $job['description'] ?? '' ?>
                        </div>
                        <a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>"
                            class="inline-flex items-center text-sm font-bold text-primary hover:text-accent transition-colors">
                            View Job <span class="ml-2">→</span>
                        </a>
                    </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center text-gray-500">
                            No open jobs at the moment. Please check back soon.
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($pager)): ?>
                    <?= $pager->links('default', 'pager_jobs') ?>
                <?php endif; ?>
            </div>

            <aside class="lg:col-span-4 space-y-6">
                <div class="bg-gray-50 border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-primary mb-4">Search Roles</h3>
                    <?php
                    $filters = $filters ?? [];
                    $types = $types ?? [];
                    $locations = $locations ?? [];
                    $departments = $departments ?? [];
                    ?>
                    <form method="get" class="space-y-4">
                        <input name="q" type="text" placeholder="Search by title or keyword"
                               value="<?= esc($filters['q'] ?? '') ?>"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm" />
                        <select name="type" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            <option value="">All Types</option>
                            <?php foreach ($types as $type): ?>
                                <option value="<?= esc($type) ?>" <?= ($filters['type'] ?? '') === $type ? 'selected' : '' ?>>
                                    <?= esc(ucwords(str_replace('-', ' ', $type))) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="location" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            <option value="">All Locations</option>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?= esc($location) ?>" <?= ($filters['location'] ?? '') === $location ? 'selected' : '' ?>>
                                    <?= esc($location) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="department" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            <option value="">All Departments</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= esc($dept) ?>" <?= ($filters['department'] ?? '') === $dept ? 'selected' : '' ?>>
                                    <?= esc($dept) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit"
                                class="w-full bg-primary text-white rounded-xl px-4 py-3 text-sm font-bold hover:bg-accent transition-all">
                            Apply Filters
                        </button>
                        <a href="<?= base_url('jobs') ?>"
                           class="block w-full text-center border border-primary text-primary rounded-xl px-4 py-3 text-sm font-bold hover:bg-primary hover:text-white transition-all">
                            Clear Filters
                        </a>
                    </form>
                </div>

                <?php
                $ctaTitle = $settings['jobs_sidebar_cta_title'] ?? 'Not seeing the right role?';
                $ctaText = $settings['jobs_sidebar_cta_text'] ?? 'Share your profile and we’ll reach out when a matching opportunity opens.';
                $ctaLink = $settings['jobs_sidebar_cta_link'] ?? base_url('contact');
                ?>
                <div class="bg-primary text-white rounded-[2.5rem] p-8 shadow-xl">
                    <h3 class="text-xl font-bold mb-3"><?= esc($ctaTitle) ?></h3>
                    <p class="text-white/70 text-sm mb-6">
                        <?= esc($ctaText) ?>
                    </p>
                    <a href="<?= esc($ctaLink) ?>"
                       class="inline-flex items-center px-6 py-3 bg-white text-primary rounded-full font-bold hover:bg-accent hover:text-white transition-all">
                        Submit Your Profile →
                    </a>
                </div>
            </aside>
        </div>
    </section>
<?= $this->endSection() ?>
