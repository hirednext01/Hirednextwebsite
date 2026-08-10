<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CandidateServices extends BaseController
{
    public function services()
    {
        $settings = $this->loadWebsiteSettings();
        $html = view('pages/services', [
            'title' => 'Services | HiredNext - Shaping Careers, Powering Organizations',
            'currentPage' => 'services',
            'settings' => $settings,
        ]);

        $promo = <<<'HTML'
<section class="py-10 md:py-14 bg-white border-b border-gray-100">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-8">
        <div class="rounded-[2rem] border border-gray-200 bg-gray-50 p-6 md:p-9 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-7 shadow-sm">
            <div class="max-w-3xl">
                <div class="text-accent text-[11px] font-black uppercase tracking-[0.25em] mb-3">For Candidates</div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3">Get your CV assessed before you apply</h2>
                <p class="text-gray-600 text-base md:text-lg leading-relaxed">Choose a free CV assessment delivered in 7–10 days, or Priority Assessment for ₹599 with a 12-hour turnaround.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                <a href="/services/cv-assessment" class="inline-flex items-center justify-center px-7 py-4 rounded-full bg-primary text-white font-bold hover:bg-accent transition">Free CV Assessment</a>
                <a href="/services/cv-assessment#assessment-form" class="inline-flex items-center justify-center px-7 py-4 rounded-full border-2 border-accent text-accent font-bold hover:bg-accent hover:text-white transition">Priority ₹599 · 12 Hours</a>
            </div>
        </div>
    </div>
</section>
HTML;

        return str_replace(
            '<!-- ================= SERVICES ================= -->',
            $promo . "\n<!-- ================= SERVICES ================= -->",
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
