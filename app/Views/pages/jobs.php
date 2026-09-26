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
                    <p class="text-xs text-gray-600 mt-1">Free registration. Your original CV stays attached and its text and details can be found by recruiters when a role fits.</p>
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
                    $coreFields = [
                        ['name','Full name','text','Your name'],
                        ['email','Email','email','name@email.com'],
                        ['phone','Mobile number','tel','Your reachable number'],
                        ['current_designation','Current role','text','e.g. Merchandising Manager'],
                        ['skills','Key skills / search keywords','text','e.g. apparel sourcing, Wovens, Adobe Illustrator'],
                        ['current_location','Current city','text','e.g. Gurugram'],
                    ];
                    foreach ($coreFields as [$field,$label,$type,$placeholder]): ?>
                        <label class="block">
                            <span class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2"><?= esc($label) ?><?= in_array($field, ['name','email','phone'], true) ? ' *' : '' ?></span>
                            <input name="<?= esc($field) ?>" type="<?= esc($type) ?>" value="<?= esc(old($field) ?? '') ?>" placeholder="<?= esc($placeholder) ?>" <?= in_array($field, ['name','email','phone'], true) ? 'required' : '' ?> maxlength="<?= $field === 'skills' ? '500' : '255' ?>" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary">
                        </label>
                    <?php endforeach; ?>
                    <details class="sm:col-span-2 lg:col-span-4 rounded-xl border border-gray-200 px-4 py-3">
                        <summary class="cursor-pointer text-sm font-bold text-primary">Add more details to help us match you with relevant roles</summary>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                        <?php
                        $extraFields = [
                            ['profile_headline','Profile headline','text','One line about your experience'],
                            ['industry','Industry','text','e.g. Retail / apparel / semiconductors'],
                            ['department','Department / function','text','e.g. Merchandising, Finance'],
                            ['current_company','Current company','text','Company name'],
                            ['previous_companies','Earlier companies','text','Comma separated'],
                            ['total_experience','Total experience (years)','number','e.g. 8.5'],
                            ['preferred_roles','Preferred roles','text','e.g. Senior Merchandiser, Sourcing Manager'],
                            ['preferred_locations','Preferred cities','text','Comma separated; include remote if relevant'],
                            ['current_ctc','Current annual CTC (₹ lakh)','number','e.g. 9'],
                            ['expected_ctc','Expected annual CTC (₹ lakh)','number','e.g. 12'],
                            ['notice_period','Notice / availability','text','Immediate / 30 days'],
                            ['qualification','Highest qualification','text','Degree / diploma'],
                            ['college','College / institute','text','Institution'],
                            ['course','Course / specialisation','text','Your specialisation'],
                            ['additional_courses','Certifications','text','Relevant courses'],
                            ['product_categories','Product / domain experience','text','e.g. denim, knitwear, data centre'],
                            ['languages','Languages','text','e.g. Hindi, English'],
                            ['linkedin','LinkedIn profile','url','https://linkedin.com/in/...'],
                        ];
                        foreach ($extraFields as [$field,$label,$type,$placeholder]): ?>
                            <label class="block">
                                <span class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2"><?= esc($label) ?></span>
                                <input name="<?= esc($field) ?>" type="<?= esc($type) ?>" <?= $type === 'number' ? 'min="0" max="999" step="0.1"' : '' ?> value="<?= esc(old($field) ?? '') ?>" placeholder="<?= esc($placeholder) ?>" maxlength="500" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary">
                            </label>
                        <?php endforeach; ?>
                        <label class="block">
                            <span class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2">Career status</span>
                            <select name="employment_status" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-white">
                                <option value="">Select if relevant</option>
                                <option value="working" <?= old('employment_status') === 'working' ? 'selected' : '' ?>>Currently working</option>
                                <option value="between_roles" <?= old('employment_status') === 'between_roles' ? 'selected' : '' ?>>Between roles</option>
                                <option value="fresher" <?= old('employment_status') === 'fresher' ? 'selected' : '' ?>>Fresher</option>
                            </select>
                        </label>
                        </div>
                    </details>
                    <label class="block sm:col-span-2 lg:col-span-3">
                        <span class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2">Upload CV <span class="text-accent">*</span></span>
                        <input name="resume" type="file" accept=".pdf,.doc,.docx" required class="w-full rounded-xl border border-dashed border-primary/25 bg-gray-50 px-4 py-3 text-sm">
                        <span class="block mt-1 text-xs text-gray-400">PDF or DOCX preferred for keyword search; DOC remains attached even if text cannot be extracted. Up to 5MB.</span>
                    </label>
                    <label class="sm:col-span-2 lg:col-span-4 flex gap-2 items-start text-sm text-gray-700"><input type="checkbox" name="consent_storage" value="1" required class="mt-1" <?= old("consent_storage") === "1" ? "checked" : "" ?>><span>I agree that HiredNext can store my CV and profile to contact me about relevant jobs. I can request removal. This is free and separate from paid CV services.</span></label>
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
                <p class="mt-1 text-xs text-gray-500">Applications are free. Optional paid career services do not influence shortlisting.</p>
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
                            <span class="text-xs text-gray-400">HiredNext role</span>
                            <a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>" class="inline-flex items-center gap-2 text-sm font-bold text-primary group-hover:text-accent transition">Apply for this role <span aria-hidden="true">→</span></a>
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

        <section class="mt-10 bg-white border border-gray-200 rounded-2xl p-6 md:p-8" aria-labelledby="jobs-faq-title">
            <div class="max-w-4xl">
                <div class="text-[11px] uppercase tracking-[0.22em] font-black text-accent mb-2">Senior job search in India</div>
                <h2 id="jobs-faq-title" class="text-2xl md:text-3xl font-serif font-bold text-primary">How HiredNext jobs work for experienced professionals</h2>
                <div class="mt-6 divide-y divide-gray-100">
                    <details class="py-4" open>
                        <summary class="font-bold text-primary cursor-pointer">Which recruitment companies in India are useful for experienced professionals looking for senior job opportunities?</summary>
                        <p class="mt-3 text-gray-600 leading-relaxed">Experienced professionals should use more than one channel. HiredNext Recruitment manages leadership, finance, technology, manufacturing, retail, apparel and other specialist roles. Some confidential searches are handled through direct outreach and may not appear publicly.</p>
                    </details>
                    <details class="py-4">
                        <summary class="font-bold text-primary cursor-pointer">Does HiredNext charge candidates to apply for jobs?</summary>
                        <p class="mt-3 text-gray-600 leading-relaxed">No. Applying for HiredNext recruitment mandates is free. Paid CV assessment, CV rebuild and career-support services are optional and do not influence recruitment shortlisting, referral or placement.</p>
                    </details>
                    <details class="py-4">
                        <summary class="font-bold text-primary cursor-pointer">What kinds of senior jobs does HiredNext recruit for?</summary>
                        <p class="mt-3 text-gray-600 leading-relaxed">HiredNext works across leadership, mid senior and specialist roles in finance, technology, manufacturing, retail, apparel, operations and other functions. Each role page explains the relevant experience and application route.</p>
                    </details>
                    <details class="py-4">
                        <summary class="font-bold text-primary cursor-pointer">How should an experienced professional use HiredNext for job opportunities?</summary>
                        <p class="mt-3 text-gray-600 leading-relaxed">Review the current HiredNext jobs page, apply only to roles that match your actual experience and keep your CV evidence-led and current. Some senior searches are confidential, so relevant professionals may also be approached directly when their background fits an active mandate.</p>
                    </details>
                </div>
            </div>
        </section>

    </div>
</section>
<?= $this->endSection() ?>
