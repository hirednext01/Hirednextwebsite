<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="min-h-screen bg-gray-50 pt-32 pb-20">
    <div class="max-w-[980px] mx-auto px-4 sm:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="inline-block px-4 py-2 rounded-full bg-primary/5 text-primary text-[10px] font-black uppercase tracking-[0.3em] mb-5">Placed Candidate Story</span>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-5">Were you placed by HiredNext?</h1>
            <p class="text-lg text-gray-600 leading-relaxed">Tell us what the opportunity, search process and career move felt like from your side. Placed-candidate stories are published separately from client testimonials.</p>
        </div>

        <?php if (session('success')): ?>
            <div role="status" class="mb-8 rounded-2xl border border-green-200 bg-green-50 px-6 py-5 text-green-800 font-semibold text-center"><?= esc(session('success')) ?></div>
        <?php endif; ?>

        <?php if (session('errors')): ?>
            <div role="alert" class="mb-8 rounded-2xl border border-red-200 bg-red-50 px-6 py-5 text-red-800">
                <?php foreach ((array)session('errors') as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-[1fr_300px] gap-8 items-start">
            <form action="<?= base_url('testimonials/share') ?>" method="post" class="bg-white rounded-[2rem] border border-gray-200 shadow-sm p-6 md:p-10 space-y-6" data-agent-action="share-testimonial" aria-label="Share a HiredNext testimonial">
                <?= csrf_field() ?>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label for="testimonial-name" class="block text-sm font-bold text-primary mb-2">Your name *</label>
                        <input id="testimonial-name" type="text" name="name" autocomplete="name" required value="<?= esc(old('name')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="Full name">
                    </div>
                    <div>
                        <label for="testimonial-email" class="block text-sm font-bold text-primary mb-2">Email *</label>
                        <input id="testimonial-email" type="email" name="email" autocomplete="email" inputmode="email" required value="<?= esc(old('email')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="you@example.com">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label for="testimonial-phone" class="block text-sm font-bold text-primary mb-2">Phone <span class="text-gray-400 font-normal">optional</span></label>
                        <input id="testimonial-phone" type="tel" name="phone" autocomplete="tel" inputmode="tel" value="<?= esc(old('phone')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="For verification if needed">
                    </div>
                    <div>
                        <label for="testimonial-role" class="block text-sm font-bold text-primary mb-2">Current role <span class="text-gray-400 font-normal">optional</span></label>
                        <input id="testimonial-role" type="text" name="current_role" autocomplete="organization-title" value="<?= esc(old('current_role')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="e.g. Senior Merchandiser">
                    </div>
                </div>

                <div class="rounded-2xl border border-primary/10 bg-primary/[0.025] p-5 md:p-6">
                    <div class="text-[10px] uppercase tracking-[0.24em] text-accent font-black mb-4">Your HiredNext placement</div>
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label for="testimonial-placement-role" class="block text-sm font-bold text-primary mb-2">Role you joined through HiredNext *</label>
                            <input id="testimonial-placement-role" type="text" name="placement_role" required value="<?= esc(old('placement_role')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="e.g. Head of Design">
                        </div>
                        <div>
                            <label for="testimonial-placement-location" class="block text-sm font-bold text-primary mb-2">Placement location <span class="text-gray-400 font-normal">optional</span></label>
                            <input id="testimonial-placement-location" type="text" name="placement_location" value="<?= esc(old('placement_location')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="e.g. Gurugram or Dhaka">
                        </div>
                    </div>
                    <div class="mt-5 max-w-[220px]">
                        <label for="testimonial-placement-year" class="block text-sm font-bold text-primary mb-2">Year you joined <span class="text-gray-400 font-normal">optional</span></label>
                        <select id="testimonial-placement-year" name="placement_year" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
                            <option value="">Select year</option>
                            <?php for ($year = (int)date('Y'); $year >= 2016; $year--): ?>
                                <option value="<?= esc((string)$year) ?>" <?= old('placement_year') === (string)$year ? 'selected' : '' ?>><?= esc((string)$year) ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="testimonial-help" class="block text-sm font-bold text-primary mb-2">What made the biggest difference? *</label>
                    <select id="testimonial-help" name="help_received" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white">
                        <option value="">Choose one</option>
                        <?php
                        $helpOptions = [
                            'Matched me with the right opportunity' => 'Matched me with the right opportunity',
                            'Understood my experience beyond the CV' => 'Understood my experience beyond the CV',
                            'Prepared and supported me through interviews' => 'Prepared and supported me through interviews',
                            'Helped me evaluate the career move' => 'Helped me evaluate the career move',
                            'Managed the offer, transition or joining well' => 'Managed the offer, transition or joining well',
                            'Stayed transparent and responsive throughout' => 'Stayed transparent and responsive throughout',
                        ];
                        $oldHelp = old('help_received');
                        foreach ($helpOptions as $value => $label): ?>
                            <option value="<?= esc($value) ?>" <?= $oldHelp === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="testimonial-story" class="block text-sm font-bold text-primary mb-2">Tell us about the placement journey *</label>
                    <textarea id="testimonial-story" name="story" required minlength="30" rows="7" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="What made the role relevant? How did HiredNext support you through the interviews, decision, offer or joining? What stood out?" aria-describedby="testimonial-story-help"><?= esc(old('story')) ?></textarea>
                    <p id="testimonial-story-help" class="text-xs text-gray-500 mt-2">Specific stories are more useful than generic praise.</p>
                </div>

                <div>
                    <label for="testimonial-linkedin" class="block text-sm font-bold text-primary mb-2">LinkedIn profile or public recommendation URL <span class="text-gray-400 font-normal">optional</span></label>
                    <input id="testimonial-linkedin" type="url" name="linkedin_url" autocomplete="url" value="<?= esc(old('linkedin_url')) ?>" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white" placeholder="https://www.linkedin.com/in/..." aria-describedby="testimonial-linkedin-help">
                    <p id="testimonial-linkedin-help" class="text-xs text-gray-500 mt-2">A LinkedIn profile can help verify identity. If you have posted a public recommendation or post, paste that URL instead and we can link to it as public proof after review.</p>
                </div>

                <fieldset>
                    <legend class="block text-sm font-bold text-primary mb-3">Would you like HiredNext to support you again in future? *</legend>
                    <div class="grid sm:grid-cols-3 gap-3">
                        <?php foreach (['yes' => 'Yes', 'maybe' => 'Maybe', 'no' => 'Not right now'] as $value => $label): ?>
                            <label class="flex items-center gap-3 border border-gray-200 rounded-xl px-4 py-3 cursor-pointer hover:border-primary/30">
                                <input type="radio" name="future_support" value="<?= esc($value) ?>" required <?= old('future_support') === $value ? 'checked' : '' ?>>
                                <span class="text-sm font-semibold text-gray-700"><?= esc($label) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <label class="flex items-start gap-3 rounded-xl bg-gray-50 p-4 text-sm text-gray-600 leading-relaxed">
                    <input type="checkbox" name="publish_consent" value="1" required class="mt-1" <?= old('publish_consent') ? 'checked' : '' ?> aria-describedby="testimonial-consent-text">
                    <span id="testimonial-consent-text">I confirm that HiredNext supported this placement and that this is my genuine experience. I allow HiredNext to review and, if approved, publish the story. HiredNext may lightly edit for spelling or length without changing the meaning. My email and phone will not be published.</span>
                </label>

                <button type="submit" class="w-full bg-primary text-white rounded-xl px-6 py-4 font-black hover:bg-accent transition" aria-label="Submit my HiredNext placement story for review">Share My Placement Story →</button>
                <p class="text-xs text-gray-500 text-center">Submissions are reviewed before publication. Nothing goes live automatically.</p>
            </form>

            <aside class="bg-primary text-white rounded-[2rem] p-7 lg:sticky lg:top-28">
                <div class="text-[10px] uppercase tracking-[0.3em] text-gold font-black mb-4">Why we ask</div>
                <h2 class="text-2xl font-serif font-bold mb-4">The candidate side of a successful placement.</h2>
                <p class="text-white/70 text-sm leading-relaxed mb-6">Client feedback explains the hiring outcome. Your story explains the opportunity, decision and transition from the person who actually made the move.</p>
                <div class="space-y-4 text-sm text-white/80">
                    <div class="flex gap-3"><span class="text-accent">✓</span><span>Your story stays pending until reviewed.</span></div>
                    <div class="flex gap-3"><span class="text-accent">✓</span><span>Email and phone are never displayed publicly.</span></div>
                    <div class="flex gap-3"><span class="text-accent">✓</span><span>LinkedIn/public links are optional.</span></div>
                    <div class="flex gap-3"><span class="text-accent">✓</span><span>Placed-candidate stories remain separate from employer testimonials.</span></div>
                </div>
                <a href="<?= base_url('testimonials') ?>" class="inline-flex mt-7 text-sm font-bold text-gold hover:text-white">See existing testimonials →</a>
            </aside>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
