<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$items = $press_media_items ?? [];
$mediaConfig = config('MediaAuthority');
$verifiedCoverage = $mediaConfig->coverage ?? [];
$coverageByUrl = [];
$outlets = [];
$videoObjects = [];

foreach ($verifiedCoverage as $coverage) {
    $url = rtrim(strtolower(trim((string)($coverage['url'] ?? ''))), '/');
    if ($url !== '') {
        $coverageByUrl[$url] = $coverage;
    }
    if (!empty($coverage['outlet'])) {
        $outlets[] = $coverage['outlet'];
    }

    if (($coverage['media_type'] ?? '') === 'video' && !empty($coverage['thumbnail_url']) && !empty($coverage['url'])) {
        $video = [
            '@context' => 'https://schema.org',
            '@type' => 'VideoObject',
            'name' => $coverage['headline'] ?? 'HiredNext media appearance',
            'description' => $coverage['topic'] ?? 'HiredNext media appearance',
            'thumbnailUrl' => [$coverage['thumbnail_url']],
            'contentUrl' => $coverage['url'],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $coverage['outlet'] ?? 'Media publisher',
            ],
            'about' => [
                ['@id' => 'https://hirednext.net/#organization'],
                ['@id' => base_url('about/taru-shikha') . '#person'],
            ],
        ];
        if (!empty($coverage['embed_url'])) {
            $video['embedUrl'] = $coverage['embed_url'];
        }
        if (!empty($coverage['published_at'])) {
            $video['uploadDate'] = $coverage['published_at'];
        }
        $videoObjects[] = $video;
    }
}
$outlets = array_values(array_unique($outlets));
?>

<?php foreach ($videoObjects as $videoObject): ?>
    <script type="application/ld+json"><?= json_encode($videoObject, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
<?php endforeach; ?>

<style>
    .media-clamp-2,
    .media-clamp-3 {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .media-clamp-2 { -webkit-line-clamp: 2; }
    .media-clamp-3 { -webkit-line-clamp: 3; }
    .media-card { transform: translateY(0); }
    .media-card:hover { transform: translateY(-4px); }
    .media-card[hidden] { display: none !important; }
    .media-filter[aria-pressed="true"] {
        background: #071f3d;
        color: #fff;
        border-color: #071f3d;
        box-shadow: 0 8px 22px rgba(7,31,61,.12);
    }
    @media (prefers-reduced-motion: reduce) {
        .media-card,
        .media-card * { transition: none !important; transform: none !important; }
    }
</style>

<div class="min-h-screen bg-[#f7f8fa] pb-20">
    <header class="relative pt-36 pb-16 overflow-hidden bg-primary text-white">
        <div class="absolute inset-0 opacity-[0.08] bg-[radial-gradient(circle_at_78%_20%,rgba(255,107,61,.9),transparent_28%)]"></div>
        <div class="absolute left-0 right-0 bottom-0 h-px bg-white/10"></div>

        <div class="max-w-[1280px] mx-auto px-5 sm:px-8 lg:px-10 relative z-20">
            <div class="grid lg:grid-cols-[1fr_auto] gap-8 lg:items-end">
                <div class="max-w-4xl">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/[0.07] text-white font-black text-[10px] uppercase tracking-[0.28em] rounded-full mb-6 border border-white/10">
                        <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>
                        Press &amp; Media
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black font-serif mb-5 leading-[1.02] tracking-tight">
                        HiredNext in the <span class="text-accent">Media</span>
                    </h1>
                    <p class="text-base md:text-lg text-white/65 max-w-3xl leading-relaxed">
                        Interviews, expert commentary and verified coverage on recruitment, AI-assisted hiring, labour reform, skills and the changing world of work.
                    </p>
                </div>

                <div class="lg:text-right lg:pb-1">
                    <div class="text-4xl font-serif font-bold text-white"><?= count($verifiedCoverage) ?></div>
                    <div class="mt-1 text-[10px] uppercase tracking-[0.22em] font-black text-white/45">verified appearances</div>
                </div>
            </div>
        </div>
    </header>

    <?php if (!empty($outlets)): ?>
        <section class="max-w-[1280px] mx-auto px-5 sm:px-8 lg:px-10 -mt-5 relative z-30">
            <div class="bg-white/95 backdrop-blur rounded-2xl border border-gray-100 shadow-lg shadow-gray-200/40 px-5 py-4">
                <div class="flex items-center gap-5 overflow-x-auto" style="scrollbar-width:none;">
                    <div class="shrink-0 text-[9px] uppercase tracking-[0.24em] font-black text-gray-400">Featured across</div>
                    <div class="h-5 w-px bg-gray-200 shrink-0"></div>
                    <?php foreach ($outlets as $outlet): ?>
                        <span class="shrink-0 text-primary font-black text-sm tracking-tight whitespace-nowrap"><?= esc($outlet) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="max-w-[1280px] mx-auto px-5 sm:px-8 lg:px-10 pt-12">
        <?php if (!empty($items)): ?>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7">
                <div class="flex flex-wrap gap-2" role="group" aria-label="Filter media coverage">
                    <button type="button" class="media-filter rounded-full border border-gray-200 bg-white px-4 py-2 text-[10px] uppercase tracking-[0.17em] font-black text-gray-600 transition" data-filter="all" aria-pressed="true">All</button>
                    <button type="button" class="media-filter rounded-full border border-gray-200 bg-white px-4 py-2 text-[10px] uppercase tracking-[0.17em] font-black text-gray-600 transition" data-filter="article" aria-pressed="false">Articles</button>
                    <button type="button" class="media-filter rounded-full border border-gray-200 bg-white px-4 py-2 text-[10px] uppercase tracking-[0.17em] font-black text-gray-600 transition" data-filter="video" aria-pressed="false">Video</button>
                </div>

                <label class="relative block w-full md:w-72">
                    <span class="sr-only">Search media coverage</span>
                    <input id="media-search" type="search" placeholder="Search coverage" class="w-full rounded-full border border-gray-200 bg-white pl-4 pr-10 py-2.5 text-sm text-primary outline-none focus:border-accent transition">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" aria-hidden="true">⌕</span>
                </label>
            </div>

            <div id="media-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <?php foreach ($items as $index => $item): ?>
                    <?php
                    $mediaLink = trim((string)($item['media_link'] ?? ''));
                    $normalisedUrl = rtrim(strtolower($mediaLink), '/');
                    $verified = $coverageByUrl[$normalisedUrl] ?? null;
                    $outlet = trim((string)($verified['outlet'] ?? 'Media Coverage'));
                    $headline = trim((string)($verified['headline'] ?? $item['description'] ?? 'HiredNext media coverage'));
                    $topic = trim((string)($verified['topic'] ?? 'Recruitment & workforce'));
                    $coverageType = trim((string)($verified['coverage_type'] ?? 'Media coverage'));
                    $publishedAt = trim((string)($verified['published_at'] ?? ''));
                    $mediaType = trim((string)($verified['media_type'] ?? 'article'));
                    $verifiedThumbnail = trim((string)($verified['thumbnail_url'] ?? ''));
                    $itemImage = trim((string)($item['image_url'] ?? ''));
                    $imageUrl = $verifiedThumbnail !== '' ? $verifiedThumbnail : $itemImage;
                    $isGenericLogo = $imageUrl !== '' && str_contains(strtolower($imageUrl), 'theme/assets/logo.jpeg');
                    $hasImage = $imageUrl !== '' && !$isGenericLogo;
                    $searchText = strtolower(trim($outlet . ' ' . $headline . ' ' . $topic . ' ' . $coverageType));
                    ?>
                    <article
                        class="media-card group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/60 transition-all duration-300 overflow-hidden flex flex-col min-h-[365px]"
                        data-media-type="<?= esc($mediaType, 'attr') ?>"
                        data-search="<?= esc($searchText, 'attr') ?>"
                    >
                        <?php if ($hasImage): ?>
                            <a href="<?= esc($mediaLink) ?>" target="_blank" rel="noopener noreferrer external" class="relative block h-44 bg-gray-100 border-b border-gray-100 overflow-hidden" aria-label="Open <?= esc($outlet) ?> coverage: <?= esc($headline) ?>">
                                <img
                                    src="<?= esc($imageUrl) ?>"
                                    alt="<?= esc($outlet . ' coverage featuring HiredNext: ' . $headline) ?>"
                                    loading="lazy"
                                    class="w-full h-full <?= $mediaType === 'video' ? 'object-cover' : 'object-contain p-4' ?> transition-transform duration-500 group-hover:scale-[1.025]"
                                    onerror="this.closest('a').style.display='none';"
                                >
                                <?php if ($mediaType === 'video'): ?>
                                    <span class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                                        <span class="w-12 h-12 rounded-full bg-white/95 text-primary shadow-lg flex items-center justify-center text-base pl-0.5 transition-transform duration-300 group-hover:scale-105">▶</span>
                                    </span>
                                    <span class="absolute left-3 bottom-3 rounded-full bg-black/65 backdrop-blur text-white px-2.5 py-1 text-[9px] uppercase tracking-[0.15em] font-black">Video</span>
                                <?php endif; ?>
                            </a>
                        <?php else: ?>
                            <div class="relative h-36 bg-primary overflow-hidden border-b border-white/10 flex items-end p-5">
                                <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_82%_18%,rgba(255,107,61,.7),transparent_30%)]"></div>
                                <div class="absolute right-4 top-2 text-[54px] leading-none font-serif text-white/[0.035]">HN</div>
                                <div class="relative z-10">
                                    <div class="text-[9px] uppercase tracking-[0.24em] text-accent font-black mb-1.5">Published by</div>
                                    <div class="text-xl text-white font-black tracking-tight"><?= esc($outlet) ?></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="inline-flex items-center rounded-full bg-accent/[0.08] text-accent px-2.5 py-1 text-[9px] uppercase tracking-[0.16em] font-black"><?= esc($outlet) ?></span>
                                <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-500 px-2.5 py-1 text-[9px] uppercase tracking-[0.13em] font-bold"><?= esc($coverageType) ?></span>
                            </div>

                            <h2 class="media-clamp-3 text-[1.2rem] leading-[1.35] font-serif font-bold text-primary mb-3 group-hover:text-accent transition-colors">
                                <?= esc($headline) ?>
                            </h2>

                            <p class="media-clamp-2 text-sm text-gray-500 leading-relaxed mb-5">
                                <?= esc($topic) ?>
                            </p>

                            <div class="mt-auto flex items-center justify-between gap-4 pt-4 border-t border-gray-100">
                                <div class="text-[9px] uppercase tracking-[0.15em] font-bold text-gray-400 whitespace-nowrap">
                                    <?= $publishedAt !== '' ? esc(date('d M Y', strtotime($publishedAt))) : 'Verified source' ?>
                                </div>
                                <?php if ($mediaLink !== ''): ?>
                                    <a href="<?= esc($mediaLink) ?>" target="_blank" rel="noopener noreferrer external" class="inline-flex items-center gap-1.5 text-primary font-black text-[9px] uppercase tracking-[0.16em] hover:text-accent transition-colors whitespace-nowrap">
                                        <?= $mediaType === 'video' ? 'Watch' : 'Read' ?> <span class="transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5" aria-hidden="true">↗</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div id="media-empty" class="hidden rounded-2xl border border-dashed border-gray-200 bg-white p-10 text-center mt-5">
                <div class="font-serif font-bold text-xl text-primary mb-2">No matching coverage</div>
                <p class="text-sm text-gray-500">Try another search or switch back to All.</p>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-500">
                Press &amp; Media items will appear here once available.
            </div>
        <?php endif; ?>
    </section>

    <section class="max-w-[1280px] mx-auto px-5 sm:px-8 lg:px-10 pt-12">
        <div class="rounded-2xl bg-primary text-white px-6 py-7 md:px-8 md:py-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="text-[9px] uppercase tracking-[0.23em] text-accent font-black mb-2">Media enquiries</div>
                <h2 class="text-2xl font-serif font-bold">Looking for a recruitment or workforce perspective?</h2>
                <p class="text-white/55 text-sm mt-2 max-w-2xl">HiredNext contributes practitioner commentary on hiring, executive search, AI in recruitment, skills and workforce change.</p>
            </div>
            <a href="<?= base_url('contact') ?>" class="shrink-0 inline-flex items-center justify-center rounded-xl bg-accent text-gray-900 px-5 py-3 font-black text-sm hover:opacity-90 transition">Contact HiredNext</a>
        </div>
    </section>
</div>

<script>
(function () {
    const buttons = Array.from(document.querySelectorAll('.media-filter'));
    const cards = Array.from(document.querySelectorAll('.media-card'));
    const search = document.getElementById('media-search');
    const empty = document.getElementById('media-empty');
    if (!cards.length) return;

    let activeFilter = 'all';

    function applyFilters() {
        const query = (search?.value || '').trim().toLowerCase();
        let visible = 0;

        cards.forEach(function (card) {
            const typeMatches = activeFilter === 'all' || card.dataset.mediaType === activeFilter;
            const textMatches = !query || (card.dataset.search || '').includes(query);
            const show = typeMatches && textMatches;
            card.hidden = !show;
            if (show) visible += 1;
        });

        if (empty) empty.classList.toggle('hidden', visible !== 0);
    }

    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            activeFilter = button.dataset.filter || 'all';
            buttons.forEach(function (item) {
                item.setAttribute('aria-pressed', item === button ? 'true' : 'false');
            });
            applyFilters();
        });
    });

    search?.addEventListener('input', applyFilters);
})();
</script>

<?= $this->endSection() ?>
