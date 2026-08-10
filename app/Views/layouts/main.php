<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php
    $settings = $settings ?? [];
    $pageTitle = $title ?? 'HiredNext | Executive Search & Leadership Recruitment Firm in India';
    $metaDescription = $metaDescription ?? ($settings['meta_description'] ?? 'HiredNext is an executive search and recruitment firm in India specialising in leadership hiring, permanent recruitment and RPO solutions.');
    $canonicalUrl = $canonical ?? current_url();
    $socialImage = $ogImage ?? base_url('theme/assets/home.jpeg');
    $socialType = $ogType ?? 'website';
    $keywordContent = $metaKeywords ?? ($settings['meta_keywords'] ?? $settings['site_keywords'] ?? 'HiredNext, talent advisory, recruitment');
    ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($pageTitle) ?></title>
    <meta name="description" content="<?= esc($metaDescription) ?>" />
    <meta name="keywords" content="<?= esc($keywordContent) ?>" />
    <?php if (!empty($articleAuthor)): ?><meta name="author" content="<?= esc($articleAuthor) ?>" /><?php endif; ?>
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1" />
    <link rel="canonical" href="<?= esc($canonicalUrl) ?>" />
    <meta property="og:type" content="<?= esc($socialType) ?>" />
    <meta property="og:locale" content="en_IN" />
    <meta property="og:title" content="<?= esc($pageTitle) ?>" />
    <meta property="og:description" content="<?= esc($metaDescription) ?>" />
    <meta property="og:url" content="<?= esc($canonicalUrl) ?>" />
    <meta property="og:site_name" content="HiredNext Recruitment" />
    <meta property="og:image" content="<?= esc($socialImage) ?>" />
    <meta property="og:image:alt" content="<?= esc($pageTitle) ?>" />
    <?php if (!empty($publishedTime)): ?><meta property="article:published_time" content="<?= esc($publishedTime) ?>" /><?php endif; ?>
    <?php if (!empty($modifiedTime)): ?><meta property="article:modified_time" content="<?= esc($modifiedTime) ?>" /><?php endif; ?>
    <?php if (!empty($articleAuthor)): ?><meta property="article:author" content="<?= esc($articleAuthor) ?>" /><?php endif; ?>
    <?php if (!empty($articleSection)): ?><meta property="article:section" content="<?= esc($articleSection) ?>" /><?php endif; ?>
    <?php foreach (($articleTags ?? []) as $articleTag): ?><meta property="article:tag" content="<?= esc($articleTag) ?>" /><?php endforeach; ?>
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= esc($pageTitle) ?>" />
    <meta name="twitter:description" content="<?= esc($metaDescription) ?>" />
    <meta name="twitter:image" content="<?= esc($socialImage) ?>" />
    <link rel="alternate" type="application/rss+xml" title="HiredNext Recruitment Insights" href="<?= base_url('blog/feed.xml') ?>" />
    <?php if (!empty($jsonLd) && is_string($jsonLd)): ?>
        <script type="application/ld+json"><?= $jsonLd ?></script>
    <?php endif; ?>
    <link rel="stylesheet" href="<?= base_url('theme/css/style.css') ?>" />
    <link rel="icon" href="<?= base_url('theme/assets/favicon.jpg') ?>" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: { primary: '#0c3466', accent: '#ff4e16', gold: '#d4af37' },
                fontFamily: { sans: ['Manrope', 'sans-serif'], serif: ['DM Serif Display', 'serif'] }
            }}
        }
    </script>
    <?php if (!empty($settings['google_analytics'])): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= esc($settings['google_analytics']) ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '<?= esc($settings['google_analytics']) ?>');
        </script>
    <?php endif; ?>
</head>
<body>
    <?php $siteName = $settings['site_name'] ?? 'HiredNext'; ?>
    <?php $calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min'; ?>

    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-3 focus:text-sm focus:font-bold focus:text-primary">Skip to main content</a>

    <nav id="navbar" aria-label="Primary" class="fixed w-full z-50 transition-all duration-300 bg-transparent py-5">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <div class="flex justify-between items-center">
                <a href="<?= base_url() ?>" class="flex items-center">
                    <span id="logoText" class="text-2xl lg:text-3xl font-bold tracking-tighter text-white">
                        <?php if ($siteName === 'HiredNext'): ?>HIRED<span class="text-accent">NEXT</span> RECRUITMENT<?php else: ?><?= esc($siteName) ?><?php endif; ?>
                    </span>
                </a>

                <div class="hidden md:flex space-x-8 lg:space-x-10 items-center">
                    <a href="<?= base_url() ?>" class="nav-link text-sm font-semibold text-white">Home</a>
                    <a href="<?= base_url('about') ?>" class="nav-link text-sm font-semibold text-white">About</a>

                    <div class="relative group py-3">
                        <button type="button" class="nav-link text-sm font-semibold text-white inline-flex items-center gap-1.5" aria-haspopup="true">
                            Services
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.51a.75.75 0 01-1.08 0l-4.25-4.51a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                        </button>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full w-72 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-200">
                            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden p-2">
                                <a href="<?= base_url('services/clients') ?>" class="block rounded-xl px-5 py-4 hover:bg-gray-50 transition">
                                    <span class="block text-sm font-extrabold text-primary">For Clients</span>
                                    <span class="block text-xs text-gray-500 mt-1">Executive search, permanent hiring & RPO</span>
                                </a>
                                <a href="<?= base_url('services/candidates') ?>" class="block rounded-xl px-5 py-4 hover:bg-gray-50 transition">
                                    <span class="block text-sm font-extrabold text-primary">For Candidates</span>
                                    <span class="block text-xs text-gray-500 mt-1">CV, interview, Avron & UpMentorX support</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="<?= base_url('testimonials') ?>" class="nav-link text-sm font-semibold text-white">Testimonials</a>
                    <a href="<?= base_url('press-media') ?>" class="nav-link text-sm font-semibold text-white">Press & Media</a>
                    <a href="<?= base_url('blog') ?>" class="nav-link text-sm font-semibold text-white">Blog</a>
                    <a href="<?= base_url('jobs') ?>" class="nav-link text-sm font-semibold text-white">Jobs</a>
                    <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="bg-accent text-gray-900 px-7 py-2.5 rounded-full text-sm font-bold hover:bg-opacity-90 transition-all shadow-lg hover:shadow-accent/30">Book a 30-Min Call</a>
                </div>

                <div class="md:hidden">
                    <button id="menuBtn" class="text-white" aria-label="Open navigation menu">
                        <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                        <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="hidden"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobileMenu" class="md:hidden hidden bg-white shadow-xl absolute top-full left-0 w-full p-6 animate-in slide-in-from-top duration-300 max-h-[calc(100vh-80px)] overflow-y-auto">
            <div class="flex flex-col space-y-4">
                <a href="<?= base_url() ?>" class="mobile-link">Home</a>
                <a href="<?= base_url('about') ?>" class="mobile-link">About</a>
                <div class="border-y border-gray-100 py-4">
                    <div class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3">Services</div>
                    <div class="space-y-2 pl-2">
                        <a href="<?= base_url('services/clients') ?>" class="mobile-link block font-bold">For Clients</a>
                        <a href="<?= base_url('services/candidates') ?>" class="mobile-link block font-bold">For Candidates</a>
                    </div>
                </div>
                <a href="<?= base_url('testimonials') ?>" class="mobile-link">Testimonials</a>
                <a href="<?= base_url('press-media') ?>" class="mobile-link">Press & Media</a>
                <a href="<?= base_url('blog') ?>" class="mobile-link">Blog</a>
                <a href="<?= base_url('jobs') ?>" class="mobile-link">Jobs</a>
                <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="bg-accent text-gray-900 px-6 py-3 rounded-xl text-center font-bold">Book a 30-Min Call</a>
            </div>
        </div>
    </nav>

    <?php $maintenanceEnabled = isset($settings['maintenance_mode']) && filter_var($settings['maintenance_mode'], FILTER_VALIDATE_BOOLEAN); ?>
    <?php if ($maintenanceEnabled): ?>
        <div class="bg-accent text-gray-900 text-center text-xs font-bold uppercase tracking-widest py-3 px-4">Maintenance Mode Enabled — The site may be temporarily unavailable.</div>
    <?php endif; ?>

    <main id="main-content"><?= $this->renderSection('content') ?></main>

    <footer class="py-20 bg-primary text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-80 h-80 bg-accent opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gold opacity-10 rounded-full blur-3xl"></div>
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div>
                    <h3 class="text-2xl font-bold mb-4"><?php if ($siteName === 'HiredNext'): ?>HIRED<span class="text-accent">NEXT</span> RECRUITMENT<?php else: ?><?= esc($siteName) ?><?php endif; ?></h3>
                    <p class="text-white/70 leading-relaxed"><?= esc($settings['site_tagline'] ?? 'A global talent advisory and recruitment firm delivering high-impact leadership solutions across sectors.') ?></p>
                </div>
                <div>
                    <h4 class="font-bold mb-5 uppercase tracking-widest text-sm">Company</h4>
                    <ul class="space-y-3 text-sm text-white/70">
                        <li><a href="<?= base_url() ?>" class="hover:text-accent">Home</a></li>
                        <li><a href="<?= base_url('about') ?>" class="hover:text-accent">About</a></li>
                        <li><a href="<?= base_url('services/clients') ?>" class="hover:text-accent">Services for Clients</a></li>
                        <li><a href="<?= base_url('services/candidates') ?>" class="hover:text-accent">Services for Candidates</a></li>
                        <li><a href="<?= base_url('blog') ?>" class="hover:text-accent">Insights & Blog</a></li>
                        <li><a href="<?= base_url('jobs') ?>" class="hover:text-accent">Jobs</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-5 uppercase tracking-widest text-sm">Contact</h4>
                    <?php
                    $phones = array_values(array_unique(array_filter([$settings['contact_phone'] ?? null,$settings['contact_phone_2'] ?? null,$settings['contact_phone_3'] ?? null,$settings['contact_phone_4'] ?? null])));
                    $emails = array_values(array_unique(array_filter([$settings['contact_email'] ?? null,$settings['contact_email_2'] ?? null,$settings['contact_email_3'] ?? null,$settings['contact_email_4'] ?? null])));
                    ?>
                    <div class="space-y-3 text-sm text-white/70">
                        <?php foreach ($phones as $phone): ?><div><?= esc($phone) ?></div><?php endforeach; ?>
                        <?php foreach ($emails as $email): ?><div><?= esc($email) ?></div><?php endforeach; ?>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-5 uppercase tracking-widest text-sm">Let’s Talk</h4>
                    <p class="text-white/70 mb-4">Book a private consultation with our advisors.</p>
                    <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-block bg-accent text-gray-900 px-6 py-3 rounded-xl font-bold">Book a 30-Min Call</a>
                    <a href="<?= base_url('contact') ?>" class="block mt-4 text-sm text-white/80 hover:text-white">Contact Us</a>
                </div>
            </div>

            <div class="border-t border-white/10 pt-10 grid lg:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-bold mb-3 uppercase tracking-widest text-sm">Executive Search in India</h4>
                    <div class="flex flex-wrap gap-x-3 gap-y-2 text-sm text-white/70">
                        <a href="<?= base_url('services/executive-search') ?>" class="hover:text-accent">Executive Search India</a>
                        <span>•</span><a href="<?= base_url('contact') ?>?location=bangalore" class="hover:text-accent">Leadership Hiring Bangalore</a>
                        <span>•</span><a href="<?= base_url('contact') ?>?location=gurgaon" class="hover:text-accent">CXO Recruitment Gurgaon</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-3 uppercase tracking-widest text-sm">Industry Expertise</h4>
                    <div class="flex flex-wrap gap-x-3 gap-y-2 text-sm text-white/70">
                        <a href="<?= base_url('industry/garment-textile-recruitment-india') ?>" class="hover:text-accent">Garment / Textile / Apparel</a>
                        <span>•</span><a href="<?= base_url('industry/it-recruitment-services-india') ?>" class="hover:text-accent">IT / Technology</a>
                        <span>•</span><a href="<?= base_url('industry/bfsi-leadership-hiring') ?>" class="hover:text-accent">BFSI / NBFC</a>
                        <span>•</span><a href="<?= base_url('industry/retail-executive-search') ?>" class="hover:text-accent">Retail</a>
                        <span>•</span><a href="<?= base_url('industry/pharma-life-sciences-recruitment-india') ?>" class="hover:text-accent">Pharma / Life Sciences</a>
                        <span>•</span><a href="<?= base_url('industry/global-capability-centres-hiring-india') ?>" class="hover:text-accent">GCC</a>
                        <span>•</span><a href="<?= base_url('industry/semiconductor-recruitment-india') ?>" class="hover:text-accent">Semiconductors</a>
                        <span>•</span><a href="<?= base_url('industry/engineering-recruitment-firm') ?>" class="hover:text-accent">Engineering</a>
                        <span>•</span><a href="<?= base_url('industry/manufacturing-talent-advisory') ?>" class="hover:text-accent">Manufacturing</a>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 mt-10 pt-8 text-center">
                <p class="text-[10px] font-bold text-white/70 uppercase tracking-[0.35em]">&copy; <?= esc(date('Y')) ?> HiredNext Recruitment. Precision in Every Placement.</p>
            </div>
        </div>
    </footer>

    <script>
        const navbar = document.getElementById('navbar');
        const logoText = document.getElementById('logoText');
        const navLinks = document.querySelectorAll('.nav-link');
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');
        let isOpen = false;

        const syncNavbar = () => {
            if (!navbar) return;
            const scrolled = window.scrollY > 80;
            navbar.classList.toggle('bg-transparent', !scrolled);
            navbar.classList.toggle('bg-white', scrolled);
            navbar.classList.toggle('shadow-premium', scrolled);
            navbar.classList.toggle('py-5', !scrolled);
            navbar.classList.toggle('py-4', scrolled);
            if (logoText) {
                logoText.classList.toggle('text-white', !scrolled);
                logoText.classList.toggle('text-primary', scrolled);
            }
            navLinks.forEach(link => {
                link.classList.toggle('text-white', !scrolled);
                link.classList.toggle('text-primary/70', scrolled);
            });
            if (menuBtn) {
                menuBtn.classList.toggle('text-white', !scrolled);
                menuBtn.classList.toggle('text-primary', scrolled);
            }
        };
        window.addEventListener('scroll', syncNavbar);
        syncNavbar();

        if (menuBtn && mobileMenu && menuIcon && closeIcon) {
            menuBtn.addEventListener('click', () => {
                isOpen = !isOpen;
                mobileMenu.classList.toggle('hidden', !isOpen);
                menuIcon.classList.toggle('hidden', isOpen);
                closeIcon.classList.toggle('hidden', !isOpen);
                document.body.classList.toggle('overflow-hidden', isOpen);
            });
            document.querySelectorAll('.mobile-link').forEach(link => link.addEventListener('click', () => {
                isOpen = false;
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }));
        }

        const observerOptions = { threshold: 0.1 };
        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible', 'reveal-visible');
                    scrollObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);
        document.querySelectorAll('.reveal').forEach(el => scrollObserver.observe(el));
    </script>
</body>
</html>