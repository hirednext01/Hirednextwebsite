<?php

// Keep capacity for three approved CV Rebuild stories. Future stories stay hidden
// until an approved image and attribution are available.
$testimonialCapacity = 3;
$testimonials = [
    [
        'published' => true,
        'name' => 'Firdaus Jahan',
        'label' => 'CV Rebuild feedback',
        'detail' => 'Shared on LinkedIn after her HiredNext CV rebuild.',
        'quote' => 'Years later, in a very different phase of my career, I went through a very thoughtful professional profile revision exercise with Taru Shikha and HiredNext Recruitment, and it made me realise how much of my leadership journey had gone unspoken. I feel far more confident in my CV now. I had never looked at the numbers behind my own work with this much clarity before: the scale, the impact, the actual weight of what I had been doing.',
    ],
    ['published' => false],
    ['published' => false],
];

$publishedTestimonials = array_values(array_filter(
    $testimonials,
    static fn (array $testimonial): bool => ($testimonial['published'] ?? false) === true,
));

if ($publishedTestimonials === []) {
    return;
}
?>

<section id="cv-rebuild-feedback" aria-labelledby="cv-rebuild-feedback-title" class="py-20 bg-[#f6f0e7]">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <p class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">CV Rebuild feedback</p>
            <h2 id="cv-rebuild-feedback-title" class="text-3xl md:text-5xl font-serif font-bold text-primary">A stronger CV makes the leadership in your career easier to see.</h2>
            <p class="text-gray-600 mt-4 leading-relaxed">The work is not about making a document look different. It is about surfacing the scale, decisions and impact that were already there.</p>
        </div>

        <div class="<?= count($publishedTestimonials) === 1 ? 'max-w-3xl mx-auto' : 'grid md:grid-cols-2 xl:grid-cols-3 gap-7' ?>">
            <?php foreach ($publishedTestimonials as $testimonial): ?>
                <article class="rounded-[1.75rem] overflow-hidden border border-primary/15 bg-white shadow-[0_18px_45px_rgba(21,50,74,0.10)]">
                    <div class="p-7 sm:p-9">
                        <div class="w-11 h-11 rounded-full bg-accent/10 text-accent flex items-center justify-center text-4xl font-serif leading-none" aria-hidden="true">“</div>
                        <blockquote class="mt-6 text-xl sm:text-2xl font-serif leading-relaxed text-primary">“<?= esc($testimonial['quote']) ?>”</blockquote>
                    </div>
                    <div class="p-6 sm:p-7 border-t border-primary/10 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.16em] text-accent"><?= esc($testimonial['label']) ?></p>
                            <h3 class="mt-2 text-2xl font-serif font-bold text-primary"><?= esc($testimonial['name']) ?></h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-600"><?= esc($testimonial['detail']) ?></p>
                        </div>
                        <a href="<?= base_url('career-services/start/rebuild_1799') ?>" class="shrink-0 inline-flex justify-center rounded-full bg-primary px-5 py-3 text-sm font-black text-white hover:bg-[#204e72]">Explore CV Rebuild</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
