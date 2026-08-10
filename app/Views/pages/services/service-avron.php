<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<header class="hero-service-detail hero-service-avron relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden text-white">
    <div class="hero-overlay"></div>
    <div class="hero-sheen"></div>
    <div class="hero-noise"></div>

    <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <nav class="flex items-center gap-2 text-sm text-white/70 mb-10">
            <a href="<?= base_url() ?>" class="hover:text-accent transition">Home</a><span>/</span>
            <a href="<?= base_url('services') ?>" class="hover:text-accent transition">Services</a><span>/</span>
            <span class="text-gold font-semibold">HiredNext Avron</span>
        </nav>

        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-3 px-5 py-2 bg-white/10 border border-white/15 rounded-full text-[11px] uppercase tracking-[0.35em] font-bold mb-8">
                <span class="h-2 w-2 rounded-full bg-gold shadow-[0_0_12px_rgba(212,175,55,0.7)]"></span>
                AI Career Acceleration + Mentorship
            </div>

            <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">
                HiredNext <span class="text-accent">Avron</span>
            </h1>

            <p class="text-xl md:text-2xl text-gold italic mb-4">
                Intelligence backed by real-world mentors
            </p>

            <p class="text-lg text-white/80 max-w-2xl">
                Avron is a structured career acceleration system that combines AI-driven career intelligence
                with expert mentorship delivered via the UpMentorX platform — giving professionals clarity,
                direction, and accountability to reach their target roles faster.
            </p>

            <div class="mt-10 flex flex-wrap gap-6">
                <a href="<?= base_url('contact') ?>"
                   class="inline-flex items-center px-8 py-4 bg-accent text-primary rounded-full font-bold shadow-xl hover:bg-accent/90 transition">
                    Start with Avron →
                </a>

                <a href="https://www.upmentorx.com" target="_blank"
                   class="inline-flex items-center px-8 py-4 border-2 border-gold text-gold rounded-full font-bold hover:bg-gold hover:text-primary transition">
                    Explore Mentorship →
                </a>
            </div>
        </div>
    </div>
</header>

<section class="relative z-20 -mt-8 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="text-center">
            <div class="text-3xl md:text-4xl font-black text-primary mb-1">AI</div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Career Intelligence</div>
        </div>
        <div class="text-center">
            <div class="text-3xl md:text-4xl font-black text-accent mb-1">Skill Gap</div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Role Mapping</div>
        </div>
        <div class="text-center">
            <div class="text-3xl md:text-4xl font-black text-primary mb-1">Learning</div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Targeted Paths</div>
        </div>
        <div class="text-center">
            <div class="text-3xl md:text-4xl font-black text-gold mb-1">Mentorship</div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">via UpMentorX</div>
        </div>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-8">
                    AI-Powered Career Intelligence
                </h2>

                <p class="text-lg text-gray-600 leading-relaxed mb-8">
                    Avron is built for professionals who want precision, not guesswork.
                    We analyze your profile against real market roles, identify gaps,
                    and combine AI insights with structured mentorship where direction matters most.
                </p>

                <ul class="space-y-5 mb-10">
                    <li class="flex items-start gap-4">
                        <span class="text-accent text-xl shrink-0">✓</span>
                        <span class="text-gray-700 font-medium">
                            AI-driven resume and profile evaluation aligned to ATS and hiring standards
                        </span>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="text-accent text-xl shrink-0">✓</span>
                        <span class="text-gray-700 font-medium">
                            Skill-gap analysis mapped directly to your target role
                        </span>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="text-accent text-xl shrink-0">✓</span>
                        <span class="text-gray-700 font-medium">
                            Structured learning paths with measurable progress tracking
                        </span>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="text-accent text-xl shrink-0">✓</span>
                        <span class="text-gray-700 font-medium">
                            Expert mentorship delivered through the UpMentorX platform
                        </span>
                    </li>
                </ul>

                <div class="flex flex-wrap gap-6">
                    <a href="<?= base_url('contact') ?>"
                       class="inline-flex items-center px-8 py-4 bg-primary text-white rounded-full font-bold hover:bg-accent transition shadow-lg">
                        Start Your Journey →
                    </a>

                    <a href="https://www.upmentorx.com" target="_blank"
                       class="inline-flex items-center px-8 py-4 border-2 border-primary text-primary rounded-full font-bold hover:bg-primary hover:text-white transition">
                        Meet Avron Mentors →
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-4 bg-gold/10 rounded-[3rem] -rotate-3"></div>
                <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=1200"
                     alt="HiredNext Avron"
                     class="relative rounded-[2.5rem] shadow-2xl w-full h-[520px] object-cover">
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-primary text-white text-center relative overflow-hidden">
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>
    <div class="relative z-10">
        <h2 class="text-4xl md:text-5xl font-serif font-bold mb-8">
            Ready to level up your career?
        </h2>
        <p class="text-xl text-white/80 max-w-xl mx-auto mb-10">
            AI clarity, structured learning, and real mentorship — working together to move your career forward.
        </p>
        <a href="<?= base_url('contact') ?>"
           class="inline-block px-12 py-5 bg-accent rounded-full font-bold shadow-xl hover:bg-accent/90 transition">
            Start with Avron
        </a>
    </div>
</section>

<?= $this->endSection() ?>
