<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="relative bg-primary text-white pt-36 pb-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute -bottom-28 -left-28 w-96 h-96 rounded-full bg-gold blur-3xl"></div>
    </div>
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
        <div class="grid lg:grid-cols-[0.7fr_1.3fr] gap-12 items-center">
            <div>
                <div class="rounded-[2rem] overflow-hidden max-w-[340px] mx-auto lg:mx-0 bg-white/5 border border-white/10">
                    <img src="<?= base_url('theme/about.png') ?>" alt="Taru Shikha, Founder of HiredNext Recruitment" class="w-full h-auto">
                </div>
            </div>
            <div>
                <div class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-4">Founder profile</div>
                <h1 class="text-4xl md:text-5xl font-serif font-bold leading-tight mb-5">Taru Shikha</h1>
                <p class="text-xl text-white/85 mb-2">Founder, HiredNext Recruitment</p>
                <p class="text-base md:text-lg text-white/70 leading-relaxed max-w-3xl mb-7">
                    Recruitment practitioner focused on executive search, leadership hiring, skills-first assessment and the responsible use of AI in hiring. Her public commentary covers how technology can improve recruitment without replacing human judgement.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="<?= esc($founderLinkedIn) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex px-6 py-3 rounded-full bg-white text-primary font-bold text-sm">LinkedIn profile</a>
                    <a href="<?= base_url('press-media') ?>" class="inline-flex px-6 py-3 rounded-full border border-white/30 text-white font-bold text-sm">Press & Media</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid lg:grid-cols-2 gap-14">
            <div>
                <div class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-3">Areas of commentary</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-6">Recruitment, leadership and the changing world of work</h2>
                <p class="text-gray-600 leading-relaxed mb-5">
                    Taru’s perspective is rooted in day-to-day hiring decisions: defining the mandate, reading beyond keywords, assessing motivation and potential, and understanding when automation adds signal versus when a recruiter needs to step in.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    She comments on executive search, AI-assisted recruitment, skills-first hiring, candidate assessment, workforce restructuring, labour-market change and the practical realities of hiring across India.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <?php foreach (['Executive search', 'AI-assisted hiring', 'Skills-first recruitment', 'Talent assessment', 'Workforce transformation', 'Career and labour-market change'] as $topic): ?>
                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5 text-sm font-bold text-primary"><?= esc($topic) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-3xl mb-10">
            <div class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-3">Selected external coverage</div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-4">Media commentary and authored perspectives</h2>
            <p class="text-gray-600 leading-relaxed">Selected independently published stories and features in which Taru Shikha has contributed commentary or authorship.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            <?php foreach (($coverage ?? []) as $item): ?>
                <article class="bg-white border border-gray-200 rounded-2xl p-6">
                    <div class="flex flex-wrap items-center gap-2 text-[11px] uppercase tracking-[0.16em] font-black text-gray-500 mb-3">
                        <span><?= esc($item['outlet']) ?></span>
                        <?php if (!empty($item['published_at'])): ?><span>•</span><span><?= esc(date('M Y', strtotime($item['published_at']))) ?></span><?php endif; ?>
                    </div>
                    <h3 class="text-lg font-bold text-primary leading-snug mb-3"><?= esc($item['headline']) ?></h3>
                    <p class="text-sm text-gray-500 mb-4"><?= esc($item['topic']) ?></p>
                    <a href="<?= esc($item['url']) ?>" target="_blank" rel="noopener noreferrer external" class="text-sm font-bold text-accent">Read external coverage →</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-16 bg-primary text-white">
    <div class="max-w-[900px] mx-auto px-4 sm:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-4">About HiredNext</h2>
        <p class="text-white/75 leading-relaxed mb-7">HiredNext supports executive search, leadership hiring and specialist recruitment with a human-led, technology-enabled approach.</p>
        <a href="<?= base_url('about') ?>" class="inline-flex px-7 py-3 rounded-full bg-accent text-white font-bold">About HiredNext</a>
    </div>
</section>

<?= $this->endSection() ?>
