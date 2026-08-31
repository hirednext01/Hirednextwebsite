<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="min-h-screen bg-gray-50 pt-28 pb-20">
    <div class="max-w-[1380px] mx-auto px-4 sm:px-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-8">
            <div>
                <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-2">HiredNext Admin</div>
                <h1 class="text-4xl font-serif font-bold text-primary">CV Review Requests</h1>
                <p class="text-sm text-gray-500 mt-2">Signed in as <?= esc($adminUser['name'] ?? $adminUser['username'] ?? '') ?> · <?= esc($adminUser['role'] ?? '') ?></p>
            </div>
            <div class="flex gap-3">
                <a href="<?= base_url('services/cv-assessment') ?>" target="_blank" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-primary">Open CV Review Page ↗</a>
                <a href="<?= base_url('admin/cv-reviews/logout') ?>" class="rounded-xl bg-primary px-4 py-2.5 text-sm font-bold text-white">Sign out</a>
            </div>
        </div>

        <?php if (session('success')): ?>
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800"><?= esc(session('success')) ?></div>
        <?php endif; ?>
        <?php if (session('error')): ?>
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="rounded-2xl bg-white border border-gray-200 p-5"><div class="text-xs uppercase tracking-wider text-gray-400 font-bold">Latest 250</div><div class="text-3xl font-black text-primary mt-1"><?= esc((string)($stats['total'] ?? 0)) ?></div></div>
            <div class="rounded-2xl bg-white border border-gray-200 p-5"><div class="text-xs uppercase tracking-wider text-gray-400 font-bold">Priority requested</div><div class="text-3xl font-black text-primary mt-1"><?= esc((string)($stats['priority_requested'] ?? 0)) ?></div></div>
            <div class="rounded-2xl bg-white border border-gray-200 p-5"><div class="text-xs uppercase tracking-wider text-gray-400 font-bold">Payment submitted</div><div class="text-3xl font-black text-accent mt-1"><?= esc((string)($stats['payment_submitted'] ?? 0)) ?></div></div>
            <div class="rounded-2xl bg-white border border-gray-200 p-5"><div class="text-xs uppercase tracking-wider text-gray-400 font-bold">Verified paid</div><div class="text-3xl font-black text-primary mt-1"><?= esc((string)($stats['paid_verified'] ?? 0)) ?></div></div>
            <div class="rounded-2xl bg-white border border-gray-200 p-5"><div class="text-xs uppercase tracking-wider text-gray-400 font-bold">New</div><div class="text-3xl font-black text-primary mt-1"><?= esc((string)($stats['new'] ?? 0)) ?></div></div>
        </div>

        <div class="rounded-[1.5rem] border border-gray-200 bg-white overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1200px] text-left">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="px-4 py-4 text-xs uppercase tracking-wider">Candidate</th>
                            <th class="px-4 py-4 text-xs uppercase tracking-wider">Service</th>
                            <th class="px-4 py-4 text-xs uppercase tracking-wider">Payment</th>
                            <th class="px-4 py-4 text-xs uppercase tracking-wider">Job / Message</th>
                            <th class="px-4 py-4 text-xs uppercase tracking-wider">Submitted</th>
                            <th class="px-4 py-4 text-xs uppercase tracking-wider">CV</th>
                            <th class="px-4 py-4 text-xs uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($rows)): ?>
                            <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No CV review requests found.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($rows as $row): ?>
                            <?php
                            $isPriority = ($row['assessment_plan'] ?? '') === 'priority_599';
                            $payment = $row['payment_status'] ?? '';
                            $status = $row['status'] ?? 'new';
                            $isSubmitted = $payment === 'pending_verification' || $status === 'payment_submitted';
                            $isPaid = in_array($payment, ['verified', 'paid'], true);
                            if ($isPriority && $isPaid) {
                                $serviceLabel = 'Priority · paid';
                                $serviceClass = 'bg-green-50 text-green-700';
                            } elseif ($isPriority && $isSubmitted) {
                                $serviceLabel = 'Priority · payment submitted';
                                $serviceClass = 'bg-amber-50 text-amber-700';
                            } elseif ($isPriority) {
                                $serviceLabel = 'Priority requested · unpaid';
                                $serviceClass = 'bg-gray-100 text-gray-600';
                            } else {
                                $serviceLabel = 'Free CV Review';
                                $serviceClass = 'bg-gray-100 text-gray-600';
                            }
                            ?>
                            <tr class="align-top hover:bg-gray-50/70">
                                <td class="px-4 py-5">
                                    <div class="font-black text-primary"><?= esc($row['name'] ?? '') ?></div>
                                    <a class="text-sm text-accent hover:underline" href="mailto:<?= esc($row['email'] ?? '') ?>"><?= esc($row['email'] ?? '') ?></a>
                                    <div class="text-sm text-gray-500 mt-1"><?= esc($row['phone'] ?? '') ?></div>
                                    <div class="text-[11px] text-gray-400 mt-2">ID #<?= esc((string)($row['id'] ?? '')) ?></div>
                                </td>
                                <td class="px-4 py-5">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-black <?= esc($serviceClass) ?>"><?= esc($serviceLabel) ?></span>
                                    <div class="text-sm font-bold text-primary mt-2"><?= $isPriority ? '₹599 · 12 hours after payment verification' : '₹0 · 7–10 days' ?></div>
                                </td>
                                <td class="px-4 py-5">
                                    <div class="font-bold text-primary"><?= esc($payment ?: '—') ?></div>
                                    <?php if (!empty($row['payment_id'])): ?><div class="text-xs text-gray-500 mt-2">UPI: <?= esc($row['payment_id']) ?></div><?php endif; ?>
                                </td>
                                <td class="px-4 py-5 max-w-[320px]">
                                    <div class="font-bold text-primary"><?= esc(($row['job_title'] ?? '') ?: 'No job specified') ?></div>
                                    <div class="text-sm text-gray-500 mt-2 line-clamp-3"><?= esc(($row['message'] ?? '') ?: 'No message') ?></div>
                                </td>
                                <td class="px-4 py-5 text-sm text-gray-600 whitespace-nowrap"><?= esc($row['created_at'] ?? '') ?></td>
                                <td class="px-4 py-5">
                                    <?php if (!empty($row['resume_path'])): ?>
                                        <a href="<?= base_url('admin/cv-reviews/' . (int)$row['id'] . '/resume') ?>" class="inline-flex rounded-xl bg-primary px-4 py-2 text-xs font-black text-white">Download CV</a>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">No file</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-5">
                                    <form action="<?= base_url('admin/cv-reviews/' . (int)$row['id'] . '/status') ?>" method="post" class="flex gap-2 items-center">
                                        <?= csrf_field() ?>
                                        <select name="status" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-bold text-primary">
                                            <?php foreach (['new' => 'New', 'payment_submitted' => 'Payment submitted', 'in_review' => 'In review', 'completed' => 'Completed', 'closed' => 'Closed'] as $value => $label): ?>
                                                <option value="<?= esc($value) ?>" <?= $status === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-bold text-primary">Save</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
