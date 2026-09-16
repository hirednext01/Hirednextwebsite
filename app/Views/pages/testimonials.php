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
.testimonial-luxe-card{box-shadow:0 1px 0 rgba(12,52,102,.05)}
.testimonial-luxe-card:hover{box-shadow:0 18px 45px rgba(12,52,102,.08)}
.testimonial-quote-mark{font-family:'DM Serif Display',serif;line-height:.65}
.testimonial-person-name{font-family:'DM Serif Display',serif;letter-spacing:-.015em}
.proof-rule{height:1px;background:linear-gradient(90deg,#ff4e16 0 72px,#dfe5ec 72px 100%)}
</style>

<header class="relative overflow-hidden bg-white text-primary pt-28 pb-14 md:pb-20 border-b border-gray-200">
  <div class="max-w-[1180px] mx-auto px-6">
    <div class="grid lg:grid-cols-12 gap-12 items-end">
      <div class="lg:col-span-8 border-l-4 border-accent pl-6 md:pl-9">
        <div class="text-accent text-[10px] font-black uppercase tracking-[0.34em] mb-5">HiredNext evidence</div>
        <h1 class="text-4xl md:text-7xl font-serif font-bold leading-[.98] tracking-tight max-w-5xl mb-7">What changed after<br><span class="text-primary/45">HiredNext entered the search.</span></h1>
        <p class="text-base md:text-xl text-gray-600 leading-relaxed max-w-3xl">Independent voices from hiring leaders and professionals placed through HiredNext. Employer testimony and candidate experience remain separate so each result can be read in the right context.</p>
      </div>
      <div class="lg:col-span-4">
        <div class="proof-rule mb-6"></div>
        <div class="grid grid-cols-3 gap-5">
          <div><span class="block text-4xl font-serif text-primary"><?= esc((string)count($employerItems)) ?></span><span class="text-[9px] uppercase tracking-[0.16em] text-gray-500">Client voices</span></div>
          <div><span class="block text-4xl font-serif text-primary"><?= esc((string)count($placedCandidateItems)) ?></span><span class="text-[9px] uppercase tracking-[0.16em] text-gray-500">Candidates</span></div>
          <div><span class="block text-4xl font-serif text-accent"><?= esc((string)$publishedCount) ?></span><span class="text-[9px] uppercase tracking-[0.16em] text-gray-500">Approved</span></div>
        </div>
        <p class="mt-6 text-xs text-gray-500 leading-relaxed">Duplicate records are suppressed. Public evidence is linked where permission and a source are available.</p>
      </div>
    </div>
  </div>
</header>

<section class="bg-[#f7f8fa] border-b border-gray-200">
  <div class="max-w-[1180px] mx-auto px-6 py-6 md:py-7 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
      <div class="text-[10px] uppercase tracking-[0.24em] text-primary/55 font-black mb-1">Placed through HiredNext?</div>
      <p class="text-sm md:text-base text-gray-600 leading-relaxed">Share what happened, what HiredNext handled, and what changed in your career. Every submission is reviewed before publication.</p>
    </div>
    <a href="<?= base_url('testimonials/share') ?>" class="shrink-0 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-primary text-white font-extrabold text-sm hover:bg-accent transition-colors">Share your placement story <span aria-hidden="true">↗</span></a>
  </div>
</section>

<section id="employer-testimonials" class="py-16 md:py-24 bg-white scroll-mt-24">
  <div class="max-w-[1180px] mx-auto px-6">
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 mb-10 md:mb-14 items-end">
      <div class="lg:col-span-8">
        <div class="text-accent text-[10px] font-black uppercase tracking-[0.3em] mb-4">01 · Client & hiring leader proof</div>
        <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary leading-tight">Evidence from the people<br><span class="text-primary/45">making the hiring decision.</span></h2>
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

<section id="placed-candidate-stories" class="py-16 md:py-24 bg-[#f7f8fa] border-y border-gray-200 scroll-mt-24">
  <div class="max-w-[1180px] mx-auto px-6">
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 mb-10 md:mb-14 items-end">
      <div class="lg:col-span-8">
        <div class="text-accent text-[10px] font-black uppercase tracking-[0.3em] mb-4">02 · Placed candidate stories</div>
        <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary leading-tight">The career move,<br><span class="text-primary/45">in the candidate’s own experience.</span></h2>
      </div>
      <div class="lg:col-span-4"><p class="text-sm text-gray-500 leading-relaxed">These are candidates HiredNext helped place. Cleaned copy preserves the substance of their original submission. Candidate identity and source links may be shown where supplied; employer and client names are withheld.</p></div>
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

<section class="bg-white py-16 md:py-24 border-b border-gray-200">
  <div class="max-w-[1180px] mx-auto px-6">
    <div class="grid lg:grid-cols-12 gap-10 items-center border-y border-gray-200 py-10 md:py-14">
      <div class="lg:col-span-2"><div class="text-6xl md:text-7xl font-serif text-accent">03</div></div>
      <div class="lg:col-span-6">
        <div class="text-[10px] font-black uppercase tracking-[0.3em] text-accent mb-3">Interview Ready · Service preview</div>
        <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary leading-tight">Build the answers your CV cannot speak for you.</h2>
        <p class="mt-4 text-gray-600 leading-relaxed max-w-2xl">Explore role-specific practice questions, the career examples worth preparing, written answer development and structured feedback for your next interview.</p>
      </div>
      <div class="lg:col-span-4 lg:text-right">
        <a href="<?= base_url('pilots/interview-ready.html?utm_source=testimonials&utm_medium=website&utm_campaign=interview_ready') ?>" class="inline-flex items-center justify-center px-7 py-4 bg-primary text-white font-black hover:bg-accent transition">Explore Interview Ready <span class="ml-3">→</span></a>
        <p class="mt-3 text-xs text-gray-500">Preview the sample and register interest in the ₹999 pilot. No payment is taken.</p>
      </div>
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
