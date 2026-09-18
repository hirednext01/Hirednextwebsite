<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-24 bg-primary text-white overflow-hidden">
  <div class="absolute -top-24 -right-20 w-96 h-96 rounded-full bg-accent/15 blur-3xl"></div>
  <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative">
    <div class="max-w-4xl">
      <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-5">HiredNext Executive Career Architecture</div>
      <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight">Executive CV Writing for CXO, VP, Director & Senior Leaders</h1>
      <p class="text-xl font-serif font-bold text-gold mt-5">Your career is the evidence. We build the executive case.</p>
      <p class="text-lg md:text-xl text-white/80 leading-relaxed max-w-3xl mt-5">A senior CV must establish scope, progression, judgement and business impact with precision. HiredNext analyses the substance of your experience and translates it into a disciplined executive narrative, supported by one signature leadership case study.</p>
      <div class="flex flex-col sm:flex-row gap-4 mt-8 items-start sm:items-center">
        <a href="<?= base_url('career-services/start/executive_6999') ?>" class="inline-flex justify-center rounded-full bg-accent px-8 py-4 font-black text-white">Build My Executive CV — ₹6,999</a>
        <div><div class="text-xl font-black">₹6,999 inclusive of GST</div><div class="text-sm text-white/60">5–7 working days after complete inputs</div></div>
      </div>
    </div>
  </div>
</section>

<section class="py-12 bg-white border-b border-gray-100">
  <div class="max-w-[1100px] mx-auto px-4 sm:px-8">
    <div class="max-w-4xl">
      <div class="text-accent text-xs font-black uppercase tracking-[0.22em]">For professionals comparing executive CV services in India</div>
      <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mt-3">A senior-leadership CV should make mandate scale, decisions and business impact visible.</h2>
      <p class="text-gray-600 leading-relaxed mt-4">If you are comparing the best executive CV writing services in India, look beyond formatting. The useful test is whether the service can extract verified leadership evidence, calibrate level and scope, build a coherent executive narrative, preserve ATS readability and avoid manufactured achievements. HiredNext publishes its process, deliverables and limits so the work can be evaluated on those criteria.</p>
      <p class="text-sm text-gray-500 mt-4">This page does not claim an independently verified “#1” ranking. It explains the service HiredNext actually delivers.</p>
    </div>
  </div>
</section>

<section class="py-20 bg-white">
  <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
    <div class="grid lg:grid-cols-12 gap-12">
      <div class="lg:col-span-5">
        <div class="text-accent text-xs font-black uppercase tracking-[0.22em]">The assignment</div>
        <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary mt-3">A career document built like a professional business case.</h2>
        <p class="text-gray-600 text-lg leading-relaxed mt-5">We examine the architecture of your career: the mandates you inherited, the complexity you handled, the decisions you made, the teams and markets you influenced, and the outcomes the evidence can support.</p>
        <p class="text-gray-600 leading-relaxed mt-4">The result is a coherent case for your next level of leadership. Every material claim remains anchored to information you provide. Where evidence is incomplete, we ask; we do not manufacture achievements.</p>
      </div>
      <div class="lg:col-span-7 grid sm:grid-cols-2 gap-5">
        <?php foreach ([
          ['Career evidence audit','Chronology, progression, functional depth, leadership scope, scale and results are mapped before writing begins.'],
          ['Role-market positioning','Your target move is translated into a clear executive proposition, with relevant capability brought forward.'],
          ['Narrative architecture','Summary, experience and achievements are rebuilt as one consistent leadership story rather than disconnected job descriptions.'],
          ['Evidence discipline','Specific facts, metrics and outcomes are tested for support. Missing information becomes a clarification, never an assumption.'],
          ['Executive presentation','The document is structured for senior decision-makers while retaining ATS-safe headings and readable source order.'],
          ['Human review','Positioning, factual integrity, tone, hierarchy and visual finish are reviewed before the first draft reaches you.'],
        ] as $item): ?>
        <article class="rounded-2xl border border-gray-200 bg-gray-50 p-6"><h3 class="font-black text-primary"><?= esc($item[0]) ?></h3><p class="text-sm text-gray-600 mt-3 leading-relaxed"><?= esc($item[1]) ?></p></article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="py-20 bg-[#f6f0e7]">
  <div class="max-w-[1100px] mx-auto px-4 sm:px-8">
    <div class="text-center max-w-3xl mx-auto"><div class="text-accent text-xs font-black uppercase tracking-[0.22em]">The HiredNext journey</div><h2 class="text-3xl md:text-5xl font-serif font-bold text-primary mt-3">From career history to executive argument.</h2></div>
    <div class="grid md:grid-cols-3 gap-5 mt-12">
      <?php foreach ([
        ['01','Discovery & evidence map','You submit your current CV, target direction and structured evidence questionnaire. We map roles, mandates, decisions, stakeholders, scale, challenges and measurable outcomes.'],
        ['02','Executive positioning thesis','We identify the central leadership proposition and organise the career around relevance, progression and decision-level impact.'],
        ['03','Achievement analysis','Responsibilities are separated from contribution. Evidence is classified across growth, transformation, operations, commercial value, people and governance.'],
        ['04','Signature case study','One defining assignment is written as a professional case: context, mandate, complexity, actions, judgement and evidenced result.'],
        ['05','CV architecture & writing','We build the executive summary, capability frame and experience narrative, then render the complete document in a refined ATS-safe format.'],
        ['06','Quality review & refinement','You receive a finished first draft. HiredNext completes two consolidated revision rounds for factual correction and calibrated positioning.'],
      ] as $step): ?>
      <article class="rounded-2xl bg-white border border-primary/10 p-7"><div class="text-3xl font-serif font-bold text-accent"><?= esc($step[0]) ?></div><h3 class="text-xl font-black text-primary mt-3"><?= esc($step[1]) ?></h3><p class="text-sm text-gray-600 mt-3 leading-relaxed"><?= esc($step[2]) ?></p></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-20 bg-primary text-white">
  <div class="max-w-[1100px] mx-auto px-4 sm:px-8 grid lg:grid-cols-2 gap-12">
    <div><div class="text-gold text-xs font-black uppercase tracking-[0.22em]">Your signature case study</div><h2 class="text-3xl md:text-5xl font-serif font-bold mt-3">One defining chapter, examined properly.</h2><p class="text-white/75 mt-5 leading-relaxed">The case study gives depth to an achievement that a bullet point cannot adequately explain. It shows the setting, the stakes, your individual contribution and the result in a form that can support leadership conversations.</p></div>
    <div class="rounded-3xl bg-white/5 border border-white/15 p-8">
      <?php foreach (['Context and business situation','Your mandate and success criteria','Constraints, stakeholders and complexity','Decisions and actions attributable to you','Verified outcomes and enduring impact','Leadership insight demonstrated'] as $point): ?>
      <div class="py-3 border-b border-white/10 last:border-0 flex gap-3"><span class="text-gold font-black">✓</span><span class="font-semibold"><?= esc($point) ?></span></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-20 bg-white">
  <div class="max-w-[960px] mx-auto px-4 sm:px-8">
    <div class="rounded-[2rem] border-2 border-primary p-8 md:p-12 shadow-xl">
      <div class="grid md:grid-cols-[1fr_auto] gap-8 items-center">
        <div><div class="text-accent text-xs font-black uppercase tracking-[0.22em]">Complete executive package</div><h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mt-3">Executive CV & Leadership Case Study</h2><p class="text-gray-600 mt-4">Executive analysis, full CV writing, one signature case study, editable and PDF-ready documents, human review and two consolidated revision rounds.</p><p class="text-xs text-gray-500 mt-4">This service improves the quality and positioning of your career documents. It does not guarantee an interview, shortlist or placement.</p></div>
        <div class="md:text-right"><div class="text-4xl font-black text-primary">₹6,999</div><div class="text-sm text-gray-500 mt-1">GST included</div><a href="<?= base_url('career-services/start/executive_6999') ?>" class="mt-5 inline-flex rounded-full bg-accent px-7 py-4 font-black text-white">Start the Executive Journey</a></div>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>

