<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="pt-32 pb-16 bg-primary text-white"><div class="max-w-[1200px] mx-auto px-4 sm:px-8 lg:px-12"><p class="text-gold text-xs font-black uppercase tracking-[0.3em] mb-4">HiredNext Insights</p><h1 class="text-5xl md:text-6xl font-serif font-bold">Answers for hiring, careers and talent.</h1><p class="mt-5 max-w-2xl text-white/75 text-lg">Practical answers from recruitment experience, built to help candidates and hiring leaders make better decisions.</p></div></section>
<section class="py-20 bg-gray-50"><div class="max-w-[1200px] mx-auto px-4 sm:px-8 lg:px-12"><div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
<?php foreach ($insights as $item): ?>
<article class="bg-white border border-gray-100 rounded-3xl p-7 shadow-sm hover:shadow-xl transition"><div class="flex flex-wrap gap-2 text-[10px] font-black uppercase tracking-widest text-gray-500 mb-5"><?php foreach ([$item['industry'], $item['location'], $item['role']] as $tag): ?><?php if ($tag): ?><span class="px-3 py-1 rounded-full bg-gray-100"><?= esc($tag) ?></span><?php endif; ?><?php endforeach; ?></div><h2 class="text-2xl font-serif font-bold text-primary mb-3"><?= esc($item['title']) ?></h2><p class="text-gray-600 leading-relaxed mb-6"><?= esc($item['excerpt'] ?: $item['question']) ?></p><a href="<?= base_url('insights/' . $item['slug']) ?>" class="font-bold text-accent">Read the answer →</a></article>
<?php endforeach; ?>
</div><?php if (empty($insights)): ?><div class="bg-white rounded-3xl p-10 text-center text-gray-500">New HiredNext insights are coming soon.</div><?php endif; ?></div></section>
<?= $this->endSection() ?>
