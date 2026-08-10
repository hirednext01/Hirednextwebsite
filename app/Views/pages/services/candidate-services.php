<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-24 bg-primary text-white overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent/15 rounded-full blur-3xl"></div>
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="max-w-4xl">
            <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-5">For Candidates</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-6">Career support from people who understand how hiring decisions are made.</h1>
            <p class="text-lg md:text-xl text-white/78 leading-relaxed max-w-3xl">Improve your CV, sharpen how you present yourself and prepare for interviews with practical guidance grounded in real recruitment experience.</p>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
            <article class="rounded-[2rem] border border-gray-200 p-7 shadow-sm">
                <div class="text-sm font-black text-accent mb-2">FREE · 7–10 DAYS</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">CV Assessment</h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Understand the strengths, gaps and obvious shortlisting issues in your current CV.</p>
                <a href="<?= base_url('services/cv-assessment') ?>" class="font-bold text-primary hover:text-accent">Assess my CV →</a>
            </article>

            <article class="rounded-[2rem] border-2 border-accent p-7 shadow-sm">
                <div class="text-sm font-black text-accent mb-2">₹599 · 12 HOURS</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">Priority CV Assessment</h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Get a faster, role-aware review before an application, recruiter conversation or interview.</p>
                <a href="<?= base_url('services/cv-assessment') ?>#assessment-form" class="font-bold text-primary hover:text-accent">Get priority review →</a>
            </article>

            <article class="rounded-[2rem] border border-gray-200 p-7 shadow-sm">
                <div class="text-sm font-black text-accent mb-2">₹2,500</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">Get a New CV Made</h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">A recruiter-informed CV rebuild focused on clarity, stronger positioning and the information hiring teams look for.</p>
                <a href="<?= base_url('contact') ?>?service=cv-rebuild" class="font-bold text-primary hover:text-accent">Request a CV rebuild →</a>
            </article>

            <article class="rounded-[2rem] border border-gray-200 p-7 shadow-sm">
                <div class="text-sm font-black text-accent mb-2">₹12,500 · 60 MIN</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">Interview Strategy Session</h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Talk to an expert about your CV, target roles, how to talk about yourself and how to build an interview-ready strategy.</p>
                <a href="<?= base_url('contact') ?>?service=interview-strategy" class="font-bold text-primary hover:text-accent">Talk to an interview expert →</a>
            </article>
        </div>
        <p class="mt-7 text-xs text-gray-500">These services improve positioning and preparation; hiring and interview outcomes remain at the employer's discretion.</p>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center rounded-[2rem] border border-gray-200 bg-white p-7 md:p-10 shadow-sm">
            <div>
                <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Accelerate your career with intelligence & mentorship</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">HiredNext Avron</h2>
                <p class="text-gold text-lg italic mb-5">AI-powered career acceleration with real mentorship</p>
                <p class="text-gray-600 leading-relaxed mb-7">Avron is an intelligent career companion that combines AI-driven skill-gap analysis, personalized learning paths and expert mentorship delivered through the UpMentorX platform — helping candidates learn from professionals who have already walked the path.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="<?= base_url('services/avron') ?>" class="inline-flex px-7 py-3.5 rounded-full bg-primary text-white font-bold hover:bg-accent transition">Explore Avron →</a>
                    <a href="https://www.upmentorx.com" target="_blank" rel="noopener noreferrer" class="inline-flex px-7 py-3.5 rounded-full border-2 border-primary text-primary font-bold hover:bg-primary hover:text-white transition">Meet Your Mentors →</a>
                </div>
            </div>
            <div class="rounded-[2rem] bg-primary text-white p-8">
                <h3 class="text-2xl font-serif font-bold mb-5">What candidates can use Avron for</h3>
                <ul class="space-y-4 text-sm text-white/80">
                    <li>✓ Skill-gap analysis against career goals</li>
                    <li>✓ Personalized development pathways</li>
                    <li>✓ Expert mentorship through UpMentorX</li>
                    <li>✓ Career direction and learning support</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-5">Not sure which service fits you?</h2>
        <p class="text-white/75 mb-8">Start with the free CV assessment. We can identify whether you need a quick correction, a complete rebuild or deeper interview preparation.</p>
        <a href="<?= base_url('services/cv-assessment') ?>" class="inline-flex px-8 py-4 rounded-full bg-accent text-white font-bold">Start with a Free CV Assessment</a>
    </div>
</section>
<?= $this->endSection() ?>
