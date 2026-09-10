<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$jobUrl = base_url('jobs/' . ($job['slug'] ?? ''));
$shareText = 'HiredNext opportunity: ' . ($job['title'] ?? 'Job') . (!empty($job['location']) ? ' — ' . $job['location'] : '') . ' ' . $jobUrl;
$whatsAppUrl = 'https://wa.me/?text=' . rawurlencode($shareText);
$emailUrl = 'mailto:?subject=' . rawurlencode('Job opportunity: ' . ($job['title'] ?? 'HiredNext role')) . '&body=' . rawurlencode("Thought this role may be relevant to you:\n\n" . $shareText);
$linkedinUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode($jobUrl);

// Presentation-only related roles: read open jobs, never mutate job/application data.
$similarJobs = [];
try {
    $db = \Config\Database::connect();
    $candidates = $db->table('jobs')
        ->where('status', 'open')
        ->where('id !=', $job['id'] ?? 0)
        ->orderBy('created_at', 'DESC')
        ->limit(20)
        ->get()
        ->getResultArray();
    $currentDepartment = strtolower(trim((string)($job['department'] ?? '')));
    $currentLocation = strtolower(trim((string)($job['location'] ?? '')));
    foreach ($candidates as &$candidate) {
        $score = 0;
        if ($currentDepartment !== '' && strtolower(trim((string)($candidate['department'] ?? ''))) === $currentDepartment) $score += 4;
        if ($currentLocation !== '' && strtolower(trim((string)($candidate['location'] ?? ''))) === $currentLocation) $score += 2;
        $currentWords = array_filter(preg_split('/[^a-z0-9]+/i', strtolower((string)($job['title'] ?? ''))));
        $candidateTitle = strtolower((string)($candidate['title'] ?? ''));
        foreach ($currentWords as $word) if (strlen($word) > 3 && str_contains($candidateTitle, $word)) $score++;
        $candidate['_match_score'] = $score;
    }
    unset($candidate);
    usort($candidates, static fn($a, $b) => ($b['_match_score'] <=> $a['_match_score']) ?: strcmp((string)($b['created_at'] ?? ''), (string)($a['created_at'] ?? '')));
    $similarJobs = array_slice($candidates, 0, 3);
} catch (\Throwable $e) {
    $similarJobs = [];
}
?>

<section class="bg-primary text-white pt-24 pb-7 md:pt-28 md:pb-8 border-b border-white/10">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 lg:px-12">
        <a href="<?= base_url('jobs') ?>" class="inline-flex items-center text-white/65 hover:text-white text-xs font-bold uppercase tracking-widest mb-4">← Back to jobs</a>
        <div class="grid lg:grid-cols-12 gap-6 items-end">
            <div class="lg:col-span-8">
                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="px-2.5 py-1 bg-white/10 border border-white/10 rounded-full text-[10px] font-black uppercase tracking-widest"><?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'full-time'))) ?></span>
                    <?php if (!empty($job['department'])): ?><span class="px-2.5 py-1 bg-white/10 border border-white/10 rounded-full text-[10px] font-black uppercase tracking-widest"><?= esc($job['department']) ?></span><?php endif; ?>
                </div>
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight"><?= esc($job['title'] ?? '') ?></h1>
                <div class="flex flex-wrap gap-x-5 gap-y-2 mt-4 text-sm text-white/70">
                    <?php if (!empty($job['location'])): ?><span>⌖ <?= esc($job['location']) ?></span><?php endif; ?>
                    <?php if (!empty($job['experience'])): ?><span>◷ <?= esc($job['experience']) ?> experience</span><?php endif; ?>
                    <?php if (!empty($job['created_at'])): ?><span>Posted <?= esc(date('d M Y', strtotime($job['created_at']))) ?></span><?php endif; ?>
                </div>
            </div>
            <div class="lg:col-span-4 lg:text-right">
                <a href="#apply" class="inline-flex w-full lg:w-auto justify-center px-7 py-3.5 rounded-xl bg-white text-primary font-black hover:bg-gold transition">Apply for this role</a>
            </div>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-8 md:py-10">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
            <main class="lg:col-span-8 space-y-6">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5 mb-6 border-b border-gray-100">
                        <div><div class="text-[11px] font-black uppercase tracking-widest text-accent mb-1">Role details</div><h2 class="text-2xl font-bold text-primary">About this opportunity</h2></div>
                        <div class="flex flex-wrap gap-2">
                            <a href="<?= esc($whatsAppUrl, 'attr') ?>" target="_blank" rel="noopener noreferrer" class="px-3 py-2 rounded-lg border border-gray-200 text-xs font-bold text-gray-700 hover:border-primary hover:text-primary transition">WhatsApp</a>
                            <a href="<?= esc($emailUrl, 'attr') ?>" class="px-3 py-2 rounded-lg border border-gray-200 text-xs font-bold text-gray-700 hover:border-primary hover:text-primary transition">Email</a>
                            <a href="<?= esc($linkedinUrl, 'attr') ?>" target="_blank" rel="noopener noreferrer" class="px-3 py-2 rounded-lg border border-gray-200 text-xs font-bold text-gray-700 hover:border-primary hover:text-primary transition">LinkedIn</a>
                            <button type="button" onclick="copyJobLink(this)" class="px-3 py-2 rounded-lg border border-gray-200 text-xs font-bold text-gray-700 hover:border-primary hover:text-primary transition">Copy link</button>
                        </div>
                    </div>
                    <div class="prose prose-lg max-w-none text-gray-700 job-richtext"><?= $job['description'] ?? '' ?></div>
                </div>

                <?php if (!empty($similarJobs)): ?>
                    <section class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8">
                        <div class="flex items-end justify-between gap-4 mb-5">
                            <div><div class="text-[11px] font-black uppercase tracking-widest text-accent mb-1">You may also consider</div><h2 class="text-2xl font-bold text-primary">Similar opportunities</h2></div>
                            <a href="<?= base_url('jobs') ?>" class="text-sm font-bold text-primary hover:text-accent">All jobs →</a>
                        </div>
                        <div class="grid md:grid-cols-3 gap-3">
                            <?php foreach ($similarJobs as $related): ?>
                                <a href="<?= base_url('jobs/' . ($related['slug'] ?? '')) ?>" class="block border border-gray-200 rounded-xl p-4 hover:border-primary/40 hover:shadow-sm transition">
                                    <div class="text-[10px] uppercase tracking-widest font-black text-accent mb-2"><?= esc($related['department'] ?? 'Opportunity') ?></div>
                                    <h3 class="font-bold text-primary leading-snug mb-2"><?= esc($related['title'] ?? '') ?></h3>
                                    <div class="text-xs text-gray-500"><?= esc($related['location'] ?? '') ?></div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </main>

            <aside class="lg:col-span-4 space-y-5 lg:sticky lg:top-24">
                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-lg font-bold text-primary mb-4">Job summary</h3>
                    <dl class="space-y-3 text-sm">
                        <?php if (!empty($job['location'])): ?><div class="flex justify-between gap-4 border-b border-gray-100 pb-3"><dt class="text-gray-500">Location</dt><dd class="text-right font-semibold text-primary"><?= esc($job['location']) ?></dd></div><?php endif; ?>
                        <div class="flex justify-between gap-4 border-b border-gray-100 pb-3"><dt class="text-gray-500">Type</dt><dd class="text-right font-semibold text-primary"><?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'full-time'))) ?></dd></div>
                        <?php if (!empty($job['department'])): ?><div class="flex justify-between gap-4 border-b border-gray-100 pb-3"><dt class="text-gray-500">Industry</dt><dd class="text-right font-semibold text-primary"><?= esc($job['department']) ?></dd></div><?php endif; ?>
                        <?php if (!empty($job['experience'])): ?><div class="flex justify-between gap-4"><dt class="text-gray-500">Experience</dt><dd class="text-right font-semibold text-primary"><?= esc($job['experience']) ?></dd></div><?php endif; ?>
                    </dl>
                    <a href="#apply" class="mt-5 inline-flex w-full justify-center px-5 py-3 rounded-xl bg-primary text-white font-black hover:bg-accent transition">Apply now</a>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-5">
                    <div class="text-[11px] uppercase tracking-widest font-black text-accent mb-2">Know someone suitable?</div>
                    <h3 class="text-lg font-bold text-primary mb-2">Send them this job</h3>
                    <p class="text-sm text-gray-500 mb-4">Forward the opportunity directly. No account or login is required to view it.</p>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="<?= esc($whatsAppUrl, 'attr') ?>" target="_blank" rel="noopener noreferrer" class="text-center px-3 py-2.5 rounded-lg border border-gray-200 text-xs font-bold hover:border-primary hover:text-primary">WhatsApp</a>
                        <a href="<?= esc($emailUrl, 'attr') ?>" class="text-center px-3 py-2.5 rounded-lg border border-gray-200 text-xs font-bold hover:border-primary hover:text-primary">Email</a>
                        <a href="<?= esc($linkedinUrl, 'attr') ?>" target="_blank" rel="noopener noreferrer" class="text-center px-3 py-2.5 rounded-lg border border-gray-200 text-xs font-bold hover:border-primary hover:text-primary">LinkedIn</a>
                        <button type="button" onclick="copyJobLink(this)" class="px-3 py-2.5 rounded-lg border border-gray-200 text-xs font-bold hover:border-primary hover:text-primary">Copy link</button>
                    </div>
                </div>
            </aside>
        </div>

        <section id="apply" class="scroll-mt-24 mt-8 bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-7"><div class="text-[11px] uppercase tracking-widest font-black text-accent mb-2">Confidential application</div><h2 id="apply-heading" class="text-2xl md:text-3xl font-bold text-primary">Apply for <?= esc($job['title'] ?? 'this role') ?></h2><p class="text-sm text-gray-500 mt-2">Your application is submitted only for this exact role.</p></div>
                <?php if (session('success')): ?><div role="status" class="rounded-xl border border-green-200 bg-green-50 text-green-700 px-5 py-4 text-sm font-semibold mb-5"><?= esc(session('success')) ?></div><?php endif; ?>
                <?php if (session('errors')): ?><div role="alert" class="rounded-xl border border-red-200 bg-red-50 text-red-700 px-5 py-4 text-sm font-semibold mb-5"><?= esc(implode(' ', session('errors'))) ?></div><?php endif; ?>

                <form action="<?= base_url('jobs/' . ($job['slug'] ?? '') . '/apply') ?>" method="post" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4" aria-labelledby="apply-heading" data-agent-action="apply-to-job" data-job-slug="<?= esc($job['slug'] ?? '') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="job_slug" value="<?= esc($job['slug'] ?? '') ?>" />
                    <div><label for="application-name" class="block text-sm font-bold text-primary mb-2">Full name *</label><input id="application-name" name="name" autocomplete="name" required placeholder="Full Name" class="w-full border border-gray-200 rounded-xl px-4 py-3" /></div>
                    <div><label for="application-email" class="block text-sm font-bold text-primary mb-2">Email *</label><input id="application-email" name="email" type="email" autocomplete="email" inputmode="email" required placeholder="Email" class="w-full border border-gray-200 rounded-xl px-4 py-3" /></div>
                    <div><label for="application-phone" class="block text-sm font-bold text-primary mb-2">Phone *</label><input id="application-phone" name="phone" type="tel" autocomplete="tel" inputmode="tel" required placeholder="Phone" class="w-full border border-gray-200 rounded-xl px-4 py-3" /></div>
                    <div><label for="application-linkedin" class="block text-sm font-bold text-primary mb-2">LinkedIn profile URL *</label><input id="application-linkedin" name="linkedin" type="text" inputmode="url" autocomplete="url" required placeholder="linkedin.com/in/your-profile" class="w-full border border-gray-200 rounded-xl px-4 py-3" /><p class="mt-1 text-xs text-gray-500">With or without https://</p></div>
                    <div class="md:col-span-2"><label for="application-message" class="block text-sm font-bold text-primary mb-2">Short message <span class="text-gray-400 font-normal">optional</span></label><textarea id="application-message" name="message" placeholder="Short message (optional)" class="w-full border border-gray-200 rounded-xl px-4 py-3" rows="3"></textarea></div>
                    <div class="md:col-span-2 rounded-xl border border-dashed border-gray-300 px-4 py-4 text-sm text-gray-500"><label for="application-resume" class="block text-sm font-bold text-primary mb-2">Resume / CV *</label><input id="application-resume" name="resume" type="file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required class="w-full" aria-describedby="application-resume-help" /><p id="application-resume-help" class="text-xs text-gray-500 mt-2">PDF, DOC or DOCX. Maximum 5MB.</p></div>
                    <div class="md:col-span-2"><button type="submit" class="w-full bg-primary text-white py-3.5 rounded-xl font-black hover:bg-accent transition" aria-label="Submit application for <?= esc($job['title'] ?? 'this role') ?>">Submit application</button><p class="text-xs text-gray-500 mt-3 text-center">HiredNext does not charge candidates to apply for a job or secure placement.</p></div>
                </form>
            </div>
        </section>
    </div>
</section>

<div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200 p-3 flex gap-2 shadow-2xl">
    <a href="#apply" class="flex-1 text-center bg-primary text-white rounded-xl py-3 text-sm font-black">Apply now</a>
    <button type="button" onclick="copyJobLink(this)" class="px-5 border border-gray-200 rounded-xl text-sm font-bold text-primary">Share</button>
</div>
<script>
function copyJobLink(button) {
    const url = <?= json_encode($jobUrl, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    const original = button.textContent;
    const done = () => { button.textContent = 'Link copied'; setTimeout(() => button.textContent = original, 1600); };
    if (navigator.clipboard && window.isSecureContext) navigator.clipboard.writeText(url).then(done).catch(() => fallbackCopy(url, done));
    else fallbackCopy(url, done);
}
function fallbackCopy(url, done) {
    const input = document.createElement('textarea'); input.value = url; input.style.position = 'fixed'; input.style.opacity = '0'; document.body.appendChild(input); input.select();
    try { document.execCommand('copy'); done(); } catch (e) { window.prompt('Copy this job link:', url); }
    document.body.removeChild(input);
}
</script>
<?= $this->endSection() ?>