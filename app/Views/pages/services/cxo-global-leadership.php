<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('theme/linkedin-positioning.css') ?>">
<div class="hn-position hn-leadership">
<section class="hn-position-hero">
 <div class="hn-position-wrap">
  <p class="hn-position-kicker">HiredNext / Leadership Advisory</p>
  <p class="hn-leadership-service">CXO / Global Leadership Positioning</p>
  <h1>Your next mandate<br>begins with how your<br><em>leadership is understood.</em></h1>
  <div class="hn-leadership-hero-bottom">
   <p class="hn-position-intro">Make the scale of your decisions, the enterprise impact of your work and the relevance of your leadership legible to the people shaping your next appointment.</p>
   <div><a class="hn-position-button" href="#engagement">Explore the engagement →</a><p class="hn-position-small"><?= esc($plan['price_label']) ?> · Private positioning engagement</p></div>
  </div>
 </div>
</section>
<section class="hn-position-section hn-leadership-supporting" aria-label="Executive market context">
 <div class="hn-position-wrap hn-position-split">
  <div><p class="hn-position-kicker">The executive market</p><h2>A title introduces you.<br>Your evidence establishes your relevance.</h2></div>
  <div><p>A CEO, investor or global search partner may encounter your LinkedIn profile without knowing your employer, the complexity of your market or the scale behind your title. Your public narrative needs to make that context understandable.</p><p>We examine what you were accountable for, what changed under your leadership and which future mandates that evidence can credibly support. The result is executive market positioning built around commercial scale, career architecture and leadership evidence.</p></div>
 </div>
</section>
<section class="hn-position-section hn-leadership-evidence" id="engagement">
 <div class="hn-position-wrap">
  <p class="hn-position-kicker">The advisory work</p>
  <h2>From career history<br>to a coherent leadership proposition.</h2>
  <div class="hn-leadership-work">
   <?php foreach ([
    ['01', 'Diagnose the leadership mandate', 'Career architecture and target appointment', 'Clarify progression, decision rights, enterprise scope and the leadership problems you are equipped to solve.'],
    ['02', 'Establish the enterprise evidence', 'Commercial scale and attributable impact', 'Map defensible P&L, growth, cost, transformation and stakeholder evidence without manufacturing claims.'],
    ['03', 'Build the executive narrative', 'Search, board and investor readability', 'Create a coherent LinkedIn narrative around target mandates, global context and decision-maker relevance.'],
   ] as $item): ?>
   <article><span class="hn-leadership-number"><?= esc($item[0]) ?></span><div><h3><?= esc($item[1]) ?></h3><p class="hn-leadership-subtitle"><?= esc($item[2]) ?></p></div><p><?= esc($item[3]) ?></p></article>
   <?php endforeach; ?>
  </div>
 </div>
</section>
<section class="hn-position-section hn-leadership-supporting">
 <div class="hn-position-wrap hn-position-split">
  <div><p class="hn-position-kicker">Who this engagement serves</p><h2>Leadership defined<br>by responsibility.</h2><p>For functional heads, VPs, Business Heads, Presidents, Country Heads, CXOs, large P&L owners and senior transformation leaders whose next move requires enterprise context.</p></div>
  <div class="hn-position-steps">
   <p><strong>Enterprise & ownership</strong> Business leadership, board and promoter-facing positions, CEO appointments and PE-backed businesses.</p>
   <p><strong>Global & cross-border</strong> GCC leadership, international mandates, India-entry companies and global executive-search mandates.</p>
   <p><strong>Transition & adjacency</strong> Leaders moving from functional authority into wider enterprise accountability, or translating their experience into a different operating context.</p>
  </div>
 </div>
</section>
<section class="hn-position-section hn-position-tint hn-leadership-supporting" id="suitability">
 <div class="hn-position-wrap">
  <p class="hn-position-kicker">Engagement suitability</p><h2>Your mandate determines the depth of work.</h2>
  <p class="hn-position-measure">We consider eight dimensions. Years of experience provide context; they never decide the service on their own.</p>
  <ol class="hn-leadership-dimensions">
   <?php foreach (['Current organisational level','Scale of responsibility','Commercial / P&L ownership','Team and organisational complexity','Geographic scope','Stakeholder level','Target role','Functional-to-enterprise leadership transition'] as $dimension): ?>
   <li><?= esc($dimension) ?></li>
   <?php endforeach; ?>
  </ol>
  <p class="hn-position-measure hn-position-small">For example, a leader with 17 years of experience running a ₹1,500 Cr business and targeting CEO or Business Head mandates may need this engagement. A professional with 22 years of experience seeking another functional senior-management role may need professional career positioning. The work follows the responsibility and target role.</p>
 </div>
</section>
<section class="hn-position-section">
 <div class="hn-position-wrap hn-position-split">
  <div><p class="hn-position-kicker">What you take forward</p><h2>A leadership position<br>you can stand behind.</h2></div>
  <div><p>A clearly articulated leadership proposition, an enterprise evidence map, target-mandate and adjacency analysis, and a LinkedIn profile narrative structured around your commercial contribution and future direction.</p><p>The final review checks coherence across the headline, About, experience and leadership keywords, with particular attention to board, CEO, investor and international readability.</p><p class="hn-position-small">We clarify the scope you actually owned. We do not manufacture achievements, elevate titles or imply board experience you do not have. Sensitive commercial information is discussed before any public wording is agreed.</p></div>
 </div>
</section>
<section class="hn-position-section hn-leadership-faq hn-leadership-supporting">
 <div class="hn-position-wrap hn-position-measure">
  <h2>Before the conversation</h2>
  <p><a href="<?= base_url('guides/executive-linkedin-profile-india') ?>" style="text-decoration:underline">Read our perspective on executive LinkedIn positioning →</a></p>
  <details><summary>What is executive LinkedIn positioning?</summary><p>It is the strategic interpretation of your leadership record for the executive market: mandate, scale, accountability, outcomes and the appointments that evidence can support. The LinkedIn profile becomes a readable expression of that positioning.</p></details>
  <details><summary>Can this support a move from functional head to enterprise leadership?</summary><p>Yes. We examine career adjacency, commercial ownership, cross-functional decisions and stakeholder exposure. The narrative makes transferable evidence visible and identifies gaps; it does not claim experience that has not been earned.</p></details>
  <details><summary>How do you make an Indian leadership profile readable globally?</summary><p>We explain the business model, operating scale, geography, reporting context and decisions behind local titles. Commercial figures retain their original currency and context; unfamiliar company names or market terms are explained where useful.</p></details>
  <details><summary>Is this relevant to GCC, PE-backed or India-entry mandates?</summary><p>Yes, when your experience supports those targets. We map the evidence to the relevant mandate—for example, building a capability, scaling a business, transforming operations or working with ownership stakeholders.</p></details>
  <details><summary>Does this include executive-search representation?</summary><p>This engagement covers your leadership positioning and LinkedIn narrative. Introductions, search mandates, board appointments and recruitment outcomes are separate from the service.</p></details>
 </div>
</section>
<section class="hn-position-section hn-leadership-close">
 <div class="hn-position-wrap hn-position-split">
  <div><p class="hn-position-kicker">A considered next step</p><h2>Bring the leadership record.<br>Define what comes next.</h2><p>Share your current role, scale of responsibility and target mandate. These inputs frame the diagnostic and the depth of the positioning work.</p></div>
  <div><p class="hn-leadership-service">CXO / Global Leadership Positioning</p><div class="hn-position-fee"><?= esc($plan['price_label']) ?></div><p class="hn-position-small"><?= esc($plan['payable_label']) ?></p><p class="hn-position-small">Positioning is private and may be completed under NDA. Introductions, executive-search representation and appointment outcomes are separate from this engagement.</p><a class="hn-position-button" href="<?= base_url('career-services/start/leadership_17500') ?>">Begin my leadership engagement →</a></div>
 </div>
</section>
<div class="hn-position-wrap"><p class="hn-position-crosslink">For professional and managerial profiles, see our <a href="<?= base_url('services/linkedin-profile-build') ?>">Professional LinkedIn Profile Build</a>.</p></div>
</div>
<?= $this->endSection() ?>
