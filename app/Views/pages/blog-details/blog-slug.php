<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<!-- ================= HERO ================= -->
  <header class="relative bg-primary pt-48 pb-32 text-center text-white overflow-hidden">
    <!-- Decorative background -->
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-30">
    </div>
    <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-accent/5 blur-[120px] rounded-full animate-pulse">
    </div>
    <div class="absolute -bottom-40 -right-40 w-[600px] h-[600px] bg-gold/5 blur-[120px] rounded-full"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-6">
      <div class="flex justify-center items-center space-x-4 mb-8">
        <span
          class="px-5 py-1.5 bg-accent text-gray-900 text-[10px] font-black uppercase tracking-[0.3em] rounded-full">Recruitment</span>
        <span class="w-1.5 h-1.5 rounded-full bg-gold"></span>
        <span class="text-[10px] font-black text-gold uppercase tracking-[0.3em]">Thought Leadership</span>
      </div>

      <h1
        class="text-5xl md:text-7xl font-serif font-black leading-[1.1] mb-12 animate-in slide-in-from-bottom-8 duration-700">
        Thought Leadership in <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-gold">Global
          Hiring</span>
      </h1>

      <div class="flex flex-wrap justify-center gap-10 py-10 border-y border-white/10">
        <div class="flex items-center space-x-4 group">
          <div
            class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-accent transition-colors duration-500">
            <i data-lucide="user" class="w-5 h-5 text-accent group-hover:text-white transition-colors"></i>
          </div>
          <div class="text-left">
            <p class="text-[10px] text-white/40 font-black uppercase tracking-widest">Author</p>
            <p class="text-sm font-bold text-white">HiredNext Editorial</p>
          </div>
        </div>

        <div class="flex items-center space-x-4 group">
          <div
            class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-gold transition-colors duration-500">
            <i data-lucide="calendar" class="w-5 h-5 text-gold group-hover:text-white transition-colors"></i>
          </div>
          <div class="text-left">
            <p class="text-[10px] text-white/40 font-black uppercase tracking-widest">Published</p>
            <p class="text-sm font-bold text-white">March 18, 2024</p>
          </div>
        </div>

        <div class="flex items-center space-x-4 group">
          <div
            class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-accent transition-colors duration-500">
            <i data-lucide="clock" class="w-5 h-5 text-accent group-hover:text-white transition-colors"></i>
          </div>
          <div class="text-left">
            <p class="text-[10px] text-white/40 font-black uppercase tracking-widest">Read Time</p>
            <p class="text-sm font-bold text-white">6 Min Read</p>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- ================= ARTICLE CONTENT ================= -->
  <main class="relative bg-white pt-10 pb-32">

    <!-- Floating Back Button -->
    <div class="max-w-[1440px] mx-auto px-6 mb-16 relative z-20">
      <a href="<?= base_url('blog') ?>"
        class="inline-flex items-center text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-accent transition-all group">
        <div
          class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center mr-4 group-hover:bg-accent group-hover:text-white transition-colors">
          <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
        </div>
        Return to Insights
      </a>
    </div>

    <!-- Main Content -->
    <article class="max-w-4xl mx-auto px-6">

      <!-- Featured Image -->
      <div class="relative -mt-32 mb-24 z-10">
        <div class="absolute -inset-4 bg-accent/10 rounded-[3rem] blur-2xl opacity-50"></div>
        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&q=80&w=1200"
          alt="Global Hiring Leadership"
          class="relative rounded-[2.5rem] shadow-premium w-full object-cover aspect-[16/9] border-8 border-white">
      </div>

      <!-- Excerpt -->
      <div class="relative mb-20">
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-accent to-gold rounded-full"></div>
        <p class="text-2xl md:text-3xl font-serif font-medium leading-relaxed text-primary/90 pl-12 italic">
          "Global hiring strategies are evolving rapidly as organizations adapt to distributed
          teams and cross-border leadership models. The future belongs to those who hire without borders."
        </p>
      </div>

      <!-- Body -->
      <div class="prose prose-lg max-w-none text-gray-700 leading-[1.8] space-y-10 text-lg md:text-xl">
        <p>
          Hiring across borders is no longer optional. Organizations that aim to compete on
          a global scale must rethink how they attract, evaluate, and retain talent across
          geographies. The talent pool has gone global, and so must your search.
        </p>

        <div class="p-10 bg-gray-50 rounded-[2rem] border-l-8 border-accent">
          <h3 class="text-2xl font-serif font-black text-primary mb-4">The Shift in Leadership Dynamics</h3>
          <p>
            Leadership pipelines today require more than technical capability. Cultural
            intelligence, compliance awareness, and the ability to operate in distributed
            environments are now core leadership traits. We are witnessing a transition from
            hierarchical models to networked leadership.
          </p>
        </div>

        <p>
          Companies that succeed in global hiring focus on long-term workforce strategy
          rather than transactional recruitment. They invest in employer branding, build
          regional expertise, and align talent decisions with business expansion goals.
          Strategic alignment is the difference between a successful expansion and a failed experiment.
        </p>

        <p>
          At HiredNext, we partner with organizations to design leadership hiring frameworks
          that scale responsibly, ensuring sustainable growth and organizational resilience.
          Our methodology focuses on the human element, even in a tech-driven world.
        </p>

        <!-- Dynamic list -->
        <div class="grid md:grid-cols-2 gap-8 my-16">
          <div class="p-8 border border-gray-100 rounded-3xl hover:border-accent/30 transition-all shadow-sm">
            <i data-lucide="globe" class="w-10 h-10 text-accent mb-6"></i>
            <h4 class="text-xl font-bold mb-3">Global Reach</h4>
            <p class="text-sm text-gray-500">Accessing talent across 12+ timezones with localized expertise.</p>
          </div>
          <div class="p-8 border border-gray-100 rounded-3xl hover:border-gold/30 transition-all shadow-sm">
            <i data-lucide="shield-check" class="w-10 h-10 text-gold mb-6"></i>
            <h4 class="text-xl font-bold mb-3">Compliance Ready</h4>
            <p class="text-sm text-gray-500">Navigating complex international labor laws with zero risk.</p>
          </div>
        </div>

      </div>

    </article>

  </main>

  <!-- ================= RELATED INSIGHTS ================= -->
  <section class="bg-gray-50 py-32">
    <div class="max-w-[1440px] mx-auto px-6">

      <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
        <div>
          <span class="text-accent text-xs font-black uppercase tracking-[0.4em] mb-4 block">Recommended</span>
          <h2 class="text-4xl md:text-6xl font-serif font-black text-primary">Explore More <span
              class="text-accent">Insights</span></h2>
        </div>
        <a href="<?= base_url('blog') ?>"
          class="text-sm font-black uppercase tracking-widest text-primary border-b-2 border-accent pb-2 hover:text-accent transition-all">
          View All articles
        </a>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">

        <!-- Card 1 -->
        <article
          class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-premium transition-all duration-500 flex flex-col">
          <div class="relative h-64 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=800"
              class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-1000 grayscale group-hover:grayscale-0">
            <div class="absolute top-6 left-6">
              <span
                class="px-4 py-1.5 bg-white/90 backdrop-blur text-[10px] font-black uppercase tracking-widest rounded-full">Leadership</span>
            </div>
          </div>
          <div class="p-10 flex flex-col flex-grow">
            <h3
              class="text-2xl font-serif font-black text-primary mb-6 group-hover:text-accent transition-colors leading-snug">
              Leadership in the Age of AI
            </h3>
            <p class="text-gray-500 leading-relaxed mb-8 flex-grow">
              How artificial intelligence is reshaping leadership decisions and human potential.
            </p>
            <a href="#"
              class="inline-flex items-center text-xs font-black uppercase tracking-[0.2em] text-primary group-hover:text-accent transition-all">
              Read Insight <i data-lucide="arrow-right" class="ml-3 w-4 h-4"></i>
            </a>
          </div>
        </article>

        <!-- Card 2 -->
        <article
          class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-premium transition-all duration-500 flex flex-col">
          <div class="relative h-64 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=800"
              class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-1000 grayscale group-hover:grayscale-0">
            <div class="absolute top-6 left-6">
              <span
                class="px-4 py-1.5 bg-white/90 backdrop-blur text-[10px] font-black uppercase tracking-widest rounded-full">Technology</span>
            </div>
          </div>
          <div class="p-10 flex flex-col flex-grow">
            <h3
              class="text-2xl font-serif font-black text-primary mb-6 group-hover:text-accent transition-colors leading-snug">
              Scaling High-Performance Teams
            </h3>
            <p class="text-gray-500 leading-relaxed mb-8 flex-grow">
              Building strong cultures and resilient structures in high-growth organizations.
            </p>
            <a href="#"
              class="inline-flex items-center text-xs font-black uppercase tracking-[0.2em] text-primary group-hover:text-accent transition-all">
              Read Insight <i data-lucide="arrow-right" class="ml-3 w-4 h-4"></i>
            </a>
          </div>
        </article>

      </div>
    </div>
  </section>

  <!-- ================= FOOTER ================= -->
<?= $this->endSection() ?>
