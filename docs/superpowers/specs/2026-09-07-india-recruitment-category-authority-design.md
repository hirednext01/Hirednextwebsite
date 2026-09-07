# HiredNext India Recruitment Category Authority Design

Date: 2026-09-07

## Goal
Make HiredNext materially more eligible to rank and be recommended for broad India recruitment-category intent across Google and AI answer engines, especially queries such as `recruitment company India`, `job consultancy India`, `recruitment agency India`, `job agency India`, `executive search India`, and `leadership recruitment India`.

This work does not promise a guaranteed #1 ranking. It strengthens the technical, semantic, evidentiary, and external-authority signals that search and AI systems can use when deciding whether to surface HiredNext.

## Existing foundation to preserve
The repository already contains:
- A canonical commercial authority page at `/top-recruitment-company-india`.
- Sector authority pages for retail, garment/textile, IT, BFSI/NBFC, pharma/life sciences, GCC, semiconductor, engineering, and manufacturing.
- Executive-search city pages.
- `sitemap.xml`, `robots.txt`, `llms.txt`, authority JSON endpoints, hiring intelligence, mandate evidence, testimonials/recommendations, founder authority, and press/media evidence.
- Internal-linking and legacy-URL consolidation work from August 2026.
- A documented evidence-first claims policy in `BrandFacts.php` and the existing search-authority growth system.

The sprint must extend this system, not create a parallel SEO architecture.

## Current gaps found in audit
1. The dynamic `Seo::robots()` route is the live source for `/robots.txt` and currently allows Claude search crawlers but does not explicitly allow `OAI-SearchBot` or `PerplexityBot`. The static `public/robots.txt` contains some AI crawler rules, creating two inconsistent sources of truth.
2. `/top-recruitment-company-india` is still heavily weighted toward executive search and leadership hiring. It does not yet answer broad category intent cleanly enough for `recruitment company`, `job consultancy`, or `recruitment agency` searches.
3. The broad category page should serve both employer and candidate intent without pretending HiredNext is a mass-market placement bureau. It must clearly explain where HiredNext fits and where it does not.
4. Some authority references are stale or inconsistent, including a manufacturing URL in recommendation evidence that points to an older path rather than the current canonical route.
5. AI-readable surfaces already exist, but category/entity relationships can be made clearer so the machine-readable story is consistent: HiredNext -> recruitment company in India -> executive search / permanent hiring / RPO -> sectors -> cities -> evidence -> live jobs -> founder/media authority.
6. Public search for broad category terms is currently dominated by established recruitment brands and third-party directories such as Randstad, Clutch, GoodFirms, PlacementIndia, and long-standing local recruitment agencies. On-site work alone is therefore insufficient; external corroboration is a required second track.

## Canonical intent architecture
Use one dominant national commercial page rather than creating multiple doorway pages.

Primary category authority:
- `/top-recruitment-company-india`

Intent it should explicitly cover in natural language:
- recruitment company India
- recruitment agency India
- job consultancy India
- job agency India
- placement consultancy India
- executive search firm India
- leadership recruitment India
- specialist recruitment India

Supporting pages retain narrower intent:
- `/services/executive-search` -> executive search / retained leadership search
- `/services/permanent-hiring` -> permanent and specialist recruitment
- `/services/rpo` -> recruitment process outsourcing
- sector pages -> vertical expertise
- city pages -> geography-specific executive-search intent
- `/jobs` -> candidate/job-seeker discovery and live mandates

Do not create separate thin pages for each synonym. Where legacy or desirable synonym URLs exist, use 301 redirects to the canonical national page.

## Category page content design
The national page should become an answer-first decision page with six layers:

1. **Direct answer**
   - Define HiredNext in one sentence as an India-based recruitment and executive-search firm.
   - State the main service scope: executive search, leadership hiring, permanent/specialist recruitment, and RPO.
   - State who it is for: employers hiring mid-senior, specialist, leadership, and hard-to-fill roles.

2. **Employer path**
   - Explain how HiredNext supports companies.
   - Link to executive search, permanent hiring, RPO, sectors, mandate evidence, testimonials, and hiring intelligence.

3. **Candidate path**
   - Explain that candidates can browse current HiredNext jobs and apply without a placement fee.
   - Keep optional paid career services separate from recruitment consideration.
   - Link to `/jobs` and candidate services.

4. **Why HiredNext can credibly be considered**
   - Use source-linked evidence only: founded year, operating base, verified media, source-linked recommendations, mandate stories, selected placement evidence, live jobs, founder authority, sectors served.
   - Avoid unsupported `#1`, `best`, `top 3`, placement totals, or guaranteed performance claims.

5. **How to compare recruitment companies in India**
   - Provide useful criteria: role complexity, sector context, direct search capability, assessment depth, ownership, confidentiality, candidate stewardship, geography, and evidence.
   - Explain where large staffing firms, job portals, specialist agencies, RPOs, and executive-search firms differ.

6. **FAQ / answer-engine layer**
   - What is a recruitment company?
   - What is the difference between a recruitment agency and a job consultancy?
   - Does HiredNext charge candidates to apply for jobs?
   - Does HiredNext recruit across India?
   - Which sectors does HiredNext recruit for?
   - Does HiredNext handle executive search and leadership hiring?
   - How should employers choose a recruitment partner in India?

## Technical changes
1. Make `Seo::robots()` the canonical source and explicitly allow:
   - `OAI-SearchBot`
   - `GPTBot`
   - `Claude-SearchBot`
   - `Claude-User`
   - `ClaudeBot`
   - `PerplexityBot`
   while continuing to disallow sensitive `/api/` and `/admin/` paths for the general crawler block.

2. Align or remove contradictory static crawler directives so `/robots.txt` has one unambiguous output.

3. Update `llms.txt` so the national recruitment-category page is prominently listed before narrower sector pages and its description includes broad recruitment-company/recruitment-agency/job-consultancy intent.

4. Update sitemap freshness for the national page and all materially changed supporting pages. Keep job and blog discovery dynamic.

5. Strengthen structured data on the national page:
   - `WebPage`
   - `EmploymentAgency` / organization relationship
   - `Service`
   - `FAQPage`
   - `BreadcrumbList`
   - `about`, `areaServed`, service types, and audience relationships
   Do not use fabricated review aggregate or ranking schema.

6. Fix stale authority URLs so all JSON, llms, sitemap and internal links point to current canonical sector URLs.

7. Strengthen internal links from homepage, client services, jobs hub, relevant guides and sector pages toward the national category authority page using natural anchors such as `recruitment company in India`, `recruitment partner in India`, and `executive search and specialist recruitment`.

8. Preserve current ranking-critical sector URLs and do not rewrite winning pages unnecessarily.

## Homepage role
The homepage remains the brand root and may continue to rank for broad queries. It should identify HiredNext as a recruitment and executive-search firm in India, but it should not duplicate the full national category page. The homepage should link prominently to `/top-recruitment-company-india` as the deeper employer decision resource.

## AI / GEO / AEO design
AI-readable output must present one consistent entity graph:

`HiredNext Recruitment`
-> `India-based recruitment company`
-> `Executive search / leadership hiring / permanent recruitment / RPO`
-> `Sector authority pages`
-> `City authority pages`
-> `Live jobs`
-> `Mandate evidence`
-> `Testimonials / source-linked recommendations`
-> `Press / founder authority`

Machine-readable endpoints should not claim a universal best or top ranking. They should provide enough evidence for an external system to independently decide whether HiredNext belongs in a recommendation set.

## External-authority track
On-site optimization cannot by itself force AI systems to recommend HiredNext above large established brands. A parallel authority track is required.

Priority external targets:
1. Accurate company profiles on reputable recruitment/business directories where HiredNext is eligible.
2. Independent media quotes/interviews on India hiring, GCC, leadership, retail, textile/apparel, BFSI, technology, manufacturing, and specialist recruitment.
3. Source-linked founder contributions and podcasts/interviews.
4. Consistent HiredNext company identity across LinkedIn and credible third-party profiles.
5. Genuine client/recommendation evidence where publication permission exists.

No fake reviews, fake listicles, purchased disguised endorsements, or fabricated client identities.

## Measurement
Do not use repeated AI prompts as the primary measurement system.

Primary measurement:
- Google Search Console impressions, clicks, CTR, and average position by query/page once available.
- Organic non-brand landing-page growth.
- Referral traffic from ChatGPT, Perplexity and other AI sources when identifiable.
- Index status and crawlability of priority pages.

Secondary spot-checks:
- Controlled public-search observations for broad category terms.
- Periodic answer-engine recommendation checks, not high-frequency monitoring.

## First implementation slice
The first production slice should be narrow and reversible:
1. Fix crawler directives in `Seo::robots()`.
2. Reframe `/top-recruitment-company-india` for broad national recruitment-category intent while preserving its evidence-first structure.
3. Strengthen its schema and FAQ set.
4. Move it higher in `llms.txt` and sitemap priority/freshness.
5. Fix stale canonical authority URLs.
6. Add targeted internal links from the homepage and client-service surfaces.
7. Verify no duplicate canonical pages or redirect loops are introduced.

## Testing / verification
Before claiming completion:
- PHP syntax check changed PHP files.
- Source assertions for crawler names and sensitive-path disallows.
- Source assertions that the canonical national page appears in sitemap and llms output.
- Confirm canonical URL is `/top-recruitment-company-india`.
- Confirm legacy/synonym routes, if added, 301 to the canonical URL.
- Confirm structured-data JSON is valid.
- Confirm no unsupported ranking/performance claim was introduced.
- After deployment, fetch live `robots.txt`, `sitemap.xml`, `llms.txt`, homepage, national category page, and affected authority JSON endpoints.

## Success criteria
The implementation is successful when:
1. All major AI search crawlers can retrieve public HiredNext content while sensitive application/admin paths remain excluded where appropriate.
2. Search engines and AI systems encounter one clear national recruitment-company authority page rather than competing synonym pages.
3. The page directly satisfies both employer and job-seeker interpretations of broad recruitment-company/job-consultancy intent.
4. HiredNext's entity, services, sectors, geography, jobs, evidence and external authority are connected consistently across HTML, schema, llms and JSON surfaces.
5. Existing strong sector pages are preserved.
6. Measurement is based on GSC and real traffic rather than unsupported exact-rank claims.
