<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<!-- ================= HERO SECTION ================= -->
    <section class="hero-about relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden text-white">
      <div class="hero-overlay"></div>
      <div class="hero-sheen"></div>
      <div class="hero-noise"></div>

      <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          <!-- LEFT CONTENT -->
          <div class="reveal reveal-right">
            <div
              class="inline-flex items-center gap-3 px-5 py-2 bg-white/10 border border-white/15 rounded-full text-[11px] uppercase tracking-[0.35em] font-bold mb-8"
            >
              <span class="h-2 w-2 rounded-full bg-gold shadow-[0_0_12px_rgba(212,175,55,0.7)]"></span>
              Our Story
            </div>
            <h1 class="text-4xl md:text-6xl xl:text-7xl font-bold mb-8 leading-tight font-serif">
              The people behind<br />
              <span class="text-accent">HiredNext</span>
            </h1>
            <p class="text-lg md:text-xl text-white/80 mb-10 max-w-2xl leading-relaxed">
              <?= esc($settings['about_description'] ?? 'With over 10+ years of recruitment excellence, HiredNext has established itself as a trusted talent partner for organizations seeking leadership-driven growth and workforce transformation.') ?>
            </p>
            <div class="flex flex-wrap items-center gap-6 text-xs uppercase tracking-[0.3em] text-white/60">
              <span class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-accent"></span> 10+ Years
              </span>
              <span class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-gold"></span> 1500+ Placements
              </span>
              <span class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-white"></span> Global Advisory
              </span>
            </div>
          </div>

          <!-- RIGHT PANEL -->
          <div class="hidden lg:block relative reveal reveal-scale">
            <div class="hero-panel rounded-[2.5rem] p-10 shadow-2xl border border-white/10">
              <div class="text-xs uppercase tracking-[0.3em] text-white/60 mb-6">
                Built on Trust
              </div>
              <div class="space-y-6">
                <div class="flex items-center justify-between">
                  <div class="text-lg font-semibold">Leadership Search</div>
                  <div class="text-white/70">98%</div>
                </div>
                <div class="h-2 w-full rounded-full bg-white/10 overflow-hidden">
                  <div class="h-full w-[90%] bg-accent rounded-full"></div>
                </div>
                <div class="flex items-center justify-between">
                  <div class="text-lg font-semibold">Client Retention</div>
                  <div class="text-white/70">94%</div>
                </div>
                <div class="h-2 w-full rounded-full bg-white/10 overflow-hidden">
                  <div class="h-full w-[86%] bg-gold rounded-full"></div>
                </div>
              </div>
            </div>

            <div
              class="hero-card relative mt-8 bg-white text-primary p-8 rounded-[2rem] shadow-2xl border border-white/80"
            >
              <div class="text-xs uppercase tracking-[0.3em] text-primary/50 mb-3">Since</div>
              <div class="text-3xl font-bold mb-2">2016</div>
              <div class="text-sm text-gray-500 uppercase font-extrabold tracking-widest">
                Trusted Talent Partners
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= ABOUT US CONTENT ================= -->
    <section class="py-32 bg-white">
      <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
          <!-- LEFT CONTENT -->
          <div class="reveal reveal-right">
            <h2
              class="text-4xl md:text-5xl font-bold text-primary mb-8 font-serif"
            >
              🏢 Our Mission
            </h2>
            <p class="text-xl text-gray-600 mb-10 leading-relaxed">
              To enable organizations and professionals to achieve long-term
              success by delivering talent solutions that balance capability,
              culture, and future potential.
            </p>

            <div class="space-y-8">
              <!-- Vision -->
              <div
                class="flex items-start p-8 bg-gray-50 rounded-2xl shadow-sm border-l-8 border-accent reveal reveal-up"
              >
                <div class="bg-accent/10 p-3 rounded-xl text-accent mr-6">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="28"
                    height="28"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <circle cx="12" cy="12" r="10" />
                    <circle cx="12" cy="12" r="4" />
                    <line x1="22" y1="12" x2="18" y2="12" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-xl font-bold text-primary mb-2">
                    🎯 Our Vision
                  </h4>
                  <p class="text-base text-gray-600">
                    To be recognized as a globally respected recruitment and
                    talent advisory firm known for insight-driven hiring,
                    integrity, and consistent results.
                  </p>
                </div>
              </div>

              <!-- Values -->
              <div
                class="flex items-start p-8 bg-gray-50 rounded-2xl shadow-sm border-l-8 border-gold reveal reveal-up"
              >
                <div class="bg-gold/10 p-3 rounded-xl text-gold mr-6">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="28"
                    height="28"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
                    />
                  </svg>
                </div>
                <div>
                  <h4 class="text-xl font-bold text-primary mb-2">
                    💎 Our Values
                  </h4>
                  <p class="text-base text-gray-600">
                    Integrity, excellence, and partnership drive everything we
                    do. We believe in building long-term relationships that
                    create value for both organizations and professionals.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- RIGHT STATS -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            <!-- Stat 1 -->
            <div
              class="bg-primary p-12 rounded-[2.5rem] text-center flex flex-col items-center justify-center transform hover:scale-105 transition-all shadow-xl h-full reveal reveal-left"
            >
              <div class="text-5xl font-bold text-gold mb-3">10+</div>
              <div
                class="text-white/70 text-sm font-bold uppercase tracking-[0.2em]"
              >
                Years Experience
              </div>
            </div>

            <!-- Stat 2 -->
            <div
              class="bg-primary p-12 rounded-[2.5rem] text-center flex flex-col items-center justify-center transform hover:scale-105 transition-all shadow-xl h-full reveal reveal-left"
            >
              <div class="text-5xl font-bold text-gold mb-3">1500+</div>
              <div
                class="text-white/70 text-sm font-bold uppercase tracking-[0.2em]"
              >
                Leadership Placements
              </div>
            </div>

            <!-- Stat 3 -->
            <div
              class="bg-primary p-12 rounded-[2.5rem] text-center flex flex-col items-center justify-center transform hover:scale-105 transition-all shadow-xl h-full reveal reveal-left"
            >
              <div class="text-5xl font-bold text-gold mb-3">25+</div>
              <div
                class="text-white/70 text-sm font-bold uppercase tracking-[0.2em]"
              >
                Industries Served
              </div>
            </div>

            <!-- Success Card -->
            <div
              class="bg-accent p-12 rounded-[2.5rem] text-center flex flex-col items-center justify-center text-white shadow-2xl shadow-accent/30 h-full reveal reveal-left"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="56"
                height="56"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="mb-4"
              >
                <path d="M20 6L9 17l-5-5" />
              </svg>
              <div class="text-2xl font-bold uppercase tracking-widest mb-1">
                Success
              </div>
              <div class="text-white/80 text-sm font-medium">
                Guaranteed Focus
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= FOUNDER SECTION ================= -->
    <section class="py-32 bg-gray-50">
      <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="reveal reveal-scale">
          <div
            class="bg-white rounded-[4rem] p-16 lg:p-24 relative overflow-hidden border border-gray-100 shadow-sm"
          >
            <!-- Big Quote Background -->
            <div class="absolute top-10 right-10 text-accent/10">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="200"
                height="200"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path d="M3 21c3 0 6-3 6-6V9H3v6h4c0 2-2 4-4 4v2z" />
                <path d="M15 21c3 0 6-3 6-6V9h-6v6h4c0 2-2 4-4 4v2z" />
              </svg>
            </div>

            <div
              class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center relative z-10"
            >
              <!-- LEFT: IMAGE -->
              <div class="lg:col-span-4 reveal reveal-right">
                <div
                  class="rounded-[2.5rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.1)] border-[12px] border-white"
                >
                  <img src="<?= base_url('theme/about.png') ?>" alt="Founder" class="w-full h-auto" />
                </div>
                <div class="mt-8 text-center lg:text-left">
                  <h3 class="text-3xl font-bold text-primary">Taru Shikha</h3>
                  <p
                    class="text-accent font-extrabold uppercase tracking-widest text-sm mt-2"
                  >
                    Founder, HiredNext
                  </p>
                </div>
              </div>

              <!-- RIGHT: CONTENT -->
              <div class="lg:col-span-8 reveal reveal-left">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="48"
                  height="48"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  class="text-accent mb-8"
                >
                  <path d="M3 21c3 0 6-3 6-6V9H3v6h4c0 2-2 4-4 4v2z" />
                  <path d="M15 21c3 0 6-3 6-6V9h-6v6h4c0 2-2 4-4 4v2z" />
                </svg>
                <p
                  class="text-3xl md:text-4xl font-serif text-primary italic leading-tight mb-10"
                >
                  "At HiredNext, recruitment goes beyond job descriptions. We
                  focus on understanding people, potential, and purpose. Every
                  hiring decision shapes an organization's future — and we take
                  that responsibility seriously."
                </p>
                <div class="flex space-x-6 items-center">
                  <div class="h-1 w-24 bg-accent"></div>
                  <p class="text-gray-500 text-lg max-w-lg leading-relaxed">
                    Our commitment is to excellence, ensuring that every
                    placement adds long-term value to both the individual and
                    the organization.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= OUR PROCESS ================= -->
    <section class="py-32 bg-white relative overflow-hidden">
      <div
        class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"
      ></div>
      <div
        class="absolute -top-40 -right-40 w-96 h-96 bg-primary/5 rounded-full blur-3xl"
      ></div>

      <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20 reveal reveal-up">
          <span
            class="text-accent font-extrabold uppercase tracking-[0.3em] text-xs mb-4 block"
          >
            How We Work
          </span>
          <h2
            class="text-4xl md:text-5xl font-bold text-primary font-serif mb-6"
          >
            Our Process
          </h2>
          <p class="text-gray-500 text-lg">
            A seamless, insight-driven approach to connecting world-class talent
            with industry-leading organizations.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
          <!-- Step 1 -->
          <div class="group text-center reveal reveal-up">
            <div class="relative w-20 h-20 mx-auto mb-8">
              <div
                class="absolute inset-0 bg-primary/5 rounded-full scale-0 group-hover:scale-110 transition-transform duration-500"
              ></div>
              <div
                class="relative w-full h-full flex items-center justify-center text-primary group-hover:text-accent transition-colors duration-300"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="40"
                  height="40"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="1.5"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                  />
                </svg>
              </div>
            </div>
            <h3 class="text-xl font-bold text-primary mb-4">
              Industry Aligned Recruiters
            </h3>
            <p class="text-gray-500 text-sm leading-relaxed">
              Our recruiters are specialists in their sectors, bringing deep
              domain expertise to understand your unique hiring needs.
            </p>
          </div>

          <!-- Step 2 -->
          <div
            class="group text-center reveal reveal-up"
            style="animation-delay: 100ms"
          >
            <div class="relative w-20 h-20 mx-auto mb-8">
              <div
                class="absolute inset-0 bg-primary/5 rounded-full scale-0 group-hover:scale-110 transition-transform duration-500"
              ></div>
              <div
                class="relative w-full h-full flex items-center justify-center text-primary group-hover:text-accent transition-colors duration-300"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="40"
                  height="40"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="1.5"
                >
                  <path
                    d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
                  />
                </svg>
              </div>
            </div>
            <h3 class="text-xl font-bold text-primary mb-4">
              End to End Solutions
            </h3>
            <p class="text-gray-500 text-sm leading-relaxed">
              From role analysis to onboarding support, we manage the complete
              recruitment lifecycle with precision.
            </p>
          </div>

          <!-- Step 3 -->
          <div
            class="group text-center reveal reveal-up"
            style="animation-delay: 200ms"
          >
            <div class="relative w-20 h-20 mx-auto mb-8">
              <div
                class="absolute inset-0 bg-primary/5 rounded-full scale-0 group-hover:scale-110 transition-transform duration-500"
              ></div>
              <div
                class="relative w-full h-full flex items-center justify-center text-primary group-hover:text-accent transition-colors duration-300"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="40"
                  height="40"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="1.5"
                >
                  <circle cx="12" cy="12" r="10" />
                  <line x1="2" y1="12" x2="22" y2="12" />
                  <path
                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
                  />
                </svg>
              </div>
            </div>
            <h3 class="text-xl font-bold text-primary mb-4">
              Global Talent Reach
            </h3>
            <p class="text-gray-500 text-sm leading-relaxed">
              Access top talent across borders through our extensive network and
              presence in multiple countries.
            </p>
          </div>

          <!-- Step 4 -->
          <div
            class="group text-center reveal reveal-up"
            style="animation-delay: 300ms"
          >
            <div class="relative w-20 h-20 mx-auto mb-8">
              <div
                class="absolute inset-0 bg-primary/5 rounded-full scale-0 group-hover:scale-110 transition-transform duration-500"
              ></div>
              <div
                class="relative w-full h-full flex items-center justify-center text-primary group-hover:text-accent transition-colors duration-300"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="40"
                  height="40"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="1.5"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
              </div>
            </div>
            <h3 class="text-xl font-bold text-primary mb-4">
              Culture First Hiring
            </h3>
            <p class="text-gray-500 text-sm leading-relaxed">
              Beyond skills matching, we ensure candidates align with your
              company's values and culture for long term success.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= CTA SECTION ================= -->
    <section
      class="py-40 bg-primary text-white text-center relative overflow-hidden"
    >
      <div
        class="absolute -top-24 -left-24 w-96 h-96 bg-accent opacity-10 rounded-full blur-3xl"
      ></div>
      <div
        class="absolute -bottom-24 -right-24 w-96 h-96 bg-gold opacity-10 rounded-full blur-3xl"
      ></div>

      <div class="max-w-5xl mx-auto px-6 relative z-10 reveal reveal-up">
        <h2
          class="text-5xl md:text-7xl font-serif font-bold mb-10 leading-tight"
        >
          Ready to transform your <br />
          <span class="text-gold italic">talent strategy?</span>
        </h2>
        <a
          href="<?= base_url('contact') ?>"
          class="inline-block px-12 py-5 bg-white text-primary rounded-full font-black uppercase tracking-widest hover:bg-accent hover:text-white transition-all shadow-[0_10px_30px_rgba(255,255,255,0.2)] hover:shadow-[0_20px_40px_rgba(255,78,22,0.4)] hover:-translate-y-1"
        >
          Get in Touch
        </a>
      </div>
    </section>

<?= $this->endSection() ?>
