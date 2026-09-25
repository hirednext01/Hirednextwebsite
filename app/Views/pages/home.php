<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="hero-home relative flex min-h-[680px] items-center overflow-hidden pb-16 pt-28 text-white">
    <div class="hero-overlay"></div><div class="hero-sheen"></div><div class="hero-noise"></div>
    <div class="relative z-10 mx-auto max-w-[1440px] px-4 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
        <div>
            <div class="mb-5 text-xs font-black uppercase tracking-[0.3em] text-gold">Executive recruitment and talent advisory</div>
            <h1 class="font-serif text-4xl font-bold leading-tight md:text-6xl lg:text-7xl">Leadership Hiring for Critical Roles</h1>
            <p class="mt-7 max-w-3xl text-lg leading-relaxed text-white/75 md:text-xl">HiredNext helps companies appoint CXOs, functional leaders and hard to find specialists through confidential search, permanent hiring, RPO and contract hiring support.</p>
            <a href="<?= base_url('hiring-discussion') ?>" class="mt-9 inline-flex rounded-2xl bg-accent px-9 py-4 text-base font-black text-white shadow-xl transition hover:bg-orange-600">Discuss a Hiring Mandate</a>
            <div class="mt-12 flex flex-wrap gap-6 text-xs uppercase tracking-[0.22em] text-white/65"><span>2016 founded</span><span>India wide</span><span>Leadership focus</span><span>Evidence led</span></div>
        </div>
        <div class="hidden lg:block">
            <div class="hero-panel rounded-[2.5rem] border border-white/10 p-10 shadow-2xl"><div class="mb-10 flex justify-between text-xs uppercase tracking-[0.3em] text-white/60"><span>Talent Intelligence</span><span class="text-accent">Search</span></div><div class="text-4xl font-bold">Evidence led</div><p class="mt-4 text-lg text-white/70">Recruiter led market mapping, assessment and search governance.</p><div class="mt-8 grid grid-cols-2 gap-6"><div><div class="text-xs uppercase tracking-widest text-white/60">Search</div><div class="mt-2 text-2xl font-bold">Mandate led</div></div><div><div class="text-xs uppercase tracking-widest text-white/60">Coverage</div><div class="mt-2 text-2xl font-bold">India wide</div></div></div></div>
            <div class="hero-card mt-8 rounded-[2rem] border border-white/80 bg-white p-8 text-primary"><div class="text-xs uppercase tracking-[0.3em] text-gray-500">Confidential by design</div><div class="mt-3 text-3xl font-bold">Selected Search Evidence</div></div>
        </div>
        </div>
    </div>
</section>

<section class="bg-white py-20">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-8 lg:px-12">
        <div class="max-w-3xl">
            <div class="mb-3 text-xs font-black uppercase tracking-[0.24em] text-accent">What employers appoint us to do</div>
            <h2 class="font-serif text-3xl font-bold text-primary md:text-5xl">One firm across critical search, permanent hiring and scalable recruitment delivery.</h2>
        </div>
        <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            <?php $employerServices = [
                ['01', 'Executive Search', 'Direct search for CXO, business and functional leadership appointments where context, discretion and judgment matter.', 'services/executive-search', 'Understand the search approach'],
                ['02', 'Confidential Search', 'Controlled market mapping and discreet outreach for sensitive replacements, succession decisions and unannounced capability builds.', 'mandate-stories', 'See anonymised mandate evidence'],
                ['03', 'Permanent Hiring', 'Industry aligned recruitment for mid senior and specialist roles, with structured screening and recruiter ownership through joining.', 'services/permanent-hiring', 'Explore permanent hiring'],
                ['04', 'RPO', 'Dedicated sourcing, screening and hiring coordination for organisations that need consistent recruitment capacity and governance.', 'services/rpo', 'Explore RPO'],
                ['05', 'Contract to Hire', 'A structured route for selected workforce requirements where capability must be assessed in role before a long term appointment.', 'hiring-discussion', 'Discuss workforce requirements'],
            ]; ?>
            <?php foreach ($employerServices as [$number, $title, $copy, $path, $label]): ?>
                <article class="rounded-3xl border border-gray-200 p-7">
                    <div class="mb-3 text-xs font-black uppercase tracking-widest text-accent"><?= esc($number) ?></div>
                    <h3 class="text-2xl font-bold text-primary"><?= esc($title) ?></h3>
                    <p class="mt-4 leading-relaxed text-gray-600"><?= esc($copy) ?></p>
                    <a href="<?= base_url($path) ?>" class="mt-6 inline-flex font-bold text-primary"><?= esc($label) ?> →</a>
                </article>
            <?php endforeach; ?>
            <article class="rounded-3xl bg-primary p-7 text-white">
                <div class="mb-3 text-xs font-black uppercase tracking-widest text-gold">Start here</div>
                <h3 class="text-2xl font-bold">A mandate deserves a clear search decision.</h3>
                <p class="mt-4 leading-relaxed text-white/70">Share the role, business context and hiring constraint. HiredNext will recommend the appropriate search model.</p>
                <a href="<?= base_url('hiring-discussion') ?>" class="mt-6 inline-flex rounded-full bg-accent px-6 py-3 font-black text-white">Discuss a Hiring Mandate</a>
            </article>
        </div>
    </div>
</section>

<section class="border-y border-gray-100 bg-gray-50 py-20">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-8 lg:px-12">
        <div class="grid gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-start">
            <div>
                <div class="mb-3 text-xs font-black uppercase tracking-[0.24em] text-accent">Where HiredNext works</div>
                <h2 class="font-serif text-3xl font-bold text-primary md:text-5xl">Sector context before candidate volume.</h2>
                <p class="mt-5 leading-relaxed text-gray-600">Search decisions improve when the recruiter understands the operating environment behind the title. HiredNext combines sector research with evidence led candidate assessment.</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <?php foreach ([
                    ['industry/garment-textile-recruitment-india', 'Textile, apparel and fashion'],
                    ['industry/it-recruitment-services-india', 'Technology and digital'],
                    ['industry/bfsi-leadership-hiring', 'BFSI and financial services'],
                    ['industry/global-capability-centres-hiring-india', 'Global Capability Centres'],
                    ['industry/semiconductor-recruitment-india', 'Semiconductors and deep tech'],
                    ['industry/manufacturing-recruitment-india', 'Manufacturing and engineering'],
                ] as [$path, $label]): ?>
                    <a href="<?= base_url($path) ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary transition hover:border-accent"><?= esc($label) ?> →</a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-20">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-8 lg:px-12">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl border border-gray-200 p-7 lg:col-span-2">
                <div class="mb-3 text-xs font-black uppercase tracking-[0.24em] text-accent">Search evidence</div>
                <h2 class="font-serif text-3xl font-bold text-primary">Confidentiality does not require vague claims.</h2>
                <p class="mt-4 max-w-3xl leading-relaxed text-gray-600">HiredNext publishes anonymised mandate stories that show the role context, recruitment judgment and verified outcome without exposing confidential client or candidate identities.</p>
                <a href="<?= base_url('mandate-stories') ?>" class="mt-6 inline-flex font-black text-primary">Review Mandate Stories →</a>
            </div>
            <div class="rounded-3xl border border-gray-200 p-7">
                <div class="mb-3 text-xs font-black uppercase tracking-[0.24em] text-accent">About HiredNext</div>
                <p class="leading-relaxed text-gray-600">Founded in Mumbai in 2016, HiredNext later moved its operating base to Gurugram (Gurgaon), Haryana. It is a remote first, India focused executive recruitment and talent advisory firm with no public walk-in office.</p>
                <a href="<?= base_url('about') ?>" class="mt-6 inline-flex font-black text-primary">About the firm →</a>
            </div>
        </div>
    </div>
</section>

<section class="bg-primary py-20 text-white">
    <div class="mx-auto max-w-[980px] px-4 text-center sm:px-8">
        <div class="mb-3 text-xs font-black uppercase tracking-[0.24em] text-gold">A considered first conversation</div>
        <h2 class="font-serif text-3xl font-bold md:text-5xl">What does the business need this appointment to change?</h2>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-relaxed text-white/70">Share the mandate, reporting context, location and the outcome expected from the hire.</p>
        <a href="<?= base_url('hiring-discussion') ?>" class="mt-8 inline-flex rounded-full bg-accent px-8 py-4 font-black text-white">Discuss a Hiring Mandate</a>
    </div>
</section>

<?= $this->endSection() ?>
