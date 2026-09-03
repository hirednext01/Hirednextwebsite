<div class="max-w-[1040px] mx-auto px-4 sm:px-8">
    <div class="text-center max-w-3xl mx-auto mb-10">
        <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Start here</div>
        <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary">Two simple ways to begin.</h2>
        <p class="text-gray-600 mt-4">Start with an assessment, or ask HiredNext to rebuild the CV for you.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <article class="rounded-[1.75rem] border-2 border-accent bg-white p-8 shadow-sm">
            <div class="text-sm font-black text-accent">₹599 · PRIORITY</div>
            <h3 class="text-3xl font-serif font-bold text-primary mt-2">Get Your CV Assessed</h3>
            <p class="text-gray-600 mt-4 leading-relaxed">A detailed HiredNext recruiter assessment covering ATS readiness, positioning, evidence gaps, shortlisting risks and the changes that matter most.</p>
            <a href="<?= base_url('services/cv-assessment') ?>" class="mt-6 inline-flex rounded-full bg-accent px-6 py-3 font-black text-white">Get assessed →</a>
            <div class="mt-6"><?= view('pages/services/_candidate-success', ['successKey' => 'assessment']) ?></div>
        </article>

        <article class="rounded-[1.75rem] border-2 border-primary bg-white p-8 shadow-sm">
            <div class="text-sm font-black text-accent">₹1,799 · DONE FOR YOU</div>
            <h3 class="text-3xl font-serif font-bold text-primary mt-2">Get a New CV Made</h3>
            <p class="text-gray-600 mt-4 leading-relaxed">HiredNext assesses your current CV, rebuilds the content and positioning, and creates two finished CV variants with two revision rounds.</p>
            <a href="<?= base_url('career-services/start/rebuild_1799') ?>" class="mt-6 inline-flex rounded-full bg-primary px-6 py-3 font-black text-white">Get a new CV made →</a>
            <div class="mt-6"><?= view('pages/services/_candidate-success', ['successKey' => 'rebuild']) ?></div>
        </article>
    </div>

    <div class="mt-12 mb-6">
        <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-2">More ways HiredNext can help</div>
        <h2 class="text-2xl md:text-3xl font-serif font-bold text-primary">Choose only if this is the problem you need solved.</h2>
    </div>

    <div class="grid lg:grid-cols-3 gap-5 items-stretch">
        <article class="rounded-[1.5rem] border border-gray-200 bg-white p-6 shadow-sm flex flex-col">
            <div class="text-sm font-black text-accent">₹999</div>
            <h3 class="text-2xl font-serif font-bold text-primary mt-2">ATS CV Optimisation</h3>
            <p class="text-sm text-gray-600 mt-3 leading-relaxed">For a CV that is fundamentally sound but needs stronger ATS structure, keywords, role language and recruiter scanability. Includes one revision round.</p>
            <a href="<?= base_url('career-services/start/ats_999') ?>" class="mt-5 inline-flex text-sm font-black text-primary hover:text-accent">Start ATS optimisation →</a>
            <div class="mt-auto pt-6"><?= view('pages/services/_candidate-success', ['successKey' => 'ats']) ?></div>
        </article>

        <article class="rounded-[1.5rem] border border-gray-200 bg-white p-6 shadow-sm flex flex-col">
            <div class="text-sm font-black text-accent">₹4,500 · 60 MINUTES</div>
            <h3 class="text-2xl font-serif font-bold text-primary mt-2">1:1 Career Strategy Consultation</h3>
            <p class="text-sm text-gray-600 mt-3 leading-relaxed">One focused session covering interview preparation, resume review and salary benchmarking for your level, function and target move.</p>
            <a href="<?= base_url('career-services/start/career_4500') ?>" class="mt-5 inline-flex text-sm font-black text-primary hover:text-accent">Book the 60-minute consultation →</a>
            <div class="mt-auto pt-6"><?= view('pages/services/_candidate-success', ['successKey' => 'strategy']) ?></div>
        </article>

        <article class="rounded-[1.5rem] border border-primary bg-white p-6 shadow-sm flex flex-col">
            <div class="text-sm font-black text-accent">PRICE ON REQUEST</div>
            <h3 class="text-2xl font-serif font-bold text-primary mt-2">C-Suite Executive CV Advisory</h3>
            <p class="text-sm text-gray-600 mt-3 leading-relaxed">Bespoke CXO/board service with a 1-to-1 positioning call and specialist executive resume expert.</p>
            <a href="<?= base_url('advisory') ?>" class="mt-5 inline-flex text-sm font-black text-primary hover:text-accent">Request executive advisory →</a>
            <div class="mt-auto pt-6 rounded-2xl border border-gray-200 bg-gray-50 p-4">
                <div class="flex gap-3 items-start">
                    <div class="w-11 h-11 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 font-black text-sm">CXO</div>
                    <div>
                        <div class="text-[10px] font-black uppercase tracking-[0.16em] text-accent">Anonymised executive outcome</div>
                        <p class="text-sm text-gray-700 leading-relaxed mt-2">“My experience was strong, but the CV positioned me one level below my actual scope. The advisory rebuilt the story around scale, commercial ownership and transformation impact before senior-level conversations.”</p>
                        <div class="text-xs font-black text-primary mt-3">Business Unit Head <span class="font-normal text-gray-400">· Manufacturing</span></div>
                        <div class="text-[10px] text-gray-400 mt-2">Outcome anonymised; individual results vary.</div>
                    </div>
                </div>
            </div>
        </article>
    </div>

    <p class="text-xs text-gray-500 text-center mt-6">Paid career services improve positioning and document quality; they do not guarantee interviews, hiring or placement.</p>
</div>