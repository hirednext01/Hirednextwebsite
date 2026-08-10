<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$posts = $blog_posts ?? [];
$categories = ['All'];
foreach ($posts as $item) {
    $category = trim((string)($item['category'] ?? '')) ?: 'Recruitment';
    if (!in_array($category, $categories, true)) {
        $categories[] = $category;
    }
}
$cleanText = static function ($value) {
    $text = html_entity_decode(strip_tags((string)$value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return trim((string)preg_replace('/\s+/u', ' ', $text));
};
$shorten = static function ($value, $limit = 180) use ($cleanText) {
    $text = $cleanText($value);
    if (strlen($text) <= $limit) {
        return $text;
    }
    $text = substr($text, 0, $limit + 1);
    $lastSpace = strrpos($text, ' ');
    return rtrim($lastSpace === false ? $text : substr($text, 0, $lastSpace), " \t\n\r\0\x0B,.;:-") . '…';
};
?>

<header class="insights-hero">
    <div class="insights-hero-orb insights-hero-orb-one"></div>
    <div class="insights-hero-orb insights-hero-orb-two"></div>
    <div class="insights-hero-inner">
        <nav class="insights-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= base_url('/') ?>">Home</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">Insights</span>
        </nav>
        <div class="insights-hero-grid">
            <div>
                <p class="editorial-kicker editorial-kicker-light"><span></span> HiredNext Intelligence</p>
                <h1>Recruitment intelligence for <em>better hiring decisions.</em></h1>
            </div>
            <div class="insights-hero-copy">
                <p>Direct, recruiter-led answers on executive search, leadership assessment, talent markets and the decisions that shape successful hiring in India.</p>
                <div class="insights-proofline">
                    <span><?= esc(count($posts)) ?> published insight<?= count($posts) === 1 ? '' : 's' ?></span>
                    <span>Written by hiring practitioners</span>
                    <span>Built for clarity, not jargon</span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="insights-index">
    <section class="insights-answer-band" aria-labelledby="what-you-will-find">
        <div>
            <p class="editorial-kicker"><span></span> The short answer</p>
            <h2 id="what-you-will-find">What will you find in HiredNext Insights?</h2>
        </div>
        <p>Practical guidance for employers hiring senior and specialist talent, and for professionals navigating important career decisions. Each article is structured to answer a real question quickly, then explain the reasoning, context and next action.</p>
    </section>

    <?php if (!empty($categories)): ?>
        <section class="insights-filter-shell" aria-label="Filter insights by topic">
            <div class="insights-filter-label">Browse by topic</div>
            <div class="insights-filters" role="group" aria-label="Insight topics">
                <?php foreach ($categories as $index => $category): ?>
                    <button type="button"
                        class="insights-filter<?= $index === 0 ? ' is-active' : '' ?>"
                        data-blog-filter="<?= esc($category, 'attr') ?>"
                        aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>">
                        <?= esc($category) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <section aria-labelledby="latest-insights">
        <div class="insights-section-heading">
            <div>
                <p class="editorial-kicker"><span></span> Latest analysis</p>
                <h2 id="latest-insights">Ideas you can use</h2>
            </div>
            <p id="insights-result-count" aria-live="polite"><?= esc(count($posts)) ?> article<?= count($posts) === 1 ? '' : 's' ?></p>
        </div>

        <?php if (!empty($posts)): ?>
            <div class="insights-grid" id="insights-grid">
                <?php foreach ($posts as $index => $post): ?>
                    <?php
                    $title = trim((string)($post['title'] ?? 'HiredNext insight'));
                    $slug = trim((string)($post['slug'] ?? ''));
                    $category = trim((string)($post['category'] ?? '')) ?: 'Recruitment';
                    $author = trim((string)($post['author_name'] ?? '')) ?: 'HiredNext Editorial';
                    if ($author === 'Metron Team') {
                        $author = 'HiredNext Editorial';
                    }
                    $excerpt = $shorten($post['excerpt'] ?? '');
                    if ($excerpt === '') {
                        $excerpt = $shorten($post['content'] ?? '');
                    }
                    $plainContent = $cleanText($post['content'] ?? '');
                    $wordCount = $plainContent === '' ? 0 : str_word_count($plainContent);
                    $readMinutes = max(1, (int)ceil($wordCount / 220));
                    $dateValue = $post['published_at'] ?? $post['created_at'] ?? null;
                    $dateLabel = !empty($dateValue) && strtotime((string)$dateValue) !== false ? date('M j, Y', strtotime((string)$dateValue)) : null;
                    $dateIso = !empty($dateValue) && strtotime((string)$dateValue) !== false ? date('Y-m-d', strtotime((string)$dateValue)) : null;
                    $image = trim((string)($post['featured_image'] ?? '')) ?: base_url('theme/assets/home.jpeg');
                    if (!preg_match('#^https?://#i', $image)) {
                        $image = base_url(ltrim($image, '/'));
                    }
                    ?>
                    <article class="insight-card<?= $index === 0 ? ' insight-card-featured' : '' ?>"
                        data-blog-card
                        data-category="<?= esc($category, 'attr') ?>">
                        <a class="insight-card-image" href="<?= base_url('blog/' . $slug) ?>" aria-label="Read <?= esc($title, 'attr') ?>">
                            <img src="<?= esc($image) ?>"
                                alt="<?= esc($title) ?>"
                                <?= $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
                                width="960" height="640">
                            <span><?= esc($category) ?></span>
                        </a>
                        <div class="insight-card-body">
                            <div class="insight-card-meta">
                                <?php if ($dateLabel): ?>
                                    <time datetime="<?= esc($dateIso, 'attr') ?>"><?= esc($dateLabel) ?></time>
                                    <span aria-hidden="true">•</span>
                                <?php endif; ?>
                                <span><?= esc($readMinutes) ?> min read</span>
                            </div>
                            <h2><a href="<?= base_url('blog/' . $slug) ?>"><?= esc($title) ?></a></h2>
                            <?php if ($excerpt !== ''): ?>
                                <p><?= esc($excerpt) ?></p>
                            <?php endif; ?>
                            <div class="insight-card-footer">
                                <span>By <?= esc($author) ?></span>
                                <a href="<?= base_url('blog/' . $slug) ?>">Read the full answer <span aria-hidden="true">→</span></a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="insights-empty" id="insights-empty" hidden>No published insights match this topic yet.</div>
        <?php else: ?>
            <div class="insights-empty">New recruiter-led insights are being prepared. Please check back soon.</div>
        <?php endif; ?>
    </section>

    <section class="insights-topic-map" aria-labelledby="topics-we-cover">
        <div class="insights-topic-intro">
            <p class="editorial-kicker editorial-kicker-light"><span></span> HiredNext expertise</p>
            <h2 id="topics-we-cover">Topics we cover with practitioner context</h2>
        </div>
        <div class="insights-topic-grid">
            <article>
                <span>01</span>
                <h3>Executive search</h3>
                <p>How confidential senior mandates are mapped, assessed and taken from market intelligence to a committed leadership hire.</p>
                <a href="<?= base_url('services/executive-search') ?>">Explore executive search</a>
            </article>
            <article>
                <span>02</span>
                <h3>Leadership decisions</h3>
                <p>How to evaluate scale, context, motivation and fit when a CV alone cannot show whether a leader will succeed.</p>
                <a href="<?= base_url('contact') ?>">Discuss a leadership mandate</a>
            </article>
            <article>
                <span>03</span>
                <h3>Talent-market intelligence</h3>
                <p>What candidate behaviour, competitor mapping and sector realities reveal before an organisation begins to hire.</p>
                <a href="<?= base_url('services') ?>">View recruitment services</a>
            </article>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filters = Array.from(document.querySelectorAll('[data-blog-filter]'));
    const cards = Array.from(document.querySelectorAll('[data-blog-card]'));
    const count = document.getElementById('insights-result-count');
    const empty = document.getElementById('insights-empty');

    filters.forEach(function (button) {
        button.addEventListener('click', function () {
            const category = button.dataset.blogFilter;
            let visible = 0;

            filters.forEach(function (item) {
                const active = item === button;
                item.classList.toggle('is-active', active);
                item.setAttribute('aria-pressed', active ? 'true' : 'false');
            });

            cards.forEach(function (card) {
                const show = category === 'All' || card.dataset.category === category;
                card.hidden = !show;
                card.classList.toggle('insight-card-featured', show && visible === 0);
                if (show) visible++;
            });

            if (count) count.textContent = visible + (visible === 1 ? ' article' : ' articles');
            if (empty) empty.hidden = visible !== 0;
        });
    });
});
</script>
<?= $this->endSection() ?>
