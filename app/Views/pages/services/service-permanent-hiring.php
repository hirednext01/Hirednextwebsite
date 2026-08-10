<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<!-- HERO -->
    <header class="hero-service-detail hero-service-permanent relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden text-white">
        <div class="hero-overlay"></div>
        <div class="hero-sheen"></div>
        <div class="hero-noise"></div>
        <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <nav class="flex items-center gap-2 text-sm text-white/70 mb-10">
                <a href="<?= base_url() ?>" class="hover:text-accent transition">Home</a><span>/</span>
                <a href="<?= base_url('services') ?>" class="hover:text-accent transition">Services</a><span>/</span>
                <span class="text-gold font-semibold">Permanent Hiring</span>
            </nav>
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-3 px-5 py-2 bg-white/10 border border-white/15 rounded-full text-[11px] uppercase tracking-[0.35em] font-bold mb-8">
                    <span class="h-2 w-2 rounded-full bg-accent shadow-[0_0_12px_rgba(255,78,22,0.8)]"></span>
                    Mid to Senior Talent
                </div>
                <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">Permanent <span class="text-accent">Hiring</span></h1>
                <p class="text-xl md:text-2xl text-gold italic mb-4">Creating Teams That Last</p>
                <p class="text-lg text-white/80 max-w-2xl">Strategic long-term hiring focused on cultural alignment, role precision, and sustainable business growth—ensuring higher retention and performance for mid to senior leadership roles.</p>
                <div class="mt-10 flex flex-wrap gap-6 text-xs uppercase tracking-[0.3em] text-white/60">
                    <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-accent"></span> Culture Fit</span>
                    <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-gold"></span> Retention First</span>
                    <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-white"></span> Mid-Senior</span>
                </div>
            </div>
        </div>
    </header>

    <!-- STATS BAR -->
    <section class="relative z-20 -mt-8 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center"><div class="text-3xl md:text-4xl font-black text-primary mb-1">1500+</div><div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Placements</div></div>
            <div class="text-center"><div class="text-3xl md:text-4xl font-black text-accent mb-1">85%</div><div class="text-xs font-bold text-gray-500 uppercase tracking-widest">1st-Year Retention</div></div>
            <div class="text-center"><div class="text-3xl md:text-4xl font-black text-primary mb-1">25+</div><div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Industries</div></div>
            <div class="text-center"><div class="text-3xl md:text-4xl font-black text-gold mb-1">8+</div><div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Years Experience</div></div>
        </div>
    </section>

    <!-- OVERVIEW -->
    <section class="py-24 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-8">Strategic Long-Term Talent Solutions</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">Our permanent hiring practice delivers more than placements—we deliver stability, performance, and long-term cultural fit. We combine industry-aligned sourcing with multi-layer evaluation, compensation benchmarking, and thorough background and reference checks so every hire is built to last.</p>
                    <ul class="space-y-5 mb-10">
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Multi-layer candidate evaluation: technical, behavioral & leadership assessment</span></li>
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Industry-aligned sourcing strategy and talent mapping</span></li>
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Background verification & structured reference checks</span></li>
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Compensation & role benchmarking for competitive offers</span></li>
                    </ul>
                    <a href="<?= base_url('contact') ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white rounded-full font-bold hover:bg-accent transition-all shadow-lg">Start Hiring Today →</a>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-accent/10 rounded-[3rem] rotate-3"></div>
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200" alt="Permanent Hiring" class="relative rounded-[2.5rem] shadow-2xl w-full h-[520px] object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- WHO IT'S FOR -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-primary text-center mb-4">Who Permanent Hiring Is For</h2>
            <p class="text-center text-gray-600 max-w-2xl mx-auto mb-16">Ideal for organizations building lasting teams with mid to senior professionals.</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-2xl font-black">👔</div>
                    <h3 class="font-bold text-primary mb-2">Mid & Senior Roles</h3>
                    <p class="text-sm text-gray-500">Managers, directors, and specialists (3–15+ years)</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-accent/10 flex items-center justify-center text-accent text-2xl font-black">🏛</div>
                    <h3 class="font-bold text-primary mb-2">Culture-First Companies</h3>
                    <p class="text-sm text-gray-500">Where fit and values matter as much as skills</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-gold/10 flex items-center justify-center text-gold text-2xl font-black">📈</div>
                    <h3 class="font-bold text-primary mb-2">Steady Growth</h3>
                    <p class="text-sm text-gray-500">Predictable hiring needs without full RPO scale</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-2xl font-black">🌐</div>
                    <h3 class="font-bold text-primary mb-2">Global Talent</h3>
                    <p class="text-sm text-gray-500">Cross-border hiring with local compliance support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="py-24 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-primary text-center mb-4">How Our Permanent Hiring Works</h2>
            <p class="text-center text-gray-600 max-w-2xl mx-auto mb-16">A rigorous, transparent process from brief to onboarding.</p>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">01</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Discovery</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">We understand your culture, goals, and role DNA—including must-haves and nice-to-haves—so we search with precision.</p>
                </div>
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">02</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Sourcing</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Targeted, industry-specific talent search using our network, databases, and direct outreach to passive candidates.</p>
                </div>
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">03</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Evaluation</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Technical, behavioral, and leadership checks—plus compensation benchmarking and structured interviews.</p>
                </div>
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">04</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Onboarding</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Seamless joining and post-hire support to ensure your new hire integrates quickly and stays long term.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- INDUSTRIES -->
    <section class="py-24 bg-primary text-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-center mb-4">Industries We Hire For</h2>
            <p class="text-center text-white/70 max-w-2xl mx-auto mb-16">Deep expertise across IT, BFSI, Retail, Engineering, Manufacturing, and more.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">IT & Technology</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">BFSI & Banking</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">Retail & E-Commerce</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">Engineering & Manufacturing</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">Healthcare & Life Sciences</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">FMCG & Consumer</span>
            </div>
        </div>
    </section>

    <!-- OTHER SERVICES -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-primary text-center mb-16">Explore Our Other Services</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <a href="<?= base_url('services/rpo') ?>" class="group bg-white p-10 rounded-[3rem] hover:bg-primary hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary">
                    <h3 class="text-2xl font-bold text-primary group-hover:text-white mb-4">RPO Solutions</h3>
                    <p class="text-gray-500 group-hover:text-white/80 leading-relaxed">End-to-end recruitment ownership with scalable models and clear SLAs.</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-accent group-hover:text-gold font-bold text-sm">Learn more →</span>
                </a>
                <a href="<?= base_url('services/executive-search') ?>" class="group bg-white p-10 rounded-[3rem] hover:bg-primary hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary">
                    <h3 class="text-2xl font-bold text-primary group-hover:text-white mb-4">Executive Search</h3>
                    <p class="text-gray-500 group-hover:text-white/80 leading-relaxed">Confidential CXO & board-level hiring with global executive networks.</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-accent group-hover:text-gold font-bold text-sm">Learn more →</span>
                </a>
                <a href="<?= base_url('services/avron') ?>" class="group bg-white p-10 rounded-[3rem] hover:bg-primary hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary">
                    <h3 class="text-2xl font-bold text-primary group-hover:text-white mb-4">HiredNext Avron</h3>
                    <p class="text-gray-500 group-hover:text-white/80 leading-relaxed">AI-powered career acceleration and skill-gap analysis for professionals.</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-accent group-hover:text-gold font-bold text-sm">Learn more →</span>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-primary text-white text-center relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <h2 class="text-4xl md:text-5xl font-serif font-bold mb-8">Ready to build a high-impact team?</h2>
            <p class="text-xl text-white/80 max-w-xl mx-auto mb-10">Tell us your hiring goals and we’ll design a permanent hiring approach that fits your culture and pace.</p>
            <a href="<?= base_url('contact') ?>" class="inline-block px-12 py-5 bg-accent rounded-full font-bold shadow-xl hover:bg-accent/90 hover:-translate-y-1 transition-all">Start Hiring Today</a>
        </div>
    </section>

    <!-- FOOTER -->
<?= $this->endSection() ?>
