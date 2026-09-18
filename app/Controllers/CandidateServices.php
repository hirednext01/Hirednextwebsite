<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CandidateServices extends BaseController
{
    public function services()
    {
        return redirect()->to('/services/clients');
    }

    public function clientServices()
    {
        $settings = $this->loadWebsiteSettings();

        return view('pages/services/client-services', [
            'title' => 'Recruitment Services for Employers | HiredNext India',
            'metaDescription' => 'Executive search, permanent hiring, RPO and sector-led recruitment services for employers hiring across India and international markets.',
            'currentPage' => 'services',
            'settings' => $settings,
        ]);
    }

    public function candidateServices()
    {
        $settings = $this->loadWebsiteSettings();
        $pageUrl = base_url('services/candidates');
        return view('pages/services/candidate-services', [
            'title' => 'CV Writing, CV Making, CV Rebuild & Assessment Services in India | HiredNext',
            'metaDescription' => 'Recruiter-led CV writing, CV making, CV remake, CV rebuild and CV assessment services in India for experienced professionals, plus executive CV and interview preparation support.',
            'metaKeywords' => 'CV making company India, best CV writing service India, professional CV writing service India, CV remake service India, CV rebuild service India, CV assessment India, CV review India, executive CV writing India, resume writing services India',
            'canonical' => $pageUrl,
            'currentPage' => 'services',
            'settings' => $settings,
            'jsonLd' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => 'HiredNext CV Assessment and Professional CV Rebuild',
                'serviceType' => ['CV assessment', 'CV making', 'CV remake', 'Professional CV writing', 'Professional CV rebuild', 'Executive CV writing', 'Interview preparation', 'Career consultation'],
                'provider' => ['@type' => 'Organization', 'name' => 'HiredNext Recruitment', 'url' => base_url()],
                'url' => $pageUrl,
                'offers' => [
                    ['@type' => 'Offer', 'name' => 'CV Assessment', 'price' => '599', 'priceCurrency' => 'INR', 'url' => base_url('services/cv-assessment')],
                    ['@type' => 'Offer', 'name' => 'Professional CV Rebuild', 'price' => '1799', 'priceCurrency' => 'INR', 'url' => base_url('career-services/start/rebuild_1799')],
                    ['@type' => 'Offer', 'name' => 'Executive CV & Leadership Case Study', 'price' => '6999', 'priceCurrency' => 'INR', 'url' => base_url('services/executive-cv')],
                    ['@type' => 'Offer', 'name' => 'Career Consultation', 'price' => '4500', 'priceCurrency' => 'INR', 'url' => base_url('career-services/start/career_4500')],
                ],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function executiveCv()
    {
        $pageUrl = base_url('services/executive-cv');
        return view('pages/services/executive-cv', [
            'title' => 'Executive CV & Leadership Case Study | HiredNext',
            'metaDescription' => 'HiredNext builds a senior leadership CV and one evidence-led career case study through structured career analysis, positioning and human review. ₹6,999 including GST.',
            'metaKeywords' => 'executive CV writing India, leadership resume, senior management CV, executive case study',
            'canonical' => $pageUrl,
            'currentPage' => 'services',
            'settings' => $this->loadWebsiteSettings(),
            'jsonLd' => json_encode([
                '@context' => 'https://schema.org', '@type' => 'Service',
                'name' => 'Executive CV & Leadership Case Study',
                'serviceType' => 'Executive CV writing and leadership positioning',
                'provider' => ['@type' => 'Organization', 'name' => 'HiredNext Recruitment', 'url' => base_url()],
                'url' => $pageUrl,
                'offers' => ['@type' => 'Offer', 'price' => '6999', 'priceCurrency' => 'INR', 'url' => base_url('career-services/start/executive_6999')],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
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
            'metaDescription' => 'Get a detailed 12-hour, role-focused CV assessment for ₹599 from HiredNext recruitment experts.',
            'currentPage' => 'services',
            'job' => $job,
        ]);
    }
}
