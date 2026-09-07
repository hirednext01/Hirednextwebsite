<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min';
$items = $testimonials ?? [];
$employerItems = $employerTestimonials ?? [];
$placedCandidateItems = $placedCandidateTestimonials ?? [];
$publishedCount = count($employerItems) + count($placedCandidateItems);
$knownRoleCompany = [
    'CEO, Stellar Manufacturing' => ['CEO', 'Stellar Manufacturing'],
    'Senior Director, Marriott International' => ['Senior Director', 'Marriott International'],
    'Country Head, Mirza Bangla' => ['Country Head', 'Mirza Bangla'],
    'Founder, Meeraki Bizz' => ['Founder', 'Meeraki Bizz'],
    'Senior Consultant, Capgemini' => ['Senior Consultant', 'Capgemini'],
];
?>

<style>
.testimonial-luxe-card{box-shadow:0 18px 55px rgba(12,52,102,.07)}
.testimonial-luxe-card:hover{box-shadow:0 28px 70px rgba(12,52,102,.12)}
.testimonial-quote-mark{font-family:'DM Serif Display',serif;line-height:.65}
.testimonial-person-name{font-family:'DM Serif Display',serif;letter-spacing:-.015em}
</style>

<header class="relative overflow-hidden bg-[#071f3d] text-white pt-28 pb-16 md:pb-20">
  <div class="absolute inset-0 opacity-40" style="background:radial-gradient(circle at 80% 10%,rgba(255,78,22,.20),transparent 34%),radial-gradient(circle at 5% 90%,rgba(212,175,55,.14),transparent 32%);"></div>
  <div class="max-w-[1180px] mx-auto px-6 relative z-10">
    <div class="grid lg:grid-cols-12 gap-10 items-end">
      <div class="lg:col-span-8">
        <div class="inline-flex items-center gap-3 text-gold text-[10px] font-black uppercase tracking-[0.34em] mb-5"><span class="w-8 h-px bg-gold/70"></span>Proof, not claims</div>
        <h1 class="text-4xl md:text-6xl font-serif font-bold leading-[1.03] max-w-4xl mb-5">Recruitment outcomes,<br><span class="text-white/65">with people you can verify.</span></h1>
        <p class="text-base md:text-lg text-white/65 leading-relaxed max-w-3xl">Client recommendations and placed-candidate stories are kept separate. Where a public profile or source was supplied, we link it directly so the evidence can be checked.</p>
      </div>
      <div class="lg:col-span-4 lg:pl-8">
        <div class="border-l border-white/15 pl-6 py-1">
          <div class="text-[10px] uppercase tracking-[0.28em] text-white/45 font-black mb-2">Published proof</div>
          <div class="grid grid-cols-2 gap-5 mb-3">
            <div><span class="block text-3xl font-serif text-white"><?= esc((string)count($employerItems)) ?></span><span class="text-[10px] uppercase tracking-[0.16em] text-white/45">Client voices</span></div>
            <div><span class="block text-3xl font-serif text-gold"><?= esc((string)count($placedCandidateItems)) ?></span><span class="text-[10px] uppercase tracking-[0.16em] text-white/45">Placed candidates</span></div>
          </div>
          <p class="text-xs text-white/45 leading-relaxed"><?= esc((string)$publishedCount) ?> approved stories currently visible. Duplicate records are suppressed.</p>
        </div>
      </div>
    </div>
  </div>
</header>

<section class="bg-[#f7f5f0] border-b border-[#e8e3d9]">
  <div class="max-w-[1180px] mx-auto px-6 py-6 md:py-7 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
      <div class="text-[10px] uppercase tracking-[0.24em] text-primary/55 font-black mb-1">Placed through HiredNext?</div>
      <p class="text-sm md:text-base text-gray-600 leading-relaxed">Share what happened, what HiredNext handled, and what changed in your career. Every submission is reviewed before publication.</p>
    </div>
    <a href="<?= base_url('testimonials/share') ?>" class="shrink-0 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-primary text-white font-extrabold text-sm hover:bg-accent transition-colors">Share your placement story <span aria-hidden="true">↗</span></a>
  </div>
</section>

<section id="employer-testimonials" class="py-14 md:py-20 bg-[#fbfaf7] scroll-mt-24">
  <div class="max-w-[1180px] mx-auto px-6">
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 mb-10 md:mb-14 items-end">
      <div class="lg:col-span-8">
        <div class="text-accent text-[10px] font-black uppercase tracking-[0.3em] mb-3">Client & hiring leader proof</div>
        <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary leading-tight">What employers say about<br><span class="text-primary/45">candidate quality and delivery.</span></h2>
      </div>
      <div class="lg:col-span-4"><p class="text-sm text-gray-500 leading-relaxed">Client-side recommendations stay in one place only. Public-source evidence remains linked directly on the card.</p></div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
      <?php if (!empty($employerItems)): ?>
        <?php foreach ($employerItems as $index => $item): ?>
          <?= view('components/testimonial-card', ['item'=>$item,'index'=>$index,'relationship'=>'employer','tone'=>'dark','knownRoleCompany'=>$knownRoleCompany]) ?>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="lg:col-span-2 bg-white border border-[#ece7dd] rounded-[1.75rem] p-12 text-center"><div class="font-serif text-3xl text-primary mb-3">Client recommendations are being curated.</div><p class="text-gray-500">Approved client and hiring-leader feedback will appear here.</p></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section id="placed-candidate-stories" class="py-14 md:py-20 bg-[#f7f5f0] border-y border-[#e8e3d9] scroll-mt-24">
  <div class="max-w-[1180px] mx-auto px-6">
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 mb-10 md:mb-14 items-end">
      <div class="lg:col-span-8">
        <div class="text-[#8b6d24] text-[10px] font-black uppercase tracking-[0.3em] mb-3">Placed candidate stories</div>
        <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary leading-tight">The career move,<br><span class="text-primary/45">in the candidate’s own experience.</span></h2>
      </div>
      <div class="lg:col-span-4"><p class="text-sm text-gray-500 leading-relaxed">These are candidates HiredNext helped place. Cleaned copy preserves the substance of their original submission; identity and source links are shown wherever supplied.</p></div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
      <?php if (!empty($placedCandidateItems)): ?>
        <?php foreach ($placedCandidateItems as $index => $item): ?>
          <?= view('components/testimonial-card', ['item'=>$item,'index'=>$index,'relationship'=>'placed_candidate','tone'=>'warm','knownRoleCompany'=>$knownRoleCompany]) ?>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="lg:col-span-2 rounded-[1.75rem] border border-[#ead9b3] bg-[#fffaf0] p-8 md:p-12"><div class="font-serif text-3xl text-primary mb-3">Placement stories are being prepared.</div><p class="text-gray-600">Approved candidate stories will appear here with supporting identity evidence wherever available.</p></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="relative overflow-hidden py-16 md:py-20 bg-[#071f3d] text-white">
  <div class="max-w-[1180px] mx-auto px-6 relative z-10">
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center">
      <div class="lg:col-span-8"><div class="text-gold text-[10px] font-black uppercase tracking-[0.3em] mb-3">A critical hire deserves senior attention</div><h2 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4">Need a search partner who will challenge the brief, not just send CVs?</h2><p class="text-white/60 max-w-3xl leading-relaxed">Speak directly with HiredNext about executive search, leadership hiring or a difficult specialist mandate in India.</p></div>
      <div class="lg:col-span-4 lg:text-right"><a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-3 px-7 py-4 rounded-full bg-accent text-white font-extrabold hover:bg-white hover:text-primary transition-colors">Book a 30-Min Call <span aria-hidden="true">↗</span></a></div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
