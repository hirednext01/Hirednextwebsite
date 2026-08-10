<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-16 bg-primary text-white overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent opacity-10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 -left-20 w-80 h-80 bg-gold opacity-10 rounded-full blur-3xl"></div>

    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <a href="<?= base_url('jobs') ?>" class="text-white/70 text-sm font-bold uppercase tracking-widest">← Back to Jobs</a>
        <h1 class="text-4xl md:text-6xl font-bold mt-6 font-serif">
            <?= esc($job['title'] ?? '') ?>
        </h1>
        <div class="flex flex-wrap gap-4 mt-6 text-white/70">
            <span class="px-4 py-1.5 bg-white/10 rounded-full text-xs font-bold uppercase tracking-widest">
                <?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'full-time'))) ?>
            </span>
            <span class="px-4 py-1.5 bg-white/10 rounded-full text-xs font-bold uppercase tracking-widest">
                <?= esc($job['location'] ?? '') ?>
            </span>
            <?php if (!empty($job['department'])): ?>
                <span class="px-4 py-1.5 bg-white/10 rounded-full text-xs font-bold uppercase tracking-widest">
                    <?= esc($job['department']) ?>
                </span>
            <?php endif; ?>
            <?php if (!empty($job['experience'])): ?>
                <span class="px-4 py-1.5 bg-white/10 rounded-full text-xs font-bold uppercase tracking-widest">
                    <?= esc($job['experience']) ?> Experience
                </span>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-16">
        <div class="lg:col-span-7">
            <div class="bg-white border border-gray-100 rounded-[2.5rem] p-10 shadow-sm">
                <h2 class="text-3xl font-bold text-primary mb-6">Role Overview</h2>
                <div class="prose prose-lg max-w-none text-gray-700 job-richtext">
                    <?= $job['description'] ?? '' ?>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 space-y-6">
            <div class="bg-gray-50 border border-gray-100 rounded-[2.5rem] p-8">
                <h3 class="text-xl font-bold text-primary mb-4">Job Summary</h3>
                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                        <span class="font-semibold text-primary">Location</span>
                        <span><?= esc($job['location'] ?? '') ?></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                        <span class="font-semibold text-primary">Type</span>
                        <span><?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'full-time'))) ?></span>
                    </div>
                    <?php if (!empty($job['department'])): ?>
                        <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                            <span class="font-semibold text-primary">Department</span>
                            <span><?= esc($job['department']) ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($job['experience'])): ?>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-primary">Experience</span>
                            <span><?= esc($job['experience']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
                <h3 class="text-2xl font-bold text-primary mb-4">Apply for this role</h3>

                <?php if (session('success')): ?>
                    <div class="rounded-2xl border border-green-200 bg-green-50 text-green-700 px-6 py-4 text-sm font-semibold mb-6">
                        <?= esc(session('success')) ?>
                    </div>
                <?php endif; ?>
                <?php if (session('errors')): ?>
                    <div class="rounded-2xl border border-red-200 bg-red-50 text-red-700 px-6 py-4 text-sm font-semibold mb-6">
                        <?= esc(implode(' ', session('errors'))) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('jobs/' . ($job['slug'] ?? '') . '/apply') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
                    <input name="name" required placeholder="Full Name" class="w-full border border-gray-200 rounded-xl px-4 py-3" />
                    <input name="email" type="email" required placeholder="Email" class="w-full border border-gray-200 rounded-xl px-4 py-3" />
                    <input name="phone" required placeholder="Phone" class="w-full border border-gray-200 rounded-xl px-4 py-3" />
                    <input name="linkedin" required placeholder="LinkedIn Profile URL" class="w-full border border-gray-200 rounded-xl px-4 py-3" />
                    <textarea name="message" placeholder="Short message (optional)" class="w-full border border-gray-200 rounded-xl px-4 py-3" rows="4"></textarea>
                    <div class="rounded-xl border border-dashed border-gray-300 px-4 py-4 text-sm text-gray-500">
                        <input name="resume" type="file" accept=".pdf,.doc,.docx" required class="w-full" />
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-accent transition-all">
                        Submit Application
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-4">Accepted formats: PDF, DOC, DOCX (max 5MB)</p>
            </div>

            <div class="relative overflow-hidden bg-primary text-white rounded-[2.5rem] p-8 shadow-xl border border-primary">
                <div class="absolute -right-12 -top-12 w-32 h-32 bg-accent/20 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <div class="text-[11px] uppercase tracking-[0.25em] font-black text-gold mb-3">Not ready to apply?</div>
                    <h3 class="text-2xl font-serif font-bold mb-3">Get your CV assessed first.</h3>
                    <p class="text-sm text-white/75 leading-relaxed mb-6">Get a free CV assessment in 7–10 days, or choose our ₹599 priority assessment for detailed feedback within 12 hours.</p>
                    <a href="<?= base_url('cv-assessment?job=' . urlencode($job['slug'] ?? '')) ?>" class="inline-flex w-full justify-center px-5 py-3 rounded-xl bg-accent text-white font-bold hover:opacity-90 transition">Assess My CV →</a>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-100 rounded-[2.5rem] p-8">
                <h3 class="text-xl font-bold text-primary mb-4">Application Tips</h3>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li>Highlight measurable outcomes and leadership impact.</li>
                    <li>Keep your LinkedIn profile updated and consistent.</li>
                    <li>Tailor your resume to the role’s responsibilities.</li>
                    <li>Use a clear subject line and concise message.</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
