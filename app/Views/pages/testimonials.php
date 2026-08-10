<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $calendlyUrl = 'https://calendly.com/tarushikha-hirednext/30min'; ?>
<!-- ================= HERO ================= -->
    <header class="bg-primary text-white pt-32 pb-48 relative overflow-hidden">
        <div
            class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20">
        </div>

        <!-- Blobs -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-accent/20 rounded-full blur-[128px] -mr-32 -mt-32">
        </div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gold/10 rounded-full blur-[128px] -ml-32 -mb-32">
        </div>

        <div class="max-w-[1440px] mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <span
                    class="inline-block px-4 py-2 bg-white/10 rounded-full text-[10px] font-black tracking-[0.4em] uppercase mb-8 border border-white/10">
                    Trusted Globally
                </span>

                <h1 class="text-5xl md:text-7xl font-serif font-bold leading-[1.05] mb-8">
                    Voices of <span class="text-gold italic">Success.</span><br>
                    Stories of <span class="text-accent">Impact.</span>
                </h1>

                <p class="text-xl text-white/60 mb-12 max-w-lg leading-relaxed">
                    Partnering with forward-thinking organizations to build the leadership teams of tomorrow.
                </p>

                <div class="flex items-center gap-12">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-1">120+</div>
                        <div class="text-[10px] uppercase tracking-widest text-white/40">Partners</div>
                    </div>
                    <div class="w-px h-12 bg-white/10"></div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-1">98%</div>
                        <div class="text-[10px] uppercase tracking-widest text-white/40">Retention</div>
                    </div>
                    <div class="w-px h-12 bg-white/10"></div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-1">25+</div>
                        <div class="text-[10px] uppercase tracking-widest text-white/40">Industries</div>
                    </div>
                </div>
            </div>

            <div class="hidden lg:block relative">
                <div class="relative rounded-[3rem] overflow-hidden border-[8px] border-white/5 shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&q=80&w=1000"
                        class="w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/90 to-transparent"></div>
                    <div class="absolute bottom-10 left-10 right-10">
                        <div class="flex gap-1 text-gold mb-4">★★★★★</div>
                        <p class="text-xl font-serif italic mb-6">"HiredNext didn't just find us a candidate; they found
                            us a future CEO."</p>
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
            foreach (($testimonials ?? []) as $item) {
                $category = $item['industry'] ?? $item['category'] ?? null;
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
        <div id="testimonialGrid" class="columns-1 md:columns-2 xl:columns-3 gap-8 space-y-8">
            <?php $items = $testimonials ?? []; ?>
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <?php
                    $rating = (int)($item['rating'] ?? 5);
                    $headline = $item['headline'] ?? $item['title'] ?? 'Client Feedback';
                    $quote = $item['review'] ?? $item['comment'] ?? $item['content'] ?? $item['testimonial'] ?? $item['message'] ?? '';
                    $name = $item['name'] ?? 'Client';
                    $role = $item['designation'] ?? $item['role'] ?? $item['title'] ?? $item['location'] ?? '';
                    $company = $item['company'] ?? $item['organization'] ?? $item['project_type'] ?? '';
                    $industry = $item['industry'] ?? $item['category'] ?? $item['project_type'] ?? 'All';
                    $image = $item['image'] ?? $item['avatar'] ?? 'https://i.pravatar.cc/100?u=' . urlencode($name);
                    ?>
                    <div class="testimonial-card reveal break-inside-avoid bg-white border border-gray-100 rounded-[2.5rem] p-8 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group"
                        data-industry="<?= esc($industry) ?>">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex gap-1 text-accent">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?= $i <= $rating ? '★' : '☆' ?>
                                <?php endfor; ?>
                            </div>
                            <span
                                class="px-3 py-1 bg-gray-50 rounded-full text-[10px] font-black uppercase tracking-widest text-gray-400"><?= esc($industry) ?></span>
                        </div>

                        <h3 class="text-lg font-bold text-primary mb-4 group-hover:text-accent transition-colors">"<?= esc($headline) ?>"</h3>

                        <p class="text-base text-gray-600 leading-relaxed mb-8">
                            "<?= esc($quote) ?>"
                        </p>
                        <div class="flex items-center pt-6 border-t border-gray-100">
                            <div class="w-12 h-12 rounded-xl mr-4 bg-primary/10 text-primary flex items-center justify-center font-bold">
                                <?= esc(strtoupper(substr($name, 0, 1))) ?>
                            </div>
                            <div>
                                <div class="font-bold text-primary text-sm"><?= esc($name) ?></div>
                                <div class="text-xs text-gray-400 font-bold uppercase tracking-wider"><?= esc($role) ?><?= $company ? ', ' : '' ?><span
                                        class="text-accent"><?= esc($company) ?></span></div>
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
            Ready for your <span class="text-accent italic">Leadership Legacy?</span>
        </h2>

        <a href="<?= esc($calendlyUrl) ?>" target="_blank" rel="noopener noreferrer"
            class="inline-flex items-center px-16 py-7 bg-primary text-white rounded-[2.5rem] font-black uppercase tracking-widest hover:bg-accent transition">
            Book a 30-Min Call →
        </a>
    </section>

<?= $this->endSection() ?>
