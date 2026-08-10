<?php
$pageTitle = $title ?? 'HiredNext | Executive Search & Leadership Recruitment Firm in India';

$metaDescription = $metaDescription
    ?? 'HiredNext is a talent advisory and recruitment firm in India specialising in executive search, leadership hiring, permanent recruitment and RPO solutions.';

$canonicalUrl = $canonical ?? current_url();

$ogTitle = $ogTitle ?? $pageTitle;
$ogDescription = $ogDescription ?? $metaDescription;
$ogUrl = $ogUrl ?? $canonicalUrl;
?>

<title><?= esc($pageTitle) ?></title>

<meta name="description" content="<?= esc($metaDescription) ?>">
<meta name="robots" content="index, follow, max-image-preview:large">

<link rel="canonical" href="<?= esc($canonicalUrl) ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="HiredNext">
<meta property="og:title" content="<?= esc($ogTitle) ?>">
<meta property="og:description" content="<?= esc($ogDescription) ?>">
<meta property="og:url" content="<?= esc($ogUrl) ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= esc($ogTitle) ?>">
<meta name="twitter:description" content="<?= esc($ogDescription) ?>">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title ?? ($settings['meta_title'] ?? (($settings['site_name'] ?? 'HiredNext') . ' | Shaping Careers, Powering Organizations'))) ?></title>
    <meta name="description" content="<?= esc($settings['meta_description'] ?? $settings['site_description'] ?? 'HiredNext is a global talent advisory and recruitment firm delivering high-impact leadership solutions.') ?>" />
    <meta name="keywords" content="<?= esc($settings['meta_keywords'] ?? $settings['site_keywords'] ?? 'HiredNext, talent advisory, recruitment') ?>" />
    <?php if (!empty($settings['company_website'])): ?>
        <link rel="canonical" href="<?= esc($settings['company_website']) ?>" />
    <?php endif; ?>

    <?php if (!empty($jsonLd) && is_string($jsonLd)): ?>
        <script type="application/ld+json"><?= $jsonLd ?></script>
    <?php endif; ?>

    <link rel="stylesheet" href="<?= base_url('theme/css/style.css') ?>" />
    <link rel="icon" href="<?= base_url('theme/assets/favicon.jpg') ?>" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0c3466',
                        accent: '#ff4e16',
                        gold: '#d4af37',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
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
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-3 focus:text-sm focus:font-bold focus:text-primary">
        Skip to main content
    </a>
    <!-- NAVBAR -->
    <nav id="navbar" aria-label="Primary" class="fixed w-full z-50 transition-all duration-300 bg-transparent py-5">

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <div class="flex justify-between items-center">

                <!-- LOGO -->
                <a href="<?= base_url() ?>" class="flex items-center">
                    <span id="logoText" class="text-3xl font-bold tracking-tighter text-white">
                        <?php if ($siteName === 'HiredNext'): ?>
                            HIRED<span class="text-accent">NEXT</span> RECRUITMENT
                        <?php else: ?>
                            <?= esc($siteName) ?>
                        <?php endif; ?>
                    </span>
                </a>

                <!-- DESKTOP NAV -->
                <div class="hidden md:flex space-x-10 items-center">
                    <a href="<?= base_url() ?>" class="nav-link text-sm font-semibold text-white">Home</a>
                    <a href="<?= base_url('about') ?>" class="nav-link text-sm font-semibold text-white">About</a>
                    <a href="<?= base_url('services') ?>" class="nav-link text-sm font-semibold text-white">Services</a>
                    <a href="<?= base_url('testimonials') ?>" class="nav-link text-sm font-semibold text-white">Testimonials</a>
                    <a href="<?= base_url('press-media') ?>" class="nav-link text-sm font-semibold text-white">Press & Media</a>
                    <a href="<?= base_url('blog') ?>" class="nav-link text-sm font-semibold text-white">Blog</a>
                    <a href="<?= base_url('jobs') ?>" class="nav-link text-sm font-semibold text-white">Jobs</a>

                    <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer"
                        class="bg-accent text-gray-900 px-8 py-2.5 rounded-full text-sm font-bold hover:bg-opacity-90 transition-all shadow-lg hover:shadow-accent/30">
                        Book a 30-Min Call
                    </a>
                </div>

                <!-- MOBILE MENU BUTTON -->
                <div class="md:hidden">
                    <button id="menuBtn" class="text-white">
                        <!-- MENU ICON -->
                        <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <line x1="3" y1="12" x2="21" y2="12" />
                            <line x1="3" y1="18" x2="21" y2="18" />
                        </svg>

                        <!-- CLOSE ICON -->
                        <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" class="hidden">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- MOBILE MENU -->
        <div id="mobileMenu"
            class="md:hidden hidden bg-white shadow-xl absolute top-full left-0 w-full p-6 animate-in slide-in-from-top duration-300">
            <div class="flex flex-col space-y-4">
                <a href="<?= base_url() ?>" class="mobile-link">Home</a>
                <a href="<?= base_url('services') ?>" class="mobile-link">Services</a>
                <a href="<?= base_url('testimonials') ?>" class="mobile-link">Testimonials</a>
                <a href="<?= base_url('press-media') ?>" class="mobile-link">Press & Media</a>
                <a href="<?= base_url('blog') ?>" class="mobile-link">Blog</a>
                <a href="<?= base_url('jobs') ?>" class="mobile-link">Jobs</a>
                <a href="<?= base_url('about') ?>" class="mobile-link">About</a>
                <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="bg-accent text-gray-900 px-6 py-3 rounded-xl text-center font-bold">
                    Book a 30-Min Call
                </a>
            </div>
        </div>
    </nav>

    <?php
    $maintenanceEnabled = isset($settings['maintenance_mode']) && filter_var($settings['maintenance_mode'], FILTER_VALIDATE_BOOLEAN);
    ?>
    <?php if ($maintenanceEnabled): ?>
        <div class="bg-accent text-gray-900 text-center text-xs font-bold uppercase tracking-widest py-3 px-4">
            Maintenance Mode Enabled — The site may be temporarily unavailable.
        </div>
    <?php endif; ?>

    <main id="main-content">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="py-24 bg-primary text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-80 h-80 bg-accent opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gold opacity-10 rounded-full blur-3xl"></div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">

                <!-- LOGO + DESC -->
                <div>
                    <h3 class="text-2xl font-bold mb-4">
                        <?php if ($siteName === 'HiredNext'): ?>
                            HIRED<span class="text-accent">NEXT</span> RECRUITMENT
                        <?php else: ?>
                            <?= esc($siteName) ?>
                        <?php endif; ?>
                    </h3>
                    <p class="text-white/70 leading-relaxed">
                        <?= esc($settings['site_tagline'] ?? 'A global talent advisory and recruitment firm delivering high-impact leadership solutions across sectors.') ?>
                    </p>
                </div>

                <!-- LINKS -->
                <div>
                    <h4 class="font-bold mb-6 uppercase tracking-widest text-sm">Company</h4>
                    <ul class="space-y-3 text-sm text-white/70">
                        <li><a href="<?= base_url() ?>" class="hover:text-accent transition-colors">Home</a></li>
                        <li><a href="<?= base_url('services') ?>" class="hover:text-accent transition-colors">Our Services</a></li>
                        <li><a href="<?= base_url('testimonials') ?>" class="hover:text-accent transition-colors">Testimonials</a></li>
                        <li><a href="<?= base_url('press-media') ?>" class="hover:text-accent transition-colors">Press & Media</a></li>
                        <li><a href="<?= base_url('blog') ?>" class="hover:text-accent transition-colors">Insights & Blog</a></li>
                        <li><a href="<?= base_url('jobs') ?>" class="hover:text-accent transition-colors">Jobs</a></li>
                    </ul>
                </div>

                <!-- CONTACT -->
                <div>
                    <h4 class="font-bold mb-6 uppercase tracking-widest text-sm">Contact</h4>
                    <?php
                    $phones = array_filter([
                        $settings['contact_phone'] ?? null,
                        $settings['contact_phone_2'] ?? null,
                        $settings['contact_phone_3'] ?? null,
                        $settings['contact_phone_4'] ?? null,
                    ]);
                    $emails = array_filter([
                        $settings['contact_email'] ?? null,
                        $settings['contact_email_2'] ?? null,
                        $settings['contact_email_3'] ?? null,
                        $settings['contact_email_4'] ?? null,
                    ]);
                    $addresses = array_filter([
                        $settings['company_address'] ?? null,
                        $settings['contact_address_2'] ?? null,
                        $settings['contact_address_3'] ?? null,
                    ]);
                    $hours = array_filter([
                        $settings['working_hours'] ?? null,
                        $settings['working_hours_2'] ?? null,
                        $settings['working_hours_3'] ?? null,
                    ]);
                    ?>
                    <div class="space-y-4 text-sm text-white/70">
                        <?php if (!empty($phones)): ?>
                            <div>
                                <p class="text-white/80 text-xs uppercase tracking-widest mb-2">Phone</p>
                                <ul class="space-y-1">
                                    <?php foreach ($phones as $phone): ?>
                                        <li><?= esc($phone) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($emails)): ?>
                            <div>
                                <p class="text-white/80 text-xs uppercase tracking-widest mb-2">Email</p>
                                <ul class="space-y-1">
                                    <?php foreach ($emails as $email): ?>
                                        <li><?= esc($email) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($addresses)): ?>
                            <div>
                                <p class="text-white/80 text-xs uppercase tracking-widest mb-2">Address</p>
                                <ul class="space-y-1">
                                    <?php foreach ($addresses as $address): ?>
                                        <li><?= esc($address) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($hours)): ?>
                            <div>
                                <p class="text-white/80 text-xs uppercase tracking-widest mb-2">Working Hours</p>
                                <ul class="space-y-1">
                                    <?php foreach ($hours as $hour): ?>
                                        <li><?= esc($hour) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CTA -->
                <div>
                    <h4 class="font-bold mb-6 uppercase tracking-widest text-sm">Let’s Talk</h4>
                    <p class="text-white/70 mb-4">Book a private consultation with our advisors.</p>
                    <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer"
                        class="inline-block bg-accent text-gray-900 px-6 py-3 rounded-xl font-bold hover:shadow-xl transition-all">
                        Book a 30-Min Call
                    </a>
                    <a href="<?= base_url('contact') ?>" class="inline-block ml-3 text-sm text-white/80 hover:text-white transition-colors">
                        Contact Us
                    </a>
                    <?php
                    $socialLinks = array_filter([
                        'Facebook' => $settings['social_facebook'] ?? null,
                        'Twitter' => $settings['social_twitter'] ?? null,
                        'LinkedIn' => $settings['social_linkedin'] ?? null,
                        'Instagram' => $settings['social_instagram'] ?? null,
                        'YouTube' => $settings['social_youtube'] ?? null,
                        'Website' => $settings['social_website'] ?? null,
                    ]);
                    ?>
                    <?php if (!empty($socialLinks)): ?>
                        <div class="mt-6">
                            <p class="text-white/80 text-xs uppercase tracking-widest mb-3">Social</p>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach ($socialLinks as $label => $url): ?>
                                    <a href="<?= esc($url) ?>" target="_blank" rel="noopener"
                                        class="w-9 h-9 rounded-full bg-white/10 hover:bg-accent transition-colors flex items-center justify-center text-[10px] font-bold uppercase">
                                        <?= esc(substr($label, 0, 2)) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SEO LINKS -->
            <div class="mt-16 border-t border-white/10 pt-12 grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h4 class="font-bold mb-4 uppercase tracking-widest text-sm">Executive Search in India</h4>
                    <p class="text-sm text-white/70 leading-relaxed mb-6">
                        Explore our leadership recruitment solutions across major hiring hubs and sector-focused retained search.
                    </p>
                    <div class="flex flex-wrap gap-3 text-sm text-white/70">
                        <a href="<?= base_url('services/executive-search') ?>" class="hover:text-accent transition-colors">Executive Search India</a>
                        <span class="text-white/20">•</span>
                        <a href="<?= base_url('contact') ?>?location=bangalore" class="hover:text-accent transition-colors">Leadership Hiring Bangalore</a>
                        <span class="text-white/20">•</span>
                        <a href="<?= base_url('contact') ?>?location=gurgaon" class="hover:text-accent transition-colors">CXO Recruitment Gurgaon</a>
                        <span class="text-white/20">•</span>
                        <a href="<?= base_url('services/permanent-hiring') ?>?location=mumbai" class="hover:text-accent transition-colors">Mid-Senior Talent Advisory Mumbai</a>
                        <span class="text-white/20">•</span>
                        <a href="<?= base_url() ?>#leadership-hiring" class="hover:text-accent transition-colors">GCC Talent Mapping India</a>
                        <span class="text-white/20">•</span>
                        <a href="<?= base_url('services/executive-search') ?>" class="hover:text-accent transition-colors">Retained Search Firm India</a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold mb-4 uppercase tracking-widest text-sm">Industry Expertise</h4>
                    <p class="text-sm text-white/70 leading-relaxed mb-6">
                        Sector-specific executive search pages for leadership hiring mandates.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-white/70">
                        <a href="<?= base_url('industry/it-recruitment-services-india') ?>" class="hover:text-accent transition-colors">IT Recruitment Services India</a>
                        <a href="<?= base_url('industry/bfsi-leadership-hiring') ?>" class="hover:text-accent transition-colors">BFSI Leadership Hiring</a>
                        <a href="<?= base_url('industry/retail-executive-search') ?>" class="hover:text-accent transition-colors">Retail Executive Search</a>
                        <a href="<?= base_url('industry/engineering-recruitment-firm') ?>" class="hover:text-accent transition-colors">Engineering Recruitment Firm</a>
                        <a href="<?= base_url('industry/manufacturing-talent-advisory') ?>" class="hover:text-accent transition-colors">Manufacturing Talent Advisory</a>
                    </div>
                </div>
            </div>

            <div class="mt-12 border-t border-white/10 pt-10">
                <h4 class="font-bold mb-4 uppercase tracking-widest text-sm">Regions We Support</h4>
                <div class="flex flex-wrap gap-3 text-sm text-white/70">
                    <a href="<?= base_url('regions/india') ?>" class="hover:text-accent transition-colors">India</a>
                    <span class="text-white/20">•</span>
                    <a href="<?= base_url('regions/middle-east') ?>" class="hover:text-accent transition-colors">Middle East</a>
                    <span class="text-white/20">•</span>
                    <a href="<?= base_url('regions/apac') ?>" class="hover:text-accent transition-colors">APAC</a>
                    <span class="text-white/20">•</span>
                    <a href="<?= base_url('regions/europe') ?>" class="hover:text-accent transition-colors">Europe</a>
                    <span class="text-white/20">•</span>
                    <a href="<?= base_url('regions/usa') ?>" class="hover:text-accent transition-colors">USA</a>
                    <span class="text-white/20">•</span>
                    <a href="<?= base_url('regions/expanding-horizons') ?>" class="hover:text-accent transition-colors">Expanding Horizons</a>
                </div>
            </div>

            <!-- COPYRIGHT -->
            <div class="border-t border-white/5 pt-12 text-center">
                <p class="text-[10px] font-bold text-white/70 uppercase tracking-[0.5em]">
                    &copy; 2016 HiredNext Talent Advisory. Precision in Every Placement.
                </p>
                <p class="mt-4 text-[10px] font-bold text-white/40 uppercase tracking-[0.3em]">
                    <a href="https://neptastic.in" target="_blank" rel="noopener" class="hover:text-accent transition-colors">
                        Designed by Neptastic.in
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <!-- ================= Global Scripts ================= -->
    <script>
        const navbar = document.getElementById('navbar');
        const logoText = document.getElementById('logoText');
        const navLinks = document.querySelectorAll('.nav-link');
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');

        let isOpen = false;

        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 80) {
                    navbar.classList.remove('bg-transparent', 'py-5');
                    navbar.classList.add('bg-white', 'shadow-premium', 'py-4');
                    if (logoText) {
                        logoText.classList.remove('text-white');
                        logoText.classList.add('text-primary');
                    }
                    navLinks.forEach(link => { link.classList.remove('text-white'); link.classList.add('text-primary/70'); });
                    if (menuBtn) {
                        menuBtn.classList.remove('text-white');
                        menuBtn.classList.add('text-primary');
                    }
                } else {
                    navbar.classList.add('bg-transparent', 'py-5');
                    navbar.classList.remove('bg-white', 'shadow-premium', 'py-4');
                    if (logoText) {
                        logoText.classList.add('text-white');
                        logoText.classList.remove('text-primary');
                    }
                    navLinks.forEach(link => { link.classList.add('text-white'); link.classList.remove('text-primary/70'); });
                    if (menuBtn) {
                        menuBtn.classList.add('text-white');
                        menuBtn.classList.remove('text-primary');
                    }
                }
            });
        }

        if (menuBtn && mobileMenu && menuIcon && closeIcon) {
            menuBtn.addEventListener('click', () => {
                isOpen = !isOpen;
                mobileMenu.classList.toggle('hidden', !isOpen);
                menuIcon.classList.toggle('hidden', isOpen);
                closeIcon.classList.toggle('hidden', !isOpen);
                document.body.classList.toggle('overflow-hidden', isOpen);
            });

            document.querySelectorAll('.mobile-link').forEach(link => {
                link.addEventListener('click', () => {
                    isOpen = false;
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            });
        }

        const yearEl = document.getElementById('year');
        if (yearEl) {
            yearEl.textContent = new Date().getFullYear();
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
