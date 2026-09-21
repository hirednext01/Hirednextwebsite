<?php

namespace App\Services\Cv;

class CvUpgradePlans
{
    /**
     * Directly priced services that may create a secure checkout order.
     * "amount" is the rounded GST-inclusive rupee amount stored in the legacy
     * whole-rupee order tables. Base/GST fields preserve the transparent
     * commercial price shown to the candidate.
     */
    public static function all(): array
    {
        return [
            'priority_992' => [
                'name' => 'Priority CV Assessment',
                'base_amount' => 992,
                'gst_rate' => 18,
                'gst_amount' => 178.56,
                'payable_exact' => 1170.56,
                'amount' => 1171,
                'price_label' => '₹992 + GST',
                'payable_label' => '₹1,171 payable including GST',
                'delivery' => '12-hour review window after payment verification',
                'description' => 'A detailed recruiter-informed CV assessment with evidence-backed gaps, reasons and recommended changes.',
            ],
            'ats_999' => [
                'name' => 'ATS CV Optimisation',
                'amount' => 999,
                'price_label' => '₹999',
                'payable_label' => '₹999 payable',
                'delivery' => 'HiredNext rewrites and optimises your existing CV + 1 revision round',
                'description' => 'You give HiredNext your current CV. We improve ATS parsing, section structure, role language, keywords and recruiter scanability while preserving truthful career facts. The candidate does not build the CV themselves.',
            ],
            'rebuild_2500' => [
                'name' => 'Professional CV Rebuild',
                'base_amount' => 2500,
                'gst_rate' => 18,
                'gst_amount' => 450.00,
                'payable_exact' => 2950.00,
                'amount' => 2950,
                'price_label' => '₹2,500 + GST',
                'payable_label' => '₹2,950 payable including GST',
                'delivery' => 'Choose from 3 ATS-safe design directions · receive 2 completed CV variants + 2 revision rounds',
                'description' => 'HiredNext rebuilds the CV from the candidate’s existing document, strengthening positioning, achievement evidence, hierarchy and recruiter readability. The finished CV is created by HiredNext, not by the candidate.',
            ],
            'bundle_3317' => [
                'name' => 'CV Assessment + Professional CV Rebuild Bundle',
                'regular_base_amount' => 3492.00,
                'base_amount' => 3317.40,
                'discount_percent' => 5,
                'gst_rate' => 18,
                'gst_amount' => 597.13,
                'payable_exact' => 3914.53,
                'amount' => 3915,
                'price_label' => '₹3,317.40 + GST',
                'regular_price_label' => '₹3,492 + GST',
                'payable_label' => '₹3,915 payable including GST',
                'delivery' => 'Detailed written assessment + managed CV rebuild · 2 CV variants · 2 revision rounds',
                'description' => 'Get the full written CV assessment first, then have HiredNext turn those findings into a professionally rebuilt CV. The bundle is priced 5% below buying both services separately.',
            ],
            'executive_6999' => [
                'name' => 'Executive CV & Leadership Case Study',
                'amount' => 6999,
                'price_label' => '₹6,999',
                'payable_label' => '₹6,999 payable',
                'delivery' => '5–7 working days after the evidence questionnaire is complete · 2 revision rounds',
                'description' => 'A rigorous, human-reviewed executive career narrative: leadership positioning, evidence and scope analysis, a professionally written executive CV, and one signature leadership case study built from verified career facts.',
            ],
            'linkedin_8999' => [
                'name' => 'LinkedIn Leadership Positioning & Narrative Strategy',
                'regular_base_amount' => 17500,
                'base_amount' => 8999,
                'gst_rate' => 18,
                'gst_amount' => 1619.82,
                'payable_exact' => 10618.82,
                'amount' => 10619,
                'price_label' => '₹8,999 + GST',
                'regular_price_label' => '₹17,500 + GST',
                'payable_label' => '₹10,619 payable including GST',
                'campaign' => true,
                'delivery' => 'Deep assessment round + leadership narrative strategy + profile rewrite plan + specialist review',
                'description' => 'A confidential senior-professional LinkedIn positioning engagement designed to make leadership scope, credibility, expertise and career narrative easier for the right audience to understand.',
            ],
            'career_4500' => [
                'name' => '1:1 Interview Coaching with Taru Shikha',
                'amount' => 4500,
                'price_label' => '₹4,500',
                'payable_label' => '₹4,500 payable',
                'delivery' => '30-minute private session · role and company-specific interview preparation',
                'description' => 'A focused 30-minute interview coaching session with Taru Shikha covering how to position your experience, likely interview themes, practical tips and company-specific insights where sufficient information is available.',
            ],
        ];
    }

    /**
     * Keep historic checkout links and stored order tiers resolvable while
     * all new public journeys use the new 2026 campaign tiers.
     */
    public static function canonicalTier(string $tier): string
    {
        return match ($tier) {
            'priority_599' => 'priority_992',
            'rebuild_1799' => 'rebuild_2500',
            default => $tier,
        };
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
        $tier = self::canonicalTier($tier);
        return self::all()[$tier] ?? null;
    }
}
