<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $rows = $rows ?? []; $stats = $stats ?? []; ?>

<section class="pt-28 pb-16 bg-[#f5f3ee] min-h-screen">
  <div class="max-w-[1240px] mx-auto px-6">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
      <div>
        <div class="text-[10px] uppercase tracking-[0.28em] font-black text-accent mb-2">HiredNext Admin</div>
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-primary">Testimonials</h1>
        <p class="mt-3 text-gray-500 max-w-2xl">Review original evidence, edit only the display copy, then publish. Public evidence links remain attached wherever candidates supplied them.</p>
      </div>
      <div class="flex gap-3">
        <a href="<?= base_url('admin/cv-reviews') ?>" class="px-5 py-3 rounded-full border border-gray-300 bg-white text-sm font-bold text-primary">CV Reviews</a>
        <a href="<?= base_url('testimonials') ?>" target="_blank" class="px-5 py-3 rounded-full bg-primary text-white text-sm font-bold">View public page ↗</a>
      </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
      <?php foreach (['total'=>'Total','pending'=>'Pending','active'=>'Published','external'=>'External','rejected'=>'Rejected'] as $key=>$label): ?>
        <div class="rounded-2xl bg-white border border-gray-200 p-4">
          <div class="text-2xl font-serif font-bold text-primary"><?= esc((string)($stats[$key] ?? 0)) ?></div>
          <div class="text-[10px] uppercase tracking-[0.16em] text-gray-400 font-black mt-1"><?= esc($label) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if (session('success')): ?><div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session('error')): ?><div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800"><?= esc(session('error')) ?></div><?php endif; ?>

    <div class="space-y-4">
      <?php foreach ($rows as $row): ?>
        <?php
          $status = strtolower((string)($row['status'] ?? 'pending'));
          $name = $row['client_name'] ?? $row['name'] ?? 'Unnamed';
          $company = $row['company'] ?? '';
          $role = $row['designation'] ?? $row['placement_role'] ?? $row['location'] ?? '';
          $quote = $row['comment'] ?? '';
          $hasEvidence = trim((string)($row['linkedin_url'] ?? $row['source_url'] ?? '')) !== '';
        ?>
        <a href="<?= base_url('admin/testimonials/' . (int)$row['id']) ?>" class="block bg-white rounded-2xl border border-gray-200 p-5 md:p-6 hover:border-accent hover:shadow-lg transition">
          <div class="grid lg:grid-cols-[1fr_auto] gap-5 items-start">
            <div>
              <div class="flex flex-wrap gap-2 items-center mb-3">
                <span class="text-lg font-serif font-bold text-primary"><?= esc($name) ?></span>
                <span class="px-2.5 py-1 rounded-full text-[9px] uppercase tracking-[0.14em] font-black <?= $status === 'active' ? 'bg-green-50 text-green-700' : ($status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') ?>"><?= esc($status) ?></span>
                <?php if ($hasEvidence): ?><span class="px-2.5 py-1 rounded-full text-[9px] uppercase tracking-[0.14em] font-black bg-blue-50 text-blue-700">Evidence linked</span><?php endif; ?>
              </div>
              <div class="text-xs uppercase tracking-[0.14em] text-gray-400 font-bold mb-3"><?= esc(implode(' · ', array_filter([$role, $company]))) ?></div>
              <p class="text-sm text-gray-600 leading-relaxed line-clamp-3"><?= esc($quote) ?></p>
            </div>
            <div class="text-sm font-bold text-accent">Review →</div>
          </div>
        </a>
      <?php endforeach; ?>
      <?php if (!$rows): ?><div class="bg-white border border-gray-200 rounded-2xl p-10 text-center text-gray-500">No testimonial records found.</div><?php endif; ?>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
