<div class="max-w-[1040px] mx-auto px-4 sm:px-8">
    <div class="text-center max-w-3xl mx-auto mb-10">
        <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Start here</div>
        <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary">Find the gaps. Or get the rewrite done.</h2>
        <p class="text-gray-600 mt-4">Start with the assessment when you want clarity. Choose the rebuild when you want a finished CV.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <article class="rounded-[1.75rem] border-2 border-accent bg-white p-8 shadow-sm">
            <div class="text-sm font-black text-accent">₹599 · GST INCLUDED · START WITH CLARITY</div>
            <h3 class="text-3xl font-serif font-bold text-primary mt-2">Get Your CV Assessed</h3>
            <p class="text-gray-600 mt-4 leading-relaxed">See what your CV may be failing to show for the role you want. Get a written assessment of its positioning, readability and evidence, with corrections in priority order.</p>
            <a href="<?= base_url('services/cv-assessment') ?>" class="mt-6 inline-flex rounded-full bg-accent px-6 py-3 font-black text-white">Get My CV Assessed — ₹599</a>
            <p class="mt-5 text-sm text-gray-600">Written report by email · 12 hours after payment verification · No full rewrite included</p>
        </article>

        <article class="rounded-[1.75rem] border-2 border-primary bg-white p-8 shadow-sm">
            <div class="text-sm font-black text-accent">₹1,799 · GST INCLUDED · DONE FOR YOU</div>
            <h3 class="text-3xl font-serif font-bold text-primary mt-2">Get Your CV Rebuilt</h3>
            <p class="text-gray-600 mt-4 leading-relaxed">HiredNext assesses your current CV, rebuilds the content and positioning, and creates two finished CV variants with two revision rounds.</p>
            <a href="<?= base_url('career-services/start/rebuild_1799') ?>" class="mt-6 inline-flex rounded-full bg-primary px-6 py-3 font-black text-white">Get My CV Rebuilt — ₹1,799</a>
            <p class="mt-5 text-sm text-gray-600">Assessment included · Two CV variants · Two revision rounds</p>
        </article>
    </div>
    <p class="mt-6 text-center text-sm font-semibold text-primary">You do not have to buy both. The rebuild already includes an assessment.</p>

    <article class="mt-8 rounded-[1.75rem] bg-primary text-white p-8 md:p-10 shadow-lg grid lg:grid-cols-[1.45fr_.75fr] gap-8 items-center">
        <div><div class="text-xs font-black text-gold uppercase tracking-[0.22em]">Senior leaders · ₹6,999 including GST</div><h3 class="text-3xl md:text-4xl font-serif font-bold mt-3">Executive CV & Leadership Case Study</h3><p class="text-white/80 mt-4 leading-relaxed">A senior career is more than a chronology. HiredNext analyses your mandates, progression, scale, decisions and evidence, then architects the story into an executive CV and one signature leadership case study.</p><p class="text-sm text-white/65 mt-4">Human reviewed · evidence constrained · 5–7 working days after complete inputs · two revision rounds</p></div>
        <div class="lg:text-right"><a href="<?= base_url('services/executive-cv') ?>" class="inline-flex justify-center rounded-full bg-accent px-7 py-4 font-black text-white">Explore Executive CV — ₹6,999</a></div>
    </article>

    <?php if (empty($primaryOnly)): ?>
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
            <div class="text-sm font-black text-accent">₹4,500 · 30 MINUTES</div>
            <h3 class="text-2xl font-serif font-bold text-primary mt-2">1:1 Interview Coaching with Taru</h3>
            <p class="text-sm text-gray-600 mt-3 leading-relaxed">Prepare for a specific interview with sharper positioning, likely interview themes, practical tips and company insights where sufficient information is available.</p>
            <a href="<?= base_url('career-services/start/career_4500') ?>" class="mt-5 inline-flex text-sm font-black text-primary hover:text-accent">Book private interview coaching →</a>
            <div class="mt-auto pt-6"><?= view('pages/services/_candidate-success', ['successKey' => 'strategy']) ?></div>
        </article>

        <article class="rounded-[1.5rem] border border-primary bg-white p-6 shadow-sm flex flex-col">
            <div class="text-sm font-black text-accent">₹6,999 · GST INCLUDED</div>
            <h3 class="text-2xl font-serif font-bold text-primary mt-2">Executive CV & Leadership Case Study</h3>
            <p class="text-sm text-gray-600 mt-3 leading-relaxed">Executive positioning, full CV architecture and one signature leadership case study built from verified career evidence.</p>
            <a href="<?= base_url('services/executive-cv') ?>" class="mt-5 inline-flex text-sm font-black text-primary hover:text-accent">Explore the executive journey →</a>
            <div class="mt-auto pt-6 rounded-2xl border border-gray-200 bg-gray-50 p-4">
                <div class="flex gap-3 items-start">
                    <div class="w-11 h-11 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 font-black text-sm">CXO</div>
                    <div>
                        <div class="text-[10px] font-black uppercase tracking-[0.16em] text-accent">Success story</div>
                        <p class="text-sm text-gray-700 leading-relaxed mt-2">“My experience was strong, but the CV positioned me one level below my actual scope. The advisory rebuilt the story around scale, commercial ownership and transformation impact before senior-level conversations.”</p>
                        <div class="text-xs font-black text-primary mt-3">Business Unit Head <span class="font-normal text-gray-400">· Manufacturing</span></div>
                        <div class="text-[10px] text-gray-400 mt-2">Stories are shared without identifying details to protect candidate privacy. Individual outcomes vary.</div>
                    </div>
                </div>
            </div>
        </article>
    </div>

    <?php endif; ?>
    <p class="text-xs text-gray-500 text-center mt-6">Paid career services address positioning and document quality; they do not guarantee interviews, hiring or placement.</p>
</div>
