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

<div class="min-h-screen bg-[#f7f8fa] pb-24">
    <header class="relative pt-44 pb-24 overflow-hidden bg-primary text-white">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-accent/10 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] bg-gold/5 blur-[120px] rounded-full"></div>

        <div class="max-w-[1440px] mx-auto px-6 sm:px-12 relative z-20">
            <div class="max-w-4xl">
                <span class="inline-flex items-center gap-2 px-5 py-2 bg-white/10 text-white font-black text-[10px] uppercase tracking-[0.3em] rounded-full mb-8 border border-white/15">
                    <span class="h-2 w-2 rounded-full bg-accent"></span>
                    Press &amp; Media
                </span>
                <h1 class="text-5xl md:text-7xl font-black font-serif mb-6 leading-[1.05]">
                    HiredNext in the <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-gold">Media</span>
                </h1>
                <p class="text-lg md:text-xl text-white/65 max-w-3xl leading-relaxed">
                    Verified coverage, interviews and expert commentary on recruitment, AI-assisted hiring, labour reform, skills and the changing world of work.
                </p>
            </div>

            <div class="mt-12 flex flex-wrap items-center gap-x-8 gap-y-4 text-sm text-white/70">
                <div><span class="text-3xl font-black text-white"><?= count($verifiedCoverage) ?></span> <span class="ml-2 uppercase tracking-[0.2em] text-[10px] font-bold">verified appearances</span></div>
                <div class="hidden sm:block h-8 w-px bg-white/15"></div>
                <div class="uppercase tracking-[0.2em] text-[10px] font-bold">National business, news &amp; workforce coverage</div>
            </div>
        </div>
    </header>

    <?php if (!empty($outlets)): ?>
        <section class="max-w-[1440px] mx-auto px-6 sm:px-12 -mt-8 relative z-30">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-xl px-6 py-5">
                <div class="text-[10px] uppercase tracking-[0.28em] font-black text-gray-400 mb-4">Featured across</div>
                <div class="flex flex-wrap gap-x-7 gap-y-3 items-center">
                    <?php foreach ($outlets as $outlet): ?>
                        <span class="text-primary font-black text-sm md:text-base tracking-tight"><?= esc($outlet) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="max-w-[1440px] mx-auto px-6 sm:px-12 pt-16">
        <?php if (!empty($items)): ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-7">
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
                    ?>
                    <article class="group bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col min-h-[420px]">
                        <?php if ($hasImage): ?>
                            <a href="<?= esc($mediaLink) ?>" target="_blank" rel="noopener noreferrer external" class="relative block bg-gray-100 border-b border-gray-100 overflow-hidden" aria-label="Open <?= esc($outlet) ?> coverage: <?= esc($headline) ?>">
                                <div class="aspect-[16/8] flex items-center justify-center bg-black/5">
                                    <img
                                        src="<?= esc($imageUrl) ?>"
                                        alt="<?= esc($outlet . ' coverage featuring HiredNext: ' . $headline) ?>"
                                        loading="lazy"
                                        class="w-full h-full <?= $mediaType === 'video' ? 'object-cover' : 'object-contain p-5' ?> transition-transform duration-500 group-hover:scale-[1.02]"
                                        onerror="this.closest('a').style.display='none';"
                                    >
                                </div>
                                <?php if ($mediaType === 'video'): ?>
                                    <span class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                                        <span class="w-16 h-16 rounded-full bg-white/95 text-primary shadow-xl flex items-center justify-center text-2xl pl-1">▶</span>
                                    </span>
                                    <span class="absolute left-5 bottom-5 rounded-full bg-black/70 text-white px-3 py-1.5 text-[10px] uppercase tracking-[0.18em] font-black">Video appearance</span>
                                <?php endif; ?>
                            </a>
                        <?php else: ?>
                            <div class="relative aspect-[16/6] bg-primary overflow-hidden border-b border-white/10 flex items-end p-7">
                                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_85%_20%,rgba(255,78,22,.8),transparent_32%)]"></div>
                                <div class="absolute right-6 top-5 text-[64px] leading-none font-serif text-white/5">HN</div>
                                <div class="relative z-10">
                                    <div class="text-[10px] uppercase tracking-[0.28em] text-accent font-black mb-2">Published by</div>
                                    <div class="text-2xl md:text-3xl text-white font-black tracking-tight"><?= esc($outlet) ?></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="p-7 md:p-8 flex flex-col flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-5">
                                <span class="inline-flex items-center rounded-full bg-accent/10 text-accent px-3 py-1.5 text-[10px] uppercase tracking-[0.2em] font-black"><?= esc($outlet) ?></span>
                                <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-500 px-3 py-1.5 text-[10px] uppercase tracking-[0.16em] font-bold"><?= esc($coverageType) ?></span>
                                <?php if ($mediaType === 'video'): ?><span class="inline-flex items-center rounded-full bg-primary/5 text-primary px-3 py-1.5 text-[10px] uppercase tracking-[0.16em] font-bold">Video</span><?php endif; ?>
                            </div>

                            <h2 class="text-2xl md:text-[1.7rem] leading-snug font-serif font-bold text-primary mb-4 group-hover:text-accent transition-colors">
                                <?= esc($headline) ?>
                            </h2>

                            <p class="text-gray-600 leading-relaxed mb-7">
                                <?= esc($topic) ?>
                            </p>

                            <div class="mt-auto flex items-center justify-between gap-5 pt-5 border-t border-gray-100">
                                <div class="text-[10px] uppercase tracking-[0.18em] font-bold text-gray-400">
                                    <?= $publishedAt !== '' ? esc(date('d M Y', strtotime($publishedAt))) : 'Verified source' ?>
                                </div>
                                <?php if ($mediaLink !== ''): ?>
                                    <a href="<?= esc($mediaLink) ?>" target="_blank" rel="noopener noreferrer external" class="inline-flex items-center gap-2 text-primary font-black text-[10px] uppercase tracking-[0.2em] hover:text-accent transition-colors">
                                        <?= $mediaType === 'video' ? 'Watch coverage' : 'Read coverage' ?> <span aria-hidden="true">↗</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-3xl border border-gray-100 p-12 text-center text-gray-500">
                Press &amp; Media items will appear here once available.
            </div>
        <?php endif; ?>
    </section>

    <section class="max-w-[1440px] mx-auto px-6 sm:px-12 pt-16">
        <div class="rounded-[2rem] bg-primary text-white px-7 py-8 md:px-10 md:py-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="text-[10px] uppercase tracking-[0.25em] text-accent font-black mb-3">Media enquiries</div>
                <h2 class="text-2xl md:text-3xl font-serif font-bold">Looking for a recruitment or workforce perspective?</h2>
                <p class="text-white/60 mt-2 max-w-2xl">HiredNext contributes practitioner commentary on hiring, executive search, AI in recruitment, skills and workforce change.</p>
            </div>
            <a href="<?= base_url('contact') ?>" class="shrink-0 inline-flex items-center justify-center rounded-xl bg-accent text-gray-900 px-6 py-3 font-black text-sm hover:opacity-90 transition">Contact HiredNext</a>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
