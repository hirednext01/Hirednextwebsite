<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<!-- HERO -->
    <header class="hero-service-detail hero-service-rpo relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden text-white">
        <div class="hero-overlay"></div>
        <div class="hero-sheen"></div>
        <div class="hero-noise"></div>
        <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <nav class="flex items-center gap-2 text-sm text-white/70 mb-10">
                <a href="<?= base_url() ?>" class="hover:text-accent transition">Home</a>
                <span>/</span>
                <a href="<?= base_url('services') ?>" class="hover:text-accent transition">Services</a>
                <span>/</span>
                <span class="text-gold font-semibold">RPO Solutions</span>
            </nav>
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-3 px-5 py-2 bg-white/10 border border-white/15 rounded-full text-[11px] uppercase tracking-[0.35em] font-bold mb-8">
                    <span class="h-2 w-2 rounded-full bg-accent shadow-[0_0_12px_rgba(255,78,22,0.8)]"></span>
                    Recruitment Process Outsourcing
                </div>
                <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">RPO <span class="text-accent">Solutions</span></h1>
                <p class="text-xl md:text-2xl text-gold italic mb-4">Dedicated Recruitment for Defined Hiring Programs</p>
                <p class="text-lg text-white/80 max-w-2xl">Flexible recruitment ownership for organisations building specialist, mid-senior or multi-role teams and needing dedicated sourcing, screening and hiring coordination.</p>
                <div class="mt-10 flex flex-wrap gap-6 text-xs uppercase tracking-[0.3em] text-white/60">
                    <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-accent"></span> Dedicated Delivery</span>
                    <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-gold"></span> Defined Mandates</span>
                    <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-white"></span> Clear Reporting</span>
                </div>
            </div>
        </div>
    </header>

    <!-- FACTS BAR -->
    <section class="relative z-20 -mt-8 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-black text-primary mb-1">2016</div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Founded</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-black text-accent mb-1">Defined</div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Hiring Scope</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-black text-primary mb-1">Dedicated</div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Recruitment Delivery</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-black text-gold mb-1">Evidence-Led</div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Candidate Review</div>
            </div>
        </div>
    </section>

    <!-- OVERVIEW -->
    <section class="py-24 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-8">Flexible Recruitment Process Outsourcing</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">HiredNext can take dedicated ownership of a defined recruitment program when an organisation needs more search capacity without immediately expanding its internal team. The model is calibrated to the roles, hiring volume, reporting rhythm and internal ownership agreed at the start.</p>
                    <ul class="space-y-5 mb-10">
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Defined recruitment workflow from job brief through sourcing, screening and coordination</span></li>
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Role- and sector-aligned search strategy for the agreed hiring program</span></li>
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Pipeline visibility and agreed reporting cadence for hiring stakeholders</span></li>
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Flexible delivery capacity for capability builds, projects or periods of concentrated hiring</span></li>
                    </ul>
                    <a href="<?= base_url('hiring-discussion') ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white rounded-full font-bold hover:bg-accent transition-all shadow-lg">Discuss an RPO Requirement →</a>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-gold/10 rounded-[3rem] -rotate-3"></div>
                    <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?auto=format&fit=crop&w=1200" alt="RPO Solutions" class="relative rounded-[2.5rem] shadow-2xl w-full h-[520px] object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- WHO IT'S FOR -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-primary text-center mb-4">Who RPO Is For</h2>
            <p class="text-center text-gray-600 max-w-2xl mx-auto mb-16">For organisations with a defined program of specialist or mid-senior hiring that needs dedicated external recruitment capacity.</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-2xl font-black">🏢</div>
                    <h3 class="font-bold text-primary mb-2">Growth & Capability Builds</h3>
                    <p class="text-sm text-gray-500">Organisations adding new teams, functions or specialist capability</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-accent/10 flex items-center justify-center text-accent text-2xl font-black">📊</div>
                    <h3 class="font-bold text-primary mb-2">Multi-Role Programs</h3>
                    <p class="text-sm text-gray-500">Several related mid-senior or specialist roles requiring one coordinated search program</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-gold/10 flex items-center justify-center text-gold text-2xl font-black">🌍</div>
                    <h3 class="font-bold text-primary mb-2">India & GCC Builds</h3>
                    <p class="text-sm text-gray-500">India-based and selected GCC hiring programs where market mapping and coordinated delivery matter</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-2xl font-black">⚡</div>
                    <h3 class="font-bold text-primary mb-2">Project & Peak Hiring</h3>
                    <p class="text-sm text-gray-500">Defined periods when internal recruiting capacity needs reinforcement</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="py-24 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-primary text-center mb-4">How Our RPO Partnership Works</h2>
            <p class="text-center text-gray-600 max-w-2xl mx-auto mb-16">A four-phase model calibrated to the agreed hiring program.</p>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">01</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Scope</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">We define the roles, priorities, ownership, process, reporting rhythm and practical success criteria.</p>
                </div>
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">02</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Search Design</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">We build the sourcing and screening approach around the roles, sector context and available talent market.</p>
                </div>
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">03</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Execution</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Dedicated recruiters manage sourcing, screening and candidate coordination with visibility for the hiring team.</p>
                </div>
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">04</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Review</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Pipeline quality, bottlenecks and priorities are reviewed against the agreed program so the search can be adjusted when needed.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- INDUSTRIES -->
    <section class="py-24 bg-primary text-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-center mb-4">Industry Search Coverage</h2>
            <p class="text-center text-white/70 max-w-2xl mx-auto mb-16">RPO is considered where the mandate fits HiredNext's sector knowledge and commercial model.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">Garment / Textile / Apparel</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">Retail</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">IT & Technology</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">Engineering & Manufacturing</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">BFSI / NBFC</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">GCC / Semiconductors</span>
            </div>
        </div>
    </section>

    <!-- OTHER SERVICES -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-primary text-center mb-16">Explore Our Other Services</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <a href="<?= base_url('services/permanent-hiring') ?>" class="group bg-white p-10 rounded-[3rem] hover:bg-primary hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary">
                    <h3 class="text-2xl font-bold text-primary group-hover:text-white mb-4">Permanent Hiring</h3>
                    <p class="text-gray-500 group-hover:text-white/80 leading-relaxed">Strategic mid-senior and specialist hiring built around role precision and targeted search.</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-accent group-hover:text-gold font-bold text-sm">Learn more →</span>
                </a>
                <a href="<?= base_url('services/executive-search') ?>" class="group bg-white p-10 rounded-[3rem] hover:bg-primary hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary">
                    <h3 class="text-2xl font-bold text-primary group-hover:text-white mb-4">Executive Search</h3>
                    <p class="text-gray-500 group-hover:text-white/80 leading-relaxed">Confidential CXO and leadership hiring using market mapping, direct outreach and structured assessment.</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-accent group-hover:text-gold font-bold text-sm">Learn more →</span>
                </a>
                <a href="<?= base_url('services/candidates') ?>" class="group bg-white p-10 rounded-[3rem] hover:bg-primary hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary">
                    <h3 class="text-2xl font-bold text-primary group-hover:text-white mb-4">Senior Career Advisory</h3>
                    <p class="text-gray-500 group-hover:text-white/80 leading-relaxed">Recruiter-informed CV, positioning and interview strategy for experienced professionals.</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-accent group-hover:text-gold font-bold text-sm">Learn more →</span>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-primary text-white text-center relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <h2 class="text-4xl md:text-5xl font-serif font-bold mb-8">Planning a defined hiring program?</h2>
            <p class="text-xl text-white/80 max-w-xl mx-auto mb-10">Share the roles, timeline and internal recruiting capacity. We will tell you whether an RPO model or mandate-by-mandate search is the better fit.</p>
            <a href="<?= base_url('hiring-discussion') ?>" class="inline-block px-12 py-5 bg-accent rounded-full font-bold shadow-xl hover:bg-accent/90 hover:-translate-y-1 transition-all">Discuss the Requirement</a>
        </div>
    </section>

    <!-- FOOTER -->
<?= $this->endSection() ?>