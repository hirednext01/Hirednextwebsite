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

    public function professionalCvRebuild()
    {
        return $this->careerProductPage('rebuild_1799', 'services/professional-cv-rebuild', [
            'title' => 'Professional CV Rebuild & CV Making Service in India | HiredNext',
            'metaDescription' => 'Professional CV rebuild, CV making, CV remake and CV writing service in India for experienced professionals. ₹1,799 including assessment, two CV variants and two revision rounds.',
            'metaKeywords' => 'professional CV rebuild India, CV making service India, CV remake India, CV writing service India, resume rewriting India, CV revamp India',
            'eyebrow' => 'Professional CV Rebuild · India',
            'headline' => 'Your experience is real. Your CV should make it easier to see.',
            'intro' => 'HiredNext rebuilds the document from your actual career evidence: positioning, hierarchy, achievements, role language and recruiter readability. This is a managed rewrite, not a template download.',
            'forWhom' => [
                'Experienced professionals whose CV reads like a list of responsibilities instead of a career story.',
                'Professionals changing role, industry, location or seniority and needing clearer relevance.',
                'Candidates who want HiredNext to do the rewrite rather than only diagnose the gaps.',
            ],
            'deliverables' => [
                'Recruiter-led CV assessment included.',
                'Evidence-led content rewrite using verified career facts.',
                'Two completed CV variants in ATS-safe design directions.',
                'Two revision rounds for factual correction and calibrated positioning.',
            ],
            'faq' => [
                ['q' => 'Is this CV making, CV writing or CV rebuilding?', 'a' => 'All three phrases can describe this service. HiredNext uses “rebuild” because the work covers positioning, content, evidence and structure—not only formatting.'],
                ['q' => 'Do I need to buy the ₹599 assessment first?', 'a' => 'No. The Professional CV Rebuild already includes the assessment.'],
                ['q' => 'Does HiredNext invent achievements to strengthen the CV?', 'a' => 'No. Claims remain anchored to facts you provide. Missing metrics or context become clarification questions, not invented content.'],
            ],
        ]);
    }

    public function atsCvOptimisation()
    {
        return $this->careerProductPage('ats_999', 'services/ats-cv-optimisation', [
            'title' => 'ATS CV Optimisation Service in India | HiredNext',
            'metaDescription' => 'ATS CV optimisation in India for professionals whose core CV is sound but needs cleaner structure, role language, keywords and recruiter scanability. ₹999 including one revision round.',
            'metaKeywords' => 'ATS CV optimisation India, ATS resume service India, ATS friendly CV India, CV keyword optimisation India, resume optimisation India',
            'eyebrow' => 'ATS CV Optimisation · India',
            'headline' => 'Keep the career. Remove avoidable CV friction.',
            'intro' => 'For a fundamentally sound CV that does not need a full rebuild, HiredNext improves ATS parsing, headings, role language, keyword alignment and recruiter scanability while preserving truthful career facts.',
            'forWhom' => [
                'Professionals whose career story is already reasonably clear but the document structure is weak.',
                'Candidates applying through ATS-heavy employer portals or high-volume recruitment workflows.',
                'People who need a lighter intervention than a complete CV rebuild.',
            ],
            'deliverables' => [
                'ATS-safe headings and reading order.',
                'Cleaner section structure and role-relevant terminology.',
                'Keyword and recruiter-scan improvements without stuffing.',
                'One revision round.',
            ],
            'faq' => [
                ['q' => 'Is ATS optimisation the same as a CV rebuild?', 'a' => 'No. ATS optimisation is a lighter service for a CV whose substance is already sound. A rebuild is better when positioning, achievements and career narrative need deeper work.'],
                ['q' => 'Can HiredNext guarantee an ATS score or interview?', 'a' => 'No. ATS-safe structure reduces avoidable parsing problems, but employer systems and shortlisting decisions vary.'],
            ],
        ]);
    }

    public function interviewCoaching()
    {
        return $this->careerProductPage('career_4500', 'services/interview-coaching', [
            'title' => 'Interview Coaching & Interview Preparation in India | HiredNext',
            'metaDescription' => '1-to-1 interview coaching and role-specific interview preparation in India with Taru Shikha. 30-minute private session for ₹4,500 including GST.',
            'metaKeywords' => 'interview coaching India, interview preparation India, executive interview coaching India, senior interview preparation, mock interview coaching India',
            'eyebrow' => '1-to-1 Interview Coaching · India',
            'headline' => 'Prepare the evidence behind the answer—not a memorised script.',
            'intro' => 'A focused 30-minute session with Taru Shikha for a specific interview: sharpen positioning, choose relevant examples, anticipate likely themes and prepare to explain your real experience clearly under follow-up questioning.',
            'forWhom' => [
                'Professionals with a scheduled interview or a clearly defined target role.',
                'Senior candidates who need to sound at the level they are targeting rather than recite responsibilities.',
                'Candidates who want practical role and company-context preparation where sufficient information is available.',
            ],
            'deliverables' => [
                '30-minute private 1-to-1 session with Taru Shikha.',
                'Role-specific positioning and likely interview themes.',
                'Evidence selection for leadership, impact and difficult-question examples.',
                'Practical guidance on answer structure and follow-up questions.',
            ],
            'faq' => [
                ['q' => 'Is this a generic mock interview course?', 'a' => 'No. It is a focused private session built around your target role and available company context.'],
                ['q' => 'Does the session guarantee selection?', 'a' => 'No. It improves preparation and communication; the employer controls the interview and hiring decision.'],
            ],
        ]);
    }

    public function executiveCv()
    {
        $pageUrl = base_url('services/executive-cv');
        return view('pages/services/executive-cv', [
            'title' => 'Executive CV Writing Service in India for CXO & Senior Leaders | HiredNext',
            'metaDescription' => 'Executive CV writing in India for CXO, VP, Director and senior leaders: structured career analysis, leadership positioning, human review and one evidence-led case study. ₹6,999 including GST.',
            'metaKeywords' => 'executive CV writing India, best executive CV writing service India, CXO CV writing, leadership resume India, senior management CV, executive resume writing India, executive case study',
            'canonical' => $pageUrl,
            'currentPage' => 'services',
            'settings' => $this->loadWebsiteSettings(),
            'jsonLd' => json_encode([
                '@context' => 'https://schema.org', '@type' => 'Service',
                'name' => 'Executive CV & Leadership Case Study',
                'serviceType' => ['Executive CV writing', 'CXO resume writing', 'Senior leadership CV writing', 'Leadership positioning'],
                'provider' => ['@type' => 'Organization', 'name' => 'HiredNext Recruitment', 'url' => base_url()],
                'url' => $pageUrl,
                'offers' => ['@type' => 'Offer', 'price' => '6999', 'priceCurrency' => 'INR', 'url' => base_url('career-services/start/executive_6999')],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    private function careerProductPage(string $tier, string $canonicalPath, array $content)
    {
        $plan = \App\Services\Cv\CvUpgradePlans::get($tier);
        if (!$plan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $pageUrl = base_url($canonicalPath);
        $faq = $content['faq'] ?? [];
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    'name' => $plan['name'],
                    'serviceType' => $plan['name'],
                    'provider' => ['@type' => 'Organization', 'name' => 'HiredNext Recruitment', 'url' => base_url()],
                    'url' => $pageUrl,
                    'areaServed' => ['@type' => 'Country', 'name' => 'India'],
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => (string) $plan['amount'],
                        'priceCurrency' => 'INR',
                        'url' => base_url('career-services/start/' . $tier),
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_map(static fn (array $item): array => [
                        '@type' => 'Question',
                        'name' => $item['q'] ?? '',
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a'] ?? ''],
                    ], $faq),
                ],
            ],
        ];

        return view('pages/services/cv-service-product', array_merge($content, [
            'canonical' => $pageUrl,
            'currentPage' => 'services',
            'settings' => $this->loadWebsiteSettings(),
            'price' => '₹' . number_format((int) $plan['amount']),
            'priceNote' => $plan['delivery'] . ' · GST included',
            'ctaLabel' => match ($tier) {
                'ats_999' => 'Optimise My CV — ₹999',
                'rebuild_1799' => 'Rebuild My CV — ₹1,799',
                'career_4500' => 'Book Interview Coaching — ₹4,500',
                default => 'Start now',
            },
            'ctaUrl' => base_url('career-services/start/' . $tier),
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]));
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
            'title' => 'CV Assessment & Resume Review Service in India | HiredNext',
            'metaDescription' => 'Get a detailed 12-hour, role-focused CV assessment for ₹599 from HiredNext recruitment experts. Includes recruiter-led resume review on positioning, readability, evidence and priority corrections.',
            'currentPage' => 'services',
            'job' => $job,
        ]);
    }
}
