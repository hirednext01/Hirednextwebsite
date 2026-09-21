<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative overflow-hidden bg-primary pt-32 pb-24 text-white">
    <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-accent/15 blur-3xl"></div>
    <div class="relative z-10 mx-auto max-w-[1120px] px-4 sm:px-8">
        <div class="text-xs font-black uppercase tracking-[0.26em] text-gold">HiredNext Career Intelligence</div>
        <h1 class="mt-4 max-w-5xl font-serif text-4xl font-bold leading-tight md:text-6xl">CV evidence, LinkedIn positioning and senior-career visibility—explained from the recruiter side.</h1>
        <p class="mt-6 max-w-3xl text-lg leading-relaxed text-white/80">Practical guides for experienced professionals who want to understand how their career is being read, what a strong public narrative should communicate, and where AI can help without replacing judgement.</p>
        <div class="mt-6 text-sm text-white/55">Reviewed by Taru Shikha · Founder &amp; CEO, HiredNext Recruitment · Updated <?= esc(date('j F Y', strtotime((string)$updatedOn))) ?></div>
    </div>
</section>

<section class="bg-white py-16">
    <div class="mx-auto max-w-[1120px] px-4 sm:px-8">
        <div class="grid gap-5 md:grid-cols-2">
            <?php foreach ($items as $item): ?>
            <a href="<?= base_url($item['path']) ?>" class="group rounded-[1.6rem] border border-gray-200 bg-white p-7 transition hover:border-primary hover:shadow-lg">
                <div class="text-xs font-black uppercase tracking-[0.18em] text-accent"><?= esc($item['eyebrow']) ?></div>
                <h2 class="mt-3 font-serif text-2xl font-bold text-primary group-hover:text-accent"><?= esc($item['title']) ?></h2>
                <p class="mt-4 text-sm leading-relaxed text-gray-600"><?= esc($item['description']) ?></p>
                <div class="mt-5 text-sm font-black text-primary">Read the guide →</div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="bg-[#f6f0e7] py-16">
    <div class="mx-auto grid max-w-[1080px] gap-8 px-4 sm:px-8 lg:grid-cols-[1fr_.9fr] lg:items-center">
        <div>
            <div class="text-xs font-black uppercase tracking-[0.2em] text-accent">From insight to action</div>
            <h2 class="mt-3 font-serif text-3xl font-bold text-primary md:text-4xl">Know what is weak. Then decide whether you want to fix it yourself or ask us to do the work.</h2>
            <p class="mt-4 leading-relaxed text-gray-600">HiredNext offers a detailed CV assessment, managed CV rebuild, executive CV work, LinkedIn Leadership Positioning and interview coaching. The right service depends on the actual problem—not on pushing every professional into the same package.</p>
        </div>
        <div class="flex flex-col gap-3">
            <a href="<?= base_url('services/candidates') ?>" class="inline-flex justify-center rounded-full bg-primary px-7 py-4 font-black text-white">Explore Career Services</a>
            <a href="<?= base_url('services/linkedin-leadership-positioning') ?>" class="inline-flex justify-center rounded-full bg-accent px-7 py-4 font-black text-white">LinkedIn Leadership Positioning</a>
        </div>
    </div>
</section>

<section class="bg-white py-14">
    <div class="mx-auto max-w-[980px] px-4 text-sm leading-relaxed text-gray-500 sm:px-8">
        <strong class="text-primary">Editorial standard:</strong> HiredNext separates evidence from assumptions. Career claims should remain attributable and defensible. These guides explain recruiter-side reading patterns and service choices; they do not promise rankings, interviews, hiring or a specific level of LinkedIn reach.
    </div>
</section>
<?= $this->endSection() ?>
