<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="min-h-screen bg-gray-50 pb-24">
    <header class="relative pt-44 pb-24 overflow-hidden bg-primary text-white">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-30"></div>
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-accent/10 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] bg-gold/5 blur-[120px] rounded-full"></div>

        <div class="max-w-[1440px] mx-auto px-6 sm:px-12 relative z-20 text-center">
            <span class="inline-block px-5 py-2 bg-accent/20 text-accent font-black text-[10px] uppercase tracking-[0.3em] rounded-full mb-8 border border-accent/20">
                Press Coverage
            </span>
            <h1 class="text-5xl md:text-7xl font-black font-serif mb-6 leading-[1.1]">
                Press & <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-gold">Media</span>
            </h1>
            <p class="text-lg md:text-xl text-white/60 max-w-2xl mx-auto leading-relaxed">
                Highlights, mentions, and media stories featuring HiredNext.
            </p>
        </div>
    </header>

    <section class="max-w-[1440px] mx-auto px-6 sm:px-12 -mt-10 relative z-30">
        <?php $items = $press_media_items ?? []; ?>
        <?php if (!empty($items)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($items as $item): ?>
                    <article class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                        <?php if (!empty($item['image_url'])): ?>
                            <a href="<?= esc($item['media_link']) ?>" target="_blank" rel="noopener noreferrer" class="block">
                                <div class="aspect-[16/10] bg-gray-100 p-4 flex items-center justify-center border-b border-gray-100">
                                    <img
                                        src="<?= esc($item['image_url']) ?>"
                                        alt="Press & Media"
                                        loading="lazy"
                                        class="max-w-full max-h-full object-contain transition-transform duration-500 hover:scale-[1.02]"
                                        onerror="this.style.display='none'; this.parentElement.classList.add('hidden');"
                                    >
                                </div>
                            </a>
                        <?php endif; ?>

                        <div class="p-6 flex flex-col flex-1">
                            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                                <?= esc($item['description'] ?? '') ?>
                            </p>

                            <a href="<?= esc($item['media_link']) ?>" target="_blank" rel="noopener noreferrer" class="mt-auto inline-flex items-center text-primary font-black text-[10px] uppercase tracking-[0.2em] hover:text-accent transition-colors">
                                Open Story
                                <span class="ml-3">→</span>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-3xl border border-gray-100 p-12 text-center text-gray-500">
                Press & Media items will appear here once available.
            </div>
        <?php endif; ?>
    </section>
</div>
<?= $this->endSection() ?>
