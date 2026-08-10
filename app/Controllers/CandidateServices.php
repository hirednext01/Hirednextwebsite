<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CandidateServices extends BaseController
{
    public function services()
    {
        $settings = $this->loadWebsiteSettings();
        $html = view('pages/services', [
            'title' => 'Recruitment & Candidate Services | HiredNext India',
            'currentPage' => 'services',
            'settings' => $settings,
        ]);

        $gateway = <<<'HTML'
<section class="py-14 md:py-20 bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <div class="text-accent text-[11px] font-black uppercase tracking-[0.25em] mb-3">Choose what you need</div>
            <h2 class="text-3xl md:text-5xl font-serif font-bold text-primary mb-4">Services for companies. Career support for candidates.</h2>
            <p class="text-gray-600 text-base md:text-lg leading-relaxed">HiredNext supports employers hiring critical talent and candidates who want to improve how they present, apply and interview.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="rounded-[2rem] bg-primary text-white p-7 md:p-10 shadow-lg">
                <div class="text-gold text-[11px] font-black uppercase tracking-[0.25em] mb-3">For Clients</div>
                <h3 class="text-3xl font-serif font-bold mb-4">Build the team your business needs</h3>
                <p class="text-white/75 leading-relaxed mb-7">Executive search, permanent hiring, RPO and sector-led recruitment for organizations hiring with precision.</p>
                <a href="#client-services" class="inline-flex items-center justify-center px-7 py-3.5 rounded-full bg-white text-primary font-bold hover:bg-accent hover:text-white transition">Explore Client Services</a>
            </div>

            <div class="rounded-[2rem] bg-gray-50 border border-gray-200 p-7 md:p-10 shadow-sm">
                <div class="text-accent text-[11px] font-black uppercase tracking-[0.25em] mb-3">For Candidates</div>
                <h3 class="text-3xl font-serif font-bold text-primary mb-4">Get shortlisted. Present yourself better. Interview smarter.</h3>
                <p class="text-gray-600 leading-relaxed mb-7">Practical support from recruitment experts who understand how CVs are screened and how candidates are evaluated.</p>
                <a href="#candidate-services" class="inline-flex items-center justify-center px-7 py-3.5 rounded-full bg-accent text-white font-bold hover:bg-primary transition">Explore Candidate Services</a>
            </div>
        </div>

        <div id="candidate-services" class="pt-16 scroll-mt-28">
            <div class="mb-8">
                <div class="text-accent text-[11px] font-black uppercase tracking-[0.25em] mb-2">For Candidates</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary">Career services built around real hiring decisions</h2>
            </div>
            <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
                <div class="rounded-2xl border border-gray-200 p-6 bg-white">
                    <div class="text-sm font-black text-accent mb-2">FREE · 7–10 DAYS</div>
                    <h3 class="text-xl font-bold text-primary mb-3">CV Assessment</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-5">Get expert feedback on what may be weakening your CV before you apply.</p>
                    <a href="/services/cv-assessment" class="font-bold text-primary hover:text-accent">Assess my CV →</a>
                </div>
                <div class="rounded-2xl border-2 border-accent p-6 bg-white shadow-sm">
                    <div class="text-sm font-black text-accent mb-2">₹599 · 12 HOURS</div>
                    <h3 class="text-xl font-bold text-primary mb-3">Priority CV Assessment</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-5">Need feedback quickly? Get priority expert assessment before an application or interview.</p>
                    <a href="/services/cv-assessment#assessment-form" class="font-bold text-primary hover:text-accent">Get priority review →</a>
                </div>
                <div class="rounded-2xl border border-gray-200 p-6 bg-white">
                    <div class="text-sm font-black text-accent mb-2">₹2,500</div>
                    <h3 class="text-xl font-bold text-primary mb-3">Get a New CV Made</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-5">A recruiter-informed CV rebuild focused on clarity, positioning and the information hiring teams look for.</p>
                    <a href="/contact?service=cv-rebuild" class="font-bold text-primary hover:text-accent">Request a CV rebuild →</a>
                </div>
                <div class="rounded-2xl border border-gray-200 p-6 bg-white">
                    <div class="text-sm font-black text-accent mb-2">₹12,500 · 60 MIN</div>
                    <h3 class="text-xl font-bold text-primary mb-3">Interview Strategy Session</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-5">Talk to an expert about how to present yourself, discuss your CV and build a strategy for the roles you are targeting.</p>
                    <a href="/contact?service=interview-strategy" class="font-bold text-primary hover:text-accent">Talk to an interview expert →</a>
                </div>
            </div>
            <p class="mt-6 text-xs text-gray-500">Our services improve positioning and preparation; hiring and interview outcomes remain at the employer's discretion.</p>
        </div>
    </div>
</section>
HTML;

        $html = str_replace(
            '<!-- ================= SERVICES ================= -->',
            '<div id="client-services" class="scroll-mt-28"></div>' . "\n<!-- ================= SERVICES ================= -->",
            $html
        );

        return str_replace(
            '<!-- ================= SERVICES ================= -->',
            $gateway . "\n<!-- ================= SERVICES ================= -->",
            $html
        );
    }

    public function cvAssessment()
    {
        $jobSlug = trim((string) ($this->request->getGet('job') ?? ''));
        $job = null;

        if ($jobSlug !== '') {
            $jobModel = new \App\Models\JobModel();
            $candidateJob = $jobModel->getBySlug($jobSlug);
            if ($candidateJob && ($candidateJob['status'] ?? '') === 'open') {
                $job = $candidateJob;
            }
        }

        return view('pages/services/cv-assessment', [
            'title' => 'CV Assessment | HiredNext',
            'currentPage' => 'services',
            'job' => $job,
        ]);
    }
}
