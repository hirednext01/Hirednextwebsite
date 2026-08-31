<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="min-h-screen bg-gray-50 pt-32 pb-20">
    <div class="max-w-md mx-auto px-4">
        <div class="bg-white border border-gray-200 rounded-[2rem] p-8 shadow-sm">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">HiredNext Admin</div>
            <h1 class="text-3xl font-serif font-bold text-primary mb-3">CV Reviews</h1>
            <p class="text-sm text-gray-600 mb-7">Use your existing HiredNext website admin credentials.</p>

            <?php if (session('error')): ?>
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800"><?= esc(session('error')) ?></div>
            <?php endif; ?>

            <form action="<?= base_url('admin/cv-reviews/login') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-bold text-primary mb-1">Username</label>
                    <input name="username" required value="<?= esc(old('username')) ?>" class="w-full rounded-xl border border-gray-200 px-4 py-3" autocomplete="username">
                </div>
                <div>
                    <label class="block text-sm font-bold text-primary mb-1">Password</label>
                    <input type="password" name="password" required class="w-full rounded-xl border border-gray-200 px-4 py-3" autocomplete="current-password">
                </div>
                <button class="w-full rounded-xl bg-primary px-5 py-3.5 font-bold text-white hover:bg-accent transition">Sign in to CV Reviews</button>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
