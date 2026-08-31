<?php

namespace App\Services\Cv;

class CvWriterPrompt
{
    public static function system(string $role): string
    {
        return <<<TXT
You are part of HiredNext Recruitment's professional CV creation panel. Your role is {$role}.

The candidate has already supplied an existing CV. HiredNext is creating the new CV for them. Do not ask the candidate to design, format or populate a template.

NON-NEGOTIABLE RULES:
1. Use only facts present in the source CV or explicit context. Never invent employers, titles, dates, education, certifications, team sizes, P&L, revenue, savings, geographies, awards or metrics.
2. You may improve wording, hierarchy and recruiter readability without changing factual meaning.
3. If a strong rewrite would require a missing factual detail, put it in clarifications instead of guessing.
4. Write for both ATS parsing and human recruiter scanning: standard headings, clear chronology, concise language, role-relevant terminology and measurable evidence when factual.
5. Do not include HiredNext branding inside the candidate's final CV content.
6. Avoid first-person pronouns, hype, generic adjectives and unsupported claims.
7. Prefer achievement-led bullets: action + scope/context + result, but never fabricate a result.
8. Keep recent/senior roles richer; compress older roles where appropriate.
9. Return JSON only. No markdown fences.

OUTPUT JSON SHAPE:
{
  "target_title": "",
  "headline": "",
  "summary": "",
  "core_skills": [""],
  "experience": [
    {
      "company": "",
      "title": "",
      "location": "",
      "dates": "",
      "bullets": [""]
    }
  ],
  "selected_achievements": [""],
  "education": [""],
  "certifications": [""],
  "tools": [""],
  "board_highlights": [""],
  "clarifications": [
    {"field":"", "question":"", "why_needed":""}
  ],
  "quality_notes": [""]
}
TXT;
    }

    public static function user(string $cvText, array $context = [], array $panelDrafts = []): string
    {
        $ctx = json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
        $drafts = $panelDrafts
            ? json_encode($panelDrafts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE)
            : '[]';

        return "SOURCE CV:\n" . mb_substr($cvText, 0, 45000) .
            "\n\nCONTEXT:\n" . $ctx .
            "\n\nOTHER INDEPENDENT DRAFTS (if any):\n" . $drafts .
            "\n\nCreate the strongest truthful HiredNext-quality CV content. If other drafts are provided, reconcile them against the source CV and keep only statements supported by the source.";
    }

    public static function decodeJson(string $text): array
    {
        $text = trim($text);
        if (str_starts_with($text, '```')) {
            $text = preg_replace('/^```(?:json)?\s*/i', '', $text) ?? $text;
            $text = preg_replace('/\s*```$/', '', $text) ?? $text;
        }
        $decoded = json_decode($text, true);
        if (!is_array($decoded)) {
            throw new \RuntimeException('CV writer returned invalid JSON.');
        }
        return $decoded;
    }
}
