<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min';
$items = $testimonials ?? [];
$featuredProof = null;
foreach ($items as $candidate) {
    if (!empty($candidate['source_url'])) {
        $featuredProof = $candidate;
        break;
    }
}
?>
<!-- ================= HERO ================= -->
<header class="bg-primary text-white pt-32 pb-48 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>

    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-accent/20 rounded-full blur-[128px] -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gold/10 rounded-full blur-[128px] -ml-32 -mb-32"></div>

    <div class="max-w-[1440px] mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center relative z-10">
        <div>
            <span class="inline-block px-4 py-2 bg-white/10 rounded-full text-[10px] font-black tracking-[0.4em] uppercase mb-8 border border-white/10">
                External Reputation
            </span>

            <h1 class="text-5xl md:text-7xl font-serif font-bold leading-[1.05] mb-8">
                What People Say About <span class="text-gold italic">HiredNext</span><br>
                & <span class="text-accent">Taru Shikha</span>
            </h1>

            <p class="text-xl text-white/60 mb-12 max-w-xl leading-relaxed">
                Public LinkedIn recommendations, recruitment partnership endorsements and client/candidate feedback that reinforce HiredNext's approach to executive search, leadership hiring and human-led recruitment.
            </p>

            <div class="flex items-center gap-10 md:gap-12">
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-white mb-1">Public</div>
                    <div class="text-[10px] uppercase tracking-widest text-white/40">LinkedIn Proof</div>
                </div>
                <div class="w-px h-12 bg-white/10"></div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-white mb-1">External</div>
                    <div class="text-[10px] uppercase tracking-widest text-white/40">Endorsements</div>
                </div>
                <div class="w-px h-12 bg-white/10"></div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-white mb-1">Source</div>
                    <div class="text-[10px] uppercase tracking-widest text-white/40">Linked</div>
                </div>
            </div>
        </div>

        <div class="hidden lg:block relative">
            <div class="relative rounded-[3rem] overflow-hidden border-[8px] border-white/5 shadow-2xl">
                <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&q=80&w=1000" class="w-full object-cover" alt="Recruitment partnership and testimonial proof">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/95 to-primary/20"></div>
                <div class="absolute bottom-10 left-10 right-10">
                    <?php if ($featuredProof): ?>
                        <div class="text-[10px] uppercase tracking-[0.3em] text-gold font-black mb-4"><?= esc($featuredProof['source_label'] ?? 'External source') ?></div>
                        <p class="text-xl font-serif italic mb-5">“<?= esc($featuredProof['comment'] ?? '') ?>”</p>
                        <div class="text-sm font-bold text-white"><?= esc($featuredProof['client_name'] ?? $featuredProof['name'] ?? '') ?></div>
                        <div class="text-xs text-white/60 mt-1"><?= esc($featuredProof['proof_type'] ?? $featuredProof['project_type'] ?? 'External recommendation') ?></div>
                        <?php if (!empty($featuredProof['source_url'])): ?>
                            <a href="<?= esc($featuredProof['source_url']) ?>" target="_blank" rel="noopener noreferrer external" class="inline-flex mt-5 text-xs font-black uppercase tracking-widest text-accent">View public source →</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-[10px] uppercase tracking-[0.3em] text-gold font-black mb-4">Recruitment Reputation</div>
                        <p class="text-xl font-serif italic mb-4">Public proof matters more than unsupported marketing claims.</p>
                        <div class="text-sm text-white/70">HiredNext Recruitment</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ================= FILTER BAR ================= -->
<div class="sticky top-20 z-40 max-w-[1440px] mx-auto px-6 -mt-10">
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-6 shadow-xl border flex flex-wrap gap-3 justify-center">
        <?php
        $filters = ['All'];
        foreach ($items as $item) {
            $category = $item['proof_type'] ?? $item['industry'] ?? $item['category'] ?? $item['project_type'] ?? null;
            if ($category) {
                $filters[] = $category;
            }
        }
        $filters = array_values(array_unique($filters));
        ?>
        <?php foreach ($filters as $i => $filter): ?>
            <button class="filter-btn <?= $i === 0 ? 'active' : '' ?>" data-filter="<?= esc($filter) ?>"><?= esc($filter) ?></button>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .filter-btn {
        padding: 12px 24px;
        border-radius: 1rem;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .2em;
        border: 2px solid #f1f1f1;
        color: #777;
        transition: .3s
    }

    .filter-btn.active,
    .filter-btn:hover {
        background: #0c3466;
        color: #fff;
        border-color: #0c3466;
        transform: scale(1.05)
    }
</style>

<!-- ================= TESTIMONIAL GRID ================= -->
<section class="py-28 max-w-[1440px] mx-auto px-6">
    <div class="max-w-4xl mx-auto text-center mb-16 reveal reveal-up">
        <span class="text-accent font-black uppercase tracking-[0.3em] text-[10px]">Recruitment Reputation</span>
        <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mt-4 mb-6">Evidence from people, partners and professionals</h2>
        <p class="text-gray-600 text-lg leading-relaxed">The strongest proof is specific and traceable. Public recommendations link back to their original source; other testimonials remain the feedback submitted to HiredNext.</p>
    </div>

    <div id="testimonialGrid" class="columns-1 md:columns-2 xl:columns-3 gap-8 space-y-8">
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <?php
                $rating = (int)($item['rating'] ?? 0);
                $proofType = $item['proof_type'] ?? $item['industry'] ?? $item['category'] ?? $item['project_type'] ?? 'Recruitment Feedback';
                $headline = $item['headline'] ?? $item['title'] ?? $proofType;
                $quote = $item['review'] ?? $item['comment'] ?? $item['review_text'] ?? $item['content'] ?? $item['testimonial'] ?? $item['message'] ?? '';
                $name = $item['client_name'] ?? $item['name'] ?? 'Client';
                $role = $item['designation'] ?? $item['role'] ?? $item['client_position'] ?? $item['location'] ?? '';
                $company = $item['company'] ?? $item['organization'] ?? $item['client_company'] ?? $item['project_type'] ?? '';
                $industry = $proofType;
                $sourceLabel = trim((string)($item['source_label'] ?? ''));
                $sourceUrl = trim((string)($item['source_url'] ?? ''));
                ?>
                <div class="testimonial-card reveal break-inside-avoid bg-white border border-gray-100 rounded-[2.5rem] p-8 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group" data-industry="<?= esc($industry) ?>">
                    <div class="flex justify-between items-start gap-4 mb-6">
                        <?php if ($sourceUrl !== ''): ?>
                            <a href="<?= esc($sourceUrl) ?>" target="_blank" rel="noopener noreferrer external" class="px-3 py-1 bg-primary/5 rounded-full text-[10px] font-black uppercase tracking-widest text-primary hover:text-accent transition-colors">
                                <?= esc($sourceLabel ?: 'Public source') ?> ↗
                            </a>
                        <?php elseif ($rating > 0): ?>
                            <div class="flex gap-1 text-accent" aria-label="<?= esc((string)$rating) ?> out of 5 rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?><?= $i <= $rating ? '★' : '☆' ?><?php endfor; ?>
                            </div>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-gray-50 rounded-full text-[10px] font-black uppercase tracking-widest text-gray-400">Feedback</span>
                        <?php endif; ?>

                        <span class="px-3 py-1 bg-gray-50 rounded-full text-[10px] font-black uppercase tracking-widest text-gray-400 text-right"><?= esc($industry) ?></span>
                    </div>

                    <h3 class="text-lg font-bold text-primary mb-4 group-hover:text-accent transition-colors"><?= esc($headline) ?></h3>

                    <p class="text-base text-gray-600 leading-relaxed mb-8">“<?= esc($quote) ?>”</p>

                    <div class="flex items-center pt-6 border-t border-gray-100">
                        <div class="w-12 h-12 rounded-xl mr-4 bg-primary/10 text-primary flex items-center justify-center font-bold">
                            <?= esc(strtoupper(substr($name, 0, 1))) ?>
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-primary text-sm"><?= esc($name) ?></div>
                            <div class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1"><?= esc($role) ?><?= $company && $company !== $proofType ? ', ' : '' ?><?php if ($company && $company !== $proofType): ?><span class="text-accent"><?= esc($company) ?></span><?php endif; ?></div>
                            <?php if ($sourceUrl !== ''): ?>
                                <div class="text-[10px] text-gray-400 mt-2">Public external source linked above.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="testimonial-card break-inside-avoid bg-white border border-gray-100 rounded-[2.5rem] p-10 text-center text-gray-500">
                Testimonials will appear here once available.
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ================= CTA ================= -->
<section class="py-40 text-center">
    <h2 class="text-6xl md:text-8xl font-serif font-bold text-primary mb-12">
        Hiring a <span class="text-accent italic">critical role?</span>
    </h2>

    <p class="text-lg text-gray-500 max-w-2xl mx-auto mb-10">Speak directly with HiredNext about executive search, leadership hiring or a difficult specialist mandate in India.</p>

    <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-16 py-7 bg-primary text-white rounded-[2.5rem] font-black uppercase tracking-widest hover:bg-accent transition">
        Book a 30-Min Call →
    </a>
</section>

<script>
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter || 'All';
            document.querySelectorAll('.filter-btn').forEach(item => item.classList.remove('active'));
            button.classList.add('active');
            document.querySelectorAll('.testimonial-card').forEach(card => {
                const show = filter === 'All' || card.dataset.industry === filter;
                card.style.display = show ? '' : 'none';
            });
        });
    });
</script>

<?= $this->endSection() ?>
