<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<header class="relative bg-primary text-white pt-32 pb-16 overflow-hidden">
    <div class="absolute -top-28 -right-28 w-[480px] h-[480px] bg-accent/10 rounded-full blur-[110px]"></div>
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="max-w-4xl">
            <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-4"><?= esc($page['eyebrow']) ?></div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-5"><?= esc($page['title']) ?></h1>
            <p class="text-lg md:text-xl text-white/75 max-w-3xl leading-relaxed"><?= esc($page['intro']) ?></p>
        </div>
    </div>
</header>

<section class="py-16 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 grid lg:grid-cols-[1.2fr_.8fr] gap-10 items-start">
        <div>
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Roles HiredNext Can Support</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-6">Leadership and specialist search built around operating context</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <?php foreach ($page['roles'] as $role): ?>
                    <div class="rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 font-bold text-primary"><?= esc($role) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <aside class="rounded-[2rem] bg-primary text-white p-7 md:p-9">
            <div class="text-gold text-xs font-black uppercase tracking-[0.22em] mb-3">How the search works</div>
            <h2 class="text-2xl font-serif font-bold mb-5">Context before candidate volume.</h2>
            <ul class="space-y-4 text-sm text-white/80 leading-relaxed">
                <li><span class="text-gold font-black">01</span> Calibrate the mandate around business outcomes, role scope and non-negotiables.</li>
                <li><span class="text-gold font-black">02</span> Map direct and adjacent talent pools instead of relying only on applicants.</li>
                <li><span class="text-gold font-black">03</span> Assess evidence of ownership, scale, outcomes, motivation and constraints.</li>
                <li><span class="text-gold font-black">04</span> Manage shortlist calibration, interviews, offer alignment and joining risk.</li>
            </ul>
            <a href="<?= base_url('hiring-discussion') ?>" class="inline-flex mt-7 rounded-full bg-accent px-6 py-3 text-sm font-black text-white">Discuss a hiring mandate</a>
        </aside>
    </div>
</section>

<section class="py-14 bg-[#f7f8fa] border-y border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Related HiredNext search markets</div>
        <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-7">Executive search by city and specialist sector</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="<?= base_url('regions/executive-search-bangalore') ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary hover:border-accent">Executive Search Bangalore →</a>
            <a href="<?= base_url('regions/executive-search-gurgaon') ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary hover:border-accent">Executive Search Gurgaon & Delhi NCR →</a>
            <a href="<?= base_url('regions/executive-search-mumbai') ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary hover:border-accent">Executive Search Mumbai →</a>
            <a href="<?= base_url('regions/executive-search-chennai') ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary hover:border-accent">Executive Search Chennai →</a>
            <a href="<?= base_url('industry/global-capability-centres-hiring-india') ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary hover:border-accent">GCC Recruitment India →</a>
            <a href="<?= base_url('industry/semiconductor-recruitment-india') ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary hover:border-accent">Semiconductor Recruitment India →</a>
            <a href="<?= base_url('industry/manufacturing-recruitment-india') ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary hover:border-accent">Manufacturing Recruitment India →</a>
            <a href="<?= base_url('industry/retail-executive-search') ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary hover:border-accent">Retail Executive Search India →</a>
            <a href="<?= base_url('services/executive-search') ?>" class="rounded-2xl border border-gray-200 bg-white px-5 py-4 font-bold text-primary hover:border-accent">Executive Search Services India →</a>
        </div>
    </div>
</section>

<section class="py-16 bg-[#f7f8fa]">
    <div class="max-w-[980px] mx-auto px-4 sm:px-8">
        <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Frequently Asked Questions</div>
        <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-8">What employers ask before starting a search</h2>
        <div class="space-y-4">
            <?php foreach ($page['questions'] as $item): ?>
                <article class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h3 class="text-lg font-black text-primary mb-2"><?= esc($item['q']) ?></h3>
                    <p class="text-gray-600 leading-relaxed"><?= esc($item['a']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="rounded-[2rem] border border-gray-200 p-7 md:p-9 grid md:grid-cols-2 gap-8">
            <div>
                <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">HiredNext evidence</div>
                <h2 class="text-3xl font-serif font-bold text-primary mb-4">Inspect the search process and public evidence.</h2>
                <p class="text-gray-600 leading-relaxed">HiredNext publishes privacy-safe mandate stories, hiring intelligence, external media coverage and source-linked reputation signals so employers can evaluate the firm beyond marketing claims.</p>
            </div>
            <div class="grid gap-3 content-start">
                <a href="<?= base_url('mandate-stories') ?>" class="rounded-xl border border-gray-200 px-5 py-4 font-bold text-primary hover:border-accent">Mandate Stories & Search Evidence →</a>
                <a href="<?= base_url('hiring-intelligence') ?>" class="rounded-xl border border-gray-200 px-5 py-4 font-bold text-primary hover:border-accent">HiredNext Hiring Intelligence →</a>
                <a href="<?= base_url('press-media') ?>" class="rounded-xl border border-gray-200 px-5 py-4 font-bold text-primary hover:border-accent">Press & Media Evidence →</a>
                <a href="<?= base_url('authority/entity.json') ?>" class="rounded-xl border border-gray-200 px-5 py-4 font-bold text-primary hover:border-accent">Machine-readable HiredNext Entity →</a>
                <a href="<?= base_url('services/executive-search') ?>" class="rounded-xl border border-gray-200 px-5 py-4 font-bold text-primary hover:border-accent">Executive Search Services →</a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>