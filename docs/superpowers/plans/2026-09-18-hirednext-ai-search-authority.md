# HiredNext AI Search Authority Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Strengthen HiredNext's Google and AI-search authority for employer mandates, jobs, CV assessment/rebuild and interview preparation using truthful canonical pages and machine-readable evidence.

**Architecture:** Reuse the existing CodeIgniter authority architecture rather than creating a parallel SEO subsystem. Strengthen existing commercial pages, add one educational interview-preparation guide, then connect all five intents through entity JSON, sitemap, llms.txt, schema and internal links.

**Tech Stack:** PHP 8 / CodeIgniter 4, existing Tailwind-style view classes, JSON-LD, existing PHP/node regression tests, GitHub Actions, Hostinger deployment, SE Ranking measurement.

**Spec:** `docs/superpowers/specs/2026-09-18-hirednext-ai-search-authority-design.md`

## Global Constraints

- HiredNext was founded in Mumbai in 2016.
- Current GST-registered and operating base is Gurugram (Gurgaon), Haryana, India.
- HiredNext is remote-first and has no public walk-in office.
- Never publish unsupported "#1", "best" or guaranteed-result claims.
- CV Assessment remains ₹599 including GST under the currently published service.
- Professional CV Rebuild remains ₹1,799 including GST and retains its currently published scope.
- The ₹999 Interview Ready pilot remains not open for purchase.
- The current ₹4,500 30-minute 1-to-1 consultation may remain commercially visible.
- Paid career services remain separate from recruitment consideration.
- Do not alter payment, CV fulfilment, Recruit OS or CRM behavior.
- Do not create a duplicate Google Business Profile.

---

### Task 1: Add an AI-search authority regression gate

**Files:**
- Create: `tests/ai_search_authority_test.php`
- Read: `app/Config/BrandFacts.php`
- Read: `app/Config/Routes.php`
- Read: `app/Controllers/EntityAuthority.php`
- Read: `app/Controllers/Seo.php`

**Interfaces:**
- Consumes: existing public route/config source files.
- Produces: one deterministic CLI test that fails when canonical intent routes or identity facts drift.

- [ ] **Step 1: Write the failing test**

Create `tests/ai_search_authority_test.php` that loads source files as text and asserts all of the following:
- BrandFacts contains `founded_in => Mumbai, Maharashtra, India`.
- BrandFacts contains `registered_location => Gurugram (Gurgaon), Haryana, India`.
- EntityAuthority includes `HiredNext Recruitment`, `CV Assessment`, `Professional CV Rebuild`, and `Interview Preparation` after implementation.
- Routes contains `guides/interview-preparation-india`.
- Seo sitemap contains `guides/interview-preparation-india`.
- The string `India's #1` is absent from the new/modified authority sources.
- The interview guide source says the ₹999 pilot is not open for purchase.

Use a small helper:
```php
function mustContain(string $haystack, string $needle, string $label): void {
    if (strpos($haystack, $needle) === false) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}
```

- [ ] **Step 2: Run the test and verify it fails**

Run:
```bash
php tests/ai_search_authority_test.php
```
Expected: FAIL because the new interview authority route/entity intent does not exist yet.

- [ ] **Step 3: Commit only the failing test**

```bash
git add tests/ai_search_authority_test.php
git commit -m "test: define AI search authority contract"
```

### Task 2: Build the interview-preparation authority guide

**Files:**
- Modify: `app/Config/Routes.php`
- Modify: `app/Controllers/DecisionGuides.php`
- Modify: `app/Config/DecisionGuides.php`
- Reuse: `app/Views/pages/guides/decision-guide.php`
- Test: `tests/ai_search_authority_test.php`

**Interfaces:**
- Consumes: `DecisionGuides::show(string $slug)` and `DecisionGuides::$guides` configuration pattern.
- Produces: GET `/guides/interview-preparation-india` rendered through the existing decision-guide view.

- [ ] **Step 1: Add the explicit canonical route**

Add before the wildcard `guides/(:segment)` route:
```php
$routes->get('guides/interview-preparation-india', 'DecisionGuides::show/interview-preparation-india');
```

- [ ] **Step 2: Add the guide configuration**

Add an `interview-preparation-india` item to `app/Config/DecisionGuides.php` with:
- title: `Interview Preparation in India for Experienced Professionals`
- meta title focused on senior/interview preparation India
- a short answer explaining role-specific evidence, examples, outcome structure and truthfulness
- visible sections covering role research, example selection, STAR/context-action-result discipline, senior leadership questions, compensation/motivation, questions to ask employers
- `where_hirednext_fits` stating the live 30-minute consultation exists and the ₹999 Interview Ready pilot is not open for purchase
- FAQs including the difference between the live consultation and pilot
- related links to `services/candidates`, `jobs`, and `about/taru-shikha`

Do not insert guaranteed outcomes or predicted employer questions.

- [ ] **Step 3: Ensure DecisionGuides schema classifies this page as candidate guidance**

In `DecisionGuides::show()`, preserve the existing employer guide schema for employer slugs, but for `interview-preparation-india` set WebPage `about` values to interview preparation, senior interviews, role-specific evidence and career communication. Do not label this guide an EmploymentAgency service.

- [ ] **Step 4: Run syntax and regression tests**

```bash
php -l app/Config/Routes.php
php -l app/Config/DecisionGuides.php
php -l app/Controllers/DecisionGuides.php
php tests/ai_search_authority_test.php
```
Expected: syntax PASS; authority test may still fail on later entity/discovery assertions.

- [ ] **Step 5: Commit**

```bash
git add app/Config/Routes.php app/Config/DecisionGuides.php app/Controllers/DecisionGuides.php
git commit -m "feat: add interview preparation authority guide"
```

### Task 3: Strengthen candidate-service intent ownership

**Files:**
- Modify: `app/Controllers/CandidateServices.php`
- Modify: `app/Views/pages/services/candidate-services.php`
- Modify: `app/Views/pages/services/cv-assessment.php`
- Modify: `app/Views/pages/services/_cv-service-faq.php`
- Test: `tests/ai_search_authority_test.php`
- Re-run: `tests/cv_assessment_conversion_test.php`, `tests/cv_public_checkout_test.php`

**Interfaces:**
- Consumes: current checkout URLs and service prices.
- Produces: stronger answer-first visible copy and truthful Service/FAQ schema without changing checkout behavior.

- [ ] **Step 1: Extend the failing authority test**

Assert candidate-services contains:
- `CV rebuild service in India`
- visible separation between recruitment and paid career services
- link to `guides/interview-preparation-india`

Assert cv-assessment contains:
- `CV assessment in India`
- visible text explaining recruiter/hiring-manager interpretation
- no numeric ATS score promise.

Run `php tests/ai_search_authority_test.php` and verify FAIL.

- [ ] **Step 2: Update CandidateServices metadata/schema**

Change candidate-services title/description to naturally include:
- CV assessment India,
- professional CV rebuild / CV writing,
- senior/executive career support.

Keep the live offers exactly as currently sold. Do not represent the ₹999 pilot as an Offer.

Add the live 1-to-1 consultation as a Service/Offer only if the existing checkout route remains available.

- [ ] **Step 3: Add one answer-first block to candidate-services**

Immediately after the hero, add visible copy headed:
`CV assessment and CV rebuild services in India — what HiredNext actually does`

Explain in concise prose:
- assessment diagnoses positioning/evidence gaps,
- rebuild rewrites and restructures only from verified facts,
- interview support is separate,
- buying career services cannot influence recruitment shortlisting.

Link naturally to assessment, rebuild, interview guide and jobs.

- [ ] **Step 4: Strengthen the CV assessment page**

Add visible content that explains what a recruiter/hiring manager can and cannot infer from a CV, using no invented metrics.

Add/adjust FAQ entries so visible FAQs and FAQ schema cover:
- what the ₹599 assessment includes,
- whether it guarantees interviews (no),
- assessment vs rebuild,
- whether candidates can implement fixes themselves (yes).

- [ ] **Step 5: Run candidate-service regressions**

```bash
php -l app/Controllers/CandidateServices.php
php -l app/Views/pages/services/candidate-services.php
php -l app/Views/pages/services/cv-assessment.php
php -l app/Views/pages/services/_cv-service-faq.php
php tests/ai_search_authority_test.php
php tests/cv_assessment_conversion_test.php
php tests/cv_public_checkout_test.php
```
Expected: all PASS except any authority assertions reserved for later tasks.

- [ ] **Step 6: Commit**

```bash
git add app/Controllers/CandidateServices.php app/Views/pages/services/candidate-services.php app/Views/pages/services/cv-assessment.php app/Views/pages/services/_cv-service-faq.php tests/ai_search_authority_test.php
git commit -m "feat: strengthen CV service search authority"
```

### Task 4: Strengthen employer mandate and jobs authority

**Files:**
- Modify: `app/Views/pages/services/client-services.php`
- Modify: `app/Config/DecisionGuides.php`
- Modify: `app/Controllers/Jobs.php`
- Modify: `app/Views/pages/jobs.php`
- Test: `tests/ai_search_authority_test.php`

**Interfaces:**
- Consumes: existing employer guide, hiring-discussion CTA and live jobs database.
- Produces: answer-first employer and jobs content without changing application behavior.

- [ ] **Step 1: Add regression assertions**

Test for:
- `Discuss Your Hiring Mandate` in client-services.
- `executive search`, `leadership hiring` and `specialist recruitment` in the top recruitment guide.
- jobs page visible text stating applications are free and paid career services do not influence shortlisting.

Run authority test and verify FAIL on the new jobs assertion before implementation.

- [ ] **Step 2: Strengthen client-services visible answer block**

Add a concise section headed:
`Which recruitment mandates is HiredNext built for?`

Cover:
- CXO/VP/Director/functional-head search,
- specialist and mid-senior hiring,
- GCC/technology/BFSI/manufacturing/apparel/retail coverage,
- direct search / market mapping,
- RPO for broader repeatable demand.

Link to top-recruitment-company guide, mandate stories and hiring discussion.

- [ ] **Step 3: Refine decision-guide answer copy**

Keep the existing nuanced "top" framing. Ensure the short answer names HiredNext only after explaining selection criteria. Preserve evidence links and no universal-best claim.

- [ ] **Step 4: Add jobs authority copy**

In `Jobs::index()`, keep CollectionPage/ItemList schema. Extend description/about terms to senior jobs, leadership jobs, specialist jobs and active employer mandates.

In `jobs.php`, add a compact visible block below the hero:
- HiredNext manages current employer mandates rather than acting as a mass job board.
- Applications are free.
- Jobs span leadership, finance, technology, manufacturing, retail and specialist functions as available.
- Paid CV services are optional and do not influence selection.

- [ ] **Step 5: Run syntax and authority tests**

```bash
php -l app/Views/pages/services/client-services.php
php -l app/Config/DecisionGuides.php
php -l app/Controllers/Jobs.php
php -l app/Views/pages/jobs.php
php tests/ai_search_authority_test.php
```

- [ ] **Step 6: Commit**

```bash
git add app/Views/pages/services/client-services.php app/Config/DecisionGuides.php app/Controllers/Jobs.php app/Views/pages/jobs.php tests/ai_search_authority_test.php
git commit -m "feat: strengthen mandate and jobs authority"
```

### Task 5: Connect the five intents to machine-readable discovery

**Files:**
- Modify: `app/Controllers/EntityAuthority.php`
- Modify: `app/Controllers/Seo.php`
- Modify if needed: `app/Views/layouts/main.php`
- Test: `tests/ai_search_authority_test.php`
- Re-run: `tests/authority_api_response_test.php`

**Interfaces:**
- Consumes: canonical routes created/strengthened in Tasks 2-4.
- Produces: one consistent organization/service graph, sitemap and llms discovery path.

- [ ] **Step 1: Extend organization entity services**

In `EntityAuthority::entityJson()`, append truthful services:
```php
['@type' => 'Service', 'name' => 'CV Assessment', 'url' => 'https://hirednext.net/services/cv-assessment'],
['@type' => 'Service', 'name' => 'Professional CV Rebuild', 'url' => 'https://hirednext.net/services/candidates'],
['@type' => 'Service', 'name' => 'Interview Preparation and Career Consultation', 'url' => 'https://hirednext.net/guides/interview-preparation-india'],
```
Also expose jobs as a canonical organizational action/URL without calling job applications a paid service.

Update `updated_on` to `2026-09-18`.

- [ ] **Step 2: Correct sitemap discovery**

Add `/guides/interview-preparation-india` with `lastmod=2026-09-18`.

Remove `/pilots/interview-ready.html` from sitemap while its page contains `noindex`.

Update lastmod for candidate-services, cv-assessment, jobs, client-services and top recruitment guide only because this release changes them.

- [ ] **Step 3: Update llms.txt**

In `Seo::llms()`, ensure the five canonical intents are explicitly listed with their URLs and truthful status:
- employer mandates,
- jobs,
- CV assessment,
- CV rebuild,
- interview preparation guide / live consultation.
Do not list the ₹999 pilot as purchasable.

- [ ] **Step 4: Add footer links only if missing**

If the footer does not already expose the canonical commercial pages, add compact links to Jobs, Employer Services, CV Assessment, CV Rebuild and Interview Preparation. Do not add city "office" labels.

- [ ] **Step 5: Run discovery/authority regressions**

```bash
php -l app/Controllers/EntityAuthority.php
php -l app/Controllers/Seo.php
php -l app/Views/layouts/main.php
php tests/ai_search_authority_test.php
php tests/authority_api_response_test.php
```
Expected: PASS.

- [ ] **Step 6: Commit**

```bash
git add app/Controllers/EntityAuthority.php app/Controllers/Seo.php app/Views/layouts/main.php tests/ai_search_authority_test.php
git commit -m "feat: connect commercial intents to AI discovery"
```

### Task 6: Final verification, PR and post-release measurement

**Files:**
- No new production files unless a verification defect requires a targeted fix.
- Validate: all files changed in Tasks 1-5.

**Interfaces:**
- Consumes: complete branch.
- Produces: reviewed PR ready to merge, then measurable Google/AI baseline after deployment.

- [ ] **Step 1: Run the focused test suite**

```bash
php tests/ai_search_authority_test.php
php tests/authority_api_response_test.php
php tests/cv_assessment_conversion_test.php
php tests/cv_public_checkout_test.php
```
Expected: all PASS.

- [ ] **Step 2: Run PHP syntax checks on every modified PHP source**

Run `php -l` on Routes, DecisionGuides config/controller, CandidateServices controller, Jobs controller, EntityAuthority, Seo and modified views.

Expected: every file reports `No syntax errors detected`.

- [ ] **Step 3: Review diff for prohibited claims**

Search the branch diff for:
```text
India's #1
guaranteed
guarantee interviews
guaranteed placement
public walk-in
```
Expected: no new unsupported promotional claims. Legitimate disclaimers such as "does not guarantee" are allowed.

- [ ] **Step 4: Open a pull request**

PR title:
`AI search authority: jobs, mandates and career services`

PR body must summarize:
- five intents,
- truthful interview-service distinction,
- no GBP duplication/address change,
- tests run,
- expected measurement plan.

- [ ] **Step 5: Merge only after checks pass**

Use the repository's normal merge/deploy path. Do not bypass failing SEO or production checks.

- [ ] **Step 6: Verify production**

Check live HTTP responses for:
- `/`
- `/jobs`
- `/services/clients`
- `/services/candidates`
- `/services/cv-assessment`
- `/top-recruitment-company-india`
- `/guides/interview-preparation-india`
- `/authority/entity.json`
- `/llms.txt`
- `/sitemap.xml`

Expected: 200, canonical content present, no pilot purchasability claim.

- [ ] **Step 7: Re-run SE Ranking measurement**

After deployment:
- run Google position checks for the existing commercial keyword groups,
- read ChatGPT/Perplexity/Gemini/Google AI Mode/AI Overview prompt results when processing completes,
- record HiredNext brand mention, cited page and competitor/source changes.

Report these as SE Ranking observations, not GSC data.

- [ ] **Step 8: Continue the Google closed-card recovery separately**

Keep the existing Google Business Profile support case/watch active. Do not create a duplicate profile or change the website's accurate founding/operating-location facts.
