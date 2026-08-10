<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<!-- ================= HERO SECTION ================= -->
    <section class="relative min-h-screen flex items-center pt-20 bg-primary overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 -left-20 w-80 h-80 bg-gold opacity-10 rounded-full blur-3xl"></div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-20">
            <div class="text-center max-w-4xl mx-auto reveal reveal-up">
                <span
                    class="inline-block px-4 py-1.5 bg-accent/20 text-accent font-bold text-xs uppercase tracking-widest rounded-full mb-6">
                    Get in Touch
                </span>
                <h1 class="text-4xl md:text-6xl xl:text-7xl font-bold text-white mb-8 leading-tight font-serif">
                    Let's Start a <span class="text-accent">Conversation</span>
                </h1>
                <p class="text-xl text-gray-300 mb-12 max-w-2xl mx-auto leading-relaxed">
                    Partner with HiredNext for executive search and advisory that delivers not just hires, but leadership legacies.
                </p>
            </div>
        </div>
    </section>

    <!-- ================= CONTACT SECTION ================= -->
    <section id="contact-form" class="py-40 bg-gradient-to-b from-[#f9fafb] to-white relative overflow-hidden">
        <!-- Ambient blobs -->
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
            <div class="absolute top-1/4 -left-20 w-80 h-80 bg-accent/5 rounded-full blur-[100px] animate-pulse">
            </div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-gold/5 rounded-full blur-[120px] animate-pulse">
            </div>
        </div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-20 xl:gap-32">
                <!-- LEFT COLUMN -->
                <div class="lg:col-span-5">
                    <div class="sticky top-32 space-y-12">
                        <div class="reveal reveal-right space-y-6">
                            <div
                                class="inline-flex items-center space-x-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
                                <span class="relative flex h-3 w-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-accent"></span>
                                </span>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-primary">
                                    Consultants Online
                                </span>
                            </div>

                            <h2 class="text-5xl md:text-7xl font-bold text-primary font-serif leading-[1.05]">
                                The talent you
                                <span class="text-accent italic">deserve</span>
                                is one conversation away.
                            </h2>

                            <p class="text-xl text-gray-500 leading-relaxed max-w-lg">
                                Partner with HiredNext for executive search and advisory that
                                delivers not just hires, but leadership legacies.
                            </p>
                        </div>

                        <?php
                        $phones = array_filter([
                            $settings['contact_phone'] ?? null,
                            $settings['contact_phone_2'] ?? null,
                            $settings['contact_phone_3'] ?? null,
                            $settings['contact_phone_4'] ?? null,
                        ]);
                        $emails = array_filter([
                            $settings['contact_email'] ?? null,
                            $settings['contact_email_2'] ?? null,
                            $settings['contact_email_3'] ?? null,
                            $settings['contact_email_4'] ?? null,
                        ]);
                        $addresses = array_filter([
                            $settings['company_address'] ?? null,
                            $settings['contact_address_2'] ?? null,
                            $settings['contact_address_3'] ?? null,
                        ]);
                        $hours = array_filter([
                            $settings['working_hours'] ?? null,
                            $settings['working_hours_2'] ?? null,
                            $settings['working_hours_3'] ?? null,
                        ]);
                        $socialLinks = array_filter([
                            'Facebook' => $settings['social_facebook'] ?? null,
                            'Twitter' => $settings['social_twitter'] ?? null,
                            'LinkedIn' => $settings['social_linkedin'] ?? null,
                            'Instagram' => $settings['social_instagram'] ?? null,
                            'YouTube' => $settings['social_youtube'] ?? null,
                            'Website' => $settings['social_website'] ?? null,
                        ]);
                        ?>

                        <!-- CONTACT CARDS -->
                        <div class="space-y-4">
                            <?php if (!empty($emails)): ?>
                                <div
                                    class="group flex items-center p-6 bg-white rounded-[2rem] border border-gray-100 hover:shadow-2xl hover:shadow-accent/10 hover:-translate-y-1 transition-all duration-500 reveal reveal-right">
                                    <div
                                        class="w-14 h-14 rounded-2xl flex items-center justify-center text-accent bg-accent/5 group-hover:bg-accent group-hover:text-white transition-all">
                                        ✉
                                    </div>
                                    <div class="ml-6">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                            Email
                                        </p>
                                        <p class="text-lg font-bold text-primary">
                                            <?= esc($emails[0]) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($phones)): ?>
                                <div
                                    class="group flex items-center p-6 bg-white rounded-[2rem] border border-gray-100 hover:shadow-2xl hover:shadow-primary/10 hover:-translate-y-1 transition-all duration-500 reveal reveal-right">
                                    <div
                                        class="w-14 h-14 rounded-2xl flex items-center justify-center text-primary bg-primary/5 group-hover:bg-primary group-hover:text-white transition-all">
                                        📞
                                    </div>
                                    <div class="ml-6">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                            Phone
                                        </p>
                                        <p class="text-lg font-bold text-primary">
                                            <?= esc($phones[0]) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($addresses)): ?>
                                <div
                                    class="group flex items-center p-6 bg-white rounded-[2rem] border border-gray-100 hover:shadow-2xl hover:shadow-gold/10 hover:-translate-y-1 transition-all duration-500 reveal reveal-right">
                                    <div
                                        class="w-14 h-14 rounded-2xl flex items-center justify-center text-gold bg-gold/5 group-hover:bg-gold group-hover:text-white transition-all">
                                        📍
                                    </div>
                                    <div class="ml-6">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                            Address
                                        </p>
                                        <p class="text-lg font-bold text-primary">
                                            <?= esc($addresses[0]) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- DETAIL LISTS -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6">
                            <?php if (!empty($settings['company_name']) || !empty($settings['company_website'])): ?>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Company</p>
                                    <ul class="space-y-2 text-gray-600 text-sm">
                                        <?php if (!empty($settings['company_name'])): ?>
                                            <li><?= esc($settings['company_name']) ?></li>
                                        <?php endif; ?>
                                        <?php if (!empty($settings['company_website'])): ?>
                                            <li>
                                                <a class="text-primary hover:text-accent transition-colors" href="<?= esc($settings['company_website']) ?>" target="_blank" rel="noopener">
                                                    <?= esc($settings['company_website']) ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($phones)): ?>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Phone Numbers</p>
                                    <ul class="space-y-2 text-gray-600 text-sm">
                                        <?php foreach ($phones as $phone): ?>
                                            <li><?= esc($phone) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($emails)): ?>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Email Addresses</p>
                                    <ul class="space-y-2 text-gray-600 text-sm">
                                        <?php foreach ($emails as $email): ?>
                                            <li><?= esc($email) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($addresses)): ?>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Addresses</p>
                                    <ul class="space-y-2 text-gray-600 text-sm">
                                        <?php foreach ($addresses as $address): ?>
                                            <li><?= esc($address) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($hours)): ?>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Working Hours</p>
                                    <ul class="space-y-2 text-gray-600 text-sm">
                                        <?php foreach ($hours as $hour): ?>
                                            <li><?= esc($hour) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($socialLinks)): ?>
                            <div class="pt-6">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Social Media</p>
                                <div class="flex flex-wrap gap-3">
                                    <?php foreach ($socialLinks as $label => $url): ?>
                                        <a href="<?= esc($url) ?>" target="_blank" rel="noopener"
                                            class="px-4 py-2 rounded-full border border-gray-200 text-xs font-bold uppercase tracking-widest text-primary hover:bg-primary hover:text-white transition-colors">
                                            <?= esc($label) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- RIGHT COLUMN: FORM -->
                <div class="lg:col-span-7">
                    <div class="reveal reveal-scale">
                        <div
                            class="relative bg-white/80 backdrop-blur-xl rounded-[4rem] p-10 md:p-16 lg:p-20 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.12)] border border-white/50">
                            <h3 class="text-4xl font-bold text-primary mb-3 font-serif">
                                Start Your Brief
                            </h3>
                            <p class="text-gray-500 mb-12">
                                Secure. Consultative. Professional.
                            </p>

                            <?php if (session('success')): ?>
                                <div class="rounded-2xl border border-green-200 bg-green-50 text-green-700 px-6 py-4 text-sm font-semibold">
                                    <?= esc(session('success')) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (session('errors')): ?>
                                <div class="rounded-2xl border border-red-200 bg-red-50 text-red-700 px-6 py-4 text-sm font-semibold">
                                    <?= esc(implode(' ', session('errors'))) ?>
                                </div>
                            <?php endif; ?>

                            <?php
                            $contactFormEnabled = !isset($settings['contact_form_enabled']) || filter_var($settings['contact_form_enabled'], FILTER_VALIDATE_BOOLEAN);
                            ?>
                            <?php if ($contactFormEnabled): ?>
                            <form id="contactForm" class="space-y-12" action="<?= base_url('contact/submit') ?>" method="post">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                    <div>
                                        <label for="contact_name" class="block text-sm font-bold text-gray-600 mb-3 uppercase tracking-widest">
                                            Your Name
                                        </label>
                                        <input id="contact_name" required name="name" placeholder="John Doe"
                                            class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl" />
                                    </div>
                                    <div>
                                        <label for="contact_email" class="block text-sm font-bold text-gray-600 mb-3 uppercase tracking-widest">
                                            Professional Email
                                        </label>
                                        <input id="contact_email" required type="email" name="email" placeholder="john@company.com"
                                            class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                    <div>
                                        <label for="contact_subject" class="block text-sm font-bold text-gray-600 mb-3 uppercase tracking-widest">
                                            Organization
                                        </label>
                                        <input id="contact_subject" name="subject" placeholder="Company Name"
                                            class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl" />
                                    </div>
                                    <div>
                                        <label for="contact_service" class="block text-sm font-bold text-gray-600 mb-3 uppercase tracking-widest">
                                            Service Interest
                                        </label>
                                        <select id="contact_service" name="service"
                                            class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl">
                                            <option>Executive Search</option>
                                            <option>Permanent Hiring</option>
                                            <option>RPO Solutions</option>
                                            <option>Career Strategy</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="contact_message" class="block text-sm font-bold text-gray-600 mb-3 uppercase tracking-widest">
                                        Project or Hiring Brief
                                    </label>
                                    <textarea id="contact_message" rows="4" name="message" placeholder="Tell us about your hiring needs..."
                                        class="w-full bg-transparent border-b-2 border-gray-100 py-3 focus:border-accent outline-none text-xl resize-none"></textarea>
                                </div>

                                <div class="pt-10 flex flex-col md:flex-row items-center gap-10">
                                    <button id="submitBtn" type="submit"
                                        class="group relative overflow-hidden px-16 py-6 rounded-2xl font-black text-lg tracking-[0.2em] uppercase bg-primary text-white hover:bg-accent hover:-translate-y-2 transition-all shadow-2xl">
                                        Send Brief
                                    </button>

                                    <div class="flex items-center text-gray-400">
                                        <span class="text-gold mr-3">✔</span>
                                        <span class="text-xs font-bold uppercase tracking-widest">
                                            Confidential Advisory
                                        </span>
                                    </div>
                                </div>
                            </form>
                            <?php else: ?>
                                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 text-yellow-700 px-6 py-4 text-sm font-semibold">
                                    Contact form is currently disabled. Please reach out via email or phone.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= MAP SECTION ================= -->
    <section class="py-32 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
            <div class="text-center mb-16 reveal reveal-up">
                <span class="text-accent font-extrabold uppercase tracking-[0.3em] text-xs mb-4 block">
                    Our Presence
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-primary font-serif mb-6">
                    Global Locations
                </h2>
                <p class="text-gray-500 text-lg">
                    We operate across multiple regions to serve you better
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Location 1 -->
                <div class="bg-gray-50 p-8 rounded-3xl hover:bg-white hover:shadow-xl transition-all reveal reveal-up">
                    <div class="text-accent mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-primary mb-2">Delhi NCR</h4>
                    <p class="text-gray-600 text-sm">Corporate Headquarters</p>
                </div>

                <!-- Location 2 -->
                <div class="bg-gray-50 p-8 rounded-3xl hover:bg-white hover:shadow-xl transition-all reveal reveal-up">
                    <div class="text-accent mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-primary mb-2">Mumbai</h4>
                    <p class="text-gray-600 text-sm">West India Operations</p>
                </div>

                <!-- Location 3 -->
                <div class="bg-gray-50 p-8 rounded-3xl hover:bg-white hover:shadow-xl transition-all reveal reveal-up">
                    <div class="text-accent mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-primary mb-2">Chennai</h4>
                    <p class="text-gray-600 text-sm">South India Hub</p>
                </div>

                <!-- Location 4 -->
                <div class="bg-gray-50 p-8 rounded-3xl hover:bg-white hover:shadow-xl transition-all reveal reveal-up">
                    <div class="text-accent mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-primary mb-2">Bangalore</h4>
                    <p class="text-gray-600 text-sm">Tech Hub Operations</p>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
