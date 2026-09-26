<?= $this->extend('layouts/main') ?>
<?= $this->section('pageStyles') ?>
<link rel="stylesheet" href="<?= base_url('theme/css/premium-home.css?v=20260926') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="hn-premium-home">
    <section class="hero-home hn-home-hero" aria-labelledby="home-title">
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="hero-sheen" aria-hidden="true"></div>
        <div class="hero-noise" aria-hidden="true"></div>
        <div class="hn-home-container hn-home-hero-grid">
            <div class="hn-home-intro">
                <p class="hn-home-eyebrow">Executive recruitment and talent advisory</p>
                <h1 id="home-title">Leadership hiring.<br>Built around your mandate.</h1>
                <p class="hn-home-summary">Confidential search, permanent hiring, RPO and contract to hire for critical business roles in India and cross-border markets.</p>
                <a class="hn-home-primary" href="<?= base_url('hiring-discussion') ?>">Discuss a Hiring Mandate <span aria-hidden="true">→</span></a>
                <p class="hn-home-principle">Confidential search. Evidence led decisions.</p>
            </div>
            <aside class="hero-panel hn-home-approach" aria-labelledby="approach-title">
                <p class="hn-home-eyebrow">Our approach</p>
                <h2 id="approach-title">Evidence before introductions.</h2>
                <ol>
                    <li><span class="hn-home-step" aria-hidden="true">01</span><span>Understand the mandate</span></li>
                    <li><span class="hn-home-step" aria-hidden="true">02</span><span>Map the right talent</span></li>
                    <li><span class="hn-home-step" aria-hidden="true">03</span><span>Assess with discretion</span></li>
                </ol>
            </aside>
        </div>
    </section>

    <section class="hn-home-services" aria-labelledby="services-title">
        <div class="hn-home-container">
            <p class="hn-home-eyebrow">Our services</p>
            <h2 id="services-title">The right hiring model.<br class="hn-home-mobile-break"> One accountable partner.</h2>
            <div class="hn-home-service-grid">
                <?php $employerServices = [
                    ['Permanent hiring', 'Leadership, mid senior and specialist appointments built around the business need.', 'services/permanent-hiring', 'Explore permanent hiring', 'people'],
                    ['Recruitment process outsourcing', 'Dedicated recruitment capacity, with clear ownership from sourcing through joining.', 'services/rpo', 'Explore RPO', 'process'],
                    ['Contract to hire', 'A considered route to assess capability in role before a long term appointment.', 'hiring-discussion', 'Discuss contract to hire', 'document'],
                ]; ?>
                <?php foreach ($employerServices as [$title, $copy, $path, $label, $icon]): ?>
                    <article class="hn-home-service">
                        <svg class="hn-home-service-icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <?php if ($icon === 'people'): ?>
                                <circle cx="13" cy="9" r="5"/><path d="M3 28v-3a10 10 0 0 1 20 0v3H3ZM22 5a5 5 0 0 1 0 9M25 18a9 9 0 0 1 4 7v3"/>
                            <?php elseif ($icon === 'process'): ?>
                                <rect x="11" y="2" width="10" height="8" rx="1"/><rect x="2" y="22" width="10" height="8" rx="1"/><rect x="20" y="22" width="10" height="8" rx="1"/><path d="M16 10v6M7 22v-6h18v6"/>
                            <?php else: ?>
                                <path d="M7 2h12l6 6v22H7V2ZM19 2v7h6M12 15h8M12 20h8M12 25h5"/>
                            <?php endif; ?>
                        </svg>
                        <div>
                            <h3><?= esc($title) ?></h3>
                            <p><?= esc($copy) ?></p>
                            <a href="<?= base_url($path) ?>"><?= esc($label) ?> <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="hn-home-search-note">
                <p>For sensitive leadership appointments, discretion shapes every stage of the search.</p>
                <a href="<?= base_url('services/executive-search') ?>">Our executive search approach <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </section>

    <section class="hn-home-credibility" aria-label="Testimonials and media coverage">
        <div class="hn-home-container hn-home-credibility-grid">
            <a class="hn-home-proof-link" href="<?= base_url('testimonials') ?>">
                <div>
                    <h2>Testimonials</h2>
                    <p>Hear from hiring leaders and professionals placed through HiredNext.</p>
                </div>
                <span class="hn-home-proof-arrow" aria-hidden="true">→</span>
            </a>
            <a class="hn-home-proof-link" href="<?= base_url('press-media') ?>">
                <div>
                    <h2>Press &amp; Media</h2>
                    <p>Interviews and commentary on recruitment and the changing world of work.</p>
                </div>
                <span class="hn-home-proof-arrow" aria-hidden="true">→</span>
            </a>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageFooter') ?>
<footer class="hn-home-footer">
    <div class="hn-home-container">
        <div class="hn-home-footer-top">
            <a href="<?= base_url() ?>" class="site-brand-lockup" aria-label="HiredNext Recruitment home">
                <span class="site-brand-primary">HIRED<span class="text-accent">NEXT</span></span>
                <span class="site-brand-divider" aria-hidden="true"></span>
                <span class="site-brand-secondary">RECRUITMENT</span>
            </a>
            <nav aria-label="Footer">
                <a href="<?= base_url('about') ?>">About the firm</a>
                <a href="<?= base_url('testimonials') ?>">Testimonials</a>
                <a href="<?= base_url('press-media') ?>">Press &amp; Media</a>
                <a href="<?= base_url('mandate-stories') ?>">Mandate stories</a>
                <a href="<?= base_url('search-authority') ?>">Hiring guides</a>
                <a href="<?= base_url('jobs') ?>">Job Board</a>
                <a href="<?= base_url('contact') ?>">Contact</a>
            </nav>
        </div>
        <details class="hn-home-firm-details">
            <summary>About HiredNext and sector expertise</summary>
            <p>Founded in Mumbai in 2016, HiredNext later moved its operating base to Gurugram (Gurgaon), Haryana. We are an India-based executive recruitment and talent advisory firm supporting work across India and cross-border markets including Indonesia, China, the UAE (Dubai), Jordan and Bangladesh. Our operating base is in Gurugram; we do not claim local offices in these markets or offer a public walk-in office.</p>
            <div class="hn-home-sector-links">
                <?php foreach ([
                    ['industry/garment-textile-recruitment-india', 'Textile, apparel and fashion'],
                    ['industry/it-recruitment-services-india', 'Technology'],
                    ['industry/bfsi-leadership-hiring', 'BFSI'],
                    ['industry/global-capability-centres-hiring-india', 'Global Capability Centres'],
                    ['industry/semiconductor-recruitment-india', 'Semiconductors'],
                    ['industry/manufacturing-recruitment-india', 'Manufacturing'],
                ] as [$path, $label]): ?>
                    <a href="<?= base_url($path) ?>"><?= esc($label) ?></a>
                <?php endforeach; ?>
            </div>
        </details>
        <div class="hn-home-legal">
            <p>&copy; <?= esc(date('Y')) ?> HiredNext Recruitment.</p>
            <p><?= esc(config('BrandFacts')->legalDisclosure()) ?></p>
        </div>
    </div>
</footer>
<?= $this->endSection() ?>
