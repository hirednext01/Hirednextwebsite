<?php

namespace App\Services\Cv;

class CvUpgradePlans
{
    /**
     * Directly priced candidate career services that may create a secure checkout order.
     * Executive/C-suite work is intentionally excluded because pricing is bespoke.
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
            'career_strategy_4500' => [
                'name' => '1:1 Career Strategy Consultation',
                'amount' => 4500,
                'delivery' => 'One 60-minute consultation covering interview preparation, resume review and salary benchmarking',
                'description' => 'A focused one-to-one HiredNext career strategy session covering interview preparation, a senior review of the current resume and practical salary benchmarking for the candidate’s level, function and target move.',
            ],
        ];
    }

    /**
     * C-suite work is consultative and must never be shown with an automated price.
     */
    public static function executiveInquiry(): array
    {
        return [
            'tier' => 'executive_request',
            'name' => 'C-Suite Executive CV Advisory',
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
