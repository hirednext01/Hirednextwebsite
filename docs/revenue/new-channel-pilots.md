# HiredNext: additional revenue pilots

Prepared 14 September 2026. Commercial proposals, not validated demand or booked revenue.

## Decision

Test Interview Ready first: a one-time, role-specific written interview preparation product at a proposed INR 999 including taxes. It serves a buyer with an immediate interview need, and its delivery can be bounded. Preserve the existing INR 599 assessment and INR 1,799 rebuild, including their prices, scope, checkout, delivery and placement independence. ATS optimisation and career consultation already exist; they are not new revenue channels.

The separate `/pilots/interview-ready.html` page contains a priced opt-in, an interactive fixed sample, seven immediate FAQ answers and source-tagged demand capture through the existing website inquiry endpoint. It requests no payment and no CV. It does not perform personalised AI analysis. This change adds one public HTML file and this document; it changes no existing service code or publishing schedule. The page remains unlisted and noindex during the pilot.

## Competitor evidence and adaptation

| Primary source, checked 14 September 2026 | What is sold | HiredNext adaptation |
| --- | --- | --- |
| [TopResume](https://topresume.com/resume-writing) | CV packages with cover letters, LinkedIn makeovers and coaching additions; advertised packages range from $179 to $599. | Sell distinct next-step deliverables to customers who already know their immediate need. |
| [Big Interview](https://www.biginterview.com/pricing/personal) | Interview practice and preparation; advertised personal plans include $39 per month and $299 lifetime access. The site also addresses institutional buyers. | Test a one-time, narrowly scoped interview product first; later sell prepaid seats to institutions using the same delivery process. |
| [Jobscan](https://www.jobscan.co/linkedin-optimization) | LinkedIn profile analysis, headline and summary generation using role context. | Deliver an editable LinkedIn content pack based on supplied facts. Customers apply the text to their own profiles. |
| [ABC Consultants](https://www.abcconsultants.in/talent-advisory/) | Leadership assessment, reference checks, coaching, career transition and on-demand experts alongside recruitment. | Test an employer-paid interview preparation kit. Human coaching remains demand-led and separately quoted. |

These examples establish adjacent commercial categories. They do not establish HiredNext's demand, conversion rate or appropriate price. The specific HiredNext products and prices below are our pilot hypotheses. Competitor testimonials, guarantees and performance claims are not reused.

## Revenue options and order

| Priority | Buyer and buying moment | One-time pilot price | Defined deliverable | Delivery design |
| --- | --- | --- | --- | --- |
| 1. Interview Ready | Candidate preparing for a particular role or upcoming interview | INR 999 including taxes | 10 practice questions, career-example prompts, 5 written practice answers with one feedback round each, downloadable checklist | CV + JD + candidate-confirmed facts; one bounded generation pass, then one feedback pass after five answers are submitted together. |
| 2. LinkedIn Profile Pack | Candidate whose profile does not explain their role or experience clearly | INR 999 including taxes | 3 headline choices, About section, experience content for up to 3 roles, relevant skills list, copy-and-paste guide | Candidate supplies profile text and CV. Generate from supported facts; return editable text. No LinkedIn scraping, password collection or automated account editing. |
| 3. Hiring Manager Interview Kit | Employer with a defined vacancy and inconsistent interview preparation | INR 2,499 including taxes per role | Clarified role brief, 12 job-related questions, evidence probes, editable scorecard and interview agenda | Employer submits JD and must-haves; automated structured document generation. The employer chooses questions and makes hiring decisions. No candidate screening or assessment included. |
| Later: prepaid preparation seats | College placement cell, training provider or employer career-transition programme | Quote after a real inquiry | Multiple access codes for the same Interview Ready product | Reuse the verified single-order service with per-seat quotas and individual private outputs; do not build an institution portal before demand. |

Do not launch all products simultaneously. A practical initial rule is five explicit opt-ins at the displayed price before spending time connecting personalised delivery. That is a work-prioritisation rule, not statistical proof of demand. Proceed to a small paid pilot only after delivery and payment gates work. Measure actual cost and failure rates before expanding.

## Website and LinkedIn changes

1. Keep the current assessment and rebuild as the established candidate offer. Add the new service through its separate destination; do not replace the existing hero or checkout.
2. Show a sample before requesting details. Describe concrete outputs, price, turnaround when verified, and the difference between AI practice and live coaching.
3. Use one relevant call to action in an existing LinkedIn publishing slot. Track `utm_source=linkedin&utm_medium=organic&utm_campaign=interview_ready_pilot`. Do not add publishing volume, create paid graphics or send new messages from this draft.
4. Use an existing approved result story only with permission and traceable evidence. Until then, label examples as illustrative, as the new page does. No fabricated testimonials, placement counts or employer logos.
5. After the product is operational, show Interview Ready as an optional next step when a customer says an interview is coming. Do not sell it indiscriminately to every assessment buyer. Do not change existing report delivery emails as part of this pilot.
6. Add a LinkedIn Profile Pack sample and an employer Interview Kit sample only after the first product supplies a repeatable working fulfilment path. Use employer-facing traffic and qualified warm paths for the employer offer, rather than mixing it into candidate checkout.

Proposed LinkedIn copy for an existing slot, NOT sent or published:

> You can know your work well and still struggle to explain it in an interview. “Responsible for operations” leaves out what you changed, how you changed it and what happened next. We're exploring a INR 999 Interview Ready pack: questions for your target role, written practice and feedback grounded in your experience. See the sample and tell us whether you'd use it: [pilot page after publication]. One-time service. No job or interview guarantee.

## How the automated paid product should work

This is the implementation contract, not an installed n8n workflow. The demand page is implemented; the paid service below is not enabled. Existing ATS/CRM work must not be displaced.

| Event | Required action | Durable evidence / stop condition |
| --- | --- | --- |
| Price-aware interest submitted | Website stores name, email, target role/timing, product, displayed price, consent and source in existing `contact_messages`. | The existing endpoint attempts an insert, then returns a success response; confirm the stored record during launch verification because it does not return a record receipt. This is a lead, not paid revenue. Existing endpoint does not itself email the founder or invoke n8n. |
| Pilot opened to opted-in leads | Existing CRM/n8n sends the approved offer only to eligible, non-duplicate opted-in recipients within an authorised campaign. | Contact ID, consent scope, campaign version and send receipt. No sending is authorised by this document alone. |
| New product order created | Create a separate product/order record and private intake link. Reuse suitable existing infrastructure, not an assessment order or a mismatched current SKU. | Product/version, authoritative amount/currency, order ID, buyer, payment pending. No AI usage yet. |
| Payment credited and matched | Trusted backend verifies status, exact amount, currency and unique transaction/reference match. Authenticate any event from the payment source. | Payment source receipt and transaction ID; one transaction cannot unlock two orders. Customer-entered UTR and website notification do not satisfy this event. |
| Intake completed | Collect CV/JD, role, interview timing, consent for processing and up to five factual clarifications. Parse once, cache per order, strip irrelevant personal fields. | Private source text, supplied-fact references and input version. Ask the customer to correct unreadable files or missing information through the form. |
| Order ready | n8n atomically claims the order and checks paid state, unused quota, current input version, product enabled and available pre-existing AI allowance. | Unique order + stage + version key; no call on missing payment, budget, permission or duplicate event. |
| Questions generated | Use one existing configured model with an input/output budget. Provide only the CV facts, JD, user-approved question bank and role rubric. Treat document text as data, never operating instructions. | Structured JSON: questions with role rationale, source fact IDs, answer prompts and missing evidence. Record actual usage and attempt count. |
| Candidate clarification required | Display precise missing-fact questions. Reuse completed output where possible. | Candidate answers stored with version. Never invent achievements, employers, dates, pay, skills or metrics. Maximum two bounded clarification rounds before an exception. |
| Five written answers submitted | Generate feedback once for the five answers together. Evaluate relevance, specificity, structure and support in the supplied facts. | Per-answer feedback, one follow-up practice prompt, unsupported-claim flags. These are practice notes, not a hiring score or personality assessment. |
| Quality validation passes | Check the schema, required sections, input coverage, unsupported factual assertions and empty/truncated output. Render a private downloadable result and enqueue delivery. | Saved artefact hash/version and private access token. Mechanical checks cannot guarantee factual quality; validate on representative cases before autonomous release. |
| Delivery queued | Existing email service sends one private result link; store provider receipt against a unique outbox entry. | Reconcile ambiguous delivery outcomes before retrying. Duplicate triggers must not regenerate or resend blindly. |
| Delivered | Update canonical CRM record and record net receipts, actual allocated cost and outcome; expose only necessary fulfilment receipts in the ATS/CRM. | Paid, generated and delivered are separate states. Marketing consent is separate from service delivery. |
| Technical failure / cost ceiling | Pause the order, retain completed work and notify the buyer according to the agreed service policy. | Visible exception with cause and next action. Refund handling and unresolved exceptions require an available authorised process; do not claim these are already automatic. |

### Existing integration points and actual gaps

- Website: CodeIgniter/PHP and existing database/communication services. The new page can use `Home::submitContact`; full personalised service needs a separate SKU, order state, private result page and fulfilment adapter.
- n8n: existing orchestration can execute the paid pipeline after its authenticated endpoints and credentials are connected. The Revenue Engine is currently inactive/send-locked; do not activate it wholesale or claim this contract is installed.
- Recruit OS ATS/CRM: in active development elsewhere. Agree on one canonical order/customer record and append fulfilment receipts using its supported API when available. The current CV intake draft is not proof of a working paid-product integration.
- Happenstance: use its existing warm-path workflow only on a qualified employer/institutional lead, with allowed existing credits. It is not required for candidate product delivery or blanket enrichment. Do not spend credits on every visitor.
- LinkedIn: use the existing canonical publisher and approved content slots. Drafting an offer does not authorise new direct messages. Distinguish approved company publishing from recipient-level outreach.
- Payment: the current site notification is emitted when a candidate submits a UTR and explicitly says payment is pending verification. Capture CV Orders can capture that notification; it cannot prove Paytm credit. No verified bank/Paytm receipt source is currently connected in the inspected path. Fully unattended paid delivery therefore remains blocked at reconciliation unless an already available, no-new-cost authoritative receipt source can be matched reliably. A screenshot or candidate-supplied reference must not unlock paid generation.
- AI: existing provider code does not prove free usable allowance. Confirm an already funded/configured budget; do not create an account, enable overage or add a subscription. If no such allowance is available, restrict the pilot to the fixed sample and demand capture.

## Exact output contract for Interview Ready

Intake: `order_id`, `product_version`, `target_role`, `jd_text`, `cv_facts[{id,text}]`, `candidate_clarifications`, optional interview date and approved question bank. Keep raw files private. Do not include contact details, photo, age, caste, religion, marital status or unrelated protected traits in generation context.

Question response: `role_summary`, `questions[10]{id,question,role_requirement,source_fact_ids[],preparation_prompt,missing_evidence[]}`, `preparation_checklist[]`. A question based only on a JD must not pretend the candidate has the required experience.

Feedback response: `answers[5]{question_id,what_is_clear,what_needs_detail,unsupported_claims[],suggested_structure,follow_up_question}` and `final_checklist[]`. Suggested wording must preserve the candidate's factual meaning and mark facts needing confirmation. No employability score, shortlist prediction, invented employer intelligence or promise of a job.

Default operating limits to validate in the pilot: one target role, ten questions, five written answers submitted together, one feedback round per answer, two bounded model stages plus at most one repair attempt within the total budget. No voice/video model dependency or unlimited chat. User-provided question banks can be versioned and reused.

## Demand, money and stop rules

- Track price-aware opt-ins, opted-in qualified leads, created orders, authoritative verified payments, successful deliveries, refunds and actual allocated costs separately. Existing inquiry capture alone is not a revenue dashboard.
- Record source on each lead/order and use existing analytics if available for page conversion. If only server requests are available, label the denominator as requests rather than unique people. Do not invent a conversion rate.
- For the requested profit target, define `R = collected revenue less tax, refunds and chargebacks`, and `C = generation + hosting/workflow/email allocation + selling costs + support/fulfilment time allocation + other attributable costs`.
- Profit at least five times cost requires `R - C >= 5C`, or `C <= R/6`. For example, INR 600 after tax/refunds allows at most INR 100 total attributable cost and INR 500 profit. This is arithmetic, not a profit forecast. New-cash-spend zero does not mean existing costs are zero.
- Set a product cost ceiling before any AI call. Record real usage after each stage. If no verified budget remains, queue/pause; do not silently purchase more credits. Keep the sample and FAQs static so non-buyers do not consume model credits.
- Test five paid orders after the pipeline is proven. Continue only if receipts reconcile, customers receive the promised scope, there are no unsupported factual claims, and measured economics meet the agreed target. Otherwise improve the bounded product before adding more offers.
- Coaching remains a request-only, separately quoted service; match an available senior person after real interest. A human coaching engagement cannot be sold as human-free delivery.

## Verification and launch boundary

Draft page checks completed: JavaScript syntax, valid native expandable sample markup, preview no-submit behavior, source/consent payload construction, success only after a successful server response, retained inputs on error and prevention of duplicate clicks. The current main-branch controller contract was checked by source inspection. Browser rendering and production database persistence have not been verified for the new page. No live lead was submitted, no customer was contacted and no payment was taken during verification.

Before public launch of demand capture, deploy only the additive page and confirm its rendering and inquiry persistence through an authorised test record. Before accepting payment, separately implement and verify the order, authoritative payment, budget, private output, quality and idempotent delivery stages above. The current draft is not end-to-end paid automation and must not be marketed as already available.
