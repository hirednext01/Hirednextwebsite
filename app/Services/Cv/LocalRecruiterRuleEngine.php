<?php

namespace App\Services\Cv;

class LocalRecruiterRuleEngine
{
    public function review(string $text, array $context = []): array
    {
        $lines = array_values(array_filter(array_map('trim', preg_split('/\n+/u', $text) ?: []), static fn ($v) => $v !== ''));
        $wordCount = preg_match_all('/\b[\pL\pN][\pL\pN\-+.&\/]*\b/u', $text) ?: 0;
        $findings = [];

        $this->checkLength($wordCount, $findings);
        $this->checkCoreSections($text, $findings);
        $this->checkQuantifiedImpact($lines, $findings);
        $this->checkLeadershipEvidence($lines, $findings);
        $this->checkResponsibilityLanguage($lines, $findings);
        $this->checkTargetRoleLanguage($text, $context, $findings);
        $this->checkExtractionStructure($text, $findings);

        $scores = $this->scores($findings, $wordCount);

        return [
            'reviewer' => 'hirednext_rules',
            'summary' => $this->summary($scores, $findings),
            'scores' => $scores,
            'findings' => $findings,
            'strengths' => $this->strengths($text, $lines),
            'usage' => ['local_rule_engine' => true],
        ];
    }

    private function checkLength(int $wordCount, array &$findings): void
    {
        if ($wordCount < 300) {
            $findings[] = $this->finding(
                'content_depth',
                'The CV is unusually brief for a professional profile.',
                'Extracted CV contains approximately ' . $wordCount . ' words.',
                'A very short CV can leave recruiters without enough evidence to judge scope, progression and outcomes.',
                'medium',
                'Add role scope and evidence of outcomes, but avoid padding with generic responsibilities.'
            );
        } elseif ($wordCount > 1900) {
            $findings[] = $this->finding(
                'scanability',
                'The CV is likely too dense for a first recruiter scan.',
                'Extracted CV contains approximately ' . $wordCount . ' words.',
                'Recruiters often make an initial relevance decision quickly; excessive density can bury the strongest evidence.',
                'medium',
                'Compress repeated responsibilities and retain the most decision-relevant achievements, scale and role evidence.'
            );
        }
    }

    private function checkCoreSections(string $text, array &$findings): void
    {
        $checks = [
            'profile_summary' => ['/(professional\s+summary|executive\s+summary|profile|career\s+summary|about\s+me)/i', 'A clear positioning summary is not evidenced.', 'Add a concise opening that states level, functional identity, sector/market relevance and the business problems you are strongest at solving.'],
            'skills' => ['/(key\s+skills|core\s+competenc|areas\s+of\s+expertise|skills)/i', 'A clearly labelled skills/competency section is not evidenced.', 'Create a focused skills section using role-relevant language rather than a long undifferentiated keyword list.'],
            'education' => ['/(education|academic|qualification)/i', 'Education/qualification information is not clearly evidenced.', 'Add a concise education/qualification section if it is missing from the submitted CV.'],
        ];

        foreach ($checks as $category => [$pattern, $finding, $recommendation]) {
            if (!preg_match($pattern, $text)) {
                $findings[] = $this->finding(
                    $category,
                    $finding,
                    'No clearly labelled section was detected in the extracted CV text.',
                    'Missing or unclear section hierarchy can weaken ATS parsing and recruiter navigation.',
                    $category === 'profile_summary' ? 'high' : 'medium',
                    $recommendation
                );
            }
        }
    }

    private function checkQuantifiedImpact(array $lines, array &$findings): void
    {
        $candidateLines = array_values(array_filter($lines, static function ($line) {
            return mb_strlen($line) >= 25 && mb_strlen($line) <= 260;
        }));
        $metricLines = array_values(array_filter($candidateLines, static function ($line) {
            return (bool) preg_match('/(?:\b\d+(?:\.\d+)?\s*%|[₹$£€]\s?\d|\b\d+(?:\.\d+)?\s*(?:cr|crore|lakh|million|billion|mn|bn|people|members|stores|countries|markets|plants|sites|months|years)\b)/i', $line);
        }));

        $ratio = count($candidateLines) > 0 ? count($metricLines) / count($candidateLines) : 0.0;
        if (count($metricLines) < 3 || $ratio < 0.04) {
            $evidence = $metricLines
                ? 'Only a small number of measurable-outcome lines were detected, for example: "' . $this->clip($metricLines[0]) . '".'
                : 'No strong quantified business-outcome statements were detected in the extracted text.';
            $findings[] = $this->finding(
                'quantified_impact',
                'Business impact is not sufficiently quantified.',
                $evidence,
                'Responsibilities explain what a person did; numbers and outcomes help a recruiter understand scale, consequence and comparative strength.',
                'high',
                'Where truthful and available, add scale such as revenue/cost impact, growth, turnaround, team size, geography, cycle-time, productivity, margin, delivery or transformation outcomes.'
            );
        }
    }

    private function checkLeadershipEvidence(array $lines, array &$findings): void
    {
        $leadershipLines = array_values(array_filter($lines, static function ($line) {
            return (bool) preg_match('/\b(led|leading|managed|managing|team of|p&l|profit|budget|board|c-suite|stakeholder|transformation|turnaround|strategy|strategic|built|scaled|head of|director|vice president|vp|chief)\b/i', $line);
        }));

        if (count($leadershipLines) < 3) {
            $findings[] = $this->finding(
                'leadership_scale',
                'Leadership scale and decision authority are not strongly evidenced in the CV.',
                $leadershipLines ? 'Limited leadership evidence detected, for example: "' . $this->clip($leadershipLines[0]) . '".' : 'Few explicit statements about team leadership, decision authority, P&L/budget, transformation or senior stakeholders were detected.',
                'For senior roles, title alone is rarely enough; hiring leaders look for evidence of scale, ownership and consequence.',
                'high',
                'Strengthen senior-role bullets with team/organisation scale, decision authority, commercial ownership, transformation scope and senior stakeholder context where factually true.'
            );
        }
    }

    private function checkResponsibilityLanguage(array $lines, array &$findings): void
    {
        $responsibilityLines = array_values(array_filter($lines, static function ($line) {
            return (bool) preg_match('/\b(responsible for|responsibilities include|duties include|involved in|worked on|handled|handling|looking after)\b/i', $line);
        }));

        if (count($responsibilityLines) >= 3) {
            $sample = implode(' / ', array_map(fn ($line) => '"' . $this->clip($line, 110) . '"', array_slice($responsibilityLines, 0, 2)));
            $findings[] = $this->finding(
                'achievement_language',
                'Too much of the CV reads as responsibility description rather than evidence of achievement.',
                'Responsibility-led phrasing detected repeatedly, including ' . $sample . '.',
                'Recruiters can often infer routine responsibilities from a title; differentiated shortlisting usually comes from outcomes, scale and difficult problems solved.',
                'high',
                'Rewrite the most important bullets as situation/action/outcome evidence. Preserve factual accuracy and do not manufacture metrics.'
            );
        }
    }

    private function checkTargetRoleLanguage(string $text, array $context, array &$findings): void
    {
        $target = trim((string) ($context['job_title'] ?? ''));
        if ($target === '') {
            return;
        }

        $tokens = array_values(array_unique(array_filter(preg_split('/[^\pL\pN]+/u', mb_strtolower($target)) ?: [], static function ($token) {
            return mb_strlen($token) >= 4 && !in_array($token, ['head', 'senior', 'manager', 'india', 'role'], true);
        })));

        if (!$tokens) {
            return;
        }

        $matched = 0;
        foreach ($tokens as $token) {
            if (mb_stripos($text, $token) !== false) {
                $matched++;
            }
        }

        if ($matched / count($tokens) < 0.5) {
            $findings[] = $this->finding(
                'target_role_fit',
                'The CV does not strongly mirror the language of the stated target role.',
                'Target role recorded by HiredNext: "' . $target . '". Fewer than half of the distinctive title terms were found in the CV text.',
                'A relevant background can still be missed if the CV does not make the connection to the target mandate easy for ATS/recruiters to see.',
                'medium',
                'Use truthful role-relevant terminology in the summary, skills and achievement bullets where the experience genuinely supports it.'
            );
        }
    }

    private function checkExtractionStructure(string $text, array &$findings): void
    {
        $tabs = substr_count($text, "\t");
        $lines = max(1, substr_count($text, "\n") + 1);
        if ($tabs > $lines * 0.7) {
            $findings[] = $this->finding(
                'ats_structure',
                'The extracted structure suggests heavy table/tab-based formatting.',
                'The text extraction contains a high number of tab separators relative to lines.',
                'Complex tables, columns and text boxes can create inconsistent ATS reading order even when the document looks attractive to a human.',
                'medium',
                'Keep the ATS version single-column with conventional headings and simple text flow; reserve heavier visual styling for the recruiter-facing version.'
            );
        }
    }

    private function scores(array $findings, int $wordCount): array
    {
        $base = [
            'ats_readiness' => 82,
            'recruiter_scanability' => 82,
            'role_positioning' => 82,
            'evidence_strength' => 82,
        ];

        foreach ($findings as $finding) {
            $penalty = ($finding['severity'] ?? 'medium') === 'high' ? 11 : (($finding['severity'] ?? '') === 'low' ? 3 : 7);
            $category = $finding['category'] ?? '';
            if (in_array($category, ['ats_structure', 'skills', 'education'], true)) {
                $base['ats_readiness'] -= $penalty;
            }
            if (in_array($category, ['scanability', 'content_depth', 'achievement_language'], true)) {
                $base['recruiter_scanability'] -= $penalty;
            }
            if (in_array($category, ['profile_summary', 'target_role_fit', 'leadership_scale'], true)) {
                $base['role_positioning'] -= $penalty;
            }
            if (in_array($category, ['quantified_impact', 'leadership_scale', 'achievement_language'], true)) {
                $base['evidence_strength'] -= $penalty;
            }
        }

        if ($wordCount >= 450 && $wordCount <= 1500) {
            $base['recruiter_scanability'] += 3;
        }

        foreach ($base as &$score) {
            $score = max(35, min(92, $score));
        }
        unset($score);

        return $base;
    }

    private function strengths(string $text, array $lines): array
    {
        $strengths = [];
        if (preg_match('/\b(led|managed|built|scaled|transformation|strategy|p&l|board)\b/i', $text)) {
            $strengths[] = 'The CV contains some evidence of ownership/leadership language that can be developed further.';
        }
        if (preg_match('/(?:\b\d+(?:\.\d+)?\s*%|[₹$£€]\s?\d)/u', $text)) {
            $strengths[] = 'The CV contains measurable information; the strongest metrics should be surfaced more deliberately.';
        }
        if (preg_match('/\b(education|qualification|degree|mba|b\.?(?:tech|com|sc)|m\.?(?:tech|com|sc))\b/i', $text)) {
            $strengths[] = 'Qualification information appears to be present and can be retained in a concise structured section.';
        }
        if (!$strengths && $lines) {
            $strengths[] = 'The submitted CV contains readable career information that can be reorganised around role relevance and evidence.';
        }
        return array_slice($strengths, 0, 4);
    }

    private function summary(array $scores, array $findings): string
    {
        $high = count(array_filter($findings, static fn ($f) => ($f['severity'] ?? '') === 'high'));
        if ($high >= 3) {
            return 'The CV contains usable career information, but several high-impact positioning/evidence gaps are likely to weaken shortlisting until the document is reworked.';
        }
        if ($high >= 1) {
            return 'The CV is broadly usable but contains material gaps that should be corrected before relying on it for targeted applications.';
        }
        return 'The CV has a workable base. The main opportunity is to improve recruiter scanability, role language and evidence density rather than rewrite indiscriminately.';
    }

    private function finding(string $category, string $finding, string $evidence, string $why, string $severity, string $recommendation): array
    {
        return [
            'category' => $category,
            'finding' => $finding,
            'evidence' => $evidence,
            'why_it_matters' => $why,
            'severity' => $severity,
            'recommendation' => $recommendation,
        ];
    }

    private function clip(string $text, int $length = 160): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
        return mb_strlen($text) > $length ? mb_substr($text, 0, $length - 1) . '…' : $text;
    }
}
