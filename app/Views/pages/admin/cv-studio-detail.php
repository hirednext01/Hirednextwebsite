<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="min-h-screen bg-gray-50 pt-28 pb-20">
<div class="max-w-[1500px] mx-auto px-4 sm:px-8">
    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-5 mb-8">
        <div>
            <a href="<?= base_url('admin/cv-studio') ?>" class="text-sm font-bold text-primary">← CV Studio</a>
            <div class="text-accent text-xs font-black uppercase tracking-[0.22em] mt-4">Managed CV Creation · Review #<?= esc((string)$lead['id']) ?></div>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-primary mt-1"><?= esc($lead['name'] ?? '') ?></h1>
            <p class="text-sm text-gray-500 mt-2"><?= esc($lead['email'] ?? '') ?> · <?= esc($lead['phone'] ?? '') ?> · candidate supplied source CV</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="<?= base_url('admin/cv-reviews/' . (int)$lead['id']) ?>" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-primary">Assessment & audit</a>
            <a href="<?= base_url('admin/cv-reviews/' . (int)$lead['id'] . '/resume') ?>" class="rounded-xl bg-primary px-4 py-2.5 text-sm font-bold text-white">Download source CV</a>
        </div>
    </div>

    <?php if (session('success')): ?><div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session('error')): ?><div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800"><?= esc(session('error')) ?></div><?php endif; ?>

    <div class="grid xl:grid-cols-12 gap-6">
        <div class="xl:col-span-8 space-y-6">
            <section class="rounded-[1.75rem] border border-gray-200 bg-white p-6 md:p-8">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                    <div><div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Choose a design direction</div><h2 class="text-3xl font-serif font-bold text-primary mt-1">3 ATS-safe HiredNext templates</h2><p class="text-sm text-gray-500 mt-2 max-w-2xl">These are presentation directions only. HiredNext writes the actual content from the candidate's uploaded CV. The final document is clean; HiredNext branding is removable.</p></div>
                </div>

                <div class="grid md:grid-cols-3 gap-5 mt-7">
                    <?php
                    $samples = [
                        'ats_classic' => ['ATS Classic','Cleanest parser-first layout','Single-column · standard headings · understated premium typography'],
                        'ats_modern' => ['ATS Modern','Sharper contemporary hierarchy','Single reading order · modern accents · recruiter-friendly scan'],
                        'executive_ats' => ['Executive ATS','Leadership-impact presentation','Board/CXO emphasis · scale and outcomes · ATS-safe structure'],
                    ];
                    foreach ($samples as $key => $sample): ?>
                        <div class="rounded-2xl border border-gray-200 overflow-hidden bg-white">
                            <div class="relative h-[330px] bg-[#fbfbfa] p-5 overflow-hidden">
                                <div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none"><span class="-rotate-12 text-2xl font-black tracking-[0.18em] text-primary/10">SAMPLE PREVIEW</span></div>
                                <div style="filter:blur(.42px);user-select:none" class="text-[7px] leading-[1.35] text-gray-700">
                                    <div class="<?= $key === 'executive_ats' ? 'bg-primary text-white -mx-5 -mt-5 px-5 py-5 mb-4' : '' ?>">
                                        <div class="text-[17px] font-black <?= $key === 'executive_ats' ? 'text-white' : 'text-primary' ?>">ARJUN MALHOTRA</div>
                                        <div class="text-[8px] font-bold <?= $key === 'ats_modern' ? 'text-accent' : '' ?>">SENIOR OPERATIONS & TRANSFORMATION LEADER</div>
                                        <div class="mt-2">Mumbai · email@example.com · +91 98XXXXXX10 · LinkedIn</div>
                                    </div>
                                    <div class="border-b border-gray-300 pb-2 mb-3"><div class="font-black text-primary text-[9px]">PROFESSIONAL SUMMARY</div><div class="mt-1">Operations leader with extensive experience across transformation, scale, cost, people and cross-functional execution. Career evidence is rewritten for clarity without inventing facts.</div></div>
                                    <?php if ($key === 'executive_ats'): ?><div class="border-b border-gray-300 pb-2 mb-3"><div class="font-black text-primary text-[9px]">LEADERSHIP IMPACT</div><div class="mt-1">P&L · transformation · business scale · people leadership · governance · growth</div></div><?php endif; ?>
                                    <div class="border-b border-gray-300 pb-2 mb-3"><div class="font-black text-primary text-[9px]">CORE EXPERTISE</div><div class="mt-1">Operational Excellence · Strategy · Transformation · Cost Optimisation · Stakeholder Management · Team Leadership</div></div>
                                    <div><div class="font-black text-primary text-[9px]">PROFESSIONAL EXPERIENCE</div><div class="font-black mt-2">XYZ MANUFACTURING PVT. LTD.</div><div>Operations Director · 2021–Present</div><ul class="list-disc ml-3 mt-1 space-y-1"><li>Achievement-led bullet structured around scope, action and factual result.</li><li>Career language sharpened for recruiter and ATS readability.</li><li>Quantified impact included only where supported by source evidence.</li></ul><div class="font-black mt-3">ABC INDUSTRIES LTD.</div><div>Senior Operations Manager · 2016–2020</div><ul class="list-disc ml-3 mt-1"><li>Earlier experience compressed to preserve relevance and scanability.</li></ul></div>
                                </div>
                            </div>
                            <div class="p-4 border-t border-gray-100"><div class="font-black text-primary"><?= esc($sample[0]) ?></div><div class="text-xs text-gray-600 mt-1"><?= esc($sample[1]) ?></div><div class="text-[11px] text-gray-400 mt-2"><?= esc($sample[2]) ?></div></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <form action="<?= base_url('admin/cv-studio/' . (int)$lead['id'] . '/generate') ?>" method="post" class="mt-7 rounded-2xl bg-gray-50 p-5">
                    <?= csrf_field() ?>
                    <div class="grid md:grid-cols-3 gap-4 items-end">
                        <div><label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Template</label><select name="template" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-bold text-primary"><option value="ats_classic">ATS Classic</option><option value="ats_modern">ATS Modern</option><option value="executive_ats">Executive ATS</option></select></div>
                        <div><label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Link to service order (optional)</label><select name="order_id" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-primary"><option value="">No order / internal draft</option><?php foreach (($orders ?? []) as $order): ?><option value="<?= (int)$order['id'] ?>"><?= esc($order['service_name'] ?? '') ?> · <?= esc(str_replace('_',' ', $order['status'] ?? '')) ?></option><?php endforeach; ?></select></div>
                        <div><button class="w-full rounded-xl bg-accent px-5 py-3 text-sm font-black text-white">Generate HiredNext CV</button></div>
                    </div>
                    <p class="text-[11px] text-gray-500 mt-3">The candidate does not fill a form. The writer panel uses the stored source CV and assessment evidence. Missing facts are flagged instead of invented.</p>
                </form>
            </section>

            <section class="rounded-[1.75rem] border border-gray-200 bg-white p-6 md:p-8">
                <div class="flex items-end justify-between gap-4"><div><div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Document history</div><h2 class="text-3xl font-serif font-bold text-primary mt-1">Generated CV drafts</h2></div><div class="text-xs text-gray-400"><?= count($documents ?? []) ?> versions</div></div>
                <?php if (empty($documents)): ?><div class="mt-6 rounded-xl bg-gray-50 p-5 text-sm text-gray-500">No CV draft generated yet.</div><?php endif; ?>
                <div class="space-y-5 mt-6">
                    <?php foreach (($documents ?? []) as $doc): ?>
                        <article class="rounded-2xl border border-gray-200 p-5">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <div><div class="flex flex-wrap gap-2"><span class="rounded-full bg-primary/5 px-3 py-1 text-xs font-black text-primary"><?= esc(str_replace('_',' ', strtoupper($doc['template_key'] ?? ''))) ?></span><span class="rounded-full px-3 py-1 text-xs font-black <?= ($doc['status'] ?? '') === 'delivered' ? 'bg-green-50 text-green-700' : (($doc['status'] ?? '') === 'clarification_needed' ? 'bg-amber-50 text-amber-700' : 'bg-gray-100 text-gray-600') ?>"><?= esc(str_replace('_',' ', strtoupper($doc['status'] ?? ''))) ?></span></div><div class="text-xs text-gray-400 mt-2">Document #<?= (int)$doc['id'] ?> · <?= esc($doc['created_at'] ?? '') ?></div></div>
                                <div class="flex flex-wrap gap-2"><a target="_blank" href="<?= base_url('admin/cv-studio/' . (int)$lead['id'] . '/documents/' . (int)$doc['id']) ?>" class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-black text-primary">Preview</a><a href="<?= base_url('admin/cv-studio/' . (int)$lead['id'] . '/documents/' . (int)$doc['id'] . '/word') ?>" class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-black text-primary">Download Word</a><?php if (($doc['status'] ?? '') !== 'clarification_needed'): ?><form action="<?= base_url('admin/cv-studio/' . (int)$lead['id'] . '/documents/' . (int)$doc['id'] . '/deliver') ?>" method="post"><?= csrf_field() ?><button class="rounded-lg bg-primary px-3 py-2 text-xs font-black text-white"><?= ($doc['status'] ?? '') === 'delivered' ? 'Send again' : 'Email candidate' ?></button></form><?php endif; ?></div>
                            </div>

                            <?php if (!empty($doc['clarifications'])): ?>
                                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4"><div class="text-xs font-black uppercase tracking-wider text-amber-800">Clarification needed before delivery</div><div class="space-y-2 mt-2"><?php foreach ($doc['clarifications'] as $item): ?><div class="text-sm text-amber-900"><strong><?= esc($item['question'] ?? '') ?></strong><?php if (!empty($item['why_needed'])): ?><div class="text-xs text-amber-700 mt-0.5"><?= esc($item['why_needed']) ?></div><?php endif; ?></div><?php endforeach; ?></div></div>
                            <?php endif; ?>

                            <div class="grid md:grid-cols-2 gap-4 mt-4">
                                <div class="rounded-xl bg-gray-50 p-4"><div class="text-[10px] font-black uppercase tracking-wider text-gray-400">Candidate headline</div><div class="font-black text-primary mt-1"><?= esc($doc['content']['headline'] ?? $doc['content']['target_title'] ?? '—') ?></div><div class="text-xs text-gray-500 mt-2 line-clamp-3"><?= esc($doc['content']['summary'] ?? '') ?></div></div>
                                <div class="rounded-xl bg-gray-50 p-4"><div class="text-[10px] font-black uppercase tracking-wider text-gray-400">Writer panel</div><div class="flex flex-wrap gap-2 mt-2"><?php foreach (($doc['panel'] ?? []) as $name => $state): ?><span class="rounded-full bg-white border border-gray-200 px-2.5 py-1 text-[10px] font-black <?= ($state['status'] ?? '') === 'completed' ? 'text-green-700' : 'text-gray-500' ?>"><?= esc(strtoupper($name)) ?> · <?= esc(str_replace('_',' ', $state['status'] ?? '')) ?></span><?php endforeach; ?></div></div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3"><div class="text-xs text-gray-500">Final candidate CV branding: <strong><?= ($doc['branding_mode'] ?? 'remove') === 'remove' ? 'NO HIREDNEXT BRANDING' : 'KEEP DISCREET HIREDNEXT CREDIT' ?></strong></div><form action="<?= base_url('admin/cv-studio/' . (int)$lead['id'] . '/documents/' . (int)$doc['id'] . '/branding') ?>" method="post" class="flex gap-2"><?= csrf_field() ?><select name="branding_mode" class="rounded-lg border border-gray-200 px-3 py-2 text-xs"><option value="remove" <?= ($doc['branding_mode'] ?? '') === 'remove' ? 'selected' : '' ?>>Remove HiredNext branding</option><option value="keep" <?= ($doc['branding_mode'] ?? '') === 'keep' ? 'selected' : '' ?>>Keep discreet credit</option></select><button class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-bold text-primary">Save</button></form></div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

        <aside class="xl:col-span-4 space-y-6">
            <section class="rounded-[1.75rem] bg-primary text-white p-6">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/55">Writer agents</div><h2 class="text-2xl font-serif font-bold mt-1">Internal panel status</h2><div class="space-y-3 mt-5"><?php foreach (($writers ?? []) as $name => $configured): ?><div class="rounded-xl border border-white/15 bg-white/5 p-4 flex items-center justify-between"><div class="font-black text-sm"><?= esc(strtoupper($name)) ?></div><div class="text-xs <?= $configured ? 'text-green-300' : 'text-white/45' ?>"><?= $configured ? 'READY' : 'NOT CONFIGURED' ?></div></div><?php endforeach; ?></div><p class="text-xs text-white/55 mt-4">These names remain internal. The candidate sees a HiredNext-created CV, not an AI transcript.</p>
            </section>

            <section class="rounded-[1.75rem] border border-gray-200 bg-white p-6">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Commercial structure</div><h2 class="text-2xl font-serif font-bold text-primary mt-1">CV creation services</h2><div class="space-y-3 mt-5"><?php foreach (($pricedPlans ?? []) as $tier => $plan): if ($tier === 'priority_599') continue; ?><div class="rounded-xl border border-gray-200 p-4"><div class="font-black text-primary"><?= esc($plan['name']) ?> · ₹<?= esc(number_format((int)$plan['amount'])) ?></div><div class="text-xs text-gray-500 mt-1"><?= esc($plan['delivery']) ?></div></div><?php endforeach; ?><div class="rounded-xl border-2 border-primary p-4"><div class="font-black text-primary"><?= esc($executivePlan['name'] ?? 'C-Suite Executive CV Advisory') ?></div><div class="text-sm font-black text-accent mt-1"><?= esc($executivePlan['price_label'] ?? 'Price on Request') ?></div><div class="text-xs text-gray-500 mt-2"><?= esc($executivePlan['delivery'] ?? '') ?></div><div class="text-xs text-gray-500 mt-2">Includes a 1-to-1 positioning call and specialist executive resume expert.</div></div></div>
            </section>

            <section class="rounded-[1.75rem] border border-gray-200 bg-white p-6"><div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Current service orders</div><h2 class="text-2xl font-serif font-bold text-primary mt-1">Payment / fulfilment</h2><?php if (empty($orders)): ?><p class="text-sm text-gray-500 mt-4">No CV creation order yet.</p><?php endif; ?><div class="space-y-3 mt-4"><?php foreach (($orders ?? []) as $order): ?><div class="rounded-xl bg-gray-50 p-4"><div class="font-black text-primary"><?= esc($order['service_name'] ?? '') ?></div><div class="text-xs text-gray-500 mt-1"><?= !empty($order['amount']) ? '₹' . esc(number_format((int)$order['amount'])) . ' · ' : '' ?><?= esc(str_replace('_',' ', strtoupper($order['status'] ?? ''))) ?></div></div><?php endforeach; ?></div></section>
        </aside>
    </div>
</div>
</section>
<?= $this->endSection() ?>
