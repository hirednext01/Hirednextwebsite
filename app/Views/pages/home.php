<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min'; ?>

<section class="hero-home home-hero-premium relative min-h-screen flex items-center pt-32 pb-20 overflow-hidden text-white">
    <div class="hero-overlay"></div>
    <div class="hero-sheen"></div>
    <div class="hero-noise"></div>

    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10 w-full">
        <div class="grid lg:grid-cols-[1.15fr_0.85fr] gap-14 xl:gap-24 items-center">
            <div class="reveal reveal-right max-w-4xl">
                <div class="editorial-kicker editorial-kicker-light mb-8">
                    <span></span> Executive search · India and cross-border
                </div>
                <h1 class="font-serif text-5xl sm:text-6xl lg:text-7xl xl:text-[5.6rem] leading-[0.98] tracking-[-0.035em] mb-8">
                    The right leader changes <em class="text-accent not-italic">what happens next.</em>
                </h1>
                <p class="text-lg md:text-xl text-white/78 leading-relaxed max-w-2xl mb-10">
                    HiredNext finds CXOs, functional heads and hard-to-reach senior talent for companies where the cost of a wrong hire is too high.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?= base_url('services/executive-search') ?>" class="premium-button premium-button-accent">
                        Explore Executive Search <span aria-hidden="true">→</span>
                    </a>
                    <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="premium-button premium-button-ghost">
                        Discuss a Hiring Mandate
                    </a>
                </div>
            </div>

            <aside class="mandate-panel reveal reveal-scale" aria-label="Mandates HiredNext supports">
                <div class="mandate-panel-label">Where clients call us in</div>
                <div class="mandate-item">
                    <span>01</span>
                    <div><strong>Confidential leadership replacement</strong><small>Discreet search with controlled market outreach</small></div>
                </div>
                <div class="mandate-item">
                    <span>02</span>
                    <div><strong>New capability or India build-out</strong><small>Market mapping before the first shortlist</small></div>
                </div>
                <div class="mandate-item">
                    <span>03</span>
                    <div><strong>Roles that conventional sourcing misses</strong><small>Direct engagement with relevant passive talent</small></div>
                </div>
                <div class="mandate-panel-foot">Founder-led judgement · Structured assessment · Closure ownership</div>
            </aside>
        </div>
    </div>
</section>

<section class="proof-strip" aria-label="HiredNext recruitment focus">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 grid sm:grid-cols-3">
        <div><strong>A decade in search</strong><span>Senior hiring experience</span></div>
        <div><strong>India + cross-border</strong><span>Leadership mandates</span></div>
        <div><strong>CXO to functional heads</strong><span>Business-critical roles</span></div>
    </div>
</section>

<section class="py-24 lg:py-32 bg-[#f7f4ef]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-[0.75fr_1.25fr] gap-12 lg:gap-24 items-end mb-16">
            <div>
                <div class="editorial-kicker mb-5"><span></span> What we solve</div>
                <h2 class="font-serif text-4xl md:text-6xl text-primary leading-[1.05]">Search built around the mandate—not the database.</h2>
            </div>
            <p class="text-lg text-slate-600 leading-relaxed max-w-2xl lg:ml-auto">
                Every search starts with the business problem behind the vacancy. We calibrate the role, map the relevant market and speak to candidates with the context needed for a serious senior-level conversation.
            </p>
        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
            <a href="<?= base_url('services/executive-search') ?>" class="service-editorial-card service-editorial-card-featured group">
                <span class="service-number">01</span>
                <div>
                    <p class="service-tag">Flagship service</p>
                    <h3>Executive Search</h3>
                    <p>Confidential CXO, business and functional leadership hiring through targeted research and direct outreach.</p>
                    <strong>View the search approach <span>→</span></strong>
                </div>
            </a>
            <a href="<?= base_url('services/permanent-hiring') ?>" class="service-editorial-card group">
                <span class="service-number">02</span>
                <div>
                    <p class="service-tag">Mid-senior recruitment</p>
                    <h3>Permanent Hiring</h3>
                    <p>Focused recruitment for specialist and management roles where industry context and candidate intent matter.</p>
                    <strong>Explore permanent hiring <span>→</span></strong>
                </div>
            </a>
            <a href="<?= base_url('services/rpo') ?>" class="service-editorial-card group">
                <span class="service-number">03</span>
                <div>
                    <p class="service-tag">Embedded capacity</p>
                    <h3>RPO Solutions</h3>
                    <p>Dedicated recruitment support for organisations that need greater sourcing, screening and coordination capacity.</p>
                    <strong>Explore RPO <span>→</span></strong>
                </div>
            </a>
            <a href="<?= base_url('cv-assessment') ?>" class="service-editorial-card group">
                <span class="service-number">04</span>
                <div>
                    <p class="service-tag">For professionals</p>
                    <h3>Career Services</h3>
                    <p>Recruiter-led CV assessment and practical career support for professionals navigating their next move.</p>
                    <strong>Assess your CV <span>→</span></strong>
                </div>
            </a>
        </div>
    </div>
</section>

<section id="leadership-hiring" class="py-24 lg:py-32 bg-primary text-white relative overflow-hidden">
    <div class="leadership-glow"></div>
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
        <div class="grid lg:grid-cols-2 gap-16 lg:gap-28">
            <div>
                <div class="editorial-kicker editorial-kicker-light mb-6"><span></span> How the work gets done</div>
                <h2 class="font-serif text-4xl md:text-6xl leading-[1.05] mb-8">A shortlist should carry judgement, not just résumés.</h2>
                <p class="text-lg text-white/70 leading-relaxed mb-10 max-w-xl">
                    We stay close to the mandate from calibration through joining. That continuity matters when senior candidates are evaluating the company as carefully as the company is evaluating them.
                </p>
                <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="premium-button premium-button-accent">Start a confidential discussion <span>→</span></a>
            </div>

            <ol class="search-steps">
                <li><span>01</span><div><h3>Calibrate the outcome</h3><p>Define what this person must change, build or protect—not merely the title and reporting line.</p></div></li>
                <li><span>02</span><div><h3>Map the real market</h3><p>Identify relevant organisations, adjacent talent pools and candidate trade-offs before outreach begins.</p></div></li>
                <li><span>03</span><div><h3>Assess with context</h3><p>Test achievements, scale, leadership judgement, motivation and fit against the actual mandate.</p></div></li>
                <li><span>04</span><div><h3>Stay through closure</h3><p>Keep expectations, decision-makers and candidate intent aligned through selection, offer and joining.</p></div></li>
            </ol>
        </div>
    </div>
</section>

<section id="industry-expertise" class="py-24 lg:py-32 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="max-w-3xl mb-14">
            <div class="editorial-kicker mb-5"><span></span> Sector context</div>
            <h2 class="font-serif text-4xl md:text-6xl text-primary leading-[1.05] mb-6">Recruiters who understand the conversation.</h2>
            <p class="text-lg text-slate-600 leading-relaxed">Sector knowledge sharpens where we search, what we ask and how quickly we can distinguish real depth from a well-presented profile.</p>
        </div>
        <div class="industry-link-grid">
            <a href="<?= base_url('industry/it-recruitment-services-india') ?>"><span>Technology & GCC</span><small>Product, engineering, data and platform leadership</small><b>→</b></a>
            <a href="<?= base_url('industry/bfsi-leadership-hiring') ?>"><span>BFSI</span><small>Banking, NBFC, fintech, insurance and governance roles</small><b>→</b></a>
            <a href="<?= base_url('industry/retail-executive-search') ?>"><span>Retail & Consumer</span><small>Commercial, buying, brand and operating leadership</small><b>→</b></a>
            <a href="<?= base_url('industry/engineering-recruitment-firm') ?>"><span>Engineering</span><small>Projects, quality, maintenance and technical leadership</small><b>→</b></a>
            <a href="<?= base_url('industry/manufacturing-talent-advisory') ?>"><span>Manufacturing</span><small>Plant, operations, supply chain and transformation</small><b>→</b></a>
        </div>
    </div>
</section>

<section class="py-24 lg:py-32 bg-[#f7f4ef]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="founder-note grid lg:grid-cols-[0.85fr_1.15fr] gap-12 lg:gap-20 items-center">
            <div class="founder-note-mark" aria-hidden="true">“</div>
            <div>
                <div class="editorial-kicker mb-6"><span></span> The HiredNext difference</div>
                <blockquote class="font-serif text-3xl md:text-5xl text-primary leading-[1.15] mb-8">
                    Senior hiring is not profile matching. It is understanding the person, the company and the consequences of the move.
                </blockquote>
                <p class="text-slate-600 leading-relaxed max-w-2xl mb-6">
                    HiredNext is founder-led and intentionally hands-on for leadership mandates. Clients get clear market feedback, candid candidate assessment and ownership of the search—not layers of account management.
                </p>
                <p class="font-bold text-primary">Taru Shikha <span class="font-medium text-slate-500">· Founder, HiredNext Recruitment</span></p>
            </div>
        </div>
    </div>
</section>

<?php $homeJobs = array_slice($jobs ?? [], 0, 3); ?>
<section class="py-24 lg:py-32 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-14">
            <div class="max-w-3xl">
                <div class="editorial-kicker mb-5"><span></span> Current opportunities</div>
                <h2 class="font-serif text-4xl md:text-6xl text-primary leading-[1.05]">Roles worth a considered move.</h2>
            </div>
            <a href="<?= base_url('jobs') ?>" class="text-primary font-bold hover:text-accent transition-colors">View all open roles →</a>
        </div>

        <?php if (!empty($homeJobs)): ?>
            <div class="grid lg:grid-cols-3 gap-5">
                <?php foreach ($homeJobs as $job): ?>
                    <?php
                    $description = trim(preg_replace('/\s+/', ' ', strip_tags($job['description'] ?? '')));
                    if (mb_strlen($description) > 150) {
                        $description = rtrim(mb_substr($description, 0, 147)) . '…';
                    }
                    ?>
                    <article class="job-card-compact">
                        <div class="job-card-meta">
                            <span><?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'Full time'))) ?></span>
                            <?php if (!empty($job['location'])): ?><span><?= esc($job['location']) ?></span><?php endif; ?>
                        </div>
                        <h3><?= esc($job['title'] ?? '') ?></h3>
                        <?php if (!empty($description)): ?><p><?= esc($description) ?></p><?php endif; ?>
                        <a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>">View role <span>→</span></a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rounded-3xl border border-slate-200 bg-slate-50 px-8 py-12 text-center text-slate-600">
                New mandates are added regularly. Visit the jobs page for the latest openings.
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($faq)): ?>
<section class="py-24 lg:py-32 bg-[#f7f4ef]">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 lg:px-12 grid lg:grid-cols-[0.7fr_1.3fr] gap-12 lg:gap-24">
        <div>
            <div class="editorial-kicker mb-5"><span></span> Clear answers</div>
            <h2 class="font-serif text-4xl md:text-5xl text-primary leading-[1.08]">What companies ask before engaging us.</h2>
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
        <div class="editorial-kicker editorial-kicker-light justify-center mb-6"><span></span> Your next critical hire</div>
        <h2 class="font-serif text-4xl md:text-6xl text-white leading-[1.05] mb-7">Bring us the role that needs more than sourcing.</h2>
        <p class="text-lg text-white/70 max-w-2xl mx-auto mb-10">Tell us what the person must achieve. We will tell you how we would approach the market.</p>
        <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="premium-button premium-button-accent">Book a 30-minute mandate discussion <span>→</span></a>
    </div>
</section>

<?= $this->endSection() ?>
