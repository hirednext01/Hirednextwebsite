# HiredNext CV Agent + Admin Audit Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Turn the existing HiredNext CV Reviews admin into an auditable multi-AI CV assessment, HiredNext-letterhead report approval, email delivery, and paid-upgrade workflow.

**Architecture:** Keep `cv_assessment_leads` as the parent record. Add analysis/report/event/email tables, a deterministic CV text extractor, optional OpenAI/Claude/Gemini adapters, a HiredNext synthesis/report builder, admin detail/actions, and a CLI worker. Candidate-facing output is a HiredNext-branded professional report; provider/model details remain admin-only.

**Tech Stack:** PHP 8.3, CodeIgniter 4.6, MySQL/MariaDB, CodeIgniter CURLRequest, existing HiredNext mail service.

**Spec:** `docs/superpowers/specs/2026-08-31-cv-agent-admin-design.md`

## Global Constraints
- Candidate sender: `jobs@hirednext.info`.
- Internal action recipient: `tarushikha@hirednext.info`.
- Paid selection != payment verified.
- Provider secrets only via environment variables.
- Every finding stores evidence, why-it-matters, severity and recommendation.
- Candidate report never exposes model names, raw prompts or provider audit.
- Existing `/admin/cv-reviews` remains the admin entry point.

---

### Task 1: Analysis/audit schema
**Files:**
- Create `app/Database/Migrations/2026-08-31-000001_CreateCvAnalysisTables.php`
- Create `app/Models/CvAnalysisRunModel.php`
- Create `app/Models/CvAnalysisFindingModel.php`
- Create `app/Models/CvReportVersionModel.php`
- Create `app/Models/CvReviewEventModel.php`
- Create `app/Models/CvEmailEventModel.php`

- [ ] Create five normalized tables: `cv_analysis_runs`, `cv_analysis_findings`, `cv_report_versions`, `cv_review_events`, `cv_email_events`.
- [ ] Add model methods to record append-only events and email outcomes.
- [ ] Verify each new PHP file with `php -l`.

### Task 2: CV extraction and provider layer
**Files:**
- Create `app/Services/Cv/CvTextExtractor.php`
- Create `app/Services/Cv/Provider/AiProviderInterface.php`
- Create `app/Services/Cv/Provider/OpenAiProvider.php`
- Create `app/Services/Cv/Provider/AnthropicProvider.php`
- Create `app/Services/Cv/Provider/GeminiProvider.php`

- [ ] DOCX extraction through ZipArchive/XML.
- [ ] PDF extraction through `pdftotext` when available; clear failure state if unavailable.
- [ ] DOC extraction through `antiword` when available; clear failure state if unavailable.
- [ ] Provider adapters return structured JSON findings and expose `configured()`.
- [ ] Hard limits: timeout, response size and no secrets in logs.
- [ ] Verify syntax.

### Task 3: HiredNext analysis orchestration
**Files:**
- Create `app/Services/Cv/CvAnalysisOrchestrator.php`
- Create `app/Services/Cv/HiredNextReportBuilder.php`
- Create `app/Services/Cv/CvAuditService.php`

- [ ] Claim one lead/run safely so duplicate analysis cannot start.
- [ ] Run deterministic extraction first.
- [ ] Run configured providers independently.
- [ ] Store provider status `completed|failed|not_configured`.
- [ ] Validate every provider finding has evidence/reason/severity/recommendation.
- [ ] Build HiredNext synthesis and commercial classification (`assessment_only|ats_optimisation|professional_rebuild|executive_rebuild`).
- [ ] Store a draft candidate report version.
- [ ] Record timeline events at every state change.
- [ ] Verify syntax.

### Task 4: Professional HiredNext report rendering
**Files:**
- Create `app/Views/pages/admin/cv-report-letterhead.php`
- Create `app/Services/Cv/CvReportRenderer.php`

- [ ] Render a sober HiredNext letterhead report with candidate/report metadata, recruiter summary, evidence-backed findings, priority changes and restrained optional recommendation.
- [ ] No AI/provider names or chat-like copy in candidate-facing output.
- [ ] Add print CSS so admin can `Print / Save as PDF` cleanly without a new PDF dependency.
- [ ] Add confidentiality footer, report ID, hirednext.net and jobs@hirednext.info.
- [ ] Verify syntax.

### Task 5: Admin detail, actions and audit history
**Files:**
- Modify `app/Controllers/CvReviewAdmin.php`
- Modify `app/Views/pages/admin/cv-reviews.php`
- Create `app/Views/pages/admin/cv-review-detail.php`
- Modify `app/Config/Routes.php`

- [ ] Add analysis/report status to list view.
- [ ] Add detail page with candidate/CV/payment state, provider audit, findings, HiredNext report preview/editor, timeline and email history.
- [ ] Add actions: Analyse now, Retry, Mark payment verified, Save report, Approve, Send, Offer ₹999, Offer ₹1,799, Offer ₹2,499.
- [ ] Every action records acting admin ID and event.
- [ ] Existing admin authentication remains required.
- [ ] Verify syntax.

### Task 6: Report and offer email delivery
**Files:**
- Create `app/Services/Cv/CvCandidateMailer.php`
- Modify `app/Controllers/CvReviewAdmin.php`

- [ ] Send approved candidate report from `jobs@hirednext.info` using professional HiredNext email copy.
- [ ] Record email attempt/sent/failed in `cv_email_events` and timeline.
- [ ] Internal action alert goes to `tarushikha@hirednext.info`.
- [ ] Upgrade offer emails are individual, evidence-led, optional and separate from recruitment consideration.
- [ ] Link TheProfile360 only as a post-improvement professional-profile step.
- [ ] Verify syntax.

### Task 7: Queue worker and backlog
**Files:**
- Create `app/Commands/CvAnalyse.php`
- Create `app/Commands/CvQueueExisting.php`

- [ ] `php spark cv:analyse [lead_id]` analyses one lead or next eligible queued lead.
- [ ] `php spark cv:queue-existing` creates queue/audit state for historical CVs without duplicate events.
- [ ] Priority order: verified ₹599 first, then free queue.
- [ ] Commands are idempotent and safe for cron/admin use.
- [ ] Verify syntax.

### Task 8: Integrate existing submission/payment events
**Files:**
- Modify `app/Controllers/CvAssessment.php`
- Modify `app/Controllers/CvPayment.php`

- [ ] Record `cv_received`, acknowledgement and payment-reference events when audit tables exist.
- [ ] Preserve existing hardcoded email-to-Taru pathway with CV attachment.
- [ ] Do not break submissions before migration; audit write gracefully no-ops if tables are not yet present.
- [ ] Verify syntax.

### Task 9: Deployment verification
- [ ] `php spark migrate`
- [ ] Syntax-check all new/modified PHP files.
- [ ] `php spark cv:queue-existing`
- [ ] Open `/admin/cv-reviews` and one detail page.
- [ ] Trigger analysis for one known test/free CV.
- [ ] Confirm provider status, findings, letterhead report preview and timeline.
- [ ] Confirm candidate-facing report contains no AI/provider branding.
- [ ] Confirm email history is recorded after a controlled test send.
- [ ] Only after verification, enable a 5-minute cron for `php spark cv:analyse` if desired.
