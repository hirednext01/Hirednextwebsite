<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="pt-32 pb-20 bg-gray-50 min-h-[70vh]">
  <div class="max-w-[820px] mx-auto px-4 sm:px-8">
    <div class="bg-white border border-gray-200 rounded-[2rem] p-8 md:p-12 shadow-sm">
      <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">HiredNext Career Services</div>
      <h1 class="text-3xl md:text-5xl font-serif font-bold text-primary"><?= esc($plan['name']) ?></h1>
      <div class="mt-3 text-2xl font-black text-primary">₹<?= number_format((int)$plan['amount']) ?></div>
      <p class="text-gray-600 mt-5 leading-relaxed"><?= esc($plan['description']) ?></p>
      <div class="rounded-2xl bg-primary/5 border border-primary/10 p-5 mt-6 text-sm text-gray-700"><strong class="text-primary">What happens next:</strong> Upload the CV you already use. HiredNext works from that document; you are not asked to build a CV yourself. After this step you will be taken to secure payment. Please look out for all service communication from <strong>jobs@hirednext.info</strong>.</div>

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
  </div>
</section>
<?= $this->endSection() ?>
