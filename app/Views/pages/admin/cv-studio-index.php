<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="min-h-screen bg-gray-50 pt-28 pb-20">
<div class="max-w-[1500px] mx-auto px-4 sm:px-8">
    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-5 mb-8">
        <div>
            <a href="<?= base_url('admin/cv-reviews') ?>" class="text-sm font-bold text-primary">← CV Assessment Pipeline</a>
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mt-4 mb-2">HiredNext Admin · Managed CV Creation</div>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-primary">CV Studio</h1>
            <p class="text-sm text-gray-500 mt-2 max-w-3xl">Candidates give HiredNext their existing CV. The writing panel extracts the facts, rewrites the career story, flags missing evidence, and creates the finished CV. Candidates do not populate templates themselves.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="<?= base_url('services/candidates') ?>" target="_blank" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-primary">Candidate Services ↗</a>
        </div>
    </div>

    <?php if (session('success')): ?><div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session('error')): ?><div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800"><?= esc(session('error')) ?></div><?php endif; ?>

    <?php if (!$studioReady): ?>
        <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-900"><strong>CV Studio database not installed yet.</strong> The existing CVs are safe. Run <code>php spark migrate</code> after deployment to activate document history.</div>
    <?php endif; ?>

    <div class="grid lg:grid-cols-12 gap-6 mb-8">
        <div class="lg:col-span-7 rounded-[1.75rem] bg-primary text-white p-7">
            <div class="text-xs font-black uppercase tracking-[0.22em] text-white/55">How this works</div>
            <h2 class="text-3xl font-serif font-bold mt-2">Upload once. HiredNext does the work.</h2>
            <div class="grid sm:grid-cols-4 gap-3 mt-6 text-xs">
                <?php foreach ([['1','Source CV','Existing CV already stored'],['2','Writer Panel','Independent AI drafting + checks'],['3','HiredNext Review','Facts and positioning reviewed'],['4','Final CV','Word draft delivered + revisions']] as $step): ?>
                    <div class="rounded-xl border border-white/15 bg-white/5 p-4"><div class="text-accent font-black text-lg"><?= esc($step[0]) ?></div><div class="font-black mt-1"><?= esc($step[1]) ?></div><div class="text-white/55 mt-1"><?= esc($step[2]) ?></div></div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="lg:col-span-5 rounded-[1.75rem] border border-gray-200 bg-white p-7">
            <div class="text-xs font-black uppercase tracking-[0.22em] text-gray-400">Writer agents</div>
            <h2 class="text-2xl font-serif font-bold text-primary mt-2">Server readiness</h2>
            <div class="grid grid-cols-3 gap-3 mt-5">
                <?php foreach (($writers ?? []) as $name => $configured): ?>
                    <div class="rounded-xl border border-gray-200 p-4 text-center"><div class="font-black text-primary text-xs"><?= esc(strtoupper($name)) ?></div><div class="text-[10px] mt-2 <?= $configured ? 'text-green-700' : 'text-gray-400' ?>"><?= $configured ? 'READY' : 'NOT CONFIGURED' ?></div></div>
                <?php endforeach; ?>
            </div>
            <p class="text-xs text-gray-500 mt-4">Provider names and technical details remain internal. Candidate-facing CVs contain no AI branding.</p>
        </div>
    </div>

    <div class="rounded-[1.5rem] border border-gray-200 bg-white overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-gray-100"><h2 class="text-2xl font-serif font-bold text-primary">Candidates</h2><p class="text-xs text-gray-500 mt-1">Open a record to create or review the new CV.</p></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1050px] text-left">
                <thead class="bg-primary text-white"><tr><th class="px-4 py-4 text-xs uppercase tracking-wider">Candidate</th><th class="px-4 py-4 text-xs uppercase tracking-wider">Source CV</th><th class="px-4 py-4 text-xs uppercase tracking-wider">Latest CV Studio status</th><th class="px-4 py-4 text-xs uppercase tracking-wider">Template</th><th class="px-4 py-4 text-xs uppercase tracking-wider">Open</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                <?php if (empty($leads)): ?><tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">No CV records found.</td></tr><?php endif; ?>
                <?php foreach (($leads ?? []) as $lead): $doc=$lead['latest_document'] ?? null; ?>
                    <tr class="hover:bg-gray-50/70">
                        <td class="px-4 py-5"><div class="font-black text-primary"><?= esc($lead['name'] ?? '') ?></div><div class="text-sm text-gray-500"><?= esc($lead['email'] ?? '') ?></div><div class="text-[11px] text-gray-400 mt-1">CV Review #<?= esc((string)($lead['id'] ?? '')) ?></div></td>
                        <td class="px-4 py-5"><span class="text-xs font-black <?= !empty($lead['resume_path']) ? 'text-green-700' : 'text-red-700' ?>"><?= !empty($lead['resume_path']) ? 'AVAILABLE' : 'MISSING' ?></span></td>
                        <td class="px-4 py-5"><span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-black text-gray-600"><?= esc(str_replace('_',' ', strtoupper($doc['status'] ?? 'NOT STARTED'))) ?></span><?php if ($doc): ?><div class="text-[11px] text-gray-400 mt-2"><?= esc($doc['updated_at'] ?? '') ?></div><?php endif; ?></td>
                        <td class="px-4 py-5 text-sm text-gray-600"><?= esc(str_replace('_',' ', strtoupper($doc['template_key'] ?? '—'))) ?></td>
                        <td class="px-4 py-5"><a href="<?= base_url('admin/cv-studio/' . (int)$lead['id']) ?>" class="inline-flex rounded-xl bg-primary px-4 py-2.5 text-xs font-black text-white">Open CV Studio →</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>
<?= $this->endSection() ?>
