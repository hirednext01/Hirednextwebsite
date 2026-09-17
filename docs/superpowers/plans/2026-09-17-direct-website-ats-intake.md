# Direct Website-to-ATS Intake Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make Recruit OS the only permanent store for new website job applications, retain verified applicant identity and LinkedIn data, and show only truthful ATS application counts.

**Architecture:** The CodeIgniter website validates the applicant and temporary upload, then sends one authenticated multipart request directly to Recruit OS. Recruit OS validates file signature, job mapping and verified identity, persists the CV and application atomically, and returns durable IDs; the website does not move the file, insert `job_applications`, or publish a resume URL. Legacy website CV files remain read-only until their ATS receipts are verified.

**Tech Stack:** CodeIgniter 4 / PHP 8.1; FastAPI / SQLAlchemy / Pydantic; PostgreSQL; existing Recruit OS object storage.

**Spec:** Approved conversation design: immediate website transfer, ATS-only permanent CV storage, fail closed, exact job-code mapping, LinkedIn capture, truthful application counts.

## Global Constraints

- No API key in source, HTML, email, logs, redirects, or client-side JavaScript.
- No new website `job_applications` row and no file move into `public/uploads/resumes`.
- The website must claim success only after Recruit OS returns candidate, document and receipt IDs.
- Existing recruiter-verified fields must not be overwritten by repeat intake.
- Legacy website CVs are not deleted until separately migrated and receipt-verified.

---

### Task 1: Extend Recruit OS verified website metadata

**Files:**
- Modify: `backend/routers/resume_ingest.py`
- Modify: `backend/tests/test_resume_ingest.py`

**Interfaces:**
- Consumes: multipart `file`, `metadata`, `X-Api-Key`
- Produces: verified `candidate_phone`, `candidate_linkedin`, `candidate_message` persisted without overwriting recruiter fields

- [ ] **Step 1: Write failing tests** for storing verified website phone/LinkedIn/message and preserving existing non-empty fields.
- [ ] **Step 2: Run the focused ingest tests and verify the new assertions fail.**
- [ ] **Step 3: Add bounded metadata fields and minimal verified-field persistence.**
- [ ] **Step 4: Run focused and existing ingest tests; verify all pass.**

### Task 2: Add the website ATS client and replace local persistence

**Files:**
- Create: `app/Libraries/RecruitOsIntakeClient.php`
- Modify: `app/Controllers/Home.php`
- Modify: `app/Models/JobModel.php`
- Modify: `app/Controllers/Jobs.php`
- Test: `tests/recruit_os_direct_intake_test.php`

**Interfaces:**
- Consumes: validated CodeIgniter UploadedFile and applicant fields
- Produces: `{status, receipt_id, candidate_id, document_id, application_id, requires_review}`

- [ ] **Step 1: Write a source-contract test** that fails while `Home::applyJob()` still moves files, inserts website application rows, emails resume links, or lacks ATS receipt validation.
- [ ] **Step 2: Run it and verify failure for the legacy path.**
- [ ] **Step 3: Implement server-only multipart intake** using `RECRUIT_OS_INGEST_URL` and `RECRUIT_OS_INGEST_API_KEY`, deterministic source IDs, verified identity fields and exact job-code mapping.
- [ ] **Step 4: Fail closed** on missing config, network errors, non-2xx responses, malformed JSON or missing durable IDs.
- [ ] **Step 5: Replace estimated local application counts** with exact Recruit OS counts when the endpoint is available; otherwise hide the number.
- [ ] **Step 6: Run PHP syntax and source-contract tests.**

### Task 3: Add a privacy-safe public ATS count endpoint

**Files:**
- Modify: `backend/routers/resume_ingest.py`
- Modify: `backend/tests/test_resume_ingest.py`

**Interfaces:**
- Consumes: approved job code
- Produces: `{job_code, application_count}` with no candidate data

- [ ] **Step 1: Write failing tests** for exact count and unknown/unapproved job behavior.
- [ ] **Step 2: Run and verify failure.**
- [ ] **Step 3: Implement the read-only aggregate endpoint.**
- [ ] **Step 4: Re-run focused tests and verify pass.**

### Task 4: Release and live verification

**Files:**
- Update the existing Recruit OS migration branch and open/update the website PR.

**Interfaces:**
- Consumes: CI results and production environment values
- Produces: one real end-to-end website receipt with matching candidate/document/application IDs

- [ ] **Step 1: Push both reviewed changes and wait for CI.**
- [ ] **Step 2: Configure the existing CV-intake secret only in Hostinger server environment.**
- [ ] **Step 3: Submit one authorized test application and verify Recruit OS IDs, readable CV, exact job attachment and no website row/file.**
- [ ] **Step 4: Re-submit the same source and verify no duplicate record.**

