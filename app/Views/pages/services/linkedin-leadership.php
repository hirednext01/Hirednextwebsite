<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('theme/linkedin-positioning.css') ?>">
<div class="hn-position hn-professional hn-profile-offer">
<section class="hn-position-hero">
 <div class="hn-position-wrap hn-profile-hero-grid">
  <div class="hn-profile-hero-copy">
   <p class="hn-position-kicker">HiredNext / Professional LinkedIn Profile Build</p>
   <h1>Make the work you have done <em>easier to find and understand.</em></h1>
   <p class="hn-position-intro">Your title alone rarely tells a recruiter what you own, what changed because of your work or which role fits you next.</p>
   <p>We turn your verified experience into a stronger headline, About section, experience story and role-relevant skills. You review the words before they go on your profile.</p>
   <div class="hn-profile-hero-actions">
    <a class="hn-position-button" href="<?= base_url('career-services/start/linkedin_8999') ?>">Build my LinkedIn profile →</a>
    <a class="hn-profile-text-link" href="#profile-sample">See the sample →</a>
   </div>
   <p class="hn-profile-hero-note">For professionals, managers, senior managers and AVPs · No promise of recruiter enquiries or interview calls</p>
  </div>
  <aside class="hn-profile-hero-card" aria-label="Service price and deliverables">
   <span class="hn-profile-card-tag">What you receive</span>
   <h2>A profile people can read in one pass.</h2>
   <ul>
    <li>Headline and About narrative</li>
    <li>Experience and achievement writing</li>
    <li>Role-aligned search language and skills</li>
    <li>Profile review for accuracy and coherence</li>
   </ul>
   <div class="hn-profile-card-price"><strong><?= esc($plan['price_label']) ?></strong><span><?= esc($plan['payable_label']) ?>, rounded to the nearest rupee</span></div>
  </aside>
 </div>
</section>

<section class="hn-position-section hn-profile-sample-section" id="profile-sample">
 <div class="hn-position-wrap">
  <p class="hn-position-kicker">See the difference</p>
  <h2>From a job-title list to a reason to keep reading.</h2>
  <p class="hn-position-measure">This fictional example shows the writing approach. It is a sample of the deliverable, not a past client, a verified outcome or a promise of visibility.</p>
  <div class="hn-profile-sample-grid">
   <div class="hn-profile-example" aria-label="Illustrative profile writing before and after">
    <div class="hn-profile-example-bar"><span class="hn-profile-example-mark">in</span><span>PROFILE WRITING SAMPLE · FICTIONAL</span></div>
    <div class="hn-profile-example-banner"><span>Clarity brings the work into view.</span></div>
    <div class="hn-profile-example-body">
     <span class="hn-profile-avatar" aria-hidden="true">HN</span>
     <div class="hn-profile-comparison">
      <div class="hn-profile-comparison-row"><span class="hn-profile-state">Before · headline</span><p>Experienced operations professional seeking new opportunities.</p></div>
      <div class="hn-profile-comparison-row hn-profile-comparison-after"><span class="hn-profile-state">After · headline</span><p>Operations Manager | Multi-site delivery, team leadership &amp; process improvement | Manufacturing</p></div>
      <div class="hn-profile-comparison-row"><span class="hn-profile-state">Before · About</span><p>Results-oriented team player with excellent communication skills.</p></div>
      <div class="hn-profile-comparison-row hn-profile-comparison-after"><span class="hn-profile-state">After · About</span><p>I lead operations across multiple sites, bringing together frontline teams, planning and process improvement. My profile explains the scope I own, the improvements I can substantiate and the next operational challenge I am equipped to take on.</p></div>
     </div>
    </div>
    <div class="hn-profile-example-foot">For your profile, we ask for the actual scale and outcomes before writing a specific claim.</div>
   </div>
   <aside class="hn-profile-measure-card" aria-label="LinkedIn analytics buyers can review">
    <span class="hn-profile-card-tag">What to check after publishing</span>
    <h3>A clearer profile. Measurable signals.</h3>
    <p>These are LinkedIn account analytics to review over time. They are not HiredNext results or guaranteed deliverables.</p>
    <dl>
     <div><dt>Search appearances</dt><dd>Are relevant searches finding you?</dd></div>
     <div><dt>Profile views</dt><dd>Are people opening your profile?</dd></div>
     <div><dt>Recruiter / HR viewers</dt><dd>Check viewer roles when LinkedIn makes them available.</dd></div>
     <div><dt>Impressions &amp; likes</dt><dd>Measure your content activity separately from profile writing.</dd></div>
    </dl>
    <p class="hn-profile-measure-note">You control your LinkedIn account and analytics. Visibility depends on market demand, network, activity and LinkedIn settings.</p>
   </aside>
  </div>
  <div class="hn-profile-sample-action"><span>See the writing. Know the scope. Decide with confidence.</span><a class="hn-position-button" href="<?= base_url('career-services/start/linkedin_8999') ?>">Start my profile build →</a></div>
 </div>
</section>

<section class="hn-position-section hn-position-tint">
 <div class="hn-position-wrap">
  <p class="hn-position-kicker">The work behind the profile</p>
  <h2>Recruiter-aware writing, grounded in your evidence.</h2>
  <p class="hn-position-measure">HiredNext reviews the career story from the reader's side: level, progression, responsibility and fit for the roles you want. We then write the sections you can review and use.</p>
  <div class="hn-professional-grid">
   <?php foreach ([
    ['01 / Diagnose', 'Review your current CV, LinkedIn profile and target roles; identify weak positioning and evidence to clarify.'],
    ['02 / Write', 'Build a role-specific headline, About section and experience narrative that show progression, scope and contribution.'],
    ['03 / Align', 'Use accurate recruiter-search language, skills and proof that match your target work without keyword stuffing.'],
    ['04 / Review', 'Check every achievement with you, resolve unsupported claims and make the sections read as one coherent profile.'],
   ] as $item): ?>
   <article><h3><?= esc($item[0]) ?></h3><p><?= esc($item[1]) ?></p></article>
   <?php endforeach; ?>
  </div>
  <p class="hn-profile-authority">This is a writing and positioning service. Applying for HiredNext jobs is free and independent of any purchase. <a href="<?= base_url('mandate-stories') ?>">See how HiredNext reads hiring evidence →</a></p>
 </div>
</section>

<section class="hn-position-section">
 <div class="hn-position-wrap hn-position-measure">
  <p class="hn-position-kicker">Before you begin</p>
  <h2>Clear answers, then one next step.</h2>
  <details><summary>What do I need to provide?</summary><p>Your current CV, LinkedIn profile and the roles you want next. We may ask for the evidence behind an achievement before including it.</p></details>
  <details><summary>Will you publish or post from my LinkedIn account?</summary><p>No. You review the finished profile wording and control what goes live in your own account. Ongoing posting and paid promotion are not included.</p></details>
  <details><summary>Will this increase likes, impressions or recruiter views?</summary><p>We improve how your experience is presented and aligned to relevant roles. LinkedIn metrics also depend on your network, posting activity, settings and demand for your skills. We do not promise a particular number of views, enquiries or interviews.</p></details>
  <details><summary>How is this different from CXO positioning?</summary><p>This service is for professional and managerial job-market positioning. Business Heads, CXOs and enterprise leaders with complex commercial mandates may need the separate leadership engagement.</p></details>
  <p class="hn-profile-guide"><a href="<?= base_url('guides/linkedin-profile-optimisation-india') ?>">Read our recruiter-led guide to LinkedIn profile optimisation →</a></p>
  <div class="hn-profile-close">
   <div><span class="hn-profile-card-tag">Professional LinkedIn Profile Build</span><p class="hn-position-fee"><?= esc($plan['price_label']) ?></p><p><?= esc($plan['payable_label']) ?>, rounded to the nearest rupee.</p></div>
   <a class="hn-position-button" href="<?= base_url('career-services/start/linkedin_8999') ?>">Build my LinkedIn profile →</a>
  </div>
  <p class="hn-position-crosslink">Operating at Business Head / CXO / enterprise leadership level? <a href="<?= base_url('leadership-advisory/cxo-global-leadership-positioning') ?>">Explore CXO / Global Leadership Positioning →</a></p>
 </div>
</section>
</div>
<?= $this->endSection() ?>
