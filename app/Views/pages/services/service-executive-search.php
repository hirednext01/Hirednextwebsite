<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="hero-service-detail hero-service-executive relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden text-white">
        <div class="hero-overlay"></div>
        <div class="hero-sheen"></div>
        <div class="hero-noise"></div>
        <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <nav class="flex items-center gap-2 text-sm text-white/70 mb-10">
                <a href="<?= base_url() ?>" class="hover:text-accent transition">Home</a><span>/</span>
                <a href="<?= base_url('services') ?>" class="hover:text-accent transition">Services</a><span>/</span>
                <span class="text-gold font-semibold">Executive Search</span>
            </nav>
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-3 px-5 py-2 bg-white/10 border border-white/15 rounded-full text-[11px] uppercase tracking-[0.35em] font-bold mb-8">
                    <span class="h-2 w-2 rounded-full bg-gold shadow-[0_0_12px_rgba(212,175,55,0.7)]"></span>
                    HiredNext Realm
                </div>
                <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">Executive <span class="text-accent">Search</span></h1>
                <p class="text-xl md:text-2xl text-gold italic mb-4">Building Leadership That Shapes the Future</p>
                <p class="text-lg text-white/80 max-w-2xl">Identifying and securing top-tier leadership requires discretion, insight, and global reach. We specialize in confidential CXO and board-level hiring, powered by deep industry networks and a rigorous evaluation process.</p>
                <div class="mt-10 flex flex-wrap gap-6 text-xs uppercase tracking-[0.3em] text-white/60">
                    <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-accent"></span> Confidential Search</span>
                    <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-gold"></span> Global Network</span>
                    <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-white"></span> CXO Focus</span>
                </div>
            </div>
        </div>
    </header>

    <section class="relative z-20 -mt-8 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center"><div class="text-3xl md:text-4xl font-black text-primary mb-1">100%</div><div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Confidential</div></div>
            <div class="text-center"><div class="text-3xl md:text-4xl font-black text-accent mb-1">50k+</div><div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Executive Network</div></div>
            <div class="text-center"><div class="text-3xl md:text-4xl font-black text-primary mb-1">CXO</div><div class="text-xs font-bold text-gray-500 uppercase tracking-widest">& Board Level</div></div>
            <div class="text-center"><div class="text-3xl md:text-4xl font-black text-gold mb-1">15+</div><div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Countries</div></div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-8">Confidential & Strategic Leadership Hiring</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">We combine bespoke CXO and board-level search methodology with strictly confidential execution. Our team taps into elite global executive networks and applies evidence-based leadership assessments so you get leaders who match both capability and culture.</p>
                    <ul class="space-y-5 mb-10">
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Bespoke CXO & board-level search methodology tailored to your context</span></li>
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Strictly confidential, professional process with clear communication</span></li>
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Access to elite global executive networks and passive candidates</span></li>
                        <li class="flex items-start gap-4"><span class="text-accent text-xl shrink-0">✓</span><span class="text-gray-700 font-medium">Evidence-based leadership assessments and cultural fit evaluation</span></li>
                    </ul>
                    <a href="<?= base_url('contact') ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white rounded-full font-bold hover:bg-accent transition-all shadow-lg">Initiate Executive Search →</a>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-accent/10 rounded-[3rem] rotate-2"></div>
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200" alt="Executive Search" class="relative rounded-[2.5rem] shadow-2xl w-full h-[520px] object-cover">
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-primary text-center mb-4">Who Executive Search Is For</h2>
            <p class="text-center text-gray-600 max-w-2xl mx-auto mb-16">When the role is mission-critical and discretion is non-negotiable.</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-2xl font-black">👑</div>
                    <h3 class="font-bold text-primary mb-2">C-Suite & Board</h3>
                    <p class="text-sm text-gray-500">CEO, CFO, CTO, COO and board appointments</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-accent/10 flex items-center justify-center text-accent text-2xl font-black">🔒</div>
                    <h3 class="font-bold text-primary mb-2">Confidential Replacements</h3>
                    <p class="text-sm text-gray-500">Sensitive succession and replacement hiring</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-gold/10 flex items-center justify-center text-gold text-2xl font-black">🌍</div>
                    <h3 class="font-bold text-primary mb-2">Global Leaders</h3>
                    <p class="text-sm text-gray-500">Cross-border leadership and regional heads</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-accent/30 hover:shadow-xl transition-all text-center">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-2xl font-black">📈</div>
                    <h3 class="font-bold text-primary mb-2">Transformational Hires</h3>
                    <p class="text-sm text-gray-500">Leaders who will drive strategy and change</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-primary text-center mb-4">Our Executive Search Process</h2>
            <p class="text-center text-gray-600 max-w-2xl mx-auto mb-16">From brief to placement, we maintain the highest standards of confidentiality and rigour.</p>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">01</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Briefing</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">We define the leadership profile, success criteria, and organizational context in depth so the search is aligned from day one.</p>
                </div>
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">02</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Mapping</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">We identify and map potential leaders across industries and geographies using our network and research capabilities.</p>
                </div>
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">03</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Vetting</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Rigorous technical, strategic, and cultural leadership assessment—including references and background verification.</p>
                </div>
                <div class="group bg-gray-50 p-10 rounded-[2.5rem] border-2 border-transparent hover:border-accent hover:shadow-xl transition-all duration-300">
                    <div class="text-accent font-black text-4xl mb-6">04</div>
                    <h4 class="font-bold text-primary text-xl mb-3">Selection</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">We support negotiations, onboarding, and transition planning so your new leader hits the ground running.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-primary text-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-center mb-4">Leadership Roles We Fill</h2>
            <p class="text-center text-white/70 max-w-2xl mx-auto mb-16">From C-suite to regional and functional heads across all major industries.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">CEO / Managing Director</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">CFO / Finance Lead</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">CTO / Technology Head</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">COO / Operations</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">CHRO / HR Leadership</span>
                <span class="px-6 py-3 bg-white/10 rounded-full text-sm font-semibold border border-white/20">Board & Advisory</span>
            </div>
        </div>
    </section>

    <section class="py-24 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <h2 class="text-4xl font-serif font-bold text-primary text-center mb-16">Explore Our Other Services</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <a href="<?= base_url('services/permanent-hiring') ?>" class="group bg-white p-10 rounded-[3rem] hover:bg-primary hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary">
                    <h3 class="text-2xl font-bold text-primary group-hover:text-white mb-4">Permanent Hiring</h3>
                    <p class="text-gray-500 group-hover:text-white/80 leading-relaxed">Strategic long-term hiring for mid to senior roles with cultural alignment.</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-accent group-hover:text-gold font-bold text-sm">Learn more →</span>
                </a>
                <a href="<?= base_url('services/rpo') ?>" class="group bg-white p-10 rounded-[3rem] hover:bg-primary hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary">
                    <h3 class="text-2xl font-bold text-primary group-hover:text-white mb-4">RPO Solutions</h3>
                    <p class="text-gray-500 group-hover:text-white/80 leading-relaxed">End-to-end recruitment ownership with scalable models.</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-accent group-hover:text-gold font-bold text-sm">Learn more →</span>
                </a>
                <a href="<?= base_url('services/avron') ?>" class="group bg-white p-10 rounded-[3rem] hover:bg-primary hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary">
                    <h3 class="text-2xl font-bold text-primary group-hover:text-white mb-4">HiredNext Avron</h3>
                    <p class="text-gray-500 group-hover:text-white/80 leading-relaxed">AI-powered career acceleration for professionals.</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-accent group-hover:text-gold font-bold text-sm">Learn more →</span>
                </a>
            </div>
        </div>
    </section>

    <section class="py-24 bg-primary text-white text-center relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <h2 class="text-4xl md:text-5xl font-serif font-bold mb-8">Find the leaders your company deserves.</h2>
            <p class="text-xl text-white/80 max-w-xl mx-auto mb-10">Start a confidential conversation about your next C-suite or board-level hire.</p>
            <a href="<?= base_url('contact') ?>" class="inline-block px-12 py-5 bg-accent rounded-full font-bold shadow-xl hover:bg-accent/90 hover:-translate-y-1 transition-all">Initiate Executive Search</a>
        </div>
    </section>
<?= $this->endSection() ?>
