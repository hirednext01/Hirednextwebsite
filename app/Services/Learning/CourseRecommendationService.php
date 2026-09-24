<?php

namespace App\Services\Learning;

class CourseRecommendationService
{
    public function recommend(array $profile, array $courses): array
    {
        $gaps = is_array($profile['gaps'] ?? null) ? $profile['gaps'] : [];
        $eligible = array_values(array_filter($gaps, static function ($gap): bool {
            if (!is_array($gap)) return false;
            $type = strtolower((string)($gap['type'] ?? ''));
            return in_array($type, ['capability','industry_knowledge','technology','commercial','leadership','certification'], true);
        }));
        if (!$eligible) return [];

        $targetRole = strtolower((string)($profile['target_role'] ?? ''));
        $targetIndustry = strtolower((string)($profile['target_industry'] ?? ''));
        $matches = [];

        foreach ($courses as $course) {
            if (($course['status'] ?? '') !== 'active') continue;
            if (($course['quality_status'] ?? 'approved') !== 'approved') continue;
            $haystack = strtolower(json_encode([
                $course['skills'] ?? [],
                $course['industries'] ?? [],
                $course['target_roles'] ?? [],
                $course['title'] ?? ''
            ]));

            foreach ($eligible as $gap) {
                $needle = strtolower(trim((string)($gap['required_capability'] ?? $gap['description'] ?? $gap['code'] ?? '')));
                if ($needle === '') continue;
                $tokens = array_values(array_filter(preg_split('/[^a-z0-9]+/i', $needle) ?: [], static fn($v) => strlen($v) > 3));
                $hits = 0;
                foreach ($tokens as $token) if (str_contains($haystack, strtolower($token))) $hits++;
                $score = $tokens ? min(70, ($hits / max(1, count($tokens))) * 70) : 0;
                if ($targetIndustry !== '' && str_contains($haystack, $targetIndustry)) $score += 15;
                if ($targetRole !== '' && str_contains($haystack, $targetRole)) $score += 10;
                $price = (int)($course['price_inr'] ?? 0);
                if ($price > 0 && $price <= 7500) $score += 5;
                if ($score < 45) continue;

                $matches[] = [
                    'course_id' => (int)($course['id'] ?? 0),
                    'gap_code' => (string)($gap['code'] ?? 'capability_gap'),
                    'relevance_score' => round(min(100, $score), 2),
                    'reason' => 'Recommended only for the documented capability gap: ' . $needle,
                ];
            }
        }

        usort($matches, static fn($a, $b) => $b['relevance_score'] <=> $a['relevance_score']);
        $unique = [];
        foreach ($matches as $row) {
            if (isset($unique[$row['course_id']])) continue;
            $unique[$row['course_id']] = $row;
            if (count($unique) >= 3) break;
        }
        return array_values($unique);
    }
}
