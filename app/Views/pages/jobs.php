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
        <div>
            <div class="max-w-3xl">
                <div class="text-[11px] uppercase tracking-[0.24em] text-gold font-black mb-3">HiredNext Job Board</div>
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight">Find your next opportunity</h1>
                <p class="mt-3 text-sm md:text-base text-white/70 max-w-2xl">Explore leadership, technology, manufacturing, retail, finance and specialist roles managed through HiredNext.</p>
            </div>
        </div>
    </div>
</section>

<section id="talent-pool" class="bg-white border-b border-gray-100 scroll-mt-24">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 lg:px-12 py-3">
        <details class="group rounded-2xl border border-primary/15 bg-[#f8f5ef] overflow-hidden" <?= session()->getFlashdata('talentPoolError') || old('name') || old('email') ? 'open' : '' ?>>
            <summary class="cursor-pointer list-none flex items-center justify-between gap-3 px-4 py-3 md:px-5">
                <div>
                    <h2 class="text-sm md:text-base font-bold text-primary">Add your CV. We will contact you when the right role matches your profile.</h2>
                    <p class="text-xs text-gray-600 mt-1">Free registration. Submit your CV once.</p>
                </div>
                <span class="shrink-0 inline-flex items-center justify-center rounded-xl bg-primary text-white px-5 py-3 text-sm font-black group-open:bg-accent">Add my CV +</span>
            </summary>
            <div class="border-t border-primary/10 bg-white p-5 md:p-7">
                <?php if ($message = session()->getFlashdata('talentPoolSuccess')): ?>
                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800"><?= esc($message) ?></div>
                <?php endif; ?>
                <?php if ($message = session()->getFlashdata('talentPoolError')): ?>
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800"><?= esc($message) ?></div>
                <?php endif; ?>
                <form method="post" action="<?= base_url('jobs/talent-pool') ?>" enctype="multipart/form-data" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <?= csrf_field() ?>
                    <?php
                    $poolFields = [
                        ['name','Full name','text','Your name'],
                        ['email','Email','email','name@email.com'],
                        ['phone','Phone','text','Mobile number'],
                        ['current_designation','Current designation','text','e.g. Merchandising Manager'],
                        ['department','Department / function','text','e.g. Merchandising, Finance, Quality'],
                        ['current_company','Current company','text','Company name'],
                        ['total_experience','Total experience','text','e.g. 12 years'],
                        ['current_location','Current location','text','City'],
                        ['preferred_locations','Preferred locations','text','Cities / remote preference'],
                        ['current_ctc','Current CTC','text','Optional'],
                        ['expected_ctc','Expected CTC','text','Optional'],
                        ['notice_period','Notice period','text','Immediate / 30 days etc.'],
                        ['qualification','Highest qualification','text','Degree / diploma'],
                        ['college','College / institute','text','Institution'],
                        ['course','Course / specialisation','text','Course'],
                        ['additional_courses','Additional courses / certifications','text','Optional'],
                        ['linkedin','LinkedIn profile','url','https://linkedin.com/in/...'],
                    ];
                    foreach ($poolFields as [$field,$label,$type,$placeholder]): ?>
                        <label class="block">
                            <span class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2"><?= esc($label) ?></span>
                            <input name="<?= esc($field) ?>" type="<?= esc($type) ?>" value="<?= esc(old($field) ?? '') ?>" placeholder="<?= esc($placeholder) ?>" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary">
                        </label>
                    <?php endforeach; ?>
                    <label class="block">
                        <span class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2">Career status</span>
                        <select name="employment_status" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary">
                            <option value="">Select if relevant</option>
                            <option value="working" <?= old('employment_status') === 'working' ? 'selected' : '' ?>>Currently working</option>
                            <option value="between_roles" <?= old('employment_status') === 'between_roles' ? 'selected' : '' ?>>Between roles</option>
                            <option value="fresher" <?= old('employment_status') === 'fresher' ? 'selected' : '' ?>>Fresher</option>
                        </select>
                    </label>
                    <label class="block sm:col-span-2 lg:col-span-3">
                        <span class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2">Upload CV <span class="text-accent">*</span></span>
                        <input name="resume" type="file" accept=".pdf,.doc,.docx" required class="w-full rounded-xl border border-dashed border-primary/25 bg-gray-50 px-4 py-3 text-sm">
                        <span class="block mt-1 text-xs text-gray-400">PDF, DOC or DOCX up to 5MB. All profile fields above are optional.</span>
                    </label>
                    <div class="sm:col-span-2 lg:col-span-1 flex items-end">
                        <button type="submit" class="w-full rounded-xl bg-accent px-5 py-3.5 font-black text-white hover:bg-primary transition">Add me to the talent pool</button>
                    </div>
                    <p class="sm:col-span-2 lg:col-span-4 text-xs text-gray-500">This is free candidate registration in HiredNext's searchable talent pool. It is separate from HiredNext's paid CV assessment, CV rebuilding and LinkedIn profile services.</p>
                </form>
            </div>
        </details>
    </div>
</section>

<section class="bg-gray-50 py-8 md:py-10">
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
                            <option value="<?= esc($industry) ?>…3818 tokens truncated…
]);

const failed = [...checks].filter(([, passed]) => !passed);
for (const [label, passed] of checks) {
  console.log(`${passed ? 'PASS' : 'FAIL'}: ${label}`);
}

if (failed.length) {
  process.exitCode = 1;
}
