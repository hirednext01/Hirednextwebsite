<?php

namespace App\Services\Cv\Provider;

class CvReviewPrompt
{
    public static function system(string $reviewer): string
    {
        return <<<TXT
You are one independent reviewer inside HiredNext Recruitment's structured CV assessment process.
Reviewer lens: {$reviewer}.

Rules:
- Analyse ONLY the supplied CV text and supplied HiredNext context.
- Never invent employers, titles, dates, achievements, salaries, team sizes, metrics, qualifications or capabilities.
- If evidence is missing, say "not evidenced in the CV"; do not claim the candidate lacks the underlying capability.
- Every finding must include finding, evidence, why_it_matters, severity and recommendation.
- Evidence should quote or tightly paraphrase the relevant CV text; keep quotations short.
- Recommendations must preserve factual accuracy and must never instruct the candidate to manufacture numbers.
- Distinguish ATS/readability problems from genuine career-positioning problems.
- Return JSON only. Do not include markdown fences or commentary outside JSON.
TXT;
    }

    public static function user(string $cvText, array $context = []): string
    {
        $jobTitle = trim((string) ($context['job_title'] ?? ''));
        $message = trim((string) ($context['message'] ?? ''));
        $plan = trim((string) ($context['assessment_plan'] ?? ''));
        $text = mb_substr($cvText, 0, 45000);

        return <<<TXT
HIREDNEXT CONTEXT
Target/job title if supplied: {$jobTitle}
Candidate note if supplied: {$message}
Assessment plan: {$plan}

CV TEXT
---
{$text}
---

Return this JSON object:
{
  "reviewer": "your reviewer/provider label",
  "summary": "2-4 sentence professional recruiter summary",
  "scores": {
    "ats_readiness": 0-100,
    "recruiter_scanability": 0-100,
    "role_positioning": 0-100,
    "evidence_strength": 0-100
  },
  "strengths": ["specific evidence-backed strength"],
  "findings": [
    {
      "category": "short machine category",
      "finding": "clear professional finding",
      "evidence": "what in the CV supports this or what is not evidenced",
      "why_it_matters": "why a recruiter/ATS/hiring manager cares",
      "severity": "low|medium|high",
      "recommendation": "specific truthful change"
    }
  ]
}
TXT;
    }

    public static function schema(): array
    {
        $finding = [
            'type' => 'object',
            'additionalProperties' => false,
            'properties' => [
                'category' => ['type' => 'string'],
                'finding' => ['type' => 'string'],
                'evidence' => ['type' => 'string'],
                'why_it_matters' => ['type' => 'string'],
                'severity' => ['type' => 'string', 'enum' => ['low', 'medium', 'high']],
                'recommendation' => ['type' => 'string'],
            ],
            'required' => ['category', 'finding', 'evidence', 'why_it_matters', 'severity', 'recommendation'],
        ];

        return [
            'type' => 'object',
            'additionalProperties' => false,
            'properties' => [
                'reviewer' => ['type' => 'string'],
                'summary' => ['type' => 'string'],
                'scores' => [
                    'type' => 'object',
                    'additionalProperties' => false,
                    'properties' => [
                        'ats_readiness' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 100],
                        'recruiter_scanability' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 100],
                        'role_positioning' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 100],
                        'evidence_strength' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 100],
                    ],
                    'required' => ['ats_readiness', 'recruiter_scanability', 'role_positioning', 'evidence_strength'],
                ],
                'strengths' => ['type' => 'array', 'items' => ['type' => 'string']],
                'findings' => ['type' => 'array', 'items' => $finding],
            ],
            'required' => ['reviewer', 'summary', 'scores', 'strengths', 'findings'],
        ];
    }

    public static function decodeJson(string $text): array
    {
        $text = trim($text);
        $decoded = json_decode($text, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        $start = strpos($text, '{');
        $end = strrpos($text, '}');
        if ($start !== false && $end !== false && $end > $start) {
            $decoded = json_decode(substr($text, $start, $end - $start + 1), true);
        }

        if (!is_array($decoded)) {
            throw new \RuntimeException('AI provider returned invalid JSON.');
        }

        return $decoded;
    }
}
