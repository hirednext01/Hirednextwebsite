<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$priceLabel = $plan['price_label'] ?? ('₹' . number_format((int)($plan['amount'] ?? 0)));
$payableLabel = $plan['payable_label'] ?? ('₹' . number_format((int)($plan['amount'] ?? 0)) . ' payable');
$regularPriceLabel = $plan['regular_price_label'] ?? null;
$isCoaching = $tier === 'career_4500';
$isExecutive = $tier === 'executive_6999';
$isLeadership = $tier === 'leadership_17500';
$isLinkedIn = in_array($tier, ['linkedin_8999', 'leadership_17500'], true);
$isBundle = $tier === 'bundle_3317';
?>
<section class="pt-32 pb-20 bg-gray-50 min-h-[70vh]">
  <div class="<?= $isCoaching ? 'max-w-[1280px] grid lg:grid-cols-[minmax(0,1.35fr)_minmax(0,0.85fr)] gap-8 items-start' : 'max-w-[820px]' ?> mx-auto px-4 sm:px-8">
    <div class="<?= $isCoaching ? 'order-2 lg:order-1 min-w-0' : '' ?> bg-white border border-gray-200 rounded-[2rem] p-8 md:p-12 shadow-sm">
      <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3"><?= $isLeadership ? 'HiredNext Leadership Advisory' : 'HiredNext Career Services' ?></div>
      <h1 class="text-3xl md:text-5xl font-serif font-bold text-primary"><?= esc($plan['name']) ?></h1>
      <div class="mt-4 flex flex-wrap items-end gap-4">
        <?php if ($regularPriceLabel): ?><div class="text-lg font-black text-gray-400 line-through"><?= esc($regularPriceLabel) ?></div><?php endif; ?>
        <div class="text-3xl font-black text-primary"><?= esc($priceLabel) ?></div>
      </div>
      <div class="mt-2 text-sm font-semibold text-gray-500"><?= esc($payableLabel) ?></div>
      <p class="text-gray-600 mt-5 leading-relaxed"><?= esc($plan['description']) ?></p>

      <?php if ($isBundle): ?>
      <div class="rounded-2xl border border-gold/30 bg-[#fffaf1] p-5 mt-6">
        <div class="text-xs font-black uppercase tracking-[0.18em] text-accent">5% bundle saving</div>
        <p class="text-sm text-gray-700 mt-2 leading-relaxed">The separate base prices total ₹3,492 + GST. This bundle gives you the full written assessment first and then the managed CV rebuild for ₹3,317.40 + GST.</p>
      </div>
      <?php endif; ?>

      <?php if ($isLeadership): ?>
      <div class="rounded-2xl border border-primary/10 bg-primary/5 p-5 mt-6">
        <div class="text-xs font-black uppercase tracking-[0.18em] text-accent">Confidential leadership engagement</div>
        <p class="text-sm text-gray-700 mt-2 leading-relaxed">A standard HiredNext NDA is shared before the assessment round. We examine leadership evidence, career architecture and target mandates before developing your executive narrative. Submitted materials are not shared externally for this engagement without your consent.</p>
      </div>
      <?php endif; ?>

      <?php if ($isExecutive): ?>
      <div class="grid sm:grid-cols-2 gap-3 mt-6 text-sm">
        <?php foreach (['Career evidence and scope analysis','Executive positioning and narrative architecture','One signature leadership case study','Executive CV in editable and PDF-ready formats','Two consolidated revision rounds','Human accuracy and presentation review'] as $item): ?>
        <div class="rounded-xl border border-primary/10 bg-primary/5 p-3 font-semibold text-primary">✓ <?= esc($item) ?></div>
        <?php endforeach; ?>
      </div>
      <p class="text-sm text-gray-600 mt-4 leading-relaxed">After payment verification, HiredNext sends a structured evidence questionnaire. We use your verified mandates, decisions, scale and outcomes to build the CV and case study. Missing facts are clarified; numbers and achievements are never invented.</p>
      <?php endif; ?>

      <?php if ($isCoaching): ?>
      <p class="text-sm text-gray-600 mt-4 leading-relaxed">The HiredNext team will share Taru Shikha's available slots by email and confirm the time with you for your 30-minute consultation.</p>
      <?php endif; ?>

      <div class="rounded-2xl bg-primary/5 border border-primary/10 p-5 mt-6 text-sm text-gray-700"><strong class="text-primary">What happens next:</strong> Upload the CV you already use, then continue to secure payment. Your service request is submitted only after you pay and enter the transaction reference. No request email is sent before payment. Once submitted, please look out for communication from <strong>jobs@hirednext.info</strong>.</div>

      <?php if (session('errors')): ?><div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800"><?= esc(implode(' ', session('errors'))) ?></div><?php endif; ?>

      <form action="<?= base_url('career-services/start/' . $tier) ?>" method="post" enctype="multipart/form-data" class="mt-8 grid md:grid-cols-2 gap-5">
        <?= csrf_field() ?>
        <div><label class="block text-sm font-bold text-primary mb-2">Name</label><input required name="name" value="<?= esc(old('name')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3"></div>
        <div><label class="block text-sm font-bold text-primary mb-2">Email</label><input required type="email" name="email" value="<?= esc(old('email')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3"></div>
        <div><label class="block text-sm font-bold text-primary mb-2">Phone</label><input required name="phone" value="<?= esc(old('phone')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3"></div>
        <div><label class="block text-sm font-bold text-primary mb-2"><?= $isLinkedIn ? 'LinkedIn URL / target positioning' : 'Target role / move' ?></label><input name="target_role" value="<?= esc(old('target_role')) ?>" placeholder="<?= $isLinkedIn ? 'Paste LinkedIn URL or describe your target positioning' : 'Optional' ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3"></div>
        <div class="md:col-span-2"><label class="block text-sm font-bold text-primary mb-2">Upload your current CV</label><input required type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white"><p class="text-xs text-gray-500 mt-2">PDF, DOC or DOCX · up to 5MB. We use it to understand your career chronology before the assessment round.</p></div>
        <?php if ($isLeadership): ?>
        <fieldset class="md:col-span-2 grid md:grid-cols-2 gap-5 border-t border-gray-200 pt-6">
          <legend class="text-lg font-bold text-primary">Your leadership context</legend>
          <p class="md:col-span-2 text-sm text-gray-600">Suitability is reviewed against your responsibility and target mandate. Years of experience alone never determine the engagement.</p>
          <?php foreach (\App\Services\Cv\LeadershipContext::FIELDS as $field => $label): ?>
          <div><label for="<?= esc($field) ?>" class="block text-sm font-bold text-primary mb-2"><?= esc($label) ?></label><input id="<?= esc($field) ?>" name="<?= esc($field) ?>" maxlength="1000" value="<?= esc(old($field)) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3" <?= in_array($field, ['leadership_level','leadership_scope','leadership_target'], true) ? 'required' : '' ?>></div>
          <?php endforeach; ?>
        </fieldset>
        <?php endif; ?>
        <div class="md:col-span-2"><label class="block text-sm font-bold text-primary mb-2">Anything we should know?</label><textarea name="message" rows="4" class="w-full border border-gray-200 rounded-xl px-4 py-3" placeholder="<?= $isLinkedIn ? ($isLeadership ? 'Optional: mandate priorities, confidentiality boundaries or context for your leadership transition.' : 'Optional: target roles, industries, achievements or concerns about your current profile.') : 'Optional: interview date, target role, salary question, or specific CV concern.' ?>"><?= esc(old('message')) ?></textarea></div>
        <div class="md:col-span-2"><button class="w-full rounded-full bg-accent px-7 py-4 text-white font-black">Continue to secure payment →</button><p class="text-xs text-gray-500 text-center mt-4">Career services improve positioning and preparation. Reach, interviews, hiring and placement outcomes are not guaranteed.</p></div>
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

<?php if (in_array($tier, ['rebuild_2500', 'bundle_3317'], true)): ?>
<?= view('pages/services/_cv-rebuild-testimonials') ?>
<?php endif; ?>

<?= $this->endSection() ?>

