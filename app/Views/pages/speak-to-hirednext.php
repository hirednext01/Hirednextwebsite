<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-20 bg-primary text-white overflow-hidden">
  <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
    <div class="max-w-4xl">
      <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-5">Speak to HiredNext</div>
      <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-6">What would you like HiredNext to help you with?</h1>
      <p class="text-lg text-white/75 max-w-3xl">Choose the route that matches your requirement. Hiring conversations remain easy to access; job applications are always free; professional advisory is a separate paid service.</p>
    </div>
  </div>
</section>
<section class="py-20 bg-gray-50">
  <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
    <div class="grid md:grid-cols-2 gap-6">
      <article class="rounded-[2rem] bg-white border-2 border-accent p-8 shadow-sm">
        <div class="text-accent text-xs font-black uppercase tracking-widest mb-3">For Employers · No consultation fee</div>
        <h2 class="text-3xl font-serif font-bold text-primary mb-4">I’m Hiring</h2>
        <p class="text-gray-600 leading-relaxed mb-6">For companies with an active or upcoming CXO, leadership, specialist or volume hiring requirement.</p>
        <a href="<?= base_url('hiring-discussion') ?>" class="inline-flex px-7 py-3.5 rounded-full bg-accent text-white font-bold">Discuss a Hiring Mandate →</a>
      </article>
      <article class="rounded-[2rem] bg-white border border-gray-200 p-8 shadow-sm">
        <div class="text-accent text-xs font-black uppercase tracking-widest mb-3">₹6,500 · 60 minutes</div>
        <h2 class="text-3xl font-serif font-bold text-primary mb-4">Career Strategy & Market Fit</h2>
        <p class="text-gray-600 leading-relaxed mb-6">A researched consultation for experienced professionals. Your CV, LinkedIn profile, career objective and specific challenge are reviewed before the conversation.</p>
        <a href="<?= base_url('advisory') ?>#career-strategy" class="font-bold text-primary hover:text-accent">View Career Strategy →</a>
      </article>
      <article class="rounded-[2rem] bg-white border border-gray-200 p-8 shadow-sm">
        <div class="text-accent text-xs font-black uppercase tracking-widest mb-3">₹12,500 · 60 minutes</div>
        <h2 class="text-3xl font-serif font-bold text-primary mb-4">CXO Strategic Advisory</h2>
        <p class="text-gray-600 leading-relaxed mb-6">Confidential decision support for CXOs and senior leaders navigating a high-stakes move, executive positioning, compensation, transition or market decision.</p>
        <a href="<?= base_url('advisory') ?>#cxo-advisory" class="font-bold text-primary hover:text-accent">View CXO Advisory →</a>
      </article>
      <article class="rounded-[2rem] bg-white border border-gray-200 p-8 shadow-sm">
        <div class="text-accent text-xs font-black uppercase tracking-widest mb-3">For Candidates · Always free to apply</div>
        <h2 class="text-3xl font-serif font-bold text-primary mb-4">I’m Looking for a Job</h2>
        <p class="text-gray-600 leading-relaxed mb-6">Explore current HiredNext mandates and apply to the exact role. If no suitable role is live, follow HiredNext Recruitment on LinkedIn for new openings. You can also send your CV to <strong>jobs@hirednext.info</strong>.</p>
        <div class="flex flex-wrap gap-3"><a href="<?= base_url('jobs') ?>" class="inline-flex px-6 py-3 rounded-full bg-primary text-white font-bold">View Current Jobs →</a><a href="https://www.linkedin.com/company/hirednext-recruitment-service/" target="_blank" rel="noopener noreferrer" class="inline-flex px-6 py-3 rounded-full border border-primary text-primary font-bold">HiredNext on LinkedIn →</a></div>
      </article>
    </div>
    <div class="mt-10 rounded-2xl border border-primary/10 bg-white p-6 text-sm text-gray-600"><strong class="text-primary">Important:</strong> HiredNext never charges candidates to apply for jobs or secure placement. Paid CV and advisory services are optional professional services and do not influence recruitment consideration.</div>
  </div>
</section>
<?= $this->endSection() ?>
