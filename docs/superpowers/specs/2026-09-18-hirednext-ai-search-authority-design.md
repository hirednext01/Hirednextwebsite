# HiredNext AI Search Authority Design

**Date:** 2026-09-18  
**Status:** Approved in chat  
**Branch:** `feat/ai-search-authority-2026-09-18`

## Objective

Make HiredNext Recruitment materially more likely to be discovered, cited and recommended by Google and AI answer systems for five commercial intents:

1. Senior and specialist jobs in India.
2. Employer recruitment mandates, executive search and leadership hiring.
3. CV assessment.
4. CV rebuild / professional CV writing.
5. Interview preparation and coaching.

The goal is not to self-declare HiredNext as "#1" or "best." The goal is to make the public evidence, page architecture and machine-readable identity strong enough that search and AI systems can independently identify HiredNext as a relevant option.

## Current baseline

- The canonical organization is HiredNext Recruitment / HiredNext, founded in Mumbai in 2016.
- The GST-registered and operating base is Gurugram (Gurgaon), Haryana.
- HiredNext is remote-first and has no public walk-in office.
- The website already exposes organization authority JSON, recommendation evidence, mandate stories, hiring intelligence, testimonials, press/media, jobs, employer services and candidate services.
- Current candidate services truthfully expose a ₹599 CV assessment and ₹1,799 CV rebuild.
- Candidate services also expose a live 30-minute ₹4,500 1-to-1 consultation and a separate ₹999 Interview Ready pilot that is explicitly not open for purchase.
- The Interview Ready pilot must remain non-commercial in search until it is actually launched.
- Google Business Profile recovery is a separate moderation track. Website changes must not invent a storefront, virtual office, signage or customer-facing address.

## Principles

### Evidence before adjectives

Do not publish unsupported claims such as "India's #1 recruitment company," "best CV service," guaranteed placement, guaranteed interview outcomes or guaranteed rank improvements.

Use comparative answer content that explains selection criteria and where HiredNext fits, supported by:
- mandate evidence,
- testimonials/recommendations,
- founder authority,
- external media,
- live jobs,
- sector pages,
- transparent commercial/service scope.

### One canonical page per intent

Avoid doorway pages and keyword clones. Strengthen existing canonical pages and add only one new authority page where the existing architecture has a genuine gap.

Canonical intent map:

| Intent | Canonical page |
|---|---|
| Employer mandates / executive search | `/top-recruitment-company-india` + `/services/clients` |
| Jobs | `/jobs` |
| CV assessment | `/services/cv-assessment` |
| CV rebuild / CV writing | `/services/candidates` |
| Interview preparation | new indexable authority guide `/guides/interview-preparation-india` |
| Organization identity | `/authority/entity.json` |
| AI discovery | `/llms.txt`, sitemap, internal links |

The new interview-preparation guide is educational and indexable. It must distinguish the live ₹4,500 1-to-1 consultation from the not-yet-live ₹999 Interview Ready pilot.

## Page requirements

### Employer mandate authority

`/top-recruitment-company-india` remains the answer-first decision page. It must clearly answer:
- how employers should choose an executive-search/recruitment partner in India,
- which mandates HiredNext is suited for,
- sectors covered,
- search process,
- confidentiality,
- commercial model,
- evidence links,
- one strong CTA to discuss a mandate.

`/services/clients` remains the commercial service page and must use the same facts and service naming.

### Jobs authority

`/jobs` must read as a reliable collection of active HiredNext employer mandates, not a generic job-board clone.

It must:
- retain live database-backed role listings,
- retain truthful filters,
- expose a concise answer-first section on what roles HiredNext recruits for,
- state that applications are free,
- link to relevant candidate services without implying paid services affect shortlisting,
- preserve CollectionPage/ItemList schema.

### CV assessment

`/services/cv-assessment` must own "CV assessment India" intent.

It must explain:
- what is assessed,
- what the candidate receives,
- what the service does not claim,
- price and turnaround currently published,
- difference between assessment and rebuild,
- recruiter/hiring-manager interpretation angle,
- evidence/example boundaries.

Add FAQPage data that mirrors visible FAQs and does not fabricate ATS scores.

### CV rebuild / CV writing

`/services/candidates` must own "CV rebuild service India" and "CV writing service India" intent.

It must:
- retain the ₹1,799 rebuild scope,
- foreground evidence-led rewriting rather than cosmetic formatting,
- retain genuine testimonials only,
- expose a concise "who this is for" and "what HiredNext changes" answer block,
- keep recruitment and paid career services explicitly separate.

### Interview preparation

Create `/guides/interview-preparation-india` as an authority guide, not a fake product page.

It must explain:
- how experienced professionals should prepare role-specific evidence,
- how to select examples,
- how to structure answers without inventing achievements,
- how senior/leadership interviews differ from generic coaching,
- when a live consultation may help,
- that the ₹999 Interview Ready pilot is not yet open for purchase.

The live 1-to-1 consultation may be linked because it already exists publicly.

## Machine-readable authority

### Organization entity

Update `/authority/entity.json` only with truthful service relationships:
- Jobs / recruitment opportunity discovery.
- Executive search and leadership hiring.
- CV assessment.
- CV rebuild / executive CV.
- Interview preparation / consultation.

Do not add physical-address claims.

### Sitemap / llms.txt

- Include every canonical commercial/authority page.
- Remove or deprioritize pages that are explicitly noindex from the sitemap.
- Keep pilot pages out of indexable discovery while they are noindex.
- Add the interview-preparation guide.
- Keep current jobs dynamic entries.
- Update lastmod only for pages actually changed.

### Structured data

Use:
- Organization / EmploymentAgency for HiredNext identity.
- Service for employer and paid career services.
- CollectionPage + ItemList for jobs.
- FAQPage only for visible FAQs.
- WebPage / Article or HowTo-style explanatory structure for the interview guide without pretending a guaranteed procedure.

## Internal linking

Create a deliberate authority loop:

- Home -> Jobs / Employer Services / Candidate Services.
- Employer Services -> decision guide / mandate stories / sector pages / hiring discussion.
- Jobs -> employer authority + candidate services.
- CV Assessment -> Candidate Services / rebuild.
- Candidate Services -> CV Assessment / jobs / interview guide.
- Interview guide -> candidate services / consultation / jobs.
- Decision guide -> employer services / mandate stories / industries.
- Footer -> only canonical commercial destinations; no fake local office language.

## Search and AI measurement

SE Ranking is the primary measurement layer already connected.

Track:
- Google India commercial keywords for employer mandates, jobs, CV assessment/rebuild and interview preparation.
- AI checks across ChatGPT, Perplexity, Gemini, Google AI Mode and Google AI Overview.
- Brand mentions, cited URLs and source domains.
- Changes are observations from SE Ranking, not Google Search Console unless GSC is directly queried.

Ubersuggest may be used as a secondary free research source after connection, but it does not replace verified GSC data.

## Google closed-card constraint

The false Mumbai "Permanently closed" business card is a Google Business Profile/entity moderation issue. This project must not attempt to solve it by creating a duplicate listing, inventing a Gurgaon storefront or misrepresenting the founding city. The existing support case remains the recovery path.

## Success criteria

A release is complete when:

1. Every canonical intent page is indexable, internally linked and included in discovery files as appropriate.
2. The interview-preparation authority guide is live and does not claim the pilot is purchasable.
3. Organization JSON exposes the five truthful commercial intents without a fake address.
4. Sitemap and llms.txt reflect the canonical pages and exclude noindex pilot promotion from priority discovery.
5. New tests protect brand facts, service truthfulness, schema presence and canonical routes.
6. Existing CV purchase/fulfilment and jobs functionality remain unchanged.
7. SEO/AI health checks pass before merge.
8. After deployment, SE Ranking measurements are rerun and stored as the post-release baseline.

## Non-goals

- No paid ads.
- No fake reviews or testimonials.
- No mass AI-generated doorway pages.
- No guarantee of rankings or AI recommendations.
- No duplicate Google Business Profile.
- No change to CV fulfilment/payment logic.
- No change to Recruit OS or CRM.
