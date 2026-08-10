<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<!-- ================= BLOG PAGE ================= -->
<div class="min-h-screen bg-gray-50 pb-32">

    <!-- Hero Section -->
    <header class="relative pt-48 pb-24 overflow-hidden bg-primary text-white">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-30"></div>
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-accent/10 blur-[120px] rounded-full animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] bg-gold/5 blur-[120px] rounded-full"></div>

        <div class="max-w-[1440px] mx-auto px-6 sm:px-12 relative z-20 text-center">
            <span class="inline-block px-5 py-2 bg-accent/20 text-accent font-black text-[10px] uppercase tracking-[0.3em] rounded-full mb-8 backdrop-blur-md border border-accent/20 animate-in fade-in duration-700">
                Industry Insights
            </span>
            <h1 class="text-5xl md:text-8xl font-black font-serif mb-8 leading-[1.1] animate-in slide-in-from-bottom-8 duration-700">
                Thoughts on <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-gold">Talent</span> & <span class="text-white">Tech</span>
            </h1>
            <p class="text-lg md:text-xl text-white/60 max-w-2xl mx-auto leading-relaxed animate-in fade-in duration-1000 delay-300">
                Navigating the future of global recruitment, leadership strategy, and technological transformation.
            </p>
        </div>
    </header>

    <!-- Filter Controls -->
    <div class="relative z-30 -mt-10 mb-16 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-[2rem] p-3 shadow-premium border border-gray-100 overflow-x-auto no-scrollbar">
                <div id="filterContainer" class="flex items-center gap-2 min-w-max" aria-label="Filter blog posts by category"></div>
            </div>
        </div>
    </div>

    <!-- Blog Grid -->
    <div class="max-w-[1440px] mx-auto px-6 sm:px-12">
        <div id="blogGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 min-h-[400px]" aria-live="polite"></div>
        <div id="pagination" class="mt-24 flex justify-center items-center space-x-3"></div>
    </div>
</div>

<!-- ================= DATA & LOGIC ================= -->
<script>
<?php
$blogData = [];
foreach (($blog_posts ?? []) as $post) {
    $excerpt = trim((string)($post['excerpt'] ?? ''));
    if ($excerpt === '' && !empty($post['content'])) {
        $plain = trim((string)preg_replace('/\s+/u', ' ', strip_tags((string)$post['content'])));
        $excerpt = mb_substr($plain, 0, 140) . (mb_strlen($plain) > 140 ? '...' : '');
    }

    $slug = trim((string)($post['slug'] ?? 'single')) ?: 'single';
    $category = trim((string)($post['category'] ?? '')) ?: 'General';
    $image = trim((string)($post['featured_image'] ?? $post['image'] ?? ''));
    if ($image === '') {
        $image = 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&q=80&w=800';
    }

    $blogData[] = [
        'id' => $post['id'] ?? null,
        'category' => $category,
        'title' => $post['title'] ?? 'Untitled',
        'excerpt' => $excerpt,
        'image' => $image,
        'readTime' => $post['read_time'] ?? $post['reading_time'] ?? '5 min',
        'link' => base_url('blog/' . $slug),
    ];
}
?>
const BLOG_DATA = <?= json_encode($blogData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

let currentFilter = 'All';
let currentPage = 1;
const postsPerPage = 6;

const blogGrid = document.getElementById('blogGrid');
const filterContainer = document.getElementById('filterContainer');
const paginationContainer = document.getElementById('pagination');

const normaliseCategory = (value) => {
    const category = String(value ?? '').replace(/\s+/g, ' ').trim();
    return category || 'General';
};

const escapeHtml = (value) => String(value ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');

BLOG_DATA.forEach(post => {
    post.category = normaliseCategory(post.category);
});

const categories = ['All', ...new Set(BLOG_DATA.map(post => post.category))];
const categoryCounts = BLOG_DATA.reduce((counts, post) => {
    counts[post.category] = (counts[post.category] || 0) + 1;
    return counts;
}, {});

function renderFilters() {
    filterContainer.innerHTML = categories.map((cat, index) => {
        const count = cat === 'All' ? BLOG_DATA.length : (categoryCounts[cat] || 0);
        return `
            <button type="button"
                    data-filter-index="${index}"
                    aria-pressed="${currentFilter === cat ? 'true' : 'false'}"
                    class="px-7 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap ${currentFilter === cat ? 'bg-primary text-white shadow-xl' : 'text-primary/60 hover:bg-gray-50 hover:text-primary'}">
                ${escapeHtml(cat)} <span class="ml-1.5 opacity-60">${count}</span>
            </button>
        `;
    }).join('');

    filterContainer.querySelectorAll('[data-filter-index]').forEach(button => {
        button.addEventListener('click', () => {
            const index = Number(button.dataset.filterIndex);
            if (Number.isInteger(index) && categories[index] !== undefined) {
                setFilter(categories[index]);
            }
        });
    });
}

function renderBlogs() {
    const filteredData = currentFilter === 'All'
        ? BLOG_DATA
        : BLOG_DATA.filter(post => normaliseCategory(post.category) === currentFilter);

    if (filteredData.length === 0) {
        blogGrid.innerHTML = `
            <div class="md:col-span-2 lg:col-span-3 bg-white rounded-[2rem] border border-gray-100 p-12 text-center shadow-sm">
                <h2 class="text-2xl font-serif font-black text-primary mb-3">More insights are being added</h2>
                <p class="text-gray-500">There are no published articles in this category yet. Choose another category to continue reading.</p>
            </div>
        `;
        paginationContainer.innerHTML = '';
        return;
    }

    const totalPages = Math.max(1, Math.ceil(filteredData.length / postsPerPage));
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    const start = (currentPage - 1) * postsPerPage;
    const paginatedData = filteredData.slice(start, start + postsPerPage);

    blogGrid.innerHTML = paginatedData.map(post => `
        <article class="group bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-premium hover:-translate-y-2 transition-all duration-500 flex flex-col h-full">
            <a href="${post.link}" class="block relative h-64 overflow-hidden">
                <img src="${escapeHtml(post.image)}" alt="${escapeHtml(post.title)}" loading="lazy" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                <div class="absolute top-6 left-6 z-20">
                    <span class="px-4 py-1.5 bg-white shadow-sm text-primary text-[10px] font-black rounded-lg uppercase tracking-widest border border-gray-100">
                        ${escapeHtml(post.category)}
                    </span>
                </div>
            </a>

            <div class="p-10 flex flex-col flex-grow">
                <div class="flex items-center text-[10px] text-gray-400 mb-6 font-black uppercase tracking-[0.2em] space-x-6">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-accent mr-3"></span>
                        HiredNext
                    </span>
                    <span class="flex items-center">
                        <i data-lucide="clock" class="w-3 h-3 mr-2 text-gray-300"></i>
                        ${escapeHtml(post.readTime)}
                    </span>
                </div>

                <h2 class="text-2xl font-black text-primary mb-6 group-hover:text-accent transition-colors font-serif leading-tight">
                    ${escapeHtml(post.title)}
                </h2>

                <p class="text-gray-500 text-sm mb-10 leading-relaxed line-clamp-3">
                    ${escapeHtml(post.excerpt)}
                </p>

                <a href="${post.link}" class="mt-auto pt-8 border-t border-gray-50 group/btn">
                    <span class="inline-flex items-center font-black text-[10px] uppercase tracking-[0.2em] text-primary group-hover/btn:text-accent transition-all group-hover/btn:translate-x-2">
                        Access Full Insight
                        <i data-lucide="arrow-right" class="ml-3 w-4 h-4 text-accent"></i>
                    </span>
                </a>
            </div>
        </article>
    `).join('');

    renderPagination(totalPages);

    if (window.lucide && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons();
    }
}

function renderPagination(totalPages) {
    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }

    let buttons = `
        <button type="button" data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''}
                class="w-12 h-12 rounded-2xl flex items-center justify-center border border-gray-100 text-primary hover:bg-primary hover:text-white transition-all disabled:opacity-30 disabled:pointer-events-none" aria-label="Previous page">
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </button>
    `;

    for (let i = 1; i <= totalPages; i++) {
        buttons += `
            <button type="button" data-page="${i}"
                    class="w-12 h-12 rounded-2xl text-sm font-black transition-all ${currentPage === i ? 'bg-primary text-white shadow-xl' : 'border border-gray-100 text-primary hover:bg-gray-50'}">
                ${i}
            </button>
        `;
    }

    buttons += `
        <button type="button" data-page="${currentPage + 1}" ${currentPage === totalPages ? 'disabled' : ''}
                class="w-12 h-12 rounded-2xl flex items-center justify-center border border-gray-100 text-primary hover:bg-primary hover:text-white transition-all disabled:opacity-30 disabled:pointer-events-none" aria-label="Next page">
            <i data-lucide="chevron-right" class="w-5 h-5"></i>
        </button>
    `;

    paginationContainer.innerHTML = buttons;
    paginationContainer.querySelectorAll('[data-page]').forEach(button => {
        button.addEventListener('click', () => setPage(Number(button.dataset.page)));
    });

    if (window.lucide && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons();
    }
}

function setFilter(category) {
    currentFilter = category === 'All' ? 'All' : normaliseCategory(category);
    currentPage = 1;
    renderFilters();
    renderBlogs();
}

function setPage(page) {
    if (!Number.isInteger(page) || page < 1) return;
    currentPage = page;
    renderBlogs();
    document.getElementById('filterContainer').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

renderFilters();
renderBlogs();
</script>
<?= $this->endSection() ?>