<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min'; ?>
<!-- ================= HERO SECTION ================= -->
    <section class="hero-home relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden text-white">

        <div class="hero-overlay"></div>
        <div class="hero-sheen"></div>
        <div class="hero-noise"></div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <!-- LEFT CONTENT -->
                <div class="reveal reveal-right">
                    <div
                        class="inline-flex items-center gap-3 px-5 py-2 bg-white/10 border border-white/15 rounded-full text-[11px] uppercase tracking-[0.35em] font-bold mb-8">
                        <span class="h-2 w-2 rounded-full bg-accent shadow-[0_0_12px_rgba(255,78,22,0.8)]"></span>
                        Leadership Recruitment
                    </div>

                    <h1 class="text-4xl md:text-6xl xl:text-7xl font-bold mb-8 leading-tight font-serif">
                        Leadership Hiring for Critical Roles
                        
                    </h1>

                    <p class="text-lg md:text-xl text-white/80 mb-10 max-w-2xl leading-relaxed">
                        Need to close a CXO, leadership or hard-to-fill role? HiredNext delivers industry-aligned executive search and mid-senior hiring across Textile & Apparel, Fashion & Lifestyle, IT, BFSI, Retail, Engineering and Manufacturing.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-5 mb-10">
                        <a href="<?= base_url('services') ?>"
                            class="bg-accent text-gray-900 px-10 py-4 rounded-2xl font-bold flex items-center justify-center hover:shadow-2xl hover:shadow-accent/40 hover:-translate-y-1 transition-all">
                            Explore Search Services
                            <span class="ml-2">›</span>
                        </a>

                        <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center px-10 py-4 rounded-2xl font-bold border border-white/30 bg-white/10 hover:bg-white/20 transition-all">
                            Have a Hiring Mandate? Book a Discussion
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 text-xs uppercase tracking-[0.3em] text-white/60">
                        <span class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-gold"></span> Experience: 10+ Years
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-accent"></span> Placements: 1500+
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-white"></span> Industries: 6 Core Sectors
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-accent"></span> Success Rate: 98%
                        </span>
                    </div>
                </div>

                <!-- RIGHT GLASS PANELS -->
                <div class="hidden lg:block relative reveal reveal-scale">
                    <div class="hero-panel rounded-[2.5rem] p-10 shadow-2xl border border-white/10">
                        <div class="flex items-center justify-between mb-10">
                            <div class="text-sm uppercase tracking-[0.35em] text-white/60">Talent Intelligence</div>
                            <div class="text-xs uppercase tracking-[0.3em] text-accent">Live</div>
                        </div>
                        <div class="text-6xl font-bold mb-4">98%</div>
                        <div class="text-white/70 text-lg leading-relaxed mb-8">
                            Candidate success rate across leadership search mandates.
                        </div>
                        <div class="grid grid-cols-2 gap-6 text-sm text-white/70">
                            <div class="space-y-2">
                                <div class="text-white/80 uppercase tracking-[0.25em] text-[10px]">Speed</div>
                                <div class="text-2xl font-bold text-white">21 days</div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-white/80 uppercase tracking-[0.25em] text-[10px]">Coverage</div>
                                <div class="text-2xl font-bold text-white">12 sectors</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="hero-card relative mt-8 bg-white text-primary p-8 rounded-[2rem] shadow-2xl border border-white/80">
                        <div class="text-xs uppercase tracking-[0.3em] text-gray-600 mb-3">Featured</div>
                        <div class="text-3xl font-bold mb-2">1500+</div>
                        <div class="text-sm text-gray-500 uppercase font-extrabold tracking-widest">
                            Leadership Placements
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ================= HOW WE CAN HELP ================= -->
    <section class="py-32 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">

            <!-- Heading -->
            <div class="text-center max-w-4xl mx-auto mb-24 reveal reveal-up">
                <h2 class="text-4xl md:text-5xl font-bold text-primary mb-8 font-serif">
                    Executive Search India
                </h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Retained executive search for leadership roles, built for speed, confidentiality, and long-term fit.
                    We combine sector-aligned research with disciplined assessment to deliver shortlists that close.
                </p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

                <!-- CARD 1 -->
                <div
                    class="group p-10 bg-gray-50 rounded-3xl border-2 border-transparent hover:border-accent hover:scale-[1.03] hover:bg-white hover:shadow-2xl transition-all duration-500 cursor-default h-full reveal reveal-up">
                    <div class="mb-8 text-accent group-hover:scale-110 transition-transform inline-block">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <rect x="2" y="7" width="20" height="14" rx="2" />
                            <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-primary mb-5 leading-tight">
                        Executive Search
                    </h3>
                    <p class="text-gray-600 text-base leading-relaxed mb-8">
                        Strategic leadership hiring for CXO and senior management roles across
                        industries.
                    </p>
                    <a href="<?= base_url('services/executive-search') ?>"
                        class="text-accent font-bold text-sm flex items-center group-hover:translate-x-2 transition-transform mt-auto">
                        Learn More <span class="ml-2">→</span>
                    </a>
                </div>

                <!-- CARD 2 -->
                <div
                    class="group p-10 bg-gray-50 rounded-3xl border-2 border-transparent hover:border-accent hover:scale-[1.03] hover:bg-white hover:shadow-2xl transition-all duration-500 cursor-default h-full reveal reveal-up">
                    <div class="mb-8 text-accent group-hover:scale-110 transition-transform inline-block">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M3 21h18" />
                            <path d="M5 21V7l8-4 8 4v14" />
                            <path d="M9 9v.01" />
                            <path d="M15 9v.01" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-primary mb-5 leading-tight">
                        Permanent Hiring
                    </h3>
                    <p class="text-gray-600 text-base leading-relaxed mb-8">
                        Reliable recruitment solutions for mid to senior-level professionals
                        aligned with long-term goals.
                    </p>
                    <a href="<?= base_url('services/permanent-hiring') ?>"
                        class="text-accent font-bold text-sm flex items-center group-hover:translate-x-2 transition-transform mt-auto">
                        Learn More <span class="ml-2">→</span>
                    </a>
                </div>

                <!-- CARD 3 -->
                <div
                    class="group p-10 bg-gray-50 rounded-3xl border-2 border-transparent hover:border-accent hover:scale-[1.03] hover:bg-white hover:shadow-2xl transition-all duration-500 cursor-default h-full reveal reveal-up">
                    <div class="mb-8 text-accent group-hover:scale-110 transition-transform inline-block">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M3 10h18" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-primary mb-5 leading-tight">
                        RPO Solutions
                    </h3>
                    <p class="text-gray-600 text-base leading-relaxed mb-8">
                        Scalable recruitment process outsourcing to improve speed, quality,
                        and hiring efficiency.
                    </p>
                    <a href="<?= base_url('services/rpo') ?>"
                        class="text-accent font-bold text-sm flex items-center group-hover:translate-x-2 transition-transform mt-auto">
                        Learn More <span class="ml-2">→</span>
                    </a>
                </div>

                <!-- CARD 4 -->
                <div
                    class="group p-10 bg-gray-50 rounded-3xl border-2 border-transparent hover:border-accent hover:scale-[1.03] hover:bg-white hover:shadow-2xl transition-all duration-500 cursor-default h-full reveal reveal-up">
                    <div class="mb-8 text-accent group-hover:scale-110 transition-transform inline-block">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M12 3v18" />
                            <path d="M3 12h18" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-primary mb-5 leading-tight">
                        Career Advisory
                    </h3>
                    <p class="text-gray-600 text-base leading-relaxed mb-8">
                        Personalized career strategy and guidance for professionals navigating
                        leadership growth.
                    </p>
                    <a href="<?= base_url('services/avron') ?>"
                        class="text-accent font-bold text-sm flex items-center group-hover:translate-x-2 transition-transform mt-auto">
                        Learn More <span class="ml-2">→</span>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= LEADERSHIP HIRING ================= -->
    <section id="leadership-hiring" class="py-32 bg-primary text-white relative overflow-hidden">

        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-5 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg">
                <circle cx="200" cy="200" r="100" fill="white" />
                <circle cx="600" cy="150" r="80" fill="white" />
                <circle cx="400" cy="300" r="120" fill="white" />
            </svg>
        </div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-16 items-center">

                <!-- LEFT CONTENT -->
                <div class="lg:col-span-2 reveal reveal-right">
                    <span
                        class="inline-block px-4 py-1 bg-gold text-primary font-bold text-xs uppercase tracking-widest rounded-full mb-6">
                        CXO / Mid-Senior
                    </span>

                    <h2 class="text-4xl md:text-5xl font-bold mb-8 font-serif leading-tight">
                        Leadership Hiring (CXO &amp; Mid-Senior)
                    </h2>

                    <p class="text-xl text-gray-300 leading-relaxed mb-10">
                        Leadership hiring across India’s major talent hubs, with GCC and global search support where needed.
                        Built for confidential replacements, growth hires, and new capability builds.
                    </p>

                    <div class="flex items-center space-x-4">
                        <div class="h-1 w-20 bg-accent"></div>
                        <span class="text-gold font-bold tracking-widest uppercase text-sm">
                            Expanding Horizons
                        </span>
                    </div>
                </div>

                <!-- RIGHT GRID -->
                <div class="lg:col-span-3">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">

                        <!-- Location 1 -->
                        <a href="<?= base_url('regions/india') ?>"
                            class="group p-6 bg-white/5 border border-white/10 rounded-2xl hover:bg-accent hover:border-accent transition-all duration-300 reveal reveal-scale">
                            <div class="text-gold group-hover:text-white mb-4">
                                <!-- Globe icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M2 12h20" />
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                </svg>
                            </div>
                            <span class="text-white text-lg font-bold block">India</span>
                        </a>

                        <!-- Location 2 -->
                        <a href="<?= base_url('regions/middle-east') ?>"
                            class="group p-6 bg-white/5 border border-white/10 rounded-2xl hover:bg-accent hover:border-accent transition-all duration-300 reveal reveal-scale">
                            <div class="text-gold group-hover:text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M2 12h20" />
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                </svg>
                            </div>
                            <span class="text-white text-lg font-bold block">Middle East</span>
                        </a>

                        <!-- Location 3 -->
                        <a href="<?= base_url('regions/apac') ?>"
                            class="group p-6 bg-white/5 border border-white/10 rounded-2xl hover:bg-accent hover:border-accent transition-all duration-300 reveal reveal-scale">
                            <div class="text-gold group-hover:text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M2 12h20" />
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                </svg>
                            </div>
                            <span class="text-white text-lg font-bold block">APAC</span>
                        </a>

                        <!-- Location 4 -->
                        <a href="<?= base_url('regions/europe') ?>"
                            class="group p-6 bg-white/5 border border-white/10 rounded-2xl hover:bg-accent hover:border-accent transition-all duration-300 reveal reveal-scale">
                            <div class="text-gold group-hover:text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M2 12h20" />
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                </svg>
                            </div>
                            <span class="text-white text-lg font-bold block">Europe</span>
                        </a>

                        <!-- Location 5 -->
                        <a href="<?= base_url('regions/usa') ?>"
                            class="group p-6 bg-white/5 border border-white/10 rounded-2xl hover:bg-accent hover:border-accent transition-all duration-300 reveal reveal-scale">
                            <div class="text-gold group-hover:text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M2 12h20" />
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                </svg>
                            </div>
                            <span class="text-white text-lg font-bold block">USA</span>
                        </a>

                        <!-- Growing -->
                        <a href="<?= base_url('regions/expanding-horizons') ?>"
                            class="p-6 bg-gold/10 border border-gold/20 rounded-2xl flex flex-col justify-center h-full reveal reveal-scale">
                            <span class="text-gold text-sm font-black uppercase tracking-tighter">
                                And Growing...
                            </span>
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= INDUSTRY EXPERTISE ================= -->
    <section id="industry-expertise" class="py-32 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-8 reveal reveal-up">
                <div class="max-w-2xl">
                    <span class="text-accent font-extrabold uppercase tracking-[0.3em] text-xs mb-4 block">
                        Specializations
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold text-primary font-serif">
                        Industry Expertise – Specialized Recruitment Solutions by Sector
                    </h2>
                </div>
                <p class="text-gray-500 max-w-sm text-lg">
                    Six sector-focused practices, built for leadership hiring and executive search in India.
                </p>
            </div>

            <!-- Domains Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- DOMAIN 1: FASHION & APPAREL -->
                <a href="<?= base_url('industry/garment-textile-recruitment-india') ?>"
                    class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-2xl border border-gray-100 hover:border-accent/20 transition-all duration-500 h-full reveal reveal-up">
                    <div
                        class="w-16 h-16 bg-white shadow-sm rounded-2xl flex items-center justify-center text-accent mb-6 group-hover:scale-110 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M8 3l4 2 4-2 5 4-3 4-2-1v11H8V10l-2 1-3-4 5-4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3 leading-tight">
                        Textile, Apparel, Fashion & Lifestyle Recruitment
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Leadership and specialist hiring for export houses, buying houses, apparel manufacturing, fashion retail and lifestyle brands.
                    </p>
                    <span class="inline-flex items-center text-accent font-bold">
                        Learn More <span class="ml-2">→</span>
                    </span>
                </a>

                <!-- DOMAIN 2 -->
                <a href="<?= base_url('industry/it-recruitment-services-india') ?>"
                    class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-2xl border border-gray-100 hover:border-accent/20 transition-all duration-500 h-full reveal reveal-up">
                    <div
                        class="w-16 h-16 bg-white shadow-sm rounded-2xl flex items-center justify-center text-accent mb-6 group-hover:scale-110 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        <!-- CPU -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <rect x="4" y="4" width="16" height="16" rx="2" />
                            <path d="M9 1v3M15 1v3M9 20v3M15 20v3M1 9h3M1 15h3M20 9h3M20 15h3" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3 leading-tight">
                        IT Recruitment Services India
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Senior tech leadership and niche engineering hires, mapped to product and platform priorities.
                    </p>
                    <span class="inline-flex items-center text-accent font-bold">
                        Learn More <span class="ml-2">→</span>
                    </span>
                </a>

                <!-- DOMAIN 2 -->
                <a href="<?= base_url('industry/bfsi-leadership-hiring') ?>"
                    class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-2xl border border-gray-100 hover:border-accent/20 transition-all duration-500 h-full reveal reveal-up">
                    <div
                        class="w-16 h-16 bg-white shadow-sm rounded-2xl flex items-center justify-center text-accent mb-6 group-hover:scale-110 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        <!-- Building -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M9 9h.01M15 9h.01M9 15h.01M15 15h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3 leading-tight">
                        BFSI Leadership Hiring
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Risk-aware leadership searches for banks, NBFCs, fintech, and insurance growth mandates.
                    </p>
                    <span class="inline-flex items-center text-accent font-bold">
                        Learn More <span class="ml-2">→</span>
                    </span>
                </a>

                <!-- DOMAIN 3 -->
                <a href="<?= base_url('industry/retail-executive-search') ?>"
                    class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-2xl border border-gray-100 hover:border-accent/20 transition-all duration-500 h-full reveal reveal-up">
                    <div
                        class="w-16 h-16 bg-white shadow-sm rounded-2xl flex items-center justify-center text-accent mb-6 group-hover:scale-110 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        <!-- Shopping -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M6 2l1.5 4h9L18 2" />
                            <path d="M3 6h18l-2 14H5L3 6z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3 leading-tight">
                        Retail Executive Search
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Commercial and category leadership hiring for omnichannel, marketplace, and brand-led retail.
                    </p>
                    <span class="inline-flex items-center text-accent font-bold">
                        Learn More <span class="ml-2">→</span>
                    </span>
                </a>

                <!-- DOMAIN 4 -->
                <a href="<?= base_url('industry/manufacturing-talent-advisory') ?>"
                    class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-2xl border border-gray-100 hover:border-accent/20 transition-all duration-500 h-full reveal reveal-up">
                    <div
                        class="w-16 h-16 bg-white shadow-sm rounded-2xl flex items-center justify-center text-accent mb-6 group-hover:scale-110 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        <!-- Shirt -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M4 4l4-2 4 2 4 2 4 2v6l-4-2v12H8V8L4 10z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3 leading-tight">
                        Manufacturing Talent Advisory
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Leadership advisory and retained hiring for capacity expansion, productivity, and compliance.
                    </p>
                    <span class="inline-flex items-center text-accent font-bold">
                        Learn More <span class="ml-2">→</span>
                    </span>
                </a>

                <!-- DOMAIN 5 -->
                <a href="<?= base_url('industry/engineering-recruitment-firm') ?>"
                    class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-2xl border border-gray-100 hover:border-accent/20 transition-all duration-500 h-full reveal reveal-up">
                    <div
                        class="w-16 h-16 bg-white shadow-sm rounded-2xl flex items-center justify-center text-accent mb-6 group-hover:scale-110 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        <!-- Gear (Engineering) -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3 leading-tight">
                        Engineering Recruitment Firm
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Plant, project, and engineering leadership searches across design, QA, and operations.
                    </p>
                    <span class="inline-flex items-center text-accent font-bold">
                        Learn More <span class="ml-2">→</span>
                    </span>
                </a>

            </div>
        </div>
    </section>



    <!-- ================= ABOUT US ================= -->
    <section id="about" class="py-32 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">

                <!-- LEFT CONTENT -->
                <div class="reveal reveal-right">
                    <h2 class="text-4xl md:text-5xl font-bold text-primary mb-8 font-serif">
                        About Us
                    </h2>

                    <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                        With over 10+ years of recruitment excellence, HiredNext has established
                        itself as a trusted talent partner for organizations seeking
                        leadership-driven growth and workforce transformation.
                    </p>

                    <div class="space-y-8">

                        <!-- Vision -->
                        <div
                            class="flex items-start p-8 bg-white rounded-2xl shadow-sm border-l-8 border-accent reveal reveal-up">
                            <div class="bg-accent/10 p-3 rounded-xl text-accent mr-6">
                                <!-- Target Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10" />
                                    <circle cx="12" cy="12" r="4" />
                                    <line x1="22" y1="12" x2="18" y2="12" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-primary mb-2">
                                    Our Vision
                                </h3>
                                <p class="text-base text-gray-600">
                                    To be recognized as a globally respected recruitment and talent
                                    advisory firm known for insight-driven hiring, integrity, and
                                    consistent results.
                                </p>
                            </div>
                        </div>

                        <!-- Mission -->
                        <div
                            class="flex items-start p-8 bg-white rounded-2xl shadow-sm border-l-8 border-gold reveal reveal-up">
                            <div class="bg-gold/10 p-3 rounded-xl text-gold mr-6">
                                <!-- Zap Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-primary mb-2">
                                    Our Mission
                                </h3>
                                <p class="text-base text-gray-600">
                                    To enable organizations and professionals to achieve long-term
                                    success by delivering talent solutions that balance capability,
                                    culture, and future potential.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT STATS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">

                    <!-- Stat 1 -->
                    <div
                        class="bg-primary p-12 rounded-[2.5rem] text-center flex flex-col items-center justify-center transform hover:scale-105 transition-all shadow-xl h-full reveal reveal-left">
                        <div class="text-5xl font-bold text-gold mb-3">10+</div>
                        <div class="text-white/70 text-sm font-bold uppercase tracking-[0.2em]">
                            Years Experience
                        </div>
                    </div>

                    <!-- Stat 2 -->
                    <div
                        class="bg-primary p-12 rounded-[2.5rem] text-center flex flex-col items-center justify-center transform hover:scale-105 transition-all shadow-xl h-full reveal reveal-left">
                        <div class="text-5xl font-bold text-gold mb-3">1500+</div>
                        <div class="text-white/70 text-sm font-bold uppercase tracking-[0.2em]">
                            Leadership Placements
                        </div>
                    </div>

                    <!-- Stat 3 -->
                    <div
                        class="bg-primary p-12 rounded-[2.5rem] text-center flex flex-col items-center justify-center transform hover:scale-105 transition-all shadow-xl h-full reveal reveal-left">
                        <div class="text-5xl font-bold text-gold mb-3">25+</div>
                        <div class="text-white/70 text-sm font-bold uppercase tracking-[0.2em]">
                            Industries Served
                        </div>
                    </div>

                    <!-- Success Card -->
                    <div
                        class="bg-accent p-12 rounded-[2.5rem] text-center flex flex-col items-center justify-center text-white shadow-2xl shadow-accent/30 h-full reveal reveal-left">
                        <!-- Check Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="mb-4">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                        <div class="text-2xl font-bold uppercase tracking-widest mb-1">
                            Success
                        </div>
                        <div class="text-white/80 text-sm font-medium">
                            Guaranteed Focus
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ================= OUR PROCESS ================= -->
    <section class="py-32 bg-white relative overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent">
        </div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">

            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-20 reveal reveal-up">
                <span class="text-accent font-extrabold uppercase tracking-[0.3em] text-xs mb-4 block">
                    How We Work
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-primary font-serif mb-6">
                    Our Process
                </h2>
                <p class="text-gray-500 text-lg">
                    A seamless, insight-driven approach to connecting world-class talent with industry-leading
                    organizations.
                </p>
            </div>

            <!-- Process Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

                <!-- Step 1: Industry Aligned Recruiters -->
                <div class="group text-center reveal reveal-up" style="animation-delay: 0ms;">
                    <div class="relative w-20 h-20 mx-auto mb-8">
                        <div
                            class="absolute inset-0 bg-primary/5 rounded-full scale-0 group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div
                            class="relative w-full h-full flex items-center justify-center text-primary group-hover:text-accent transition-colors duration-300">
                            <!-- User Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Industry Aligned Recruiters</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Our recruiters are specialists in their sectors, bringing deep domain expertise to understand
                        your unique hiring needs and candidate requirements.
                    </p>
                </div>

                <!-- Step 2: End to End Solutions -->
                <div class="group text-center reveal reveal-up" style="animation-delay: 100ms;">
                    <div class="relative w-20 h-20 mx-auto mb-8">
                        <div
                            class="absolute inset-0 bg-primary/5 rounded-full scale-0 group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div
                            class="relative w-full h-full flex items-center justify-center text-primary group-hover:text-accent transition-colors duration-300">
                            <!-- Layers/Stack Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">End to End Solutions</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        From role analysis to onboarding support, we manage the complete recruitment lifecycle with
                        precision and professionalism.
                    </p>
                </div>

                <!-- Step 3: Global Talent Reach -->
                <div class="group text-center reveal reveal-up" style="animation-delay: 200ms;">
                    <div class="relative w-20 h-20 mx-auto mb-8">
                        <div
                            class="absolute inset-0 bg-primary/5 rounded-full scale-0 group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div
                            class="relative w-full h-full flex items-center justify-center text-primary group-hover:text-accent transition-colors duration-300">
                            <!-- Globe Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path
                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Global Talent Reach</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Access top talent across borders through our extensive network and presence in multiple
                        countries for niche and specialized roles.
                    </p>
                </div>

                <!-- Step 4: Culture First Hiring -->
                <div class="group text-center reveal reveal-up" style="animation-delay: 300ms;">
                    <div class="relative w-20 h-20 mx-auto mb-8">
                        <div
                            class="absolute inset-0 bg-primary/5 rounded-full scale-0 group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div
                            class="relative w-full h-full flex items-center justify-center text-primary group-hover:text-accent transition-colors duration-300">
                            <!-- Heart/Handshake Icon (Culture) -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Culture First Hiring</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Beyond skills matching, we ensure candidates align with your company's values and culture for
                        long term success and retention.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= JOBS SECTION ================= -->
    <section class="py-32 bg-white relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-accent/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 -left-20 w-80 h-80 bg-primary/5 rounded-full blur-3xl"></div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
            <div class="flex flex-col lg:flex-row items-start lg:items-end justify-between gap-10 mb-16 reveal reveal-up">
                <div>
                    <span class="text-accent font-extrabold uppercase tracking-[0.3em] text-xs mb-4 block">
                        Careers
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold text-primary font-serif mb-4">
                        Open Roles at HiredNext
                    </h2>
                    <p class="text-gray-500 text-lg max-w-2xl">
                        Explore opportunities to shape leadership teams and build the future of talent.
                    </p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="<?= base_url('jobs') ?>"
                        class="inline-flex items-center px-8 py-4 bg-primary text-white rounded-full font-bold hover:bg-accent transition-all shadow-lg">
                        View All Jobs
                        <span class="ml-3">→</span>
                    </a>
                    <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center px-8 py-4 border border-primary text-primary rounded-full font-bold hover:bg-primary hover:text-white transition-all">
                        Have a Hiring Mandate? Book a Discussion
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php
                $homeJobs = $jobs ?? [];
                $homeJobs = array_slice($homeJobs, 0, 3);
                ?>
                <?php if (!empty($homeJobs)): ?>
                    <?php foreach ($homeJobs as $job): ?>
                        <div class="bg-gray-50 border border-gray-100 rounded-[2.5rem] p-10 shadow-sm hover:shadow-2xl transition-all reveal reveal-up">
                            <div class="flex items-center justify-between mb-5">
                                <span class="text-xs font-bold uppercase tracking-widest text-accent">
                                    <?= esc(ucwords(str_replace('-', ' ', $job['type'] ?? 'full-time'))) ?>
                                </span>
                                <span class="text-xs font-bold text-gray-400">
                                    <?= esc($job['location'] ?? '') ?>
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-primary mb-4">
                                <?= esc($job['title'] ?? '') ?>
                            </h3>
                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 uppercase tracking-widest mb-4">
                                <span>Posted <?= !empty($job['created_at']) ? esc(date('M d, Y', strtotime($job['created_at']))) : '' ?></span>
                                <?php if (!empty($job['experience'])): ?>
                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-300"></span>
                                    <span><?= esc($job['experience']) ?> Experience</span>
                                <?php endif; ?>
                            </div>
                            <div class="prose prose-sm max-w-none text-gray-600 mb-6 line-clamp-4 job-richtext">
                                <?= $job['description'] ?? '' ?>
                            </div>
                            <a href="<?= base_url('jobs/' . ($job['slug'] ?? '')) ?>"
                                class="inline-flex items-center text-sm font-bold text-primary hover:text-accent transition-colors">
                                View Role <span class="ml-2">→</span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full text-center text-gray-500">
                        New roles will appear here soon. Check back for updates.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>


    <!-- ================= TESTIMONIALS SECTION ================= -->
    <section class="py-32 bg-primary text-white overflow-hidden relative">

        <!-- Background Glow -->
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-accent opacity-5 rounded-full blur-[100px] -mr-48 -mt-48">
        </div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">

            <!-- Header -->
            <div class="text-center mb-20 reveal reveal-up">
                <span class="text-gold font-black uppercase tracking-[0.3em] text-[10px] mb-4 block">
                    Proven Partnerships
                </span>
                <h2 class="text-3xl md:text-5xl font-bold mb-5 font-serif">
                    What Clients & Hiring Leaders Say
                </h2>
                <p class="text-gray-300 max-w-2xl mx-auto text-base md:text-lg">
                    Employer-side feedback stays separate from the stories shared by
                    candidates HiredNext has placed.
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-24">
                <?php
                $homeTestimonials = $testimonials ?? [];
                $homeTestimonials = array_values(array_filter($homeTestimonials, static function (array $item): bool {
                    $relationship = trim((string)($item['relationship_type'] ?? ''));
                    $submittedVia = trim((string)($item['submitted_via'] ?? ''));
                    $proofType = mb_strtolower(trim((string)($item['proof_type'] ?? $item['project_type'] ?? '')));
                    if (in_array($relationship, ['placed_candidate', 'candidate_professional'], true)) {
                        return false;
                    }
                    if (str_contains($submittedVia, 'candidate_')) {
                        return false;
                    }
                    if (str_contains($proofType, 'candidate') || str_contains($proofType, 'career')) {
                        return false;
                    }
                    if (($item['status'] ?? '') === 'external' && $relationship === '') {
                        $explicitEmployerTypes = [
                            'employer recruitment experience',
                            'employer recruitment delivery',
                            'apparel & textile recruitment',
                            'talent evaluation',
                            'recruitment experience',
                        ];
                        return in_array($proofType, $explicitEmployerTypes, true);
                    }
                    return true;
                }));
                $homeTestimonials = array_slice($homeTestimonials, 0, 3);
                ?>
                <?php if (!empty($homeTestimonials)): ?>
                    <?php foreach ($homeTestimonials as $index => $item): ?>
                        <?php
                        $rating = (int)($item['rating'] ?? 5);
                        $quote = $item['review'] ?? $item['comment'] ?? $item['content'] ?? $item['testimonial'] ?? $item['message'] ?? '';
                        $name = $item['name'] ?? 'Client';
                        $role = $item['designation'] ?? $item['role'] ?? $item['title'] ?? $item['location'] ?? '';
                        $company = $item['company'] ?? $item['organization'] ?? $item['project_type'] ?? '';
                        $image = $item['image'] ?? $item['avatar'] ?? 'https://i.pravatar.cc/150?img=' . (11 + $index);
                        ?>
                        <div
                            class="bg-white/5 border border-white/10 p-10 rounded-[3.5rem] hover:bg-white/10 transition-all group flex flex-col h-full relative overflow-hidden reveal reveal-up">
                            <div class="absolute top-12 right-12 text-white/5 group-hover:text-accent/10 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path d="M3 21c3 0 6-3 6-6V9H3v6h4c0 2-2 4-4 4v2z" />
                                    <path d="M15 21c3 0 6-3 6-6V9h-6v6h4c0 2-2 4-4 4v2z" />
                                </svg>
                            </div>

                            <?php if ($rating > 0): ?>
                                <div class="flex gap-1 mb-8 text-gold">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?= $i <= $rating ? '★' : '☆' ?>
                                    <?php endfor; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-[10px] uppercase tracking-[0.22em] text-gold font-black mb-8">Employer recommendation</div>
                            <?php endif; ?>

                            <p class="text-lg md:text-xl font-serif text-gray-200 italic leading-relaxed mb-10 flex-grow">
                                “<?= esc($quote) ?>”
                            </p>

                            <div class="flex items-center pt-8 border-t border-white/10">
                                <div
                                    class="w-16 h-16 rounded-[1.5rem] mr-5 bg-white/10 border-2 border-white/10 flex items-center justify-center text-white font-bold text-lg">
                                    <?= esc(strtoupper(substr($name, 0, 1))) ?>
                                </div>
                                <div>
                                    <div class="font-bold text-white text-lg leading-tight">
                                        <?= esc($name) ?>
                                    </div>
                                    <div class="text-gray-400 text-sm mt-1">
                                        <?= esc($role) ?><?= $company ? ', ' : '' ?><span class="text-accent"><?= esc($company) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-white/5 border border-white/10 p-12 rounded-[3.5rem] text-center text-white/70 col-span-full">
                        Testimonials will appear here once available.
                    </div>
                <?php endif; ?>
            </div>

<!-- CTA -->
            <div class="text-center reveal reveal-up flex flex-wrap justify-center gap-4">
                <a href="<?= base_url('testimonials') ?>"
                    class="group inline-flex items-center px-10 py-5 bg-white text-primary rounded-2xl font-black text-xs uppercase tracking-[0.3em] hover:bg-accent hover:text-white transition-all shadow-xl shadow-primary/20">
                    Client Testimonials
                    <span class="ml-3 group-hover:translate-x-2 transition-transform">→</span>
                </a>
                <a href="<?= base_url('testimonials#placed-candidate-stories') ?>"
                    class="group inline-flex items-center px-10 py-5 border border-white/20 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:border-gold hover:text-gold transition-all">
                    Placed Candidate Stories
                    <span class="ml-3 group-hover:translate-x-2 transition-transform">→</span>
                </a>
            </div>

        </div>
    </section>

    <!-- ================= PRESS & MEDIA PREVIEW ================= -->
    <section class="py-32 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-14">
                <div class="reveal reveal-up">
                    <span class="inline-block px-4 py-2 rounded-full bg-accent/10 text-accent text-[10px] font-black uppercase tracking-[0.3em] mb-5">
                        In The Media
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold text-primary font-serif mb-4">
                        Press & Media
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl">
                        Recent stories and media mentions featuring HiredNext.
                    </p>
                </div>
                <div class="reveal reveal-up">
                    <a href="<?= base_url('press-media') ?>"
                        class="inline-flex items-center px-8 py-4 bg-primary text-white rounded-2xl font-black text-xs uppercase tracking-[0.25em] hover:bg-accent transition-all">
                        View All Press & Media
                        <span class="ml-3">→</span>
                    </a>
                </div>
            </div>

            <?php
            $homePressItems = $press_media_items ?? [];
            $homePressItems = array_slice($homePressItems, 0, 3);
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if (!empty($homePressItems)): ?>
                    <?php foreach ($homePressItems as $item): ?>
                        <article class="bg-gray-50 border border-gray-100 rounded-[2rem] overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 reveal reveal-up">
                            <?php if (!empty($item['image_url'])): ?>
                                <a href="<?= esc($item['media_link']) ?>" target="_blank" rel="noopener noreferrer" class="block">
                                    <div class="aspect-[16/10] bg-gray-100 p-4 flex items-center justify-center border-b border-gray-100">
                                        <img
                                            src="<?= esc($item['image_url']) ?>"
                                            alt="Press coverage"
                                            loading="lazy"
                                            class="max-w-full max-h-full object-contain transition-transform duration-500 hover:scale-[1.02]"
                                            onerror="this.style.display='none'; this.parentElement.classList.add('hidden');"
                                        />
                                    </div>
                                </a>
                            <?php endif; ?>
                            <div class="p-6">
                                <p class="text-gray-600 text-sm leading-relaxed mb-6">
                                    <?= esc($item['description'] ?? '') ?>
                                </p>
                                <a href="<?= esc($item['media_link']) ?>" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center text-primary font-black text-[10px] uppercase tracking-[0.2em] hover:text-accent transition-colors">
                                    Open Story
                                    <span class="ml-3">→</span>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-gray-50 border border-gray-100 rounded-[2rem] p-10 text-center text-gray-500 col-span-full">
                        Press & Media updates will appear here soon.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ================= FAQ SECTION ================= -->
    <section class="py-32 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <div class="max-w-4xl mx-auto">

                <!-- Heading -->
                <div class="reveal reveal-up">
                    <h2 class="text-4xl font-bold text-primary mb-16 text-center font-serif">
                        Frequently Asked Questions
                    </h2>
                </div>

                <!-- FAQ LIST -->
                <div class="space-y-6">

                    <!-- FAQ ITEM 1 -->
                    <div class="border border-gray-200 rounded-[1.5rem] overflow-hidden reveal reveal-up">
                        <button
                            class="faq-btn w-full flex justify-between items-center p-8 text-left hover:bg-gray-50 transition-colors">
                            <span class="text-xl font-bold text-primary">
                                Do you provide IT recruitment services in India?
                            </span>
                            <span class="faq-icon text-accent transition-transform duration-500 text-2xl">+</span>
                        </button>
                        <div class="faq-content px-8 pb-8 text-lg text-gray-600 leading-relaxed hidden">
                            Yes. We support IT recruitment in India for mid-senior and leadership roles across product,
                            engineering, data, security, and platform functions.
                        </div>
                    </div>

                    <!-- FAQ ITEM 2 -->
                    <div class="border border-gray-200 rounded-[1.5rem] overflow-hidden reveal reveal-up">
                        <button
                            class="faq-btn w-full flex justify-between items-center p-8 text-left hover:bg-gray-50 transition-colors">
                            <span class="text-xl font-bold text-primary">
                                Do you offer executive search for BFSI roles?
                            </span>
                            <span class="faq-icon text-accent transition-transform duration-500 text-2xl">+</span>
                        </button>
                        <div class="faq-content px-8 pb-8 text-lg text-gray-600 leading-relaxed hidden">
                            Yes. We run confidential executive searches for BFSI leadership roles across banking, NBFC,
                            fintech, and insurance mandates.
                        </div>
                    </div>

                    <!-- FAQ ITEM 3 -->
                    <div class="border border-gray-200 rounded-[1.5rem] overflow-hidden reveal reveal-up">
                        <button
                            class="faq-btn w-full flex justify-between items-center p-8 text-left hover:bg-gray-50 transition-colors">
                            <span class="text-xl font-bold text-primary">
                                How do you find senior retail leaders?
                            </span>
                            <span class="faq-icon text-accent transition-transform duration-500 text-2xl">+</span>
                        </button>
                        <div class="faq-content px-8 pb-8 text-lg text-gray-600 leading-relaxed hidden">
                            We use competitor mapping, performance-based shortlisting, and structured interviews to identify
                            leaders with proven P&amp;L and omnichannel execution.
                        </div>
                    </div>

                    <!-- FAQ ITEM 4 -->
                    <div class="border border-gray-200 rounded-[1.5rem] overflow-hidden reveal reveal-up">
                        <button
                            class="faq-btn w-full flex justify-between items-center p-8 text-left hover:bg-gray-50 transition-colors">
                            <span class="text-xl font-bold text-primary">
                                What engineering leadership roles do you specialize in?
                            </span>
                            <span class="faq-icon text-accent transition-transform duration-500 text-2xl">+</span>
                        </button>
                        <div class="faq-content px-8 pb-8 text-lg text-gray-600 leading-relaxed hidden">
                            We specialize in leadership roles across engineering, projects, quality, maintenance, operations,
                            plant leadership, and supply chain.
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ================= CONTACT SECTION ================= -->
    <section id="contact" class="py-40 bg-gradient-to-b from-[#f9fafb] to-white relative overflow-hidden">

        <!-- Ambient blobs -->
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
            <div class="absolute top-1/4 -left-20 w-80 h-80 bg-accent/5 rounded-full blur-[100px] animate-pulse">
            </div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-gold/5 rounded-full blur-[120px] animate-pulse">
            </div>
        </div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-20 xl:gap-32">

                <!-- LEFT COLUMN -->
                <div class="lg:col-span-5">
                    <div class="sticky top-32 space-y-12">

                        <div class="reveal reveal-right space-y-6">
                            <div
                                class="inline-flex items-center space-x-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
                                <span class="relative flex h-3 w-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-accent"></span>
                                </span>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-primary">
                                    Consultants Online
                                </span>
                            </div>

                            <h2 class="text-5xl md:text-7xl font-bold text-primary font-serif leading-[1.05]">
                                The talent you
                                <span class="text-accent italic">deserve</span>
                                is one conversation away.
                            </h2>

                            <p class="text-xl text-gray-500 leading-relaxed max-w-lg">
                                Partner with HiredNext for executive search and advisory that
                                delivers not just hires, but leadership legacies.
                            </p>
                        </div>

                        <!-- CONTACT CARDS -->
                        <div class="space-y-4">

                            <!-- Email -->
                            <a href="mailto:jobs@hirednext.info"
                                class="group flex items-center p-6 bg-white rounded-[2rem] border border-gray-100 hover:shadow-2xl hover:shadow-accent/10 hover:-translate-y-1 transition-all duration-500 reveal reveal-right">
                                <div
                                    class="w-14 h-14 rounded-2xl flex items-center justify-center text-accent bg-accent/5 group-hover:bg-accent group-hover:text-white transition-all">
                                    ✉
                                </div>
                                <div class="ml-6">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                        Send an Inquiry
                                    </p>
                                    <p class="text-lg font-bold text-primary">
                                        jobs@hirednext.info
                                    </p>
                                </div>
                                <span class="ml-auto text-gray-200 group-hover:text-accent transition-all">
                                    ↗
                                </span>
                            </a>

                            <!-- Call -->
                            <div
                                class="group flex items-center p-6 bg-white rounded-[2rem] border border-gray-100 hover:shadow-2xl hover:shadow-primary/10 hover:-translate-y-1 transition-all duration-500 reveal reveal-right">
                                <div
                                    class="w-14 h-14 rounded-2xl flex items-center justify-center text-primary bg-primary/5 group-hover:bg-primary group-hover:text-white transition-all">
                                    🎧
                                </div>
                                <div class="ml-6">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                        Schedule a Call
                                    </p>
                                    <p class="text-lg font-bold text-primary">
                                        Connect with Advisory
                                    </p>
                                </div>
                            </div>

                            <!-- Guarantee -->
                            <div
                                class="group flex items-center p-6 bg-white rounded-[2rem] border border-gray-100 hover:shadow-2xl hover:shadow-gold/10 hover:-translate-y-1 transition-all duration-500 reveal reveal-right">
                                <div
                                    class="w-14 h-14 rounded-2xl flex items-center justify-center text-gold bg-gold/5 group-hover:bg-gold group-hover:text-white transition-all">
                                    ✔
                                </div>
                                <div class="ml-6">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                        Success Guaranteed
                                    </p>
                                    <p class="text-lg font-bold text-primary">
                                        100% Confidential Process
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: FORM -->
                <div class="lg:col-span-7">
                    <div class="reveal reveal-scale">

                        <div
                            class="relative bg-white/80 backdrop-blur-xl rounded-[4rem] p-10 md:p-16 lg:p-20 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.12)] border border-white/50">

                            <h3 class="text-4xl font-bold text-primary mb-3 font-serif">
                                Start Your Brief
                            </h3>
                            <p class="text-gray-500 mb-12">
                                Secure. Consultative. Professional.
                            </p>

                            <?php if (session('success')): ?>
                                <div class="rounded-2xl border border-green-200 bg-green-50 text-green-700 px-6 py-4 text-sm font-semibold mb-6">
                                    <?= esc(session('success')) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (session('errors')): ?>
                                <div class="rounded-2xl border border-red-200 bg-red-50 text-red-700 px-6 py-4 text-sm font-semibold mb-6">
                                    <?= esc(implode(' ', session('errors'))) ?>
                                </div>
                            <?php endif; ?>

                            <?php
                            $contactFormEnabled = !isset($settings['contact_form_enabled']) || filter_var($settings['contact_form_enabled'], FILTER_VALIDATE_BOOLEAN);
                            ?>
                            <?php if ($contactFormEnabled): ?>
                            <form id="contactForm" class="space-y-12" action="<?= base_url('contact/submit') ?>" method="post">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                    <div>
                                        <label for="home_contact_name" class="sr-only">Your Name</label>
                                        <input id="home_contact_name" required name="name" placeholder="Your Name"
                                            class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl" />
                                    </div>
                                    <div>
                                        <label for="home_contact_email" class="sr-only">Professional Email</label>
                                        <input id="home_contact_email" required type="email" name="email" placeholder="Professional Email"
                                            class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                    <div>
                                        <label for="home_contact_subject" class="sr-only">Organization</label>
                                        <input id="home_contact_subject" name="subject" placeholder="Organization"
                                            class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl" />
                                    </div>
                                    <div>
                                        <label for="home_contact_service" class="sr-only">Service Interest</label>
                                        <select id="home_contact_service" name="service"
                                            class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl">
                                            <option>Executive Search</option>
                                            <option>Permanent Hiring</option>
                                            <option>RPO Solutions</option>
                                            <option>Career Strategy</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="home_contact_message" class="sr-only">Project or Hiring Brief</label>
                                    <textarea id="home_contact_message" rows="3" name="message" placeholder="Project or Hiring Brief"
                                        class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl resize-none"></textarea>
                                </div>

                                <div class="pt-10 flex flex-col md:flex-row items-center gap-10">
                                    <button id="submitBtn" type="submit"
                                        class="group relative overflow-hidden px-16 py-6 rounded-2xl font-black text-lg tracking-[0.2em] uppercase bg-primary text-white hover:bg-accent hover:-translate-y-2 transition-all shadow-2xl">
                                        Send Brief
                                    </button>

                                    <div class="flex items-center text-gray-400">
                                        <span class="text-gold mr-3">✔</span>
                                        <span class="text-xs font-bold uppercase tracking-widest">
                                            Confidential Advisory
                                        </span>
                                    </div>
                                </div>

                            </form>
                            <?php else: ?>
                                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 text-yellow-700 px-6 py-4 text-sm font-semibold">
                                    Contact form is currently disabled. Please reach out via email or phone.
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
<!-- ================= FAQ Section ================= -->
    <script>
        const faqButtons = document.querySelectorAll('.faq-btn');
        if (faqButtons.length) {
            faqButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const content = btn.nextElementSibling;
                    const icon = btn.querySelector('.faq-icon');

                    const isOpen = !content.classList.contains('hidden');

                    // Close all
                    document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
                    document.querySelectorAll('.faq-icon').forEach(i => i.textContent = '+');

                    // Toggle current
                    if (!isOpen) {
                        content.classList.remove('hidden');
                        icon.textContent = '×';
                    }
                });
            });
        }
    </script>


<?= $this->endSection() ?>
