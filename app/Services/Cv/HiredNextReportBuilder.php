<?php

namespace App\Services\Cv;

class HiredNextReportBuilder
{
    public function build(array $lead, array $reviews): array
    {
        $findings = $this->collectFindings($reviews);
        $scores = $this->aggregateScores($reviews);
        $strengths = $this->collectStrengths($reviews);
        $risk = $this->shortlistRisk($findings, $scores);
        $commercial = $this->commercialRecommendation($lead, $findings, $scores);
        $priorityChanges = array_slice($this->sortFindings($findings), 0, 10);

        $report = [
            'report_title' => 'HiredNext CV Assessment Report',
            'candidate_name' => (string) ($lead['name'] ?? 'Candidate'),
            'candidate_email' => (string) ($lead['email'] ?? ''),
            'job_title' => (string) ($lead['job_title'] ?? ''),
            'report_date' => date('d M Y'),
            'report_id' => 'HN-CV-' . str_pad((string) ($lead['id'] ?? '0'), 5, '0', STR_PAD_LEFT) . '-' . date('ymd'),
            'recruiter_summary' => $this->recruiterSummary($risk, $scores, $findings),
            'overall_verdict' => $this->verdict($risk, $findings),
            'shortlist_risk' => $risk,
            'scores' => $scores,
            'strengths' => $strengths,
            'findings' => $this->sortFindings($findings),
            'priority_changes' => $priorityChanges,
            'recommended_next_step' => $commercial,
            'methodology' => 'Prepared using HiredNext\'s structured recruiter assessment process and the evidence contained in the submitted CV.',
            'disclaimer' => 'This assessment is based on the submitted CV. It is professional advisory, not a guarantee of interview, shortlist or placement.',
        ];

        $report['report_text'] = $this->asText($report);
        return $report;
    }

    private function collectFindings(array $reviews): array
    {
        $out = [];
        $seen = [];
        foreach ($reviews as $review) {
            foreach (($review['findings'] ?? []) as $finding) {
                if (!is_array($finding)) {
                    continue;
                }
                $normalised = $this->normaliseFinding($finding, (string) ($review['reviewer'] ?? 'reviewer'));
                if (!$normalised) {
                    continue;
                }
                $key = strtolower($normalised['category'] . '|' . preg_replace('/\W+/u', '', mb_substr($normalised['finding'], 0, 80)));
                if (isset($seen[$key])) {
                    $idx = $seen[$key];
                    if ($this->severityRank($normalised['severity']) > $this->severityRank($out[$idx]['severity'])) {
                        $out[$idx] = $normalised;
                    }
                    continue;
                }
                $seen[$key] = count($out);
                $out[] = $normalised;
            }
        }
        return $out;
    }

    private function normaliseFinding(array $finding, string $reviewer): ?array
    {
        $required = ['category', 'finding', 'evidence', 'why_it_matters', 'recommendation'];
        foreach ($required as $key) {
            if (trim((string) ($finding[$key] ?? '')) === '') {
                return null;
            }
        }

        $severity = strtolower(trim((string) ($finding['severity'] ?? 'medium')));
        if (!in_array($severity, ['low', 'medium', 'high'], true)) {
            $severity = 'medium';
        }

        return [
            'reviewer' => $reviewer,
            'category' => mb_substr(trim((string) $finding['category']), 0, 100),
            'finding' => trim((string) $finding['finding']),
            'evidence' => trim((string) $finding['evidence']),
            'why_it_matters' => trim((string) $finding['why_it_matters']),
            'severity' => $severity,
            'recommendation' => trim((string) $finding['recommendation']),
        ];
    }

    private function aggregateScores(array $reviews): array
    {
        $keys = ['ats_readiness', 'recruiter_scanability', 'role_positioning', 'evidence_strength'];
        $scores = [];
        foreach ($keys as $key) {
            $values = [];
            foreach ($reviews as $review) {
                $value = $review['scores'][$key] ?? null;
                if (is_numeric($value)) {
                    $values[] = max(0, min(100, (int) round((float) $value)));
                }
            }
            sort($values);
            if (!$values) {
                $scores[$key] = 60;
                continue;
            }
            $count = count($values);
            $scores[$key] = $count % 2
                ? $values[(int) floor($count / 2)]
                : (int) round(($values[$count / 2 - 1] + $values[$count / 2]) / 2);
        }
        return $scores;
    }

    private function collectStrengths(array $reviews): array
    {
        $out = [];
        foreach ($reviews as $review) {
            foreach (($review['strengths'] ?? []) as $strength) {
                $strength = trim((string) $strength);
                if ($strength !== '' && !in_array($strength, $out, true)) {
                    $out[] = $strength;
                }
            }
        }
        return array_slice($out, 0, 6);
    }

    private function shortlistRisk(array $findings, array $scores): string
    {
        $high = count(array_filter($findings, static fn ($f) => ($f['severity'] ?? '') === 'high'));
        $average = array_sum($scores) / max(1, count($scores));
        if ($high >= 3 || $average < 58) {
            return 'high';
        }
        if ($high >= 1 || $average < 74) {
            return 'medium';
        }
        return 'low';
    }

    private function commercialRecommendation(array $lead, array $findings, array $scores): array
    {
        $highCategories = [];
        foreach ($findings as $finding) {
            if (($finding['severity'] ?? '') === 'high') {
                $highCategories[] = $finding['category'];
            }
        }
        $highCategories = array_values(array_unique($highCategories));
        $highCount = count($highCategories);
        $seniorText = strtolower(implode(' ', [
            (string) ($lead['job_title'] ?? ''),
            (string) ($lead['message'] ?? ''),
        ]));
        $looksExecutive = (bool) preg_match('/\b(cxo|ceo|cfo|coo|chro|chief|vice president|vp|director|business head|functional head)\b/i', $seniorText);
        $structuralCategories = array_intersect($highCategories, ['profile_summary', 'quantified_impact', 'achievement_language', 'leadership_scale', 'target_role_fit', 'content_depth']);

        if ($looksExecutive && count($structuralCategories) >= 2 && ($scores['role_positioning'] ?? 100) < 72) {
            return [
                'classification' => 'executive_rebuild',
                'service' => 'Executive CV Rebuild',
                'price' => 2499,
                'reason' => 'The profile appears senior/executive and the gaps are not limited to formatting. Leadership scale, positioning or evidence requires a more deliberate executive narrative and HiredNext human review.',
                'what_changes' => 'Two executive-ready CV versions, two revision rounds and senior-positioning review.',
            ];
        }

        if (count($structuralCategories) >= 3 || $highCount >= 4) {
            return [
                'classification' => 'professional_rebuild',
                'service' => 'Professional CV Rebuild',
                'price' => 1799,
                'reason' => 'Multiple structural/content gaps mean keyword editing alone is unlikely to solve the shortlisting problem.',
                'what_changes' => 'Two CV versions - ATS-focused and recruiter-facing - plus two revision rounds.',
            ];
        }

        $ats = (int) ($scores['ats_readiness'] ?? 100);
        $evidence = (int) ($scores['evidence_strength'] ?? 0);
        if ($ats < 74 && $evidence >= 58) {
            return [
                'classification' => 'ats_optimisation',
                'service' => 'ATS CV Optimisation',
                'price' => 999,
                'reason' => 'The career content appears usable, but ATS structure, role language or recruiter scanability needs correction.',
                'what_changes' => 'The existing CV is optimised for parsing, structure, keywords and recruiter readability without inventing career facts.',
            ];
        }

        return [
            'classification' => 'assessment_only',
            'service' => null,
            'price' => 0,
            'reason' => 'The CV has a workable base; the priority is to apply the recommended changes rather than purchase a rebuild automatically.',
            'what_changes' => 'No paid rebuild is automatically recommended from the current evidence.',
        ];
    }

    private function sortFindings(array $findings): array
    {
        usort($findings, fn ($a, $b) => $this->severityRank($b['severity'] ?? 'medium') <=> $this->severityRank($a['severity'] ?? 'medium'));
        return $findings;
    }

    private function severityRank(string $severity): int
    {
        return ['low' => 1, 'medium' => 2, 'high' => 3][$severity] ?? 2;
    }

    private function recruiterSummary(string $risk, array $scores, array $findings): string
    {
        $high = count(array_filter($findings, static fn ($f) => ($f['severity'] ?? '') === 'high'));
        if ($risk === 'high') {
            return 'The submitted CV contains career information that may be relevant, but the document currently creates material shortlisting risk. HiredNext identified ' . $high . ' high-impact evidence or positioning gaps that should be corrected before relying on this version for targeted applications.';
        }
        if ($risk === 'medium') {
            return 'The CV has a credible base, but important evidence and positioning issues reduce how quickly a recruiter can understand the candidate\'s fit. Targeted corrections should materially improve clarity and shortlisting readiness.';
        }
        return 'The CV is broadly recruiter-usable. The main opportunity is refinement: stronger evidence density, clearer role language and a more deliberate first-page narrative rather than wholesale rewriting.';
    }

    private function verdict(string $risk, array $findings): string
    {
        if ($risk === 'high') {
            return 'Do not rely on the current version for important applications until the high-impact gaps below are addressed.';
        }
        if ($risk === 'medium') {
            return 'Usable, but should be strengthened before targeted applications or senior recruiter conversations.';
        }
        return 'Usable with focused improvements; a full rebuild is not automatically justified.';
    }

    private function asText(array $report): string
    {
        $lines = [
            'HIREDNEXT CV ASSESSMENT REPORT',
            'Candidate: ' . $report['candidate_name'],
            'Report ID: ' . $report['report_id'],
            'Date: ' . $report['report_date'],
            '',
            'RECRUITER SUMMARY',
            $report['recruiter_summary'],
            '',
            'OVERALL VERDICT',
            $report['overall_verdict'],
            '',
            'PRIORITY CHANGES',
        ];
        foreach ($report['priority_changes'] as $i => $finding) {
            $lines[] = ($i + 1) . '. ' . $finding['finding'];
            $lines[] = 'Evidence: ' . $finding['evidence'];
            $lines[] = 'Why it matters: ' . $finding['why_it_matters'];
            $lines[] = 'Recommended change: ' . $finding['recommendation'];
            $lines[] = '';
        }
        $next = $report['recommended_next_step'];
        $lines[] = 'RECOMMENDED NEXT STEP';
        $lines[] = $next['service'] ? ($next['service'] . ' - ₹' . number_format((int) $next['price'])) : 'No paid rebuild automatically recommended';
        $lines[] = $next['reason'];
        $lines[] = '';
        $lines[] = $report['disclaimer'];
        return implode("\n", $lines);
    }
}
