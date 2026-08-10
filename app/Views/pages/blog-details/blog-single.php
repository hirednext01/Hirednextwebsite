<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$postTitle = $post['title'] ?? 'Blog Post';
$postCategory = $post['category'] ?? 'Recruitment';
$postTags = $post['tags'] ?? 'Insights';
$postAuthor = $post['author_name'] ?? 'HiredNext Editorial';
$postDate = !empty($post['published_at']) ? date('F j, Y', strtotime($post['published_at'])) : date('F j, Y');
$postReadTime = $post['read_time'] ?? $post['reading_time'] ?? '5 Min Read';
$postImage = $post['featured_image'] ?? $post['image'] ?? 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&q=80&w=1200';
$postExcerpt = $post['excerpt'] ?? '';
if (!$postExcerpt && !empty($post['content'])) {
    $postExcerpt = substr(strip_tags($post['content']), 0, 180) . '...';
}
$postExcerpt = trim(preg_replace('/\s+/', ' ', strip_tags($postExcerpt)));
$postContentRaw = $post['content'] ?? '';
$postContent = html_entity_decode($postContentRaw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$postContent = preg_replace('/<h1[^>]*>.*?<\/h1>/si', '', $postContent, 1);
$tagList = array_values(array_filter(array_map('trim', explode(',', (string)$postTags))));
$tagDisplay = !empty($tagList) ? array_slice($tagList, 0, 4) : ['Insights'];
?>
<!-- ================= HERO ================= -->
    <header class="article-hero">
        <div class="article-hero-inner">
            <div class="article-kicker">
                <span class="article-pill"><?= esc($postCategory) ?></span>
                <?php foreach ($tagDisplay as $tag): ?>
                    <span class="article-tag"><?= esc($tag) ?></span>
                <?php endforeach; ?>
            </div>

            <h1 class="article-title"><?= esc($postTitle) ?></h1>

            <div class="article-meta">
                <span class="article-meta-item"><?= esc($postAuthor) ?></span>
                <span class="article-meta-dot">•</span>
                <span class="article-meta-item"><?= esc($postDate) ?></span>
                <span class="article-meta-dot">•</span>
                <span class="article-meta-item"><?= esc($postReadTime) ?></span>
            </div>
        </div>
    </header>

    <!-- ================= ARTICLE CONTENT ================= -->
    <main class="article-body">
        <!-- Floating Back Button -->
        <div class="max-w-[1440px] mx-auto px-6 mb-10 relative z-20">
            <a href="<?= base_url('blog') ?>"
                class="inline-flex items-center text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-accent transition-all group">
                <div
                    class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center mr-4 group-hover:bg-accent group-hover:text-white transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                </div>
                Return to Insights
            </a>
        </div>

        <!-- Main Content -->
        <article class="article-shell">
            <!-- Featured Image -->
            <div class="article-feature">
                <img src="<?= esc($postImage) ?>" alt="<?= esc($postTitle) ?>">
            </div>

            <!-- Excerpt -->
            <?php if (!empty($postExcerpt)): ?>
                <p class="article-excerpt">
                    <?= esc($postExcerpt) ?>
                </p>
            <?php endif; ?>

            <!-- Body -->
            <div class="article-content">
                <?= $postContent ?>
            </div>

        </article>

    </main>

    <!-- ================= RELATED INSIGHTS ================= -->
    <section class="bg-gray-50 py-32">
        <div class="max-w-[1440px] mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
                <div>
                    <span class="text-accent text-xs font-black uppercase tracking-[0.4em] mb-4 block">Recommended</span>
                    <h2 class="text-4xl md:text-6xl font-serif font-black text-primary">Explore More <span
                            class="text-accent">Insights</span></h2>
                </div>
                <a href="<?= base_url('blog') ?>"
                    class="text-sm font-black uppercase tracking-widest text-primary border-b-2 border-accent pb-2 hover:text-accent transition-all">
                    View All articles
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">
                <?php $related = $related_posts ?? []; ?>
                <?php if (!empty($related)): ?>
                    <?php foreach ($related as $item): ?>
                        <?php
                        $relatedTitle = $item['title'] ?? 'Insight';
                        $relatedCategory = $item['category'] ?? 'General';
                        $relatedExcerpt = $item['excerpt'] ?? (isset($item['content']) ? substr(strip_tags($item['content']), 0, 140) . '...' : '');
                        $relatedImage = $item['featured_image'] ?? $item['image'] ?? 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&q=80&w=800';
                        $relatedSlug = $item['slug'] ?? '';
                        ?>
                        <article
                            class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-premium transition-all duration-500 flex flex-col">
                            <div class="relative h-64 overflow-hidden">
                                <img src="<?= esc($relatedImage) ?>"
                                    class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-1000 grayscale group-hover:grayscale-0">
                                <div class="absolute top-6 left-6">
                                    <span
                                        class="px-4 py-1.5 bg-white/90 backdrop-blur text-[10px] font-black uppercase tracking-widest rounded-full"><?= esc($relatedCategory) ?></span>
                                </div>
                            </div>
                            <div class="p-10 flex flex-col flex-grow">
                                <h3
                                    class="text-2xl font-serif font-black text-primary mb-6 group-hover:text-accent transition-colors leading-snug">
                                    <?= esc($relatedTitle) ?>
                                </h3>
                                <p class="text-gray-500 leading-relaxed mb-8 flex-grow">
                                    <?= esc($relatedExcerpt) ?>
                                </p>
                                <a href="<?= base_url('blog/' . $relatedSlug) ?>"
                                    class="inline-flex items-center text-xs font-black uppercase tracking-[0.2em] text-primary group-hover:text-accent transition-all">
                                    Read Insight <i data-lucide="arrow-right" class="ml-3 w-4 h-4"></i>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full bg-white rounded-[2.5rem] p-10 text-center text-gray-500">
                        More insights will appear here soon.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>


    <!-- ================= FOOTER ================= -->
<?= $this->endSection() ?>
