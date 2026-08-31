<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="min-h-screen bg-gray-50 pt-28 pb-20">
    <div class="max-w-[1500px] mx-auto px-4 sm:px-8">
        <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-5 mb-8">
            <div>
                <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-2">HiredNext Admin · CV Intelligence</div>
                <h1 class="text-4xl md:text-5xl font-serif font-bold text-primary">CV Assessment Pipeline</h1>
                <p class="text-sm text-gray-500 mt-2">Signed in as <?= esc($adminUser['name'] ?? $adminUser['username'] ?? '') ?> · see what arrived, what was analysed, what was sent, and what converted.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="<?= base_url('services/cv-assessment') ?>" target="_blank" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-primary">Candidate CV Page ↗</a>
                <a href="<?= base_url('admin/cv-reviews/logout') ?>" class="rounded-xl bg-primary px-4 py-2.5 text-sm font-bold text-white">Sign out</a>
            </div>
        </div>

        <?php if (session('success')): ?><div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800"><?= esc(session('success')) ?></div><?php endif; ?>
        <?php if (session('error')): ?><div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800"><?= esc(session('error')) ?></div><?php endif; ?>

        <?php if (!$analysisReady): ?>
            <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-900"><strong>Analysis database not installed yet.</strong> CVs are safe. Run <code>php spark migrate</code> on Hostinger after the latest pull to activate analysis/report history.</div>
        <?php endif; ?>

        <div class="mb-6 rounded-2xl border border-gray-200 bg-white px-5 py-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
            <div><div class="text-xs font-black uppercase tracking-[0.18em] text-gray-400">Multi-review panel</div><div class="text-sm text-gray-600 mt-1">HiredNext rules always run. External reviewers participate when configured; missing providers are shown rather than hidden.</div></div>
            <div class="flex flex-wrap gap-2 text-xs font-black">
                <?php foreach (($providers ?? []) as $name => $configured): ?>
                    <span class="rounded-full px-3 py-1.5 <?= $configured ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' ?>"><?= esc(strtoupper($name)) ?> · <?= $configured ? 'READY' : 'NOT CONFIGURED' ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
            <?php foreach ([
                ['Queued / not analysed', $stats['queued'] ?? 0],
                ['Analysing', $stats['analysing'] ?? 0],
                ['Ready for review', $stats['ready'] ?? 0],
                ['Reports sent', $stats['sent'] ?? 0],
                ['Payment submitted', $stats['payment_submitted'] ?? 0],
                ['Verified paid', $stats['paid_verified'] ?? 0],
            ] as $card): ?>
                <div class="rounded-2xl bg-white border border-gray-200 p-5"><div class="text-[10px] uppercase tracking-wider text-gray-400 font-bold"><?= esc($card[0]) ?></div><div class="text-3xl font-black text-primary mt-1"><?= esc((string)$card[1]) ?></div></div>
            <?php endforeach; ?>
        </div>

        <div class="rounded-[1.5rem] border border-gray-200 bg-white overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1260px] text-left">
                    <thead class="bg-primary text-white"><tr>
                        <th class="px-4 py-4 text-xs uppercase tracking-wider">Candidate</th>
                        <th class="px-4 py-4 text-xs uppercase tracking-wider">Service / Payment</th>
                        <th class="px-4 py-4 text-xs uppercase tracking-wider">Analysis / Report</th>
                        <th class="px-4 py-4 text-xs uppercase tracking-wider">Job Context</th>
                        <th class="px-4 py-4 text-xs uppercase tracking-wider">Last Action</th>
                        <th class="px-4 py-4 text-xs uppercase tracking-wider">CV</th>
                        <th class="px-4 py-4 text-xs uppercase tracking-wider">Open</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                    <?php if (empty($rows)): ?><tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No CV review requests found.</td></tr><?php endif; ?>
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $isPriority = ($row['assessment_plan'] ?? '') === 'priority_599';
                        $payment = strtolower((string)($row['payment_status'] ?? ''));
                        $leadStatus = $row['status'] ?? 'new';
                        $isSubmitted = $payment === 'pending_verification' || $leadStatus === 'payment_submitted';
                        $isPaid = in_array($payment, ['verified','paid','captured'], true);
                        if ($isPriority && $isPaid) { $serviceLabel='Priority · paid'; $serviceClass='bg-green-50 text-green-700'; }
                        elseif ($isPriority && $isSubmitted) { $serviceLabel='Priority · payment submitted'; $serviceClass='bg-amber-50 text-amber-700'; }
                        elseif ($isPriority) { $serviceLabel='Priority requested · unpaid'; $serviceClass='bg-gray-100 text-gray-600'; }
                        else { $serviceLabel='Free CV Review'; $serviceClass='bg-gray-100 text-gray-600'; }
                        $analysis = $row['analysis_status'] ?? 'not_started';
                        $reportStatus = $row['report_status'] ?? null;
                        $analysisClass = in_array($analysis,['synthesis_ready','human_review'],true) ? 'bg-blue-50 text-blue-700' : (in_array($analysis,['extract_failed','provider_failed','synthesis_failed'],true) ? 'bg-red-50 text-red-700' : 'bg-gray-100 text-gray-600');
                        ?>
                        <tr class="align-top hover:bg-gray-50/70">
                            <td class="px-4 py-5"><div class="font-black text-primary"><?= esc($row['name'] ?? '') ?></div><div class="text-sm text-gray-600"><?= esc($row['email'] ?? '') ?></div><div class="text-xs text-gray-400 mt-1"><?= esc($row['phone'] ?? '') ?> · ID #<?= esc((string)$row['id']) ?></div></td>
                            <td class="px-4 py-5"><span class="inline-flex rounded-full px-3 py-1 text-xs font-black <?= esc($serviceClass) ?>"><?= esc($serviceLabel) ?></span><div class="text-xs text-gray-500 mt-2"><?= $isPriority ? '₹599 · 12h after verification' : 'Free · 7–10 day queue' ?></div><?php if (!empty($row['payment_id'])): ?><div class="text-[11px] text-gray-400 mt-1">UPI ref: <?= esc($row['payment_id']) ?></div><?php endif; ?></td>
                            <td class="px-4 py-5"><span class="inline-flex rounded-full px-3 py-1 text-xs font-black <?= esc($analysisClass) ?>"><?= esc(str_replace('_',' ', strtoupper($analysis))) ?></span><div class="text-xs text-gray-500 mt-2">Report: <?= esc($reportStatus ? strtoupper($reportStatus) : 'NOT CREATED') ?></div><?php if (!empty($row['latest_order'])): ?><div class="text-[11px] text-accent font-bold mt-2"><?= esc($row['latest_order']['service_name'] ?? '') ?> · <?= esc(str_replace('_',' ', $row['latest_order']['status'] ?? '')) ?></div><?php endif; ?></td>
                            <td class="px-4 py-5 max-w-[260px]"><div class="font-bold text-primary"><?= esc(($row['job_title'] ?? '') ?: 'No job specified') ?></div><div class="text-xs text-gray-500 mt-1 line-clamp-2"><?= esc(($row['message'] ?? '') ?: 'No candidate note') ?></div></td>
                            <td class="px-4 py-5 text-xs text-gray-600 whitespace-nowrap"><?= esc($row['last_action_at'] ?? $row['created_at'] ?? '') ?></td>
                            <td class="px-4 py-5"><?php if (!empty($row['resume_path'])): ?><a href="<?= base_url('admin/cv-reviews/' . (int)$row['id'] . '/resume') ?>" class="inline-flex rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-black text-primary">Download</a><?php else: ?><span class="text-xs text-gray-400">No file</span><?php endif; ?></td>
                            <td class="px-4 py-5"><a href="<?= base_url('admin/cv-reviews/' . (int)$row['id']) ?>" class="inline-flex rounded-xl bg-primary px-4 py-2.5 text-xs font-black text-white">Open record →</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
