<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$gstInclusive = in_array($tier, ['priority_599', 'rebuild_1799', 'executive_6999'], true);
$isCoaching = $tier === 'career_4500';
$isExecutive = $tier === 'executive_6999';
?>
<section class="pt-32 pb-20 bg-gray-50 min-h-[70vh]">
  <div class="<?= $isCoaching ? 'max-w-[1280px] grid lg:grid-cols-[minmax(0,1.35fr)_minmax(0,0.85fr)] gap-8 items-start' : 'max-w-[820px]' ?> mx-auto px-4 sm:px-8">
    <div class="<?= $isCoaching ? 'order-2 lg:order-1 min-w-0' : '' ?> bg-white border border-gray-200 rounded-[2rem] p-8 md:p-12 shadow-sm">
      <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">HiredNext Career Services</div>
      <h1 class="text-3xl md:text-5xl font-serif font-bold text-primary"><?= esc($plan['name']) ?></h1>
      <div class="mt-3 text-2xl font-black text-primary">₹<?= number_format((int)$plan['amount']) ?><?php if ($gstInclusive): ?><span class="ml-2 text-sm font-semibold text-gray-500">(inclusive of GST)</span><?php endif; ?></div>
      <p class="text-gray-600 mt-5 leading-relaxed"><?= esc($plan['description']) ?></p>
      <?php if ($isExecutive): ?>
      <div class="grid sm:grid-cols-2 gap-3 mt-6 text-sm">
        <?php foreach (['Career evidence and scope analysis','Executive positioning and narrative architecture','One signature leadership case study','Executive CV in editable and PDF-ready formats','Two consolidated revision rounds','Human accuracy and presentation review'] as $item): ?>
        <div class="rounded-xl border border-primary/10 bg-primary/5 p-3 font-semibold text-primary">✓ <?= esc($item) ?></div>
        <?php endforeach; ?>
      </div>
      <p class="text-sm text-gray-600 mt-4 leading-relaxed">After payment verification, HiredNext sends a structured evidence questionnaire. We use your verified mandates, decisions, scale and outcomes to build the CV and case study. Missing facts are clarified; numbers and achievements are never invented.</p>
      <?php endif; ?>
      <?php if ($tier === 'career_4500'): ?>
      <p class="text-sm text-gray-600 mt-4 leading-relaxed">The HiredNext team will share Taru Shikha's available slots by email and confirm the time with you for your 30-minute consultation.</p>
      <?php endif; ?>
      <div class="rounded-2xl bg-primary/5 border border-primary/10 p-5 mt-6 text-sm text-gray-700"><strong class="text-primary">What happens next:</strong> Upload the CV you already use, then continue to secure payment. Your service request is submitted only after you pay and enter the transaction reference. No request email is sent before payment. Once submitted, please look out for communication from <strong>jobs@hirednext.info</strong>.</div>

      <?php if (session('errors')): ?><div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800"><?= esc(implode(' ', session('errors'))) ?></div><?php endif; ?>

      <form action="<?= base_url('career-services/start/' . $tier) ?>" method="post" enctype="multipart/form-data" class="mt-8 grid md:grid-cols-2 gap-5">
        <?= csrf_field() ?>
        <div><label class="block text-sm font-bold text-primary mb-2">Name</label><input required name="name" value="<?= esc(old('name')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3"></div>
        <div><label class="block text-sm font-bold text-primary mb-2">Email</label><input required type="email" name="email" value="<?= esc(old('email')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3"></div>
        <div><label class="block text-sm font-bold text-primary mb-2">Phone</label><input required name="phone" value="<?= esc(old('phone')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3"></div>
        <div><label class="block text-sm font-bold text-primary mb-2">Target role / move</label><input name="target_role" value="<?= esc(old('target_role')) ?>" placeholder="Optional" class="w-full border border-gray-200 rounded-xl px-4 py-3"></div>
        <div class="md:col-span-2"><label class="block text-sm font-bold text-primary mb-2">Upload your current CV</label><input required type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white"><p class="text-xs text-gray-500 mt-2">PDF, DOC or DOCX · up to 5MB.</p></div>
        <div class="md:col-span-2"><label class="block text-sm font-bold text-primary mb-2">Anything we should know?</label><textarea name="message" rows="4" class="w-full border border-gray-200 rounded-xl px-4 py-3" placeholder="Optional: interview date, target role, salary question, or specific CV concern."><?= esc(old('message')) ?></textarea></div>
        <div class="md:col-span-2"><button class="w-full rounded-full bg-accent px-7 py-4 text-white font-black">Continue to secure payment →</button><p class="text-xs text-gray-500 text-center mt-4">Paid career services are separate from recruitment consideration and never guarantee interviews, hiring or placement.</p></div>
      </form>
    </div>
    <?php if ($isCoaching): ?>
    <aside aria-labelledby="meet-your-interview-coach" class="order-1 lg:order-2 min-w-0 lg:sticky lg:top-28 rounded-[2rem] overflow-hidden border border-primary/10 bg-white shadow-sm">
      <div class="p-6 sm:p-8">
        <p class="text-accent text-xs font-black uppercase tracking-[0.2em] mb-3">Your interview coach</p>
        <h2 id="meet-your-interview-coach" class="text-3xl font-serif font-bold text-primary leading-tight">Walk into your next interview prepared.</h2>
        <p class="mt-4 text-sm text-gray-600 leading-relaxed">Prepare with Taru Shikha. Learn how to explain your strengths, choose the right examples and handle difficult interview questions.</p>
      </div>
      <figure>
        <img src="<?= base_url('theme/taru-shikha-interview-coaching.png') ?>" alt="Taru Shikha seated with a tablet during a one-to-one conversation" width="1122" height="1402" class="block w-full h-auto" loading="eager" decoding="async">
        <figcaption class="bg-primary px-6 py-5 sm:px-8 text-white">
          <p class="text-xl font-serif font-bold">Taru Shikha</p>
          <p class="mt-1 text-sm text-white/80">Founder &amp; CEO · HiredNext Recruitment</p>
        </figcaption>
      </figure>
    </aside>
    <?php endif; ?>
  </div>
</section>
<?php if ($tier === 'rebuild_1799'): ?>
<?= view('pages/services/_cv-rebuild-testimonials') ?>
<?php endif; ?>
<?= $this->endSection() ?>
