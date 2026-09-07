<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$row = $row ?? [];
$id = (int)($row['id'] ?? 0);
$status = strtolower((string)($row['status'] ?? 'pending'));
$name = $row['client_name'] ?? $row['name'] ?? '';
$company = $row['company'] ?? '';
$designation = $row['designation'] ?? '';
$comment = $row['comment'] ?? '';
$original = $row['original_comment'] ?? $comment;
$linkedin = $row['linkedin_url'] ?? '';
$sourceUrl = $row['source_url'] ?? '';
$sourceLabel = $row['source_label'] ?? '';
?>
<section class="pt-28 pb-16 bg-[#f5f3ee] min-h-screen">
  <div class="max-w-[1100px] mx-auto px-6">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-7">
      <div>
        <a href="<?= base_url('admin/testimonials') ?>" class="text-xs font-bold text-accent">← All testimonials</a>
        <h1 class="text-3xl md:text-4xl font-serif font-bold text-primary mt-2"><?= esc($name ?: 'Testimonial') ?></h1>
      </div>
      <span class="px-3 py-1.5 rounded-full text-[10px] uppercase tracking-[0.16em] font-black <?= $status === 'active' ? 'bg-green-50 text-green-700' : ($status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') ?>"><?= esc($status) ?></span>
    </div>

    <?php if (session('success')): ?><div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session('error')): ?><div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800"><?= esc(session('error')) ?></div><?php endif; ?>

    <div class="grid lg:grid-cols-2 gap-6 mb-6">
      <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="text-[10px] uppercase tracking-[0.22em] font-black text-gray-400 mb-3">Original submission / evidence</div>
        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap"><?= esc($original) ?></p>
        <div class="mt-5 pt-5 border-t border-gray-100 space-y-2 text-sm">
          <?php if (!empty($row['submitter_email'])): ?><div><b>Email:</b> <?= esc($row['submitter_email']) ?></div><?php endif; ?>
          <?php if (!empty($row['placement_date'])): ?><div><b>Placement date:</b> <?= esc($row['placement_date']) ?></div><?php endif; ?>
          <?php if (!empty($row['placement_role'])): ?><div><b>Placement:</b> <?= esc($row['placement_role']) ?></div><?php endif; ?>
          <?php if (!empty($row['placement_location'])): ?><div><b>Location:</b> <?= esc($row['placement_location']) ?></div><?php endif; ?>
          <?php if ($sourceLabel): ?><div><b>Source:</b> <?= esc($sourceLabel) ?></div><?php endif; ?>
        </div>
        <div class="flex flex-wrap gap-3 mt-5">
          <?php if ($linkedin): ?><a href="<?= esc($linkedin) ?>" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-full border border-blue-200 bg-blue-50 text-blue-700 text-xs font-black">LinkedIn profile ↗</a><?php endif; ?>
          <?php if ($sourceUrl): ?><a href="<?= esc($sourceUrl) ?>" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-full border border-gray-200 bg-gray-50 text-primary text-xs font-black">Evidence/source ↗</a><?php endif; ?>
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="text-[10px] uppercase tracking-[0.22em] font-black text-accent mb-3">Public display copy</div>
        <form method="post" action="<?= base_url('admin/testimonials/' . $id . '/save') ?>" class="space-y-4">
          <?= csrf_field() ?>
          <div class="grid sm:grid-cols-2 gap-3">
            <label class="text-xs font-bold text-gray-600">Name<input name="client_name" value="<?= esc($name) ?>" class="mt-1 w-full rounded-xl border-gray-300" /></label>
            <label class="text-xs font-bold text-gray-600">Company<input name="company" value="<?= esc($company) ?>" class="mt-1 w-full rounded-xl border-gray-300" /></label>
            <label class="text-xs font-bold text-gray-600">Designation<input name="designation" value="<?= esc($designation) ?>" class="mt-1 w-full rounded-xl border-gray-300" /></label>
            <label class="text-xs font-bold text-gray-600">Placement location<input name="placement_location" value="<?= esc($row['placement_location'] ?? '') ?>" class="mt-1 w-full rounded-xl border-gray-300" /></label>
            <label class="text-xs font-bold text-gray-600 sm:col-span-2">Placement role<input name="placement_role" value="<?= esc($row['placement_role'] ?? '') ?>" class="mt-1 w-full rounded-xl border-gray-300" /></label>
            <label class="text-xs font-bold text-gray-600">Placement year<input name="placement_year" value="<?= esc($row['placement_year'] ?? '') ?>" class="mt-1 w-full rounded-xl border-gray-300" /></label>
            <label class="text-xs font-bold text-gray-600">Source label<input name="source_label" value="<?= esc($sourceLabel) ?>" class="mt-1 w-full rounded-xl border-gray-300" /></label>
          </div>
          <label class="block text-xs font-bold text-gray-600">Cleaned testimonial<textarea name="comment" rows="8" class="mt-1 w-full rounded-xl border-gray-300"><?= esc($comment) ?></textarea></label>
          <label class="block text-xs font-bold text-gray-600">LinkedIn URL<input name="linkedin_url" value="<?= esc($linkedin) ?>" class="mt-1 w-full rounded-xl border-gray-300" /></label>
          <label class="block text-xs font-bold text-gray-600">Evidence/source URL<input name="source_url" value="<?= esc($sourceUrl) ?>" class="mt-1 w-full rounded-xl border-gray-300" /></label>
          <button class="w-full rounded-xl bg-primary text-white py-3 text-sm font-black">Save display copy</button>
        </form>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-5 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
      <div><div class="font-serif text-xl font-bold text-primary">Publication status</div><p class="text-sm text-gray-500 mt-1">Only active testimonials appear on the public page.</p></div>
      <div class="flex flex-wrap gap-2">
        <form method="post" action="<?= base_url('admin/testimonials/' . $id . '/status') ?>"><?= csrf_field() ?><input type="hidden" name="status" value="pending"><button class="px-4 py-2 rounded-full border border-amber-300 text-amber-700 text-xs font-black">Pending</button></form>
        <form method="post" action="<?= base_url('admin/testimonials/' . $id . '/status') ?>"><?= csrf_field() ?><input type="hidden" name="status" value="rejected"><button class="px-4 py-2 rounded-full border border-red-300 text-red-700 text-xs font-black">Reject</button></form>
        <form method="post" action="<?= base_url('admin/testimonials/' . $id . '/status') ?>"><?= csrf_field() ?><input type="hidden" name="status" value="active"><button class="px-5 py-2 rounded-full bg-green-700 text-white text-xs font-black">Approve & publish</button></form>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
