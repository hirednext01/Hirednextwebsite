<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('theme/linkedin-positioning.css') ?>">
<div class="hn-position hn-professional">
<section class="hn-position-hero">
 <div class="hn-position-wrap hn-position-split">
  <div>
   <p class="hn-position-kicker">Career Services / LinkedIn Profile Build</p>
   <h1>Make your experience easier to find.<br><em>And easier to recognise.</em></h1>
   <p class="hn-position-intro">Professional LinkedIn Profile Build</p>
   <p>A clear professional story, aligned with the roles you want. We turn your experience and achievements into a LinkedIn profile that supports recruiter visibility, searchability and confident career positioning.</p>
   <a class="hn-position-button" href="<?= base_url('career-services/start/linkedin_8999') ?>">Build my LinkedIn profile →</a>
  </div>
  <aside class="hn-professional-summary" aria-label="Professional service scope and fee">
   <p class="hn-position-kicker">Your next career move</p>
   <h2>Experience.<br>Achievements.<br>Role alignment.</h2>
   <p>For professionals, managers, senior managers and AVPs whose priority is job-market positioning.</p>
   <div class="hn-position-fee"><?= esc($plan['price_label']) ?></div>
   <p class="hn-position-small"><?= esc($plan['payable_label']) ?>, rounded to the nearest rupee.</p>
  </aside>
 </div>
</section>
<section class="hn-position-section">
 <div class="hn-position-wrap">
  <p class="hn-position-kicker">Professional career positioning</p>
  <h2>Give recruiters a clear reason to keep reading.</h2>
  <p class="hn-position-measure">Your profile should make your functional strengths, contribution and target-role relevance visible. Every section works toward that purpose, grounded in the work you have actually done.</p>
  <div class="hn-professional-grid">
   <?php foreach ([
    ['Profile diagnostic', 'Identify unclear positioning, missing evidence and inconsistencies across your current profile and CV.'],
    ['Headline strategy & About', 'Define your professional identity and write an About section that explains your expertise, achievements and direction.'],
    ['Experience restructuring', 'Organise roles and responsibilities into a coherent career story with accurate scope and progression.'],
    ['Achievement articulation', 'Bring forward your contribution and outcomes. Clarify missing context with you before making a claim.'],
    ['Recruiter-search keywords', 'Use relevant role and industry language naturally to support searchability and job-search discoverability.'],
    ['Skills & profile optimisation', 'Build a role-aligned skills architecture and review profile consistency, completeness and basic LinkedIn optimisation.'],
   ] as $item): ?>
   <article><h3><?= esc($item[0]) ?></h3><p><?= esc($item[1]) ?></p></article>
   <?php endforeach; ?>
  </div>
 </div>
</section>
<section class="hn-position-section hn-position-tint">
 <div class="hn-position-wrap hn-position-split">
  <div><p class="hn-position-kicker">How we work</p><h2>Your evidence.<br>A stronger professional story.</h2><p>Share your current CV, LinkedIn profile and target roles. We diagnose the gaps, clarify achievements, develop the profile content and review it for factual consistency and role alignment.</p></div>
  <div class="hn-position-steps">
   <p><strong>01 / Diagnose</strong> Understand your current profile and the roles you want to be considered for.</p>
   <p><strong>02 / Build</strong> Restructure your headline, About, experience and skills around relevant evidence.</p>
   <p><strong>03 / Review</strong> Check accuracy, achievement wording, search language and the coherence of the finished profile.</p>
  </div>
 </div>
</section>
<section class="hn-position-section">
 <div class="hn-position-wrap hn-position-measure">
  <h2>Questions before you begin</h2>
  <details><summary>Is this suitable for an experienced senior manager?</summary><p>Yes, when the main requirement is professional career positioning and recruiter visibility. Years of experience alone do not determine the engagement. Current responsibility and the role you are targeting matter more.</p></details>
  <details><summary>What does LinkedIn profile optimisation include?</summary><p>Profile diagnosis, headline strategy, About, experience restructuring, achievement articulation, recruiter-search keywords, role-specific positioning, searchability, skills architecture and basic profile optimisation.</p></details>
  <details><summary>Will you add achievements or metrics I cannot substantiate?</summary><p>No. We work from your career evidence and ask for missing context. You review the profile for accuracy before using the final content.</p></details>
  <details><summary>Does this guarantee recruiter enquiries?</summary><p>The service improves presentation, role alignment and discoverability. Recruiter outreach and hiring decisions also depend on market demand and role fit.</p></details>
  <div class="hn-position-close"><p class="hn-position-fee"><?= esc($plan['price_label']) ?></p><a class="hn-position-button" href="<?= base_url('career-services/start/linkedin_8999') ?>">Start my profile build →</a></div>
  <p class="hn-position-crosslink">Operating at Business Head / CXO / enterprise leadership level?<br><a href="<?= base_url('leadership-advisory/cxo-global-leadership-positioning') ?>">Explore CXO / Global Leadership Positioning →</a></p>
 </div>
</section>
</div>
<?= $this->endSection() ?>
