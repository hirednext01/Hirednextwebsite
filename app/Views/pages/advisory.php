<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    #navbar { background:#fff !important; box-shadow:0 8px 30px rgba(12,52,102,.08); padding-top:1rem !important; padding-bottom:1rem !important; }
    #navbar #logoText, #navbar .nav-link, #navbar #menuBtn { color:#0c3466 !important; }
</style>

<section class="relative pt-32 pb-24 bg-primary text-white overflow-hidden">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-4xl">
            <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-5">Leadership Advisory</div>
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-6">Your next leadership move should be designed, not guessed.</h1>
            <p class="text-lg md:text-xl text-white/75 max-w-3xl leading-relaxed">HiredNext combines recruiter judgement, market intelligence and evidence-led positioning to help experienced professionals understand where they stand, what the market can see and what must change next.</p>
            <div class="flex flex-wrap gap-3 mt-9">
                <a href="#career-intelligence" class="inline-flex items-center px-6 py-3.5 rounded-full bg-accent text-white font-bold hover:opacity-90 transition">Start with an assessment</a>
                <a href="#coaching" class="inline-flex items-center px-6 py-3.5 rounded-full border border-white/30 text-white font-bold hover:bg-white/10 transition">Request a senior coach</a>
            </div>
        </div>
    </div>
</section>

<section class="py-14 bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="border-l-2 border-accent pl-5">
                <div class="text-xs font-black uppercase tracking-[0.2em] text-accent mb-2">01 · Understand</div>
                <p class="text-primary font-semibold">Read the full career profile, not only the CV.</p>
            </div>
            <div class="border-l-2 border-gold pl-5">
                <div class="text-xs font-black uppercase tracking-[0.2em] text-accent mb-2">02 · Diagnose</div>
                <p class="text-primary font-semibold">Identify the gap between current position and target role.</p>
            </div>
            <div class="border-l-2 border-primary pl-5">
                <div class="text-xs font-black uppercase tracking-[0.2em] text-accent mb-2">03 · Activate</div>
                <p class="text-primary font-semibold">Choose only the intervention that is genuinely justified.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50" id="career-intelligence">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <?php if (session('success')): ?>
            <div class="mb-8 rounded-2xl border border-green-200 bg-green-50 px-6 py-5 text-green-900 font-semibold"><?= esc(session('success')) ?></div>
        <?php endif; ?>
        <?php if (session('error')): ?>
            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 px-6 py-5 text-red-900 font-semibold"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <div class="max-w-3xl mb-10">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">Flagship service</div>
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-5">Executive Career Intelligence Assessment</h2>
            <p class="text-lg text-gray-600 leading-relaxed">A confidential assessment for professionals preparing for a more senior, higher-value or strategically different career move.</p>
        </div>

        <div class="rounded-[2rem] border-2 border-accent bg-white p-7 md:p-10 shadow-[0_25px_70px_-35px_rgba(12,52,102,.45)]">
            <div class="grid lg:grid-cols-[1fr_0.42fr] gap-10 items-start">
                <div>
                    <p class="text-gray-600 leading-relaxed mb-6">We assess your career history, current market position, target direction, compensation, mobility, education, courses, CV, LinkedIn profile and leadership evidence as one connected profile.</p>
                    <div class="grid sm:grid-cols-2 gap-x-8 gap-y-3 text-sm text-gray-600">
                        <div>✓ Current CTC and expected CTC</div>
                        <div>✓ Current and preferred location</div>
                        <div>✓ Designation and department</div>
                        <div>✓ Notice period and joining readiness</div>
                        <div>✓ Education, college and courses</div>
                        <div>✓ CV and LinkedIn market read</div>
                        <div>✓ Target roles and companies</div>
                        <div>✓ Leadership, commercial and evidence gaps</div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <p class="text-sm text-gray-600 leading-relaxed">You receive a written market-position report, readiness perspective and a prioritised action plan. Recommendations are limited to the next justified intervention.</p>
                    </div>
                </div>
                <div class="rounded-2xl bg-primary text-white p-6">
                    <div class="text-[10px] uppercase tracking-[0.22em] text-white/55 font-black mb-2">Prepared assessment</div>
                    <div class="text-4xl font-black mb-2">₹19,999</div>
                    <div class="text-sm text-white/70 mb-6">Inclusive of GST</div>
                    <a href="<?= base_url('advisory/payment/career-intelligence') ?>" class="inline-flex w-full justify-center px-5 py-3.5 rounded-xl bg-accent text-white font-bold hover:opacity-90 transition">Begin confidential assessment →</a>
                    <p class="text-xs text-white/55 mt-4">Includes one interpretation call. CV, LinkedIn rebuilding and coaching are separate interventions where recommended.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white" id="positioning">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-3xl mb-10">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">02 · Positioning</div>
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-5">Make your leadership value visible.</h2>
            <p class="text-lg text-gray-600 leading-relaxed">LinkedIn is the discovery layer. Your CV is the consideration layer. Your interview is the belief layer. HiredNext aligns all three around verified experience and the role you want next.</p>
        </div>

        <div class="rounded-[2rem] border border-gray-200 bg-gray-50 p-7 md:p-10">
            <div class="grid lg:grid-cols-[0.7fr_1fr_0.35fr] gap-8 items-center">
                <div>
                    <div class="text-accent text-sm font-black uppercase tracking-[0.18em] mb-3">Executive positioning</div>
                    <h3 class="text-3xl font-serif font-bold text-primary mb-3">CV and LinkedIn Leadership Positioning</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">For senior professionals whose experience is stronger than the way it is currently being read. We rebuild the narrative, evidence, search signals, commercial scale and leadership credibility around the target market.</p>
                <a href="<?= base_url('services/linkedin-leadership-positioning') ?>" class="inline-flex justify-center px-5 py-3 rounded-xl bg-primary text-white font-bold hover:bg-accent transition">Explore positioning →</a>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50" id="coaching">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-3xl mb-10">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">03 · One-to-one coaching</div>
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-5">The right senior coach for the decision in front of you.</h2>
            <p class="text-lg text-gray-600 leading-relaxed">Tell us what you are trying to solve, what type of coaching or mentoring you need and the outcome you want. We will review your request and share relevant coach profiles from our network before you book.</p>
        </div>

        <div class="space-y-6">
            <article class="overflow-hidden rounded-[2rem] border border-gray-200 bg-white">
                <div class="grid md:grid-cols-[0.34fr_1fr]">
                    <div class="relative min-h-[230px] bg-primary">
                        <img src="https://images.unsplash.com/photo-1747913485241-53ac8ce1c089?auto=format&fit=crop&q=80&w=900" alt="Representative senior coach image" class="absolute inset-0 h-full w-full object-cover opacity-80" loading="lazy" referrerpolicy="no-referrer">
                        <div class="absolute inset-x-0 bottom-0 bg-primary/80 px-5 py-3 text-[10px] text-white uppercase tracking-[0.16em] font-black">Representative image</div>
                    </div>
                    <div class="p-7 md:p-9">
                        <div class="text-accent text-xs font-black uppercase tracking-[0.18em] mb-3">Coaching pathway 01</div>
                        <h3 class="text-3xl font-serif font-bold text-primary mb-3">Executive Transition and Market Positioning</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">For leaders moving towards VP, business head or CXO roles, changing industries or functions, repositioning after a career break or deciding which opportunities deserve attention.</p>
                        <p class="text-sm font-bold text-primary">From ₹10,000 per 60-minute session</p>
                    </div>
                </div>
            </article>

            <article class="overflow-hidden rounded-[2rem] border border-gray-200 bg-white">
                <div class="grid md:grid-cols-[0.34fr_1fr]">
                    <div class="relative min-h-[230px] bg-primary">
                        <img src="https://images.unsplash.com/photo-1780454242636-41941a9f789a?auto=format&fit=crop&q=80&w=900" alt="Representative executive coach image" class="absolute inset-0 h-full w-full object-cover" loading="lazy" referrerpolicy="no-referrer">
                        <div class="absolute inset-x-0 bottom-0 bg-primary/80 px-5 py-3 text-[10px] text-white uppercase tracking-[0.16em] font-black">Representative image</div>
                    </div>
                    <div class="p-7 md:p-9">
                        <div class="text-accent text-xs font-black uppercase tracking-[0.18em] mb-3">Coaching pathway 02</div>
                        <h3 class="text-3xl font-serif font-bold text-primary mb-3">Leadership Presence and Stakeholder Influence</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">For leaders preparing for CEO, board or investor interaction, cross-functional influence, difficult stakeholder situations, greater organisational visibility or a broader leadership mandate.</p>
                        <p class="text-sm font-bold text-primary">From ₹10,000 per 60-minute session</p>
                    </div>
                </div>
            </article>

            <article class="overflow-hidden rounded-[2rem] border border-gray-200 bg-white">
                <div class="grid md:grid-cols-[0.34fr_1fr]">
                    <div class="relative min-h-[230px] bg-primary">
                        <img src="https://images.unsplash.com/photo-1665023022859-973316d08414?auto=format&fit=crop&q=80&w=900" alt="Representative leadership mentor image" class="absolute inset-0 h-full w-full object-cover" loading="lazy" referrerpolicy="no-referrer">
                        <div class="absolute inset-x-0 bottom-0 bg-primary/80 px-5 py-3 text-[10px] text-white uppercase tracking-[0.16em] font-black">Representative image</div>
                    </div>
                    <div class="p-7 md:p-9">
                        <div class="text-accent text-xs font-black uppercase tracking-[0.18em] mb-3">Coaching pathway 03</div>
                        <h3 class="text-3xl font-serif font-bold text-primary mb-3">Career Decision, Interview and Negotiation Strategy</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">For senior interviews, multiple offers, compensation negotiation, relocation, international opportunities, notice-period concerns, board conversations and high-stakes career decisions.</p>
                        <p class="text-sm font-bold text-primary">From ₹10,000 per 60-minute session</p>
                    </div>
                </div>
            </article>
        </div>

        <div class="mt-10 rounded-[2rem] bg-white border border-gray-200 p-7 md:p-10">
            <div class="grid lg:grid-cols-[1fr_0.9fr] gap-10 items-start">
                <div>
                    <h3 class="text-3xl font-serif font-bold text-primary mb-3">Request a senior coach</h3>
                    <p class="text-gray-600 leading-relaxed">Share the challenge, target outcome and type of coach you need. HiredNext will review the request and send relevant mentor profiles and availability before booking.</p>
                </div>
                <form action="<?= base_url('contact/submit') ?>" method="post" class="space-y-4">
                    <input type="hidden" name="subject" value="Senior Coach Request">
                    <input type="hidden" name="service" value="One-to-One Executive Coaching">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <input name="name" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Your name">
                        <input type="email" name="email" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Professional email">
                    </div>
                    <select name="coaching_need" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white text-gray-700">
                        <option value="">What do you need coaching for?</option>
                        <option>Executive transition and market positioning</option>
                        <option>Leadership presence and stakeholder influence</option>
                        <option>Career decision, interview and negotiation strategy</option>
                    </select>
                    <textarea name="message" required rows="5" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Tell us about the challenge, target role and outcome you want."></textarea>
                    <button type="submit" class="w-full px-5 py-3.5 rounded-xl bg-accent text-white font-bold hover:opacity-90 transition">Send coaching request →</button>
                    <p class="text-xs text-gray-500">Final coach matching depends on expertise, availability and fit. Coaching is separate from recruitment consideration.</p>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white" id="strategic-advisory">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="max-w-3xl mb-10">
            <div class="text-accent text-xs font-black uppercase tracking-[0.24em] mb-3">04 · Strategic advisory</div>
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-5">Prepared conversations for high-stakes decisions.</h2>
            <p class="text-lg text-gray-600 leading-relaxed">These are researched advisory sessions, not introductory calls. Your CV, LinkedIn profile, objective and stated challenge are reviewed before the conversation.</p>
        </div>

        <div class="space-y-5">
            <article class="rounded-[2rem] border border-gray-200 bg-gray-50 p-7 md:p-9">
                <div class="grid lg:grid-cols-[0.22fr_1fr_0.22fr] gap-7 items-start">
                    <div class="text-accent text-sm font-black">₹6,500<br><span class="text-gray-500 text-xs">60 minutes</span></div>
                    <div>
                        <h3 class="text-3xl font-serif font-bold text-primary mb-3">Career Strategy and Market Fit</h3>
                        <p class="text-gray-600 leading-relaxed">Role and level fit, career positioning, compensation perspective, transition or interview strategy and a practical next-step plan.</p>
                    </div>
                    <a href="<?= base_url('advisory/payment/career-strategy') ?>" class="inline-flex justify-center px-5 py-3 rounded-xl border-2 border-primary text-primary font-bold hover:bg-primary hover:text-white transition">Request session →</a>
                </div>
            </article>

            <article class="rounded-[2rem] border-2 border-accent bg-white p-7 md:p-9">
                <div class="grid lg:grid-cols-[0.22fr_1fr_0.22fr] gap-7 items-start">
                    <div class="text-accent text-sm font-black">₹12,500<br><span class="text-gray-500 text-xs">60 minutes</span></div>
                    <div>
                        <h3 class="text-3xl font-serif font-bold text-primary mb-3">CXO Strategic Advisory</h3>
                        <p class="text-gray-600 leading-relaxed">Confidential decision support for CXOs and senior leaders navigating role, company, compensation, transition, negotiation or executive positioning decisions.</p>
                    </div>
                    <a href="<?= base_url('advisory/payment/cxo-advisory') ?>" class="inline-flex justify-center px-5 py-3 rounded-xl bg-primary text-white font-bold hover:bg-accent transition">Request CXO advisory →</a>
                </div>
            </article>
        </div>

        <div class="mt-8 rounded-[2rem] bg-primary text-white p-7 md:p-9">
            <div class="text-gold text-xs font-black uppercase tracking-[0.24em] mb-3">Founder-led access</div>
            <h3 class="text-3xl font-serif font-bold mb-3">Four prepared advisory appointments each month.</h3>
            <p class="text-white/70 leading-relaxed">Maximum one founder-led appointment per week, on weekdays between 10:00 AM and 12:00 noon IST. Payment and profile information are reviewed before the appointment is confirmed. Senior coach requests are matched separately through the coaching pathway.</p>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="rounded-[2rem] bg-white border border-gray-200 p-7 md:p-10">
            <div class="grid md:grid-cols-3 gap-8 items-start">
                <div>
                    <div class="text-accent text-xs font-black uppercase tracking-[0.2em] mb-3">Confidential by design</div>
                    <h2 class="text-3xl font-serif font-bold text-primary">Clear advice. Appropriate routing. No forced intervention.</h2>
                </div>
                <div class="text-sm text-gray-600 space-y-3">
                    <p>We do not recommend a paid service unless the assessment identifies a meaningful gap.</p>
                    <p>Assessment, coaching and advisory do not buy preference in recruitment.</p>
                </div>
                <div class="text-sm text-gray-600 space-y-3">
                    <p>HiredNext never charges candidates to apply for jobs or secure placement.</p>
                    <a href="<?= base_url('jobs') ?>" class="font-bold text-primary hover:text-accent">View current roles →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
