# HiredNext CV Agent + Admin Audit Design

## Goal
Build a production CV-assessment system inside the existing HiredNext CV Reviews admin so every submitted CV can be analysed, reviewed, approved, emailed, monetised, and audited without maintaining a separate dashboard.

## Core user outcome
For every CV record, the admin must show a chronological, human-readable history of what happened: CV received, payment state, analysis state, AI reviewers used, findings, evidence, HiredNext synthesis, report approval, report sent, upgrade offered, upgrade payment, rewrite state, and final delivery.

## Existing foundations to preserve
- Existing `cv_assessment_leads` table remains the canonical candidate/CV record.
- Existing `/admin/cv-reviews` remains the admin surface.
- Existing CV files remain under the current `writable/uploads/cv-assessments` storage path.
- Candidate email comes from `jobs@hirednext.info`.
- Internal action alerts go to `tarushikha@hirednext.info`.
- Payment selection and payment verification remain separate concepts; selecting Priority is never equivalent to being paid.

## Product tiers
1. Free CV Assessment — ₹0 — short report, 7–10 day queue.
2. Priority CV Assessment — ₹599 — detailed report, 12-hour target after payment verification.
3. ATS CV Optimisation — ₹999 — improve the existing CV for ATS parsing, keywords, structure and recruiter scanning.
4. Professional CV Rebuild — ₹1,799 — two CV versions plus two revision rounds.
5. Executive CV Rebuild — ₹2,499 — senior/CXO positioning, two versions, two revision rounds, mandatory HiredNext human review.

All paid services are optional and must never be represented as affecting job applications, interviews or placement.

## Multi-AI review model
The system uses independent reviewer roles. Each provider must form its initial opinion without seeing other providers' output.

### Reviewer roles
- Fact Extractor: employment, roles, dates, education, skills, achievements, quantified outcomes, team sizes, geographies and other explicit evidence.
- Recruiter Reviewer: shortlist likelihood, role positioning, recruiter scanability, career narrative and likely objections.
- ATS Reviewer: parsing/format risks, keyword coverage, section structure, chronology and role terminology.
- Leadership Reviewer: seniority calibration, evidence of scale, decision authority, transformation, P&L/commercial impact and stakeholder complexity.
- Devil's Advocate: attempts to reject the CV and states evidence-backed reasons.
- HiredNext Synthesiser: reconciles findings and disagreements into one recruiter-facing report.

### Provider adapters
The code supports OpenAI, Anthropic Claude and Google Gemini through server-side environment variables. A provider that is not configured must be shown as `not_configured` in admin and must never be silently treated as a completed review.

Environment variables:
- `OPENAI_API_KEY`
- `ANTHROPIC_API_KEY`
- `GEMINI_API_KEY`

No provider secret is stored in GitHub, database records, logs, or admin HTML.

## Evidence and hallucination rules
Every negative or positive conclusion must have an evidence chain:
1. Finding.
2. Exact evidence found in the CV, or explicit statement that evidence is absent.
3. Why the finding matters to a recruiter/ATS/hiring manager.
4. Severity: low, medium, high.
5. Recommended change.

The system must not invent employers, achievements, salaries, team sizes, dates, titles, metrics, education, certifications or business outcomes. Unknowns remain unknown. A finding may say `not evidenced in the CV`; it may not say `candidate lacks this capability` unless the CV explicitly supports that conclusion.

## Report structure
Each report stores:
- Overall recruiter verdict.
- Shortlist risk: low / medium / high.
- ATS readiness score with explanation.
- Recruiter scanability score with explanation.
- Role positioning score with explanation.
- Seniority calibration.
- Strongest selling points.
- Missing/weak evidence.
- Quantified impact review.
- Leadership scale review.
- Career chronology and gaps.
- Keyword/role-language gaps.
- Formatting/parsing risks.
- Potential red flags.
- Top 10 changes recommended.
- Recommended next service and reason.
- AI disagreements.
- Human reviewer notes.
- Final approved report text.

Scores are advisory signals, not statistical claims or guarantees.

## Processing priority
- Verified ₹599 requests first.
- Payment-reference-submitted requests next only after manual verification if required.
- Free queue after paid work.
- Executive rebuild work always requires human review before delivery.

## Admin workflow
Per CV:
`received -> queued -> extracting -> reviewing -> synthesis_ready -> human_review -> approved -> sent`

Error states:
`extract_failed`, `provider_failed`, `synthesis_failed`, `send_failed`.

Commercial states are tracked independently:
`free`, `priority_requested_unpaid`, `priority_payment_submitted`, `priority_paid`, `ats_999_offered`, `ats_999_paid`, `rebuild_1799_offered`, `rebuild_1799_paid`, `executive_2499_offered`, `executive_2499_paid`.

## Admin UI requirements
The existing `/admin/cv-reviews` page must add:
- Pipeline summary cards: queued, analysing, ready for review, sent, failed, verified paid.
- Per-candidate report status and last action.
- `Analyse now` action.
- `View analysis` action.
- `Approve & send` action.
- `Retry failed` action.
- `Mark payment verified` action.
- `Offer ATS ₹999`, `Offer Rebuild ₹1,799`, `Offer Executive ₹2,499` actions.
- CV download.
- Report preview/editor.
- Provider status panel showing OpenAI/Claude/Gemini outcome or not-configured state.
- Evidence table for findings.
- Timeline/audit log with timestamp, actor, event, channel and outcome.
- Email history showing subject, recipient, event type, sent/failed and timestamp.

## Email rules
All candidate messages originate from `jobs@hirednext.info`.

Report-delivery email includes:
- Thank-you acknowledgement.
- Link/attached or rendered report as implemented.
- Clear statement that findings are based on the submitted CV.
- Optional next-step recommendation selected by the report.
- Link to `https://www.theprofile360.in` after a revised/rebuilt CV is available.
- Statement that paid services are optional and unrelated to recruitment consideration.

Internal alerts to `tarushikha@hirednext.info` include candidate, service, payment state, report state and CV/report link or attachment where supported.

## Audit model
Create append-only event records. Important events include:
- cv_received
- acknowledgement_sent
- payment_reference_submitted
- payment_verified
- analysis_queued
- extraction_completed / failed
- provider_review_completed / failed / not_configured
- synthesis_completed / failed
- human_review_started
- report_approved
- report_sent / send_failed
- upgrade_offered
- upgrade_payment_submitted
- rewrite_started
- revision_requested
- rewrite_delivered

Admin actions must also record the acting admin user.

## Storage model
Keep `cv_assessment_leads` unchanged as the parent record and add focused tables:
- `cv_analysis_runs`
- `cv_analysis_findings`
- `cv_report_versions`
- `cv_review_events`
- `cv_email_events`

Do not place large provider payloads or secrets in the lead table.

## Automation model
Provide both:
- CLI worker command for scheduled processing of queued CVs.
- Admin `Analyse now` action for immediate processing.

The CLI command must be safe to run repeatedly and lock/claim work to avoid processing the same CV twice.

Recommended cron cadence after deployment: every 5 minutes. The code must function correctly even before cron is configured; admin-triggered processing remains available.

## Cost controls
- Free tier: at most two configured reviewer roles plus HiredNext synthesis.
- ₹599 tier: up to three independent providers plus synthesis.
- ₹999/₹1,799/₹2,499: deeper review may use all configured providers.
- Per-provider timeout and response-size limits.
- Failed providers do not trigger endless retries.
- Store usage metadata when provider responses expose it.

## Security
- CV files remain protected behind authenticated admin download routes.
- No public report endpoint containing candidate personal data.
- Provider calls are server-side only.
- Avoid sending unnecessary PII to providers; only CV content required for assessment is sent.
- Admin access uses existing HiredNext users/roles.
- CSRF protection remains on state-changing admin routes.

## Acceptance criteria
1. A new CV appears in admin with `received/queued` status and a timeline entry.
2. Admin can trigger analysis without downloading/reuploading the CV manually.
3. Configured providers run independently; unconfigured providers are visibly marked.
4. Each finding has evidence/reason/severity/recommendation.
5. Admin can edit and approve the final report before sending.
6. Sending creates an email audit record and timeline event.
7. Paid/unpaid status is never inferred merely from selected service.
8. Upgrade offers and subsequent payment states are visible in the same candidate record.
9. Existing CVs can be backfilled into the analysis queue.
10. Candidate messages come from `jobs@hirednext.info`; internal action alerts go to `tarushikha@hirednext.info`.
