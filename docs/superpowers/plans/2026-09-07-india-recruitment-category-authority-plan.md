# HiredNext India Recruitment Category Authority Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Strengthen HiredNext as a nationally discoverable and recommendable recruitment brand for broad India category intent across Google and AI answer engines, with priority on ChatGPT/OpenAI and Claude, followed by Perplexity, Gemini/Google AI, and Grok.

**Architecture:** Keep `/top-recruitment-company-india` as the single canonical national category authority page. Extend the existing SEO/AEO/GEO system by aligning crawler directives, broadening the page from leadership-heavy intent to national recruitment-company/job-consultancy intent, tightening schema/entity relationships, elevating the page in `llms.txt` and sitemap output, fixing stale canonical references, and adding selective internal links from high-authority pages. Preserve existing sector and city pages and do not create synonym doorway pages.

**Tech Stack:** PHP 8+/CodeIgniter 4, server-rendered views, Schema.org JSON-LD, robots.txt, XML sitemap, llms.txt, GitHub.

**Spec:** `docs/superpowers/specs/2026-09-07-india-recruitment-category-authority-design.md`

## Global Constraints

- Do not claim HiredNext is objectively `#1`, `top 3`, or the universal best recruitment firm.
- Keep all public company claims consistent with `app/Config/BrandFacts.php`.
- Do not publish unsupported placement totals, success rates, hiring-speed claims, or fabricated reviews.
- Preserve current ranking-critical sector URLs and city authority URLs.
- Keep `/top-recruitment-company-india` as the canonical national category page.
- Do not create separate thin pages for `job consultancy India`, `recruitment agency India`, or other synonyms.
- Explicitly support documented OpenAI and Claude search crawlers; support Perplexity where documented; do not invent an xAI/Grok crawler user-agent that is not officially documented.
- Keep `/api/` and `/admin/` excluded from the general crawler block.
- Preserve the existing dynamic sitemap, jobs, blog and AEO-insight discovery flows.

---

### Task 1: Align AI crawler directives

**Files:**
- Modify: `app/Controllers/Seo.php`
- Modify: `public/robots.txt`

**Interfaces:**
- Consumes: existing `Seo::robots(): ResponseInterface` route at `/robots.txt`.
- Produces: one consistent robots policy allowing public search/AI crawlers while excluding sensitive paths from the general crawler block.

- [ ] **Step 1: Add a source-level regression assertion for crawler policy**

Create or extend a lightweight test/assertion script under the existing project test convention that verifies the `Seo::robots()` output source contains:

```text
User-agent: OAI-SearchBot
Allow: /

User-agent: GPTBot
Allow: /

User-agent: Claude-SearchBot
Allow: /

User-agent: Claude-User
Allow: /

User-agent: ClaudeBot
Allow: /

User-agent: PerplexityBot
Allow: /
```

and that the general block still contains:

```text
Disallow: /api/
Disallow: /admin/
```

Do not add a guessed Grok/xAI user-agent.

- [ ] **Step 2: Run the assertion and verify it fails on the current code**

Expected failure: missing `OAI-SearchBot`, `GPTBot`, or `PerplexityBot` in `Seo::robots()`.

- [ ] **Step 3: Update `Seo::robots()`**

Use this ordering in the generated text:

```php
$body = "User-agent: *\nAllow: /\nDisallow: /api/\nDisallow: /admin/\n\n";
$body .= "User-agent: OAI-SearchBot\nAllow: /\n\n";
$body .= "User-agent: GPTBot\nAllow: /\n\n";
$body .= "User-agent: Claude-SearchBot\nAllow: /\n\n";
$body .= "User-agent: Claude-User\nAllow: /\n\n";
$body .= "User-agent: ClaudeBot\nAllow: /\n\n";
$body .= "User-agent: PerplexityBot\nAllow: /\n\n";
$body .= "Sitemap: " . rtrim(base_url(), '/') . "/sitemap.xml\n";
```

- [ ] **Step 4: Align `public/robots.txt`**

Mirror the same crawler names and sitemap entry so a static fallback cannot contradict the dynamic route. Keep sensitive-path disallows in the general block.

- [ ] **Step 5: Re-run the crawler assertion**

Expected: PASS.

- [ ] **Step 6: Commit**

Commit message:

```text
SEO: align AI crawler discovery directives
```

---

### Task 2: Broaden the national recruitment-category authority page

**Files:**
- Modify: `app/Config/DecisionGuides.php`

**Interfaces:**
- Consumes: `DecisionGuides::$guides['executive-search-firm-india']` and its canonical path `/top-recruitment-company-india`.
- Produces: broad national recruitment-company intent while preserving evidence-first executive-search depth.

- [ ] **Step 1: Add a source assertion for national-intent phrases**

Verify the canonical guide configuration contains all of these concepts in natural language:

```text
recruitment company in India
recruitment agency in India
job consultancy in India
executive search
permanent recruitment
RPO
candidates are not charged to apply for jobs
```

- [ ] **Step 2: Run the assertion and verify the broad-intent coverage is incomplete**

Expected: FAIL for at least the broad job-consultancy/recruitment-agency coverage.

- [ ] **Step 3: Update the guide metadata and answer-first copy**

Set the primary title/meta intent to broad recruitment-category language while retaining leadership depth. Use copy equivalent to:

```php
'title' => 'Recruitment Company in India for Employers & Job Seekers',
'meta_title' => 'Recruitment Company & Job Consultancy in India | HiredNext',
'meta_description' => 'HiredNext is an India-based recruitment company supporting executive search, leadership hiring, permanent recruitment, specialist hiring and RPO. Employers can hire through HiredNext and candidates can browse live jobs and apply without placement fees.',
```

The `short_answer` must define HiredNext in the first sentence as an India-based recruitment and executive-search firm, then distinguish employer services from candidate/job-seeker access.

- [ ] **Step 4: Add candidate-intent content to the existing guide data structure**

Add a compact candidate path that states:

```text
Candidates can browse current HiredNext-managed jobs and apply directly. HiredNext does not charge candidates to apply for a job or secure placement. Optional career services, when offered, are separate from recruitment consideration.
```

Link this path to `/jobs` and `/services/candidates`.

- [ ] **Step 5: Expand comparison intent without creating unsupported ranking claims**

Ensure the page answers how to compare:

```text
large staffing firms
specialist recruitment agencies
job consultancies
executive-search firms
RPO providers
job portals/direct advertising
```

Use decision criteria based on role complexity, sector context, ownership, direct-search capability, assessment depth, confidentiality, and evidence.

- [ ] **Step 6: Add/refresh FAQs**

Include exact FAQ topics:

```text
What is a recruitment company?
What is the difference between a recruitment agency and a job consultancy?
Does HiredNext charge candidates to apply for jobs?
Does HiredNext recruit across India?
Which sectors does HiredNext recruit for?
Does HiredNext handle executive search and leadership hiring?
How should employers choose a recruitment partner in India?
```

- [ ] **Step 7: Re-run the national-intent assertion**

Expected: PASS.

- [ ] **Step 8: Commit**

Commit message:

```text
SEO: broaden India recruitment category authority
```

---

### Task 3: Strengthen schema for broad category intent

**Files:**
- Modify: `app/Controllers/DecisionGuides.php`

**Interfaces:**
- Consumes: guide metadata from `DecisionGuides.php` config.
- Produces: valid JSON-LD graph connecting the national page to HiredNext as an `EmploymentAgency`, its recruitment services, India coverage, FAQ and breadcrumb data.

- [ ] **Step 1: Add a source assertion for structured-data entities**

Verify the national guide schema includes:

```text
WebPage
EmploymentAgency
Service
FAQPage
BreadcrumbList
areaServed
India
recruitment company in India
recruitment agency in India
job consultancy in India
```

- [ ] **Step 2: Run the assertion and verify current schema lacks full broad-category coverage**

Expected: FAIL for `EmploymentAgency` node or broad about/service terms.

- [ ] **Step 3: Add an `EmploymentAgency` organization node to the JSON-LD graph**

Use the canonical organization `@id`:

```text
https://hirednext.net/#organization
```

Populate only facts from `BrandFacts.php`: organization name, URL, India area served, founder relation, and service scope. Do not add fabricated ratings or aggregate reviews.

- [ ] **Step 4: Expand `WebPage.about` and `Service.serviceType`**

Include broad categories such as:

```text
Recruitment company in India
Recruitment agency in India
Job consultancy in India
Executive search
Leadership hiring
Permanent recruitment
Specialist recruitment
Recruitment process outsourcing
```

- [ ] **Step 5: Validate JSON encoding path remains unchanged**

Keep:

```php
JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
```

- [ ] **Step 6: Re-run the schema assertion**

Expected: PASS.

- [ ] **Step 7: Commit**

Commit message:

```text
SEO: strengthen recruitment category structured data
```

---

### Task 4: Elevate the national page in `llms.txt` and sitemap

**Files:**
- Modify: `app/Controllers/Seo.php`

**Interfaces:**
- Consumes: existing `Seo::llms()` and `Seo::sitemap()` output.
- Produces: prominent discovery of the canonical national recruitment page for search engines and AI systems.

- [ ] **Step 1: Add source assertions**

Verify `Seo::llms()` contains a prominent link to:

```text
/top-recruitment-company-india
```

with description language covering recruitment company, recruitment agency, job consultancy, executive search, permanent hiring and RPO.

Verify `Seo::sitemap()` contains the same canonical URL with priority `1.0` or `0.9` and `lastmod` updated to `2026-09-07`.

- [ ] **Step 2: Run assertions and verify the current output is incomplete or insufficiently prominent**

Expected: FAIL if the canonical national page is missing from the static priority URL list or not explicitly described in the top `llms.txt` core section.

- [ ] **Step 3: Add the national page near the top of `llms.txt` core pages**

Use wording equivalent to:

```text
[Recruitment Company & Job Consultancy in India]: National HiredNext authority page covering recruitment agency, executive search, permanent/specialist hiring, RPO, sectors, employer selection criteria and candidate job access.
```

- [ ] **Step 4: Add/update sitemap entry**

Use:

```php
['loc' => base_url('top-recruitment-company-india'), 'lastmod' => '2026-09-07', 'changefreq' => 'weekly', 'priority' => '1.0'],
```

Ensure the guide-config loop does not create a duplicate canonical URL. If it would, de-duplicate sitemap entries by URL before XML rendering.

- [ ] **Step 5: Re-run assertions**

Expected: PASS with exactly one canonical national URL in the generated sitemap source path.

- [ ] **Step 6: Commit**

Commit message:

```text
SEO: promote national recruitment authority in discovery feeds
```

---

### Task 5: Fix stale authority references

**Files:**
- Modify: `app/Controllers/DecisionGuides.php`
- Inspect and modify only if needed: `app/Controllers/Seo.php`
- Inspect and modify only if needed: authority/config files referenced by machine-readable endpoints

**Interfaces:**
- Consumes: sector URLs emitted in `recommendationEvidenceJson()` and `llms.txt`.
- Produces: one current canonical URL per sector.

- [ ] **Step 1: Add a source assertion for manufacturing canonical URL**

Verify no machine-readable authority output references:

```text
industry/manufacturing-talent-advisory
```

and all relevant references use:

```text
industry/manufacturing-recruitment-india
```

- [ ] **Step 2: Run the assertion and verify it fails on the stale recommendation-evidence URL**

Expected: FAIL.

- [ ] **Step 3: Replace stale references only**

Update `recommendationEvidenceJson()` and any remaining AI-readable outputs to the current canonical manufacturing route.

- [ ] **Step 4: Search for other old route variants**

Search exact strings for old manufacturing, city, executive-search, and recruitment-guide paths. Only replace a URL when the current route table confirms the canonical replacement.

- [ ] **Step 5: Re-run assertion**

Expected: PASS.

- [ ] **Step 6: Commit**

Commit message:

```text
SEO: fix stale authority canonical references
```

---

### Task 6: Add selective internal links to the national authority page

**Files:**
- Modify: `app/Views/pages/home.php`
- Inspect and modify if appropriate: existing client-services view resolved by `CandidateServices::clientServices`

**Interfaces:**
- Consumes: canonical `/top-recruitment-company-india` route.
- Produces: contextual internal links from high-authority commercial surfaces without duplicating the full guide copy.

- [ ] **Step 1: Identify an existing employer-focused section on the homepage**

Use an existing text/proof/services block rather than creating a new large homepage section.

- [ ] **Step 2: Add one contextual homepage link**

Use natural anchor text such as:

```text
recruitment company in India
```

or:

```text
how to compare recruitment partners in India
```

pointing to:

```php
base_url('top-recruitment-company-india')
```

- [ ] **Step 3: Add one contextual client-services link**

Use employer-focused anchor text such as:

```text
recruitment partner in India
```

or:

```text
executive search and specialist recruitment
```

Do not add repeated exact-match anchors throughout the page.

- [ ] **Step 4: Verify no existing high-performing sector page is rewritten**

Only add links; do not modify ranking-critical sector titles/H1/core copy in this task.

- [ ] **Step 5: Commit**

Commit message:

```text
SEO: strengthen internal links to national recruitment authority
```

---

### Task 7: Add Grok/xAI visibility support without speculative crawler rules

**Files:**
- Modify if needed: `docs/marketing/SEARCH_AUTHORITY_GROWTH_SYSTEM.md`
- No robots change unless xAI publishes an official crawler user-agent.

**Interfaces:**
- Consumes: existing general crawlability, public HTML pages, external authority plan.
- Produces: a documented Grok strategy based on live web search and X authority rather than fabricated crawler directives.

- [ ] **Step 1: Document current xAI constraint**

Record that Grok uses live web search and live X integration, but no official xAI crawler user-agent has been verified in the current source review.

- [ ] **Step 2: Add Grok-specific authority actions**

Document these actions:

```text
Keep public HiredNext pages crawlable to general web crawlers.
Keep HiredNext company identity consistent on X and the website.
Publish source-linked founder/company commentary on India recruitment topics.
Link X posts to exact HiredNext authority pages where relevant.
Do not fabricate independent endorsements or fake listicles.
```

- [ ] **Step 3: Commit**

Commit message:

```text
GEO: document Grok live-search authority strategy
```

---

### Task 8: Final verification and deployment handoff

**Files:**
- No new production files unless a verification fix is required.

**Interfaces:**
- Consumes: all prior tasks.
- Produces: verified deployment-ready commit set and exact Hostinger checks.

- [ ] **Step 1: Run PHP syntax checks on every changed PHP file**

Run locally or in CI-capable environment:

```bash
php -l app/Controllers/Seo.php
php -l app/Controllers/DecisionGuides.php
php -l app/Config/DecisionGuides.php
```

Expected: `No syntax errors detected` for each file.

- [ ] **Step 2: Run all source assertions/regression tests created in prior tasks**

Expected: all PASS.

- [ ] **Step 3: Search for unsupported ranking claims**

Search changed files for:

```text
#1
top 3
best recruitment company
guaranteed
```

Any occurrence must be either explanatory/caveat text or removed.

- [ ] **Step 4: Verify canonical consistency**

Confirm:

```text
/top-recruitment-company-india
```

is the only canonical national recruitment-category page and that any legacy guide route resolves to it with HTTP 301 where already configured.

- [ ] **Step 5: Verify machine-readable consistency**

Confirm current canonical URLs across:

```text
robots.txt
sitemap.xml
llms.txt
authority/recommendation-evidence.json
authority/search-pages.json
```

- [ ] **Step 6: Prepare Hostinger deployment instructions**

After production pull, verify live:

```text
https://hirednext.net/robots.txt
https://hirednext.net/sitemap.xml
https://hirednext.net/llms.txt
https://hirednext.net/top-recruitment-company-india
https://hirednext.net/authority/recommendation-evidence.json
```

- [ ] **Step 7: Post-deploy spot checks**

Verify HTTP 200, canonical tag, page title/meta, JSON-LD validity, crawler directives, one sitemap entry, and presence of the national page in `llms.txt`.

- [ ] **Step 8: Final commit if verification required changes**

Use a narrow message describing only the verification fix. Otherwise do not create an empty/no-op commit.
