<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$providerStatuses = $run ? (json_decode((string)($run['provider_status_json'] ?? ''), true) ?: []) : [];
$payment = strtolower((string)($lead['payment_status'] ?? ''));
$isPaymentSubmitted = $payment === 'pending_verification' || ($lead['status'] ?? '') === 'payment_submitted';
$isPaid = in_array($payment, ['verified','paid','captured'], true);
$analysisStatus = $run['status'] ?? 'not_started';
?>
<section class="min-h-screen bg-gray-50 pt-28 pb-20">
<div class="max-w-[1500px] mx-auto px-4 sm:px-8">
    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-4 mb-7">
        <div><a href="<?= base_url('admin/cv-reviews') ?>" class="text-sm font-bold text-primary">← CV Pipeline</a><div class="text-accent text-xs font-black uppercase tracking-[0.22em] mt-4">CV Review #<?= esc((string)$lead['id']) ?></div><h1 class="text-4xl font-serif font-bold text-primary mt-1"><?= esc($lead['name'] ?? '') ?></h1><p class="text-sm text-gray-500 mt-1"><?= esc($lead['email'] ?? '') ?> · <?= esc($lead['phone'] ?? '') ?></p></div>
        <div class="flex flex-wrap gap-2"><a href="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/resume') ?>" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-primary">Download original CV</a><?php if ($reportVersion): ?><a target="_blank" href="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/report') ?>" class="rounded-xl bg-primary px-4 py-2.5 text-sm font-bold text-white">HiredNext Letterhead Preview ↗</a><?php endif; ?></div>
    </div>

    <?php if (session('success')): ?><div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session('error')): ?><div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800"><?= esc(session('error')) ?></div><?php endif; ?>

    <div class="grid lg:grid-cols-12 gap-6 mb-6">
        <div class="lg:col-span-8 grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5"><div class="text-[10px] font-black uppercase tracking-wider text-gray-400">Service selected</div><div class="font-black text-primary mt-2"><?= ($lead['assessment_plan'] ?? '') === 'priority_599' ? 'Priority ₹599' : 'Free CV Assessment' ?></div><div class="text-xs text-gray-500 mt-1"><?= esc($lead['created_at'] ?? '') ?></div></div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5"><div class="text-[10px] font-black uppercase tracking-wider text-gray-400">Payment</div><div class="font-black <?= $isPaid ? 'text-green-700' : ($isPaymentSubmitted ? 'text-amber-700' : 'text-primary') ?> mt-2"><?= esc(str_replace('_',' ', strtoupper($payment ?: 'NOT REQUIRED'))) ?></div><?php if (!empty($lead['payment_id'])): ?><div class="text-xs text-gray-500 mt-1">Ref <?= esc($lead['payment_id']) ?></div><?php endif; ?></div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5"><div class="text-[10px] font-black uppercase tracking-wider text-gray-400">Analysis</div><div class="font-black text-primary mt-2"><?= esc(str_replace('_',' ', strtoupper($analysisStatus))) ?></div><div class="text-xs text-gray-500 mt-1"><?= esc($run['updated_at'] ?? 'Not started') ?></div></div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5"><div class="text-[10px] font-black uppercase tracking-wider text-gray-400">Report</div><div class="font-black text-primary mt-2"><?= esc(strtoupper($reportVersion['status'] ?? 'NOT CREATED')) ?></div><div class="text-xs text-gray-500 mt-1"><?= $reportVersion ? 'Version ' . esc((string)$reportVersion['version']) : 'Analyse CV first' ?></div></div>
        </div>
        <div class="lg:col-span-4 rounded-2xl bg-primary text-white p-5">
            <div class="text-[10px] font-black uppercase tracking-[0.18em] text-white/55">Quick actions</div>
            <div class="flex flex-wrap gap-2 mt-4">
                <form action="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/analyse') ?>" method="post"><?= csrf_field() ?><button class="rounded-xl bg-accent px-4 py-2.5 text-xs font-black text-white"><?= $run ? 'Analyse again' : 'Analyse now' ?></button><?php if ($run): ?><input type="hidden" name="force" value="1"><?php endif; ?></form>
                <?php if ($isPaymentSubmitted && !empty($lead['payment_id']) && !$isPaid): ?><form action="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/payment-verified') ?>" method="post"><?= csrf_field() ?><button class="rounded-xl bg-white px-4 py-2.5 text-xs font-black text-primary">Mark ₹599 verified</button></form><?php endif; ?>
            </div>
            <p class="text-xs text-white/65 mt-4">Analysis always includes HiredNext rules. Configured external reviewers are added independently and their status is recorded below.</p>
        </div>
    </div>

    <div class="grid xl:grid-cols-12 gap-6">
        <div class="xl:col-span-8 space-y-6">
            <section class="rounded-2xl border border-gray-200 bg-white p-6">
                <div class="flex items-center justify-between gap-4 mb-5"><div><div class="text-[10px] font-black uppercase tracking-[0.18em] text-gray-400">Internal quality audit</div><h2 class="text-2xl font-serif font-bold text-primary">Reviewer Panel</h2></div><span class="text-xs text-gray-500">Never shown on candidate report</span></div>
                <div class="grid sm:grid-cols-3 gap-3">
                    <?php foreach (($providers ?? []) as $name => $configured): $status = $providerStatuses[$name]['status'] ?? ($configured ? 'configured / not run' : 'not_configured'); ?>
                    <div class="rounded-xl border border-gray-200 p-4"><div class="text-xs font-black text-primary"><?= esc(strtoupper($name)) ?></div><div class="text-xs mt-1 <?= $status === 'completed' ? 'text-green-700' : ($status === 'failed' ? 'text-red-700' : 'text-gray-500') ?>"><?= esc(str_replace('_',' ', $status)) ?></div><?php if (!empty($providerStatuses[$name]['finding_count'])): ?><div class="text-[11px] text-gray-400 mt-1"><?= esc((string)$providerStatuses[$name]['finding_count']) ?> findings</div><?php endif; ?></div>
                    <?php endforeach; ?>
                </div>
            </section>

            <?php if ($reportVersion): ?>
            <section class="rounded-2xl border border-gray-200 bg-white p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5"><div><div class="text-[10px] font-black uppercase tracking-[0.18em] text-gray-400">Candidate-facing HiredNext document</div><h2 class="text-2xl font-serif font-bold text-primary">Report Review & Approval</h2></div><span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-black text-gray-600"><?= esc(strtoupper($reportVersion['status'] ?? 'draft')) ?></span></div>
                <form action="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/report/save') ?>" method="post" class="space-y-4"><?= csrf_field() ?>
                    <div><label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-1">Recruiter Summary</label><textarea name="recruiter_summary" rows="5" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"><?= esc($report['recruiter_summary'] ?? '') ?></textarea></div>
                    <div><label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-1">Overall HiredNext Verdict</label><textarea name="overall_verdict" rows="3" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"><?= esc($report['overall_verdict'] ?? '') ?></textarea></div>
                    <div><label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-1">Internal human reviewer note (not shown to candidate yet)</label><textarea name="human_notes" rows="3" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"><?= esc($reportVersion['human_notes'] ?? '') ?></textarea></div>
                    <div class="flex flex-wrap gap-2"><button class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-black text-primary">Save edits</button><a target="_blank" href="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/report') ?>" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-black text-primary">Preview letterhead</a></div>
                </form>
                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                    <?php if (($reportVersion['status'] ?? '') !== 'sent'): ?><form action="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/report/approve') ?>" method="post"><?= csrf_field() ?><button class="rounded-xl bg-primary px-4 py-2.5 text-xs font-black text-white">Approve report</button></form><?php endif; ?>
                    <?php if (($reportVersion['status'] ?? '') === 'approved'): ?><form action="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/report/send') ?>" method="post"><?= csrf_field() ?><button class="rounded-xl bg-accent px-4 py-2.5 text-xs font-black text-white">Approve & Send from jobs@</button></form><?php endif; ?>
                </div>
                <?php if (!empty($report['recommended_next_step'])): $next=$report['recommended_next_step']; ?><div class="mt-5 rounded-xl bg-gray-50 p-4"><div class="text-[10px] font-black uppercase tracking-wider text-gray-400">System recommendation</div><div class="font-black text-primary mt-1"><?= esc(($next['service'] ?? '') ?: 'No paid rebuild automatically recommended') ?><?= !empty($next['price']) ? ' · ₹' . esc(number_format((int)$next['price'])) : '' ?></div><p class="text-sm text-gray-600 mt-2"><?= esc($next['reason'] ?? '') ?></p></div><?php endif; ?>
            </section>
            <?php endif; ?>

            <section class="rounded-2xl border border-gray-200 bg-white p-6">
                <div class="mb-5"><div class="text-[10px] font-black uppercase tracking-[0.18em] text-gray-400">Why the report reached its conclusions</div><h2 class="text-2xl font-serif font-bold text-primary">Evidence & Findings</h2></div>
                <?php if (!$findings): ?><p class="text-sm text-gray-500">No stored findings yet. Run analysis first.</p><?php endif; ?>
                <div class="space-y-4"><?php foreach ($findings as $finding): ?><article class="rounded-xl border border-gray-200 p-4"><div class="flex flex-wrap items-center gap-2"><span class="text-[10px] font-black uppercase tracking-wider text-accent"><?= esc($finding['severity'] ?? '') ?></span><span class="text-[10px] rounded-full bg-gray-100 px-2 py-1 text-gray-500"><?= esc($finding['reviewer'] ?? '') ?></span><span class="text-[10px] text-gray-400"><?= esc($finding['category'] ?? '') ?></span></div><h3 class="font-black text-primary mt-2"><?= esc($finding['finding'] ?? '') ?></h3><div class="mt-2 rounded-lg bg-gray-50 px-3 py-2 text-xs text-gray-600"><strong>Evidence:</strong> <?= esc($finding['evidence'] ?? '') ?></div><p class="text-xs text-gray-600 mt-2"><strong>Why it matters:</strong> <?= esc($finding['why_it_matters'] ?? '') ?></p><p class="text-xs text-gray-600 mt-1"><strong>Fix:</strong> <?= esc($finding['recommendation'] ?? '') ?></p></article><?php endforeach; ?></div>
            </section>
        </div>

        <aside class="xl:col-span-4 space-y-6">
            <section class="rounded-2xl border border-gray-200 bg-white p-6"><div class="text-[10px] font-black uppercase tracking-[0.18em] text-gray-400">Evidence-led revenue options</div><h2 class="text-2xl font-serif font-bold text-primary mt-1">Send Optional Service</h2><p class="text-xs text-gray-500 mt-2 mb-4">Each offer is individual, tracked, and creates a secure candidate checkout link. Paid services remain separate from recruitment.</p><div class="space-y-3"><?php foreach (($upgradePlans ?? []) as $tier => $plan): ?><div class="rounded-xl border border-gray-200 p-4"><div class="font-black text-primary"><?= esc($plan['name']) ?> · ₹<?= esc(number_format((int)$plan['amount'])) ?></div><div class="text-xs text-gray-500 mt-1"><?= esc($plan['delivery']) ?></div><form action="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/offer/' . $tier) ?>" method="post" class="mt-3"><?= csrf_field() ?><button class="rounded-lg border border-primary px-3 py-2 text-xs font-black text-primary">Send offer from jobs@</button></form></div><?php endforeach; ?></div></section>

            <section class="rounded-2xl border border-gray-200 bg-white p-6"><div class="text-[10px] font-black uppercase tracking-[0.18em] text-gray-400">Payment & fulfilment</div><h2 class="text-2xl font-serif font-bold text-primary mt-1">CV Service Orders</h2><?php if (!$orders): ?><p class="text-sm text-gray-500 mt-3">No paid upgrade orders yet.</p><?php endif; ?><div class="space-y-3 mt-4"><?php foreach ($orders as $order): ?><div class="rounded-xl border border-gray-200 p-4"><div class="font-black text-primary"><?= esc($order['service_name'] ?? '') ?> · ₹<?= esc(number_format((int)($order['amount'] ?? 0))) ?></div><div class="text-xs text-gray-500 mt-1">Status: <?= esc(str_replace('_',' ', $order['status'] ?? '')) ?></div><?php if (!empty($order['payment_reference'])): ?><div class="text-xs text-gray-500">UPI ref: <?= esc($order['payment_reference']) ?></div><?php endif; ?><div class="flex flex-wrap gap-2 mt-3"><?php if (($order['status'] ?? '') === 'payment_submitted'): ?><form action="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/orders/' . (int)$order['id'] . '/verify') ?>" method="post"><?= csrf_field() ?><button class="rounded-lg bg-green-700 px-3 py-2 text-xs font-black text-white">Mark verified</button></form><?php endif; ?><?php if (in_array($order['status'] ?? '', ['verified','in_fulfilment'], true)): ?><form action="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/orders/' . (int)$order['id'] . '/status') ?>" method="post" class="flex gap-2"><?= csrf_field() ?><select name="status" class="rounded-lg border border-gray-200 px-2 py-2 text-xs"><option value="in_fulfilment">In fulfilment</option><option value="delivered">Delivered</option><option value="cancelled">Cancelled</option></select><button class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-black">Save</button></form><?php endif; ?></div></div><?php endforeach; ?></div></section>

            <section class="rounded-2xl border border-gray-200 bg-white p-6"><div class="text-[10px] font-black uppercase tracking-[0.18em] text-gray-400">Outbound audit</div><h2 class="text-2xl font-serif font-bold text-primary mt-1">Email History</h2><?php if (!$emails): ?><p class="text-sm text-gray-500 mt-3">No tracked email events yet.</p><?php endif; ?><div class="space-y-3 mt-4 max-h-[430px] overflow-auto"><?php foreach ($emails as $mail): ?><div class="border-b border-gray-100 pb-3"><div class="text-xs font-black text-primary"><?= esc($mail['event_type'] ?? '') ?> · <?= esc(strtoupper($mail['status'] ?? '')) ?></div><div class="text-xs text-gray-500 mt-1"><?= esc($mail['recipient'] ?? '') ?></div><div class="text-[11px] text-gray-400 mt-1"><?= esc($mail['subject'] ?? '') ?> · <?= esc($mail['created_at'] ?? '') ?></div><?php if (!empty($mail['error_message'])): ?><div class="text-[11px] text-red-600 mt-1"><?= esc($mail['error_message']) ?></div><?php endif; ?></div><?php endforeach; ?></div></section>

            <section class="rounded-2xl border border-gray-200 bg-white p-6"><div class="text-[10px] font-black uppercase tracking-[0.18em] text-gray-400">Everything that happened</div><h2 class="text-2xl font-serif font-bold text-primary mt-1">Timeline</h2><?php if (!$timeline): ?><p class="text-sm text-gray-500 mt-3">No audit events yet.</p><?php endif; ?><div class="space-y-3 mt-4 max-h-[520px] overflow-auto"><?php foreach ($timeline as $event): $meta=json_decode((string)($event['metadata_json'] ?? ''),true) ?: []; ?><div class="border-l-2 border-gray-200 pl-3"><div class="text-xs font-black text-primary"><?= esc(str_replace('_',' ', $event['event_type'] ?? '')) ?></div><div class="text-[11px] text-gray-400"><?= esc($event['created_at'] ?? '') ?> · <?= esc($event['actor_type'] ?? '') ?><?= !empty($event['outcome']) ? ' · ' . esc($event['outcome']) : '' ?></div><?php if ($meta): ?><div class="text-[11px] text-gray-500 mt-1"><?= esc(mb_substr(json_encode($meta, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),0,260)) ?></div><?php endif; ?></div><?php endforeach; ?></div></section>
        </aside>
    </div>
</div>
</section>
<?= $this->endSection() ?>
