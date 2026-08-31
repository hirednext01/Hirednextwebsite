<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$qrUrl = base_url('cv-payment/qr') . '?v=20260831';
$tier = (string)($order['tier'] ?? '');
$showCvCreationPitch = in_array($tier, ['ats_999', 'rebuild_1799'], true);
?>
<style>
    #navbar { background:#fff !important; box-shadow:0 8px 30px rgba(12,52,102,.08); padding-top:1rem !important; padding-bottom:1rem !important; }
    #navbar #logoText, #navbar .nav-link, #navbar #menuBtn { color:#0c3466 !important; }
    .sample-soft { filter: blur(.42px); user-select:none; -webkit-user-select:none; }
</style>
<section class="min-h-[75vh] pt-32 pb-20 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <?php if ($showCvCreationPitch): ?>
        <section class="mb-8 rounded-[2rem] border border-gray-200 bg-white p-7 md:p-10 shadow-sm">
            <div class="max-w-4xl">
                <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">HiredNext Managed CV Creation</div>
                <h1 class="text-3xl md:text-5xl font-serif font-bold text-primary leading-tight">Give us the CV you have. We build the CV you should be sending.</h1>
                <p class="text-lg text-gray-600 leading-relaxed mt-5">You are not buying a template and you are not being asked to rewrite your own career. HiredNext starts with your existing CV, extracts the facts, identifies what is buried or weak, rewrites the positioning and achievement language, checks the document for ATS-safe structure, and creates the finished CV for you.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-5 mt-8">
                <?php foreach ([
                    ['ATS Classic','Parser-first and highly versatile','Single-column · standard headings · understated premium typography'],
                    ['ATS Modern','Sharper contemporary presentation','Clean source order · modern hierarchy · recruiter-friendly scan'],
                    ['Executive ATS','Leadership and impact focused','Scale · mandate · business outcomes · board/CXO readability'],
                ] as $i => $sample): ?>
                <article class="rounded-2xl border border-gray-200 overflow-hidden bg-white">
                    <div class="h-[280px] bg-[#fbfbfa] p-5 relative overflow-hidden">
                        <div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none"><span class="-rotate-12 text-xl font-black tracking-[0.14em] text-primary/10">SAMPLE PREVIEW</span></div>
                        <div class="sample-soft text-[6px] leading-[1.45] text-gray-700">
                            <div class="<?= $i === 2 ? 'bg-primary text-white -mx-5 -mt-5 px-5 py-5 mb-3' : '' ?>">
                                <div class="text-[16px] font-black <?= $i === 2 ? 'text-white' : 'text-primary' ?>">ARJUN MALHOTRA</div>
                                <div class="text-[7px] font-black <?= $i === 1 ? 'text-accent' : '' ?>">SENIOR OPERATIONS & TRANSFORMATION LEADER</div>
                                <div class="mt-1">Mumbai · email@example.com · +91 98XXXXXX10</div>
                            </div>
                            <div class="border-b border-gray-300 pb-2 mb-2"><div class="font-black text-primary text-[8px]">PROFESSIONAL SUMMARY</div><div class="mt-1">Senior operating profile rewritten around scope, transformation, commercial contribution and recruiter relevance.</div></div>
                            <div class="border-b border-gray-300 pb-2 mb-2"><div class="font-black text-primary text-[8px]">CORE COMPETENCIES</div><div class="mt-1">Strategy · Operations · Transformation · Cost Optimisation · Stakeholder Management</div></div>
                            <div><div class="font-black text-primary text-[8px]">PROFESSIONAL EXPERIENCE</div><div class="font-black mt-2">XYZ MANUFACTURING PVT. LTD.</div><div>Operations Director · 2021–Present</div><ul class="list-disc ml-3 mt-1 space-y-1"><li>Achievement-led language created from verified source facts.</li><li>Role-relevant evidence surfaced for ATS and recruiter scanning.</li><li>No invented numbers, titles or business outcomes.</li></ul></div>
                        </div>
                    </div>
                    <div class="p-5"><div class="text-[10px] font-black text-accent">OPTION <?= $i + 1 ?></div><h3 class="text-xl font-serif font-bold text-primary mt-1"><?= esc($sample[0]) ?></h3><p class="text-sm text-gray-600 mt-2"><?= esc($sample[1]) ?></p><p class="text-xs text-gray-400 mt-2"><?= esc($sample[2]) ?></p></div>
                </article>
                <?php endforeach; ?>
            </div>
            <p class="text-xs text-gray-400 text-center mt-4">Previews are intentionally softened and watermarked. Your completed paid CV is delivered clean and high quality. HiredNext branding can be removed from the final document.</p>

            <div class="grid md:grid-cols-4 gap-4 mt-8">
                <?php foreach ([
                    ['1','We read the CV you already have','Career facts, chronology, roles, skills and evidenced achievements are extracted first.'],
                    ['2','We diagnose why it may undersell you','Recruiter logic, ATS structure, positioning, missing evidence and role-language gaps are reviewed.'],
                    ['3','We rewrite and build it for you','HiredNext creates the summary, hierarchy and achievement-led experience language without inventing facts.'],
                    ['4','You review a finished draft','You check facts and request the revision rounds included in your selected service.'],
                ] as $step): ?>
                <div class="rounded-2xl bg-gray-50 border border-gray-200 p-5"><div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-black"><?= esc($step[0]) ?></div><div class="font-black text-primary mt-3"><?= esc($step[1]) ?></div><p class="text-xs text-gray-500 mt-2 leading-relaxed"><?= esc($step[2]) ?></p></div>
                <?php endforeach; ?>
            </div>

            <div class="mt-8 rounded-2xl bg-primary p-6 text-white">
                <div class="text-gold text-xs font-black uppercase tracking-[0.18em]">Why this is different from a generic AI rewrite</div>
                <p class="text-white/85 mt-3 leading-relaxed">The final document is built through a controlled HiredNext workflow: source facts are separated from assumptions, recruiter and ATS issues are assessed, rewriting is evidence-constrained, factual gaps are flagged instead of fabricated, and the completed CV is rendered into an ATS-safe professional document. The candidate receives a finished career document, not a chat answer.</p>
            </div>
        </section>
        <?php endif; ?>

        <div class="bg-white rounded-[2rem] border border-gray-200 p-7 md:p-10 shadow-sm">
            <div class="grid md:grid-cols-2 gap-10 items-start">
                <div>
                    <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">HiredNext CV Service</div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4"><?= esc($order['service_name'] ?? 'CV Service') ?></h2>
                    <p class="text-gray-600 leading-relaxed mb-6"><?= esc($plan['description'] ?? '') ?></p>
                    <div class="rounded-2xl bg-primary text-white p-6 mb-6">
                        <div class="text-[10px] uppercase tracking-[0.22em] text-white/55 font-black mb-2">Amount to pay</div>
                        <div class="text-4xl font-black">₹<?= esc(number_format((int)($order['amount'] ?? 0))) ?></div>
                        <div class="text-sm text-white/70 mt-2"><?= esc($plan['delivery'] ?? '') ?></div>
                    </div>
                    <div class="flex flex-col items-center rounded-2xl border border-gray-200 bg-gray-50 p-5">
                        <div class="bg-white p-3 rounded-2xl border border-gray-200 shadow-sm">
                            <img src="<?= esc($qrUrl) ?>" alt="HiredNext payment QR" width="280" height="280" class="block w-[280px] max-w-full h-auto object-contain" loading="eager" decoding="sync">
                        </div>
                        <div class="mt-4 font-black tracking-[0.16em] text-primary">HIREDNEXT</div>
                    </div>
                </div>
                <div>
                    <?php if (session('success')): ?><div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800 font-semibold"><?= esc(session('success')) ?></div><?php endif; ?>
                    <?php if (session('error')): ?><div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 font-semibold"><?= esc(session('error')) ?></div><?php endif; ?>
                    <div class="mb-6">
                        <div class="text-[10px] uppercase tracking-[0.22em] text-accent font-black mb-2">After payment</div>
                        <h2 class="text-2xl font-serif font-bold text-primary mb-2">Submit the transaction reference</h2>
                        <p class="text-sm text-gray-600 leading-relaxed">Use the same email address used for your HiredNext CV request. Payment remains pending until HiredNext verifies the transaction.</p>
                    </div>
                    <form action="<?= base_url('cv-upgrade/' . esc($order['token'])) ?>" method="post" class="space-y-4">
                        <?= csrf_field() ?>
                        <div><label class="block text-sm font-bold text-primary mb-1">Email used with HiredNext *</label><input type="email" name="email" required value="<?= esc(old('email')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="you@example.com"></div>
                        <div><label class="block text-sm font-bold text-primary mb-1">UPI transaction/reference number *</label><input name="payment_reference" required minlength="6" value="<?= esc(old('payment_reference')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Reference shown by your payment app"></div>
                        <button type="submit" class="w-full bg-accent text-white py-4 rounded-xl font-bold hover:opacity-90 transition">I have paid ₹<?= esc(number_format((int)($order['amount'] ?? 0))) ?> — Submit for verification</button>
                        <p class="text-xs text-gray-500 text-center">This professional CV service is optional and separate from recruitment consideration, job applications, interviews or placement through HiredNext.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
