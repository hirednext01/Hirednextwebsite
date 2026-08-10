<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min'; ?>
<!-- Hero Section -->
    <header class="hero-services relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden text-white">
        <div class="hero-overlay"></div>
        <div class="hero-sheen"></div>
        <div class="hero-noise"></div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10 text-center">
            <div
                class="reveal reveal-up inline-flex items-center gap-3 px-5 py-2 bg-white/10 border border-white/15 rounded-full text-[11px] uppercase tracking-[0.35em] font-bold mb-8">
                <span class="h-2 w-2 rounded-full bg-accent shadow-[0_0_12px_rgba(255,78,22,0.8)]"></span>
                Our Services
            </div>
            <h1 class="reveal reveal-up text-5xl md:text-7xl font-bold font-serif mb-8 leading-tight">
                Leadership hiring<span class="text-accent"> built for growth</span>
            </h1>
            <p class="reveal reveal-up text-lg md:text-2xl text-white/80 max-w-3xl mx-auto leading-relaxed">
                <?= esc($settings['services_description'] ?? 'Executive search, permanent hiring, RPO solutions, and career advisory—tailored to help organizations scale with confidence.') ?>
            </p>
            <div class="reveal reveal-up mt-10 flex flex-wrap justify-center gap-6 text-xs uppercase tracking-[0.3em] text-white/60">
                <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-gold"></span> Executive Search</span>
                <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-accent"></span> Permanent Hiring</span>
                <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-white"></span> RPO & Avron</span>
            </div>
        </div>
    </header>
    <!-- ================= SERVICES ================= -->
    <section class="py-32 bg-white">
        <div class="max-w-[1440px] mx-auto px-6 space-y-32">

            <!-- ================= 1. PERMANENT HIRING ================= -->
            <div class="flex flex-col lg:flex-row gap-20 items-center">

                <!-- IMAGE -->
                <div class="lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-primary/10 rounded-[3rem] rotate-2"></div>
                    <div class="relative overflow-hidden rounded-[3rem] shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200"
                            class="w-full h-[520px] object-cover transition-transform duration-700 hover:scale-105" />
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="lg:w-1/2">
                    <span class="text-accent font-black tracking-widest uppercase text-xs">
                        Creating Teams That Last
                    </span>

                    <h2 class="text-5xl font-serif font-black text-primary mt-4 mb-6">
                        Permanent Hiring
                    </h2>

                    <p class="text-gold text-xl italic mb-6">
                        Strategic long-term hiring solutions
                    </p>

                    <p class="text-gray-500 text-lg leading-relaxed mb-10 max-w-xl">
                        Strategic long-term hiring focused on cultural alignment, role precision,
                        and sustainable business growth — ensuring higher retention and performance.
                    </p>

                    <a href="<?= base_url('services/permanent-hiring') ?>"
                        class="inline-flex items-center gap-4 px-10 py-4 bg-primary text-white rounded-full font-bold hover:bg-accent transition shadow-xl">
                        Explore Service →
                    </a>
                </div>
            </div>

            <!-- ================= 2. RPO SOLUTIONS ================= -->
            <div class="flex flex-col lg:flex-row-reverse gap-20 items-center">

                <div class="lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-gold/10 rounded-[3rem] -rotate-2"></div>
                    <div class="relative overflow-hidden rounded-[3rem] shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?auto=format&fit=crop&w=1200"
                            class="w-full h-[520px] object-cover transition-transform duration-700 hover:scale-105" />
                    </div>
                </div>

                <div class="lg:w-1/2">
                    <span class="text-accent font-black tracking-widest uppercase text-xs">
                        Smarter Hiring. Stronger Results.
                    </span>

                    <h2 class="text-5xl font-serif font-black text-primary mt-4 mb-6">
                        RPO Solutions
                    </h2>

                    <p class="text-gold text-xl italic mb-6">
                        End-to-end recruitment ownership
                    </p>

                    <p class="text-gray-500 text-lg leading-relaxed mb-10 max-w-xl">
                        Comprehensive recruitment management that reduces cost, accelerates
                        hiring timelines, and ensures consistent talent quality at scale.
                    </p>

                    <a href="<?= base_url('services/rpo') ?>"
                        class="inline-flex items-center gap-4 px-10 py-4 bg-primary text-white rounded-full font-bold hover:bg-gold transition shadow-xl">
                        Explore Service →
                    </a>
                </div>
            </div>

            <!-- ================= 3. EXECUTIVE SEARCH ================= -->
            <div class="flex flex-col lg:flex-row gap-20 items-center">

                <div class="lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-primary/10 rounded-[3rem] rotate-2"></div>
                    <div class="relative overflow-hidden rounded-[3rem] shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200"
                            class="w-full h-[520px] object-cover transition-transform duration-700 hover:scale-105" />
                    </div>
                </div>

                <div class="lg:w-1/2">
                    <span class="text-accent font-black tracking-widest uppercase text-xs">
                        Building Leadership That Shapes the Future
                    </span>

                    <h2 class="text-5xl font-serif font-black text-primary mt-4 mb-6">
                        HiredNext Realm
                    </h2>

                    <p class="text-gold text-xl italic mb-6">
                        Elite executive & CXO search
                    </p>

                    <p class="text-gray-500 text-lg leading-relaxed mb-10 max-w-xl">
                        Confidential, research-driven leadership hiring backed by global executive
                        networks and deep industry intelligence.
                    </p>

                    <a href="<?= base_url('services/executive-search') ?>"
                        class="inline-flex items-center gap-4 px-10 py-4 bg-primary text-white rounded-full font-bold hover:bg-accent transition shadow-xl">
                        Explore Service →
                    </a>
                </div>
            </div>

            <!-- ================= 4. HIREDNEXT AVRON ================= -->
            <div class="flex flex-col lg:flex-row-reverse gap-20 items-center">

                <div class="lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-gold/10 rounded-[3rem] -rotate-2"></div>
                    <div class="relative overflow-hidden rounded-[3rem] shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1200"
                            class="w-full h-[520px] object-cover transition-transform duration-700 hover:scale-105" />
                    </div>
                </div>
            
                <div class="lg:w-1/2">
                    <span class="text-accent font-black tracking-widest uppercase text-xs">
                        Accelerate Your Career with Intelligence & Mentorship
                    </span>
            
                    <h2 class="text-5xl font-serif font-black text-primary mt-4 mb-6">
                        HiredNext Avron
                    </h2>
            
                    <p class="text-gold text-xl italic mb-6">
                        AI-powered career acceleration with real mentorship
                    </p>
            
                    <p class="text-gray-500 text-lg leading-relaxed mb-10 max-w-xl">
                        Avron is an intelligent career companion that combines AI-driven skill-gap analysis,
                        personalized learning paths, and expert mentorship delivered through the
                        UpMentorX platform — ensuring guidance from professionals who’ve already walked the path.
                    </p>
            
                    <div class="flex flex-wrap gap-6">
                        <!-- Primary CTA -->
                        <a href="<?= base_url('services/avron') ?>"
                            class="inline-flex items-center gap-4 px-10 py-4 bg-primary text-white rounded-full font-bold hover:bg-gold transition shadow-xl">
                            Explore Avron →
                        </a>
            
                        <!-- Secondary CTA -->
                        <a href="https://www.upmentorx.com" target="_blank"
                            class="inline-flex items-center gap-4 px-10 py-4 border-2 border-primary text-primary rounded-full font-bold hover:bg-primary hover:text-white transition">
                            Meet Your Mentors →
                        </a>
                    </div>
                </div>
            
            </div>


        </div>
    </section>

    <!-- ================= CTA ================= -->
    <section class="py-40 bg-primary text-white text-center relative overflow-hidden">
        <div
            class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 mix-blend-overlay">
        </div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-accent opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-gold opacity-10 rounded-full blur-3xl"></div>

        <div class="max-w-5xl mx-auto px-6 relative z-10 reveal reveal-up">
            <h2 class="text-5xl md:text-7xl font-serif font-bold mb-10 leading-tight">
                Transform talent into a <br>
                <span class="text-gold italic">strategic advantage.</span>
            </h2>

            <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer"
                class="inline-block px-12 py-5 bg-white text-primary rounded-full font-black uppercase tracking-widest hover:bg-accent hover:text-white transition-all shadow-[0_10px_30px_rgba(255,255,255,0.2)] hover:shadow-[0_20px_40px_rgba(255,78,22,0.4)] hover:-translate-y-1">
                Book a 30-Min Call
            </a>
        </div>
    </section>

    <!-- ================= METHODOLOGY ================= -->
    <section class="py-32 bg-gray-50 relative overflow-hidden">
        <div class="max-w-[1440px] mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal reveal-up">
                <span class="text-accent font-black uppercase tracking-[0.3em] text-[10px] mb-4 block">
                    How We Deliver
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-primary font-serif mb-6">
                    Our Methodology
                </h2>
                <p class="text-gray-500 text-lg">
                    A precision-engineered approach to talent acquisition that balances speed, quality, and cultural
                    alignment.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="group reveal reveal-up">
                    <div
                        class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 h-full hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div
                            class="text-3xl font-black text-accent/20 mb-6 group-hover:text-accent/40 transition-colors">
                            01</div>
                        <h3 class="text-xl font-bold text-primary mb-4">Discovery</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Deep dive into your organizational culture,
                            goals, and specific role requirements.</p>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="group reveal reveal-up" style="animation-delay: 100ms;">
                    <div
                        class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 h-full hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div
                            class="text-3xl font-black text-accent/20 mb-6 group-hover:text-accent/40 transition-colors">
                            02</div>
                        <h3 class="text-xl font-bold text-primary mb-4">Sourcing</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Leveraging global networks and AI-powered tools
                            to identify elite talent.</p>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="group reveal reveal-up" style="animation-delay: 200ms;">
                    <div
                        class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 h-full hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div
                            class="text-3xl font-black text-accent/20 mb-6 group-hover:text-accent/40 transition-colors">
                            03</div>
                        <h3 class="text-xl font-bold text-primary mb-4">Evaluation</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Multi-layered assessment focusing on both
                            technical mastery and soft skill alignment.</p>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="group reveal reveal-up" style="animation-delay: 300ms;">
                    <div
                        class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 h-full hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div
                            class="text-3xl font-black text-accent/20 mb-6 group-hover:text-accent/40 transition-colors">
                            04</div>
                        <h3 class="text-xl font-bold text-primary mb-4">Onboarding</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Ensuring seamless integration and providing
                            post-placement support for long-term success.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= WHY CHOOSE US (FIXED + UPGRADED) ================= -->
    <section class="py-32 bg-white relative overflow-hidden">
        <!-- subtle background glow -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>

        <div class="max-w-[1440px] mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-24 items-center">

                <!-- LEFT CONTENT -->
                <div class="reveal reveal-right">
                    <span class="text-accent font-black uppercase tracking-[0.35em] text-[11px] mb-6 block">
                        The HiredNext Edge
                    </span>

                    <h2 class="text-4xl md:text-6xl font-bold text-primary font-serif mb-10 leading-tight">
                        Why Strategic Leaders <br>
                        <span class="text-accent">Choose Us.</span>
                    </h2>

                    <p class="text-xl text-gray-500 mb-14 leading-relaxed max-w-xl">
                        We don’t just fill roles — we architect leadership ecosystems that
                        fuel long-term growth, trust, and measurable business outcomes.
                    </p>

                    <div class="space-y-6 max-w-xl">
                        <!-- Item -->
                        <div
                            class="flex items-center gap-6 p-6 bg-gray-50 rounded-2xl group hover:bg-primary transition-all duration-300">
                            <div
                                class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-accent shadow-sm group-hover:bg-accent group-hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="text-lg font-bold group-hover:text-white">
                                Industry-First Intelligence
                            </span>
                        </div>

                        <!-- Item -->
                        <div
                            class="flex items-center gap-6 p-6 bg-gray-50 rounded-2xl group hover:bg-primary transition-all duration-300">
                            <div
                                class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-accent shadow-sm group-hover:bg-accent group-hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <span class="text-lg font-bold group-hover:text-white">
                                100% Confidential Search
                            </span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT STATS -->
                <div class="grid grid-cols-2 gap-8 reveal reveal-left">

                    <!-- Card -->
                    <div
                        class="p-12 bg-primary rounded-[3rem] text-center hover:-translate-y-3 transition-all duration-500 shadow-xl">
                        <div class="text-5xl font-black text-gold mb-3">98%</div>
                        <div class="text-white/70 text-[11px] font-black uppercase tracking-widest">
                            Client Retention
                        </div>
                    </div>

                    <!-- Card -->
                    <div
                        class="p-12 bg-accent rounded-[3rem] text-center hover:-translate-y-3 transition-all duration-500 shadow-xl">
                        <div class="text-5xl font-black text-white mb-3">15d</div>
                        <div class="text-white/70 text-[11px] font-black uppercase tracking-widest">
                            Avg. Fill Time
                        </div>
                    </div>

                    <!-- Card -->
                    <div
                        class="p-12 bg-gray-100 rounded-[3rem] text-center hover:-translate-y-3 transition-all duration-500 shadow-md">
                        <div class="text-5xl font-black text-primary mb-3">50k+</div>
                        <div class="text-primary/50 text-[11px] font-black uppercase tracking-widest">
                            Global Network
                        </div>
                    </div>

                    <!-- Card -->
                    <div
                        class="p-12 bg-gold rounded-[3rem] text-center hover:-translate-y-3 transition-all duration-500 shadow-xl">
                        <div class="text-5xl font-black text-white mb-3">10+</div>
                        <div class="text-white/70 text-[11px] font-black uppercase tracking-widest">
                            Years Excellence
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <script>
        const reveals = document.querySelectorAll('.reveal');
        const obs = new IntersectionObserver(e => {
            e.forEach(x => x.isIntersecting && x.target.classList.add('reveal-visible'))
        }, { threshold: .15 });
        reveals.forEach(r => obs.observe(r));
    </script>

<?= $this->endSection() ?>
