<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-24 bg-primary text-white overflow-hidden">
    <div class="absolute -top-28 -right-24 w-96 h-96 bg-accent/15 rounded-full blur-3xl"></div>
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="max-w-4xl">
            <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-5">For Clients</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-6">Recruitment services built for serious hiring mandates.</h1>
            <p class="text-lg md:text-xl text-white/78 leading-relaxed max-w-3xl">HiredNext helps organizations identify, assess and hire leadership and specialist talent through executive search, permanent hiring, RPO and sector-led recruitment.</p>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid md:grid-cols-3 gap-6">
            <article class="rounded-[2rem] border border-gray-200 p-8 shadow-sm">
                <div class="text-accent text-xs font-black uppercase tracking-widest mb-3">Leadership</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">Executive Search</h2>
                <p class="text-gray-600 leading-relaxed mb-6">Confidential, research-led search for CXO, business leadership and hard-to-find senior talent.</p>
                <a href="<?= base_url('services/executive-search') ?>" class="font-bold text-primary hover:text-accent">Explore Executive Search →</a>
            </article>
            <article class="rounded-[2rem] border border-gray-200 p-8 shadow-sm">
                <div class="text-accent text-xs font-black uppercase tracking-widest mb-3">Scale</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">Permanent Hiring</h2>
                <p class="text-gray-600 leading-relaxed mb-6">Structured recruitment support for mid-senior and specialist roles where quality, fit and speed matter.</p>
                <a href="<?= base_url('services/permanent-hiring') ?>" class="font-bold text-primary hover:text-accent">Explore Permanent Hiring →</a>
            </article>
            <article class="rounded-[2rem] border border-gray-200 p-8 shadow-sm">
                <div class="text-accent text-xs font-black uppercase tracking-widest mb-3">Embedded Hiring</div>
                <h2 class="text-2xl font-serif font-bold text-primary mb-4">RPO Solutions</h2>
                <p class="text-gray-600 leading-relaxed mb-6">Flexible recruitment ownership for organizations that need a consistent hiring engine and stronger process control.</p>
                <a href="<?= base_url('services/rpo') ?>" class="font-bold text-primary hover:text-accent">Explore RPO →</a>
            </article>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <div>
                <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Industry Expertise</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-5">Recruitment shaped by sector context.</h2>
                <p class="text-gray-600 leading-relaxed">Our core recruitment work spans Garment & Textile, Retail, Hospitality, NBFC & Financial Services, Engineering, IT & Technology, Manufacturing and other growth sectors.</p>
            </div>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <a href="<?= base_url('industry/retail-executive-search') ?>" class="rounded-xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">Retail Executive Search</a>
                <a href="<?= base_url('industry/engineering-recruitment-firm') ?>" class="rounded-xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">Engineering Recruitment</a>
                <a href="<?= base_url('industry/it-recruitment-services-india') ?>" class="rounded-xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">IT Recruitment Services</a>
                <a href="<?= base_url('industry/bfsi-leadership-hiring') ?>" class="rounded-xl bg-white border border-gray-200 p-5 font-bold text-primary hover:border-accent">BFSI / NBFC Leadership Hiring</a>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-5">Hiring for a critical role?</h2>
        <p class="text-white/75 mb-8">Tell us the mandate, location and business context. We’ll discuss the right search approach.</p>
        <a href="https://calendly.com/tarushikha-hirednext/30min" target="_blank" rel="noopener noreferrer" class="inline-flex px-8 py-4 rounded-full bg-accent text-white font-bold">Book a 30-Min Call</a>
    </div>
</section>
<?= $this->endSection() ?>
