<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="relative pt-32 pb-20 bg-primary text-white overflow-hidden">
  <div class="max-w-[1180px] mx-auto px-4 sm:px-8 relative z-10">
    <div class="max-w-4xl">
      <div class="text-gold text-xs font-black uppercase tracking-[0.28em] mb-5">Limited Advisory Access</div>
      <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-6">Speak with HiredNext for strategic career and leadership advice.</h1>
      <p class="text-lg md:text-xl text-white/75 leading-relaxed max-w-3xl">Advisory conversations are separate from recruitment mandates. Only four advisory appointments are released each month, normally on weekdays between 10:00 AM and 12:00 noon IST.</p>
    </div>
  </div>
</section>

<section class="py-20 bg-gray-50">
  <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
    <div class="grid lg:grid-cols-2 gap-6 mb-10">
      <article class="rounded-[2rem] border border-gray-200 bg-white p-8 shadow-sm">
        <div class="text-accent text-sm font-black mb-2">₹4,500 · 60 MINUTES</div>
        <h2 class="text-3xl font-serif font-bold text-primary mb-4">Strategic Consultation</h2>
        <p class="text-gray-600 leading-relaxed">For experienced professionals seeking focused guidance on career direction, positioning, interviews, compensation, transitions or a specific professional decision.</p>
      </article>
      <article class="rounded-[2rem] border-2 border-accent bg-white p-8 shadow-sm">
        <div class="text-accent text-sm font-black mb-2">₹12,500 · 60 MINUTES</div>
        <h2 class="text-3xl font-serif font-bold text-primary mb-4">CXO Strategic Advisory</h2>
        <p class="text-gray-600 leading-relaxed">For CXOs and senior leaders requiring deeper market perspective, executive positioning, transition strategy or leadership decision support. Where useful, HiredNext may involve an appropriate senior industry expert.</p>
      </article>
    </div>

    <div class="rounded-[2rem] bg-primary text-white p-8 md:p-10 mb-10">
      <div class="text-gold text-xs font-black uppercase tracking-[0.24em] mb-3">Availability</div>
      <h2 class="text-3xl font-serif font-bold mb-4">4 advisory slots per month. Maximum one appointment per week.</h2>
      <p class="text-white/75">Requests are reviewed first. Approved requests receive the available weekday slot between 10:00 AM and 12:00 noon IST. Submitting a request does not reserve a slot.</p>
    </div>

    <div class="grid lg:grid-cols-5 gap-8">
      <div class="lg:col-span-3 rounded-[2rem] bg-white border border-gray-200 p-8 md:p-10">
        <h2 class="text-3xl font-serif font-bold text-primary mb-3">Request an advisory appointment</h2>
        <p class="text-gray-500 mb-8">Tell us what you need help with. We review the request before sharing availability.</p>
        <form action="<?= base_url('contact/submit') ?>" method="post" class="space-y-6">
          <input type="hidden" name="subject" value="Strategic Advisory Request">
          <div class="grid md:grid-cols-2 gap-6">
            <input required name="name" placeholder="Your name" class="w-full border border-gray-200 rounded-xl px-4 py-4 outline-none focus:border-accent">
            <input required type="email" name="email" placeholder="Professional email" class="w-full border border-gray-200 rounded-xl px-4 py-4 outline-none focus:border-accent">
          </div>
          <select required name="service" class="w-full border border-gray-200 rounded-xl px-4 py-4 outline-none focus:border-accent">
            <option value="">Select advisory type</option>
            <option value="Strategic Consultation - Rs 4,500 / 60 min">Strategic Consultation — ₹4,500 / 60 min</option>
            <option value="CXO Strategic Advisory - Rs 12,500 / 60 min">CXO Strategic Advisory — ₹12,500 / 60 min</option>
          </select>
          <textarea required minlength="10" rows="6" name="message" placeholder="What would you like advice on? Include your current role, context and the decision or challenge you want to discuss." class="w-full border border-gray-200 rounded-xl px-4 py-4 outline-none focus:border-accent"></textarea>
          <button type="submit" class="inline-flex px-8 py-4 rounded-full bg-accent text-white font-bold">Submit Advisory Request →</button>
        </form>
      </div>
      <aside class="lg:col-span-2 space-y-5">
        <div class="rounded-[2rem] bg-white border border-gray-200 p-7">
          <div class="text-xs font-black uppercase tracking-widest text-accent mb-3">Have a hiring mandate?</div>
          <h3 class="text-2xl font-serif font-bold text-primary mb-3">Do not use paid advisory.</h3>
          <p class="text-gray-600 text-sm leading-relaxed mb-5">Companies actively hiring can speak to HiredNext about the mandate without an advisory fee.</p>
          <a href="https://calendly.com/tarushikha-hirednext/30min" target="_blank" rel="noopener noreferrer" class="font-bold text-primary hover:text-accent">Book a Hiring Discussion →</a>
        </div>
        <div class="rounded-[2rem] bg-white border border-gray-200 p-7">
          <div class="text-xs font-black uppercase tracking-widest text-accent mb-3">Looking for a job?</div>
          <h3 class="text-2xl font-serif font-bold text-primary mb-3">You do not need a meeting.</h3>
          <p class="text-gray-600 text-sm leading-relaxed mb-4">View current roles or email your CV to <strong>jobs@hirednext.info</strong>. If your profile matches a mandate, our recruitment team will contact you.</p>
          <a href="<?= base_url('jobs') ?>" class="font-bold text-primary hover:text-accent">View Current Jobs →</a>
        </div>
      </aside>
    </div>
    <p class="mt-8 text-xs text-gray-500">HiredNext never charges candidates to apply for jobs or secure placement. Advisory is an optional professional service and does not influence consideration for recruitment mandates.</p>
  </div>
</section>
<?= $this->endSection() ?>
