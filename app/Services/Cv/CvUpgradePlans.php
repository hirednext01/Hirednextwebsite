<?php

namespace App\Services\Cv;

class CvUpgradePlans
{
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
                'delivery' => 'Existing CV optimised',
                'description' => 'Improves ATS parsing, section structure, role language, keywords and recruiter scanability while preserving truthful career facts.',
            ],
            'rebuild_1799' => [
                'name' => 'Professional CV Rebuild',
                'amount' => 1799,
                'delivery' => 'Two CV versions + two revision rounds',
                'description' => 'A deeper rebuild for profiles where content hierarchy, achievement evidence and positioning need more than keyword edits.',
            ],
            'executive_2499' => [
                'name' => 'Executive CV Rebuild',
                'amount' => 2499,
                'delivery' => 'Two executive CV versions + two revision rounds + HiredNext human review',
                'description' => 'Executive/CXO positioning focused on leadership scale, business impact, board/CEO readability and senior mandate relevance.',
            ],
        ];
    }

    public static function get(string $tier): ?array
    {
        return self::all()[$tier] ?? null;
    }
}
