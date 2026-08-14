<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min'; ?>

<header class="hero-service-detail hero-service-executive executive-hero relative min-h-[88vh] flex items-center pt-32 pb-20 overflow-hidden text-white">
    <div class="hero-overlay"></div>
    <div class="hero-sheen"></div>
    <div class="hero-noise"></div>
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10 w-full">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-sm text-white/60 mb-12">
            <a href="<?= base_url() ?>" class="hover:text-white transition-colors">Home</a><span>/</span>
            <a href="<?= base_url('services') ?>" class="hover:text-white transition-colors">Services</a><span>/</span>
            <span class="text-white">Executive Search</span>
        </nav>
        <div class="grid lg:grid-cols-[1.15fr_0.85fr] gap-14 lg:gap-24 items-end">
            <div class="max-w-4xl">
                <div class="editorial-kicker editorial-kicker-light mb-8"><span></span> Executive Search</div>
                <h1 class="font-serif text-5xl sm:text-6xl lg:text-8xl leading-[0.98] tracking-[-0.035em] mb-8">
                    Leadership hiring when the <em class="text-accent not-italic">decision matters most.</em>
                </h1>
                <p class="text-lg md:text-xl text-white/78 max-w-2xl leading-relaxed">
                    Confidential search for CXOs, business leaders and functional heads—combining mandate calibration, market mapping, direct outreach and evidence-led assessment.
                </p>
            </div>
            <div class="executive-hero-brief">
                <p class="executive-hero-brief-label">Designed for</p>
                <ul>
                    <li>Confidential replacements</li>
                    <li>New leadership capability</li>
                    <li>India and GCC build-outs</li>
                    <li>Hard-to-reach specialist leaders</li>
                </ul>
                <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer">Discuss the mandate <span>→</span></a>
            </div>
        </div>
    </div>
</header>

<section class="executive-principles">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 grid md:grid-cols-3">
        <div><span>01</span><strong>Discreet by design</strong><p>Disclosure and outreach are calibrated to the sensitivity of the search.</p></div>
        <div><span>02</span><strong>Research before reach-out</strong><p>The relevant market is mapped before profiles are presented.</p></div>
        <div><span>03</span><strong>Assessment with evidence</strong><p>Recommendations are tied to achievements, context and mandate fit.</p></div>
    </div>
</section>

<section class="py-24 lg:py-32 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 grid lg:grid-cols-[0.85fr_1.15fr] gap-14 lg:gap-24 items-start">
        <div class="lg:sticky lg:top-32">
            <div class="editorial-kicker mb-5"><span></span> The real brief</div>
            <h2 class="font-serif text-4xl md:text-6xl text-primary leading-[1.05] mb-8">We search for the outcome—not a copy of the last person.</h2>
            <p class="text-lg text-slate-600 leading-relaxed mb-8">
                A job description rarely captures the full leadership problem. We clarify the business stage, stakeholder expectations, non-negotiable experience and the conditions under which the new leader must succeed.
            </p>
            <a href="<?= base_url('contact') ?>" class="text-primary font-bold hover:text-accent transition-colors">Share a confidential brief →</a>
        </div>

        <div class="executive-question-grid">
            <article><span>Business context</span><h3>What must change after this person joins?</h3><p>Growth, transformation, governance, capability building, succession or stabilisation each require a different leadership profile.</p></article>
            <article><span>Relevant scale</span><h3>What complexity have they handled?</h3><p>We look beyond titles to team scale, market conditions, decision authority and the measurable consequences of their work.</p></article>
            <article><span>Candidate motivation</span><h3>Why would the right leader move?</h3><p>Senior candidates need a credible account of the opportunity, risks, sponsor and room to create impact—not a generic pitch.</p></article>
            <article><span>Organisational fit</span><h3>Where will judgement matter most?</h3><p>We explore pace, ownership, ambiguity, stakeholder style and leadership environment so fit is discussed with specificity.</p></article>
        </div>
    </div>
</section>

<section class="py-24 lg:py-32 bg-[#f7f4ef]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="max-w-3xl mb-16">
            <div class="editorial-kicker mb-5"><span></span> Search architecture</div>
            <h2 class="font-serif text-4xl md:text-6xl text-primary leading-[1.05] mb-6">A disciplined path from mandate to joining.</h2>
            <p class="text-lg text-slate-600 leading-relaxed">The process stays structured, but the research and assessment are built around the individual search.</p>
        </div>
        <ol class="executive-process-grid">
            <li><span>01</span><h3>Mandate calibration</h3><p>Stakeholder conversations, success outcomes, target profile, search boundaries and confidentiality protocol.</p></li>
            <li><span>02</span><h3>Market mapping</h3><p>Target companies, adjacent pools, relevant leaders and a realistic view of availability and compensation.</p></li>
            <li><span>03</span><h3>Direct engagement</h3><p>Credible, discreet outreach that gives potential candidates enough context for a serious conversation.</p></li>
            <li><span>04</span><h3>Evidence-led assessment</h3><p>Structured evaluation of achievements, leadership context, motivation, risks and role-specific fit.</p></li>
            <li><span>05</span><h3>Decision support</h3><p>Clear candidate notes, market feedback, interview alignment and reference context for informed comparison.</p></li>
            <li><span>06</span><h3>Closure and joining</h3><p>Expectation management through offer, notice period and transition—when senior hiring remains most vulnerable.</p></li>
        </ol>
    </div>
</section>

<section class="py-24 lg:py-32 bg-primary text-white relative overflow-hidden">
    <div class="leadership-glow"></div>
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
        <div class="grid lg:grid-cols-[0.8fr_1.2fr] gap-14 lg:gap-24">
            <div>
                <div class="editorial-kicker editorial-kicker-light mb-5"><span></span> Leadership coverage</div>
                <h2 class="font-serif text-4xl md:text-6xl leading-[1.05] mb-8">Roles where leadership judgement changes the business.</h2>
                <p class="text-white/70 text-lg leading-relaxed">Our search universe is defined by the mandate, not restricted to one job-title vocabulary.</p>
            </div>
            <div class="leadership-role-list">
                <div><strong>Enterprise leadership</strong><span>CEO · Managing Director · Country Head · Business Head</span></div>
                <div><strong>Growth and commercial</strong><span>Chief Commercial Officer · Sales · Marketing · Category · Retail</span></div>
                <div><strong>Technology and digital</strong><span>CTO · CIO · Product · Engineering · Data · Information Security</span></div>
                <div><strong>Operations and supply chain</strong><span>COO · Plant · Manufacturing · Projects · Quality · Supply Chain</span></div>
                <div><strong>Corporate functions</strong><span>CFO · CHRO · Legal · Risk · Strategy · Transformation</span></div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 lg:py-32 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-[0.8fr_1.2fr] gap-12 lg:gap-24 mb-14">
            <div>
                <div class="editorial-kicker mb-5"><span></span> Industry and geography</div>
                <h2 class="font-serif text-4xl md:text-6xl text-primary leading-[1.05]">Built in India. Ready for cross-border mandates.</h2>
            </div>
            <p class="text-lg text-slate-600 leading-relaxed lg:self-end">
                We support India leadership hiring as well as roles connected to GCC growth, regional responsibilities and international operating contexts. Each search is anchored in the specific sector and talent market.
            </p>
        </div>
        <div class="executive-link-columns">
            <div><h3>Sector expertise</h3><a href="<?= base_url('industry/garment-textile-recruitment-india') ?>">Textile, Apparel, Fashion & Lifestyle</a><a href="<?= base_url('industry/it-recruitment-services-india') ?>">Technology & GCC</a><a href="<?= base_url('industry/bfsi-leadership-hiring') ?>">BFSI</a><a href="<?= base_url('industry/retail-executive-search') ?>">Retail & Consumer</a><a href="<?= base_url('industry/engineering-recruitment-firm') ?>">Engineering</a><a href="<?= base_url('industry/manufacturing-talent-advisory') ?>">Manufacturing</a></div>
            <div><h3>Regions supported</h3><a href="<?= base_url('regions/india') ?>">India</a><a href="<?= base_url('regions/middle-east') ?>">Middle East</a><a href="<?= base_url('regions/apac') ?>">APAC</a><a href="<?= base_url('regions/europe') ?>">Europe</a><a href="<?= base_url('regions/usa') ?>">United States</a></div>
        </div>
    </div>
</section>

<?php if (!empty($faq)): ?>
<section class="py-24 lg:py-32 bg-[#f7f4ef]">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 lg:px-12 grid lg:grid-cols-[0.7fr_1.3fr] gap-12 lg:gap-24">
        <div>
            <div class="editorial-kicker mb-5"><span></span> Executive search FAQs</div>
            <h2 class="font-serif text-4xl md:text-5xl text-primary leading-[1.08]">Direct answers before we begin.</h2>
        </div>
        <div class="faq-list">
            <?php foreach ($faq as $index => $item): ?>
                <details <?= $index === 0 ? 'open' : '' ?>>
                    <summary><?= esc($item['q']) ?><span aria-hidden="true">+</span></summary>
                    <p><?= esc($item['a']) ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="closing-cta">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 lg:px-12 text-center relative z-10">
        <div class="editorial-kicker editorial-kicker-light justify-center mb-6"><span></span> Begin discreetly</div>
        <h2 class="font-serif text-4xl md:text-6xl text-white leading-[1.05] mb-7">Let’s discuss the leadership outcome before the job description.</h2>
        <p class="text-lg text-white/70 max-w-2xl mx-auto mb-10">A confidential first conversation is enough to understand the mandate and outline the search.</p>
        <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="premium-button premium-button-accent">Book a confidential discussion <span>→</span></a>
    </div>
</section>

<?= $this->endSection() ?>
