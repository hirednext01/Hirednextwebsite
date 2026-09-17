<?php

namespace App\Services\Cv;

class CvUpgradePlans
{
    /**
     * Directly priced services that may create a secure checkout order.
     * Each listed service may create a secure checkout order.
     */
    public static function all(): array
    {
        return [
            'priority_599' => [
                'name' => 'Priority CV Assessment',
                'amount' => 599,
                'delivery' => '12-hour review window after payment verification',
                'description' => 'A detailed recruiter-informed CV assessment with evidence-backed gaps, reasons and recommended changes.',
            ],
            'ats_999' => [
                'name' => 'ATS CV Optimisation',
                'amount' => 999,
                'delivery' => 'HiredNext rewrites and optimises your existing CV + 1 revision round',
                'description' => 'You give HiredNext your current CV. We improve ATS parsing, section structure, role language, keywords and recruiter scanability while preserving truthful career facts. The candidate does not build the CV themselves.',
            ],
            'rebuild_1799' => [
                'name' => 'Professional CV Rebuild',
                'amount' => 1799,
                'delivery' => 'Choose from 3 ATS-safe design directions · receive 2 completed CV variants + 2 revision rounds',
                'description' => 'HiredNext rebuilds the CV from the candidate’s existing document, strengthening positioning, achievement evidence, hierarchy and recruiter readability. The finished CV is created by HiredNext, not by the candidate.',
            ],
            'executive_6999' => [
                'name' => 'Executive CV & Leadership Case Study',
                'amount' => 6999,
                'delivery' => '5–7 working days after the evidence questionnaire is complete · 2 revision rounds',
                'description' => 'A rigorous, human-reviewed executive career narrative: leadership positioning, evidence and scope analysis, a professionally written executive CV, and one signature leadership case study built from verified career facts.',
            ],
            'career_4500' => [
                'name' => '1:1 Interview Coaching with Taru Shikha',
                'amount' => 4500,
                'delivery' => '30-minute private session · role and company-specific interview preparation',
                'description' => 'A focused 30-minute interview coaching session with Taru Shikha covering how to position your experience, likely interview themes, practical tips and company-specific insights where sufficient information is available.',
            ],
        ];
    }

    public static function executiveInquiry(): array
    {
        return [
            'tier' => 'executive_request',
            'name' => 'Bespoke C-Suite Advisory',
            'price_label' => 'Price on Request',
            'delivery' => '1-to-1 positioning call + specialist executive resume expert + bespoke executive CV',
            'description' => 'For CXO, board and senior leadership profiles where the career story, mandate relevance, leadership scale and board-level positioning require bespoke human input.',
        ];
    }

    public static function get(string $tier): ?array
    {
        return self::all()[$tier] ?? null;
    }
}
