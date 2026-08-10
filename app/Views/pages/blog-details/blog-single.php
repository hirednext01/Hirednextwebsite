<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$postTitle = trim((string)($post['title'] ?? 'HiredNext insight'));
$postCategory = trim((string)($post['category'] ?? '')) ?: 'Recruitment';
$postAuthor = $post_author ?? (trim((string)($post['author_name'] ?? '')) ?: 'HiredNext Editorial');
$postImage = $post_image ?? (trim((string)($post['featured_image'] ?? '')) ?: base_url('theme/assets/home.jpeg'));
$postExcerpt = trim((string)($post_excerpt ?? $post['excerpt'] ?? ''));
$postContent = $post_content ?? html_entity_decode((string)($post['content'] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
$postToc = $post_toc ?? [];
$postReadMinutes = max(1, (int)($post_read_minutes ?? 5));
$publishedValue = $post['published_at'] ?? $post['created_at'] ?? null;
$updatedValue = $post['updated_at'] ?? $publishedValue;
$publishedLabel = !empty($publishedValue) && strtotime((string)$publishedValue) !== false ? date('F j, Y', strtotime((string)$publishedValue)) : null;
$publishedIso = !empty($publishedValue) && strtotime((string)$publishedValue) !== false ? date(DATE_ATOM, strtotime((string)$publishedValue)) : null;
$updatedLabel = !empty($updatedValue) && strtotime((string)$updatedValue) !== false ? date('F j, Y', strtotime((string)$updatedValue)) : null;
$updatedIso = !empty($updatedValue) && strtotime((string)$updatedValue) !== false ? date(DATE_ATOM, strtotime((string)$updatedValue)) : null;
$tagList = array_values(array_unique(array_filter(array_map('trim', explode(',', (string)($post['tags'] ?? ''))))));
?>

<header class="article-hero article-hero-editorial">
    <div class="article-hero-inner">
        <nav class="article-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= base_url('/') ?>">Home</a>
            <span aria-hidden="true">/</span>
            <a href="<?= base_url('blog') ?>">Insights</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page"><?= esc($postCategory) ?></span>
        </nav>

        <div class="article-kicker">
            <span class="article-pill"><?= esc($postCategory) ?></span>
            <?php foreach (array_slice($tagList, 0, 3) as $tag): ?>
                <span class="article-tag"><?= esc($tag) ?></span>
            <?php endforeach; ?>
        </div>

        <h1 class="article-title"><?= esc($postTitle) ?></h1>

        <div class="article-meta">
            <span class="article-meta-item">By <?= esc($postAuthor) ?></span>
            <?php if ($publishedLabel): ?>
                <span class="article-meta-dot">•</span>
                <time class="article-meta-item" datetime="<?= esc($publishedIso, 'attr') ?>">Published <?= esc($publishedLabel) ?></time>
            <?php endif; ?>
            <span class="article-meta-dot">•</span>
            <span class="article-meta-item"><?= esc($postReadMinutes) ?> min read</span>
        </div>
    </div>
</header>

<div class="article-body article-body-editorial">
    <div class="article-return-row">
        <a href="<?= base_url('blog') ?>">
            <span aria-hidden="true">←</span> All HiredNext insights
        </a>
        <?php if ($updatedLabel): ?>
            <time datetime="<?= esc($updatedIso, 'attr') ?>">Last updated <?= esc($updatedLabel) ?></time>
        <?php endif; ?>
    </div>

    <article class="article-editorial-shell">
        <figure class="article-feature">
            <img src="<?= esc($postImage) ?>" alt="<?= esc($postTitle) ?>" width="1200" height="675" fetchpriority="high">
        </figure>

        <?php if ($postExcerpt !== ''): ?>
            <section class="answer-first" aria-labelledby="short-answer-heading">
                <span>The short answer</span>
                <h2 id="short-answer-heading">What you need to know</h2>
                <p><?= esc($postExcerpt) ?></p>
            </section>
        <?php endif; ?>

        <div class="article-reading-grid">
            <aside class="article-context-panel" aria-label="Article navigation and context">
                <?php if (count($postToc) >= 2): ?>
                    <nav class="article-toc" aria-labelledby="contents-heading">
                        <h2 id="contents-heading">In this insight</h2>
                        <ol>
                            <?php foreach ($postToc as $item): ?>
                                <li class="toc-level-<?= esc($item['level'], 'attr') ?>">
                                    <a href="#<?= esc($item['id'], 'attr') ?>"><?= esc($item['text']) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </nav>
                <?php endif; ?>

                <div class="article-author-note">
                    <span>Practitioner perspective</span>
                    <h2>About HiredNext Insights</h2>
                    <p>Our articles turn recruiter-led search experience into direct, usable guidance for employers and professionals. External facts and statistics should be linked to their original sources within the article.</p>
                    <a href="<?= base_url('about') ?>">About HiredNext</a>
                </div>
            </aside>

            <div class="article-content">
                <?= $postContent ?>

                <section class="article-next-step" aria-labelledby="apply-insight-heading">
                    <span>Put the insight to work</span>
                    <h2 id="apply-insight-heading">Making a business-critical hire?</h2>
                    <p>HiredNext supports confidential executive search, leadership hiring and hard-to-find specialist mandates with structured market mapping and assessment.</p>
                    <div>
                        <a href="<?= base_url('services/executive-search') ?>">Explore executive search</a>
                        <a href="<?= base_url('contact') ?>">Discuss a mandate</a>
                    </div>
                </section>
            </div>
        </div>
    </article>
</div>

<section class="related-insights" aria-labelledby="related-insights-heading">
    <div class="related-insights-inner">
        <div class="related-insights-heading">
            <div>
                <p class="editorial-kicker"><span></span> Continue reading</p>
                <h2 id="related-insights-heading">Related HiredNext insights</h2>
            </div>
            <a href="<?= base_url('blog') ?>">View all insights <span aria-hidden="true">→</span></a>
        </div>

        <?php $related = $related_posts ?? []; ?>
        <?php if (!empty($related)): ?>
            <div class="related-insights-grid">
                <?php foreach ($related as $item): ?>
                    <?php
                    $relatedTitle = trim((string)($item['title'] ?? 'HiredNext insight'));
                    $relatedCategory = trim((string)($item['category'] ?? '')) ?: 'Recruitment';
                    $relatedExcerpt = trim((string)($item['excerpt'] ?? ''));
                    if ($relatedExcerpt === '') {
                        $relatedExcerpt = trim((string)preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string)($item['content'] ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
                    }
                    if (strlen($relatedExcerpt) > 150) {
                        $relatedExcerpt = rtrim(substr($relatedExcerpt, 0, 147)) . '…';
                    }
                    $relatedImage = trim((string)($item['featured_image'] ?? '')) ?: base_url('theme/assets/home.jpeg');
                    if (!preg_match('#^https?://#i', $relatedImage)) {
                        $relatedImage = base_url(ltrim($relatedImage, '/'));
                    }
                    ?>
                    <article>
                        <a class="related-insight-image" href="<?= base_url('blog/' . ($item['slug'] ?? '')) ?>">
                            <img src="<?= esc($relatedImage) ?>" alt="<?= esc($relatedTitle) ?>" loading="lazy" width="800" height="520">
                            <span><?= esc($relatedCategory) ?></span>
                        </a>
                        <div>
                            <h3><a href="<?= base_url('blog/' . ($item['slug'] ?? '')) ?>"><?= esc($relatedTitle) ?></a></h3>
                            <?php if ($relatedExcerpt !== ''): ?><p><?= esc($relatedExcerpt) ?></p><?php endif; ?>
                            <a href="<?= base_url('blog/' . ($item['slug'] ?? '')) ?>">Read insight <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="related-insights-empty">More recruiter-led insights will appear here soon.</div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
