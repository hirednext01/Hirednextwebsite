# CV automatic fulfilment implementation

Goal: connect a confirmed Priority CV Assessment order to an evidence-based three-page PDF and automatic delivery, using the existing website, jobs mailbox and connected ChatGPT execution. No separate AI API calls or new paid service.

The user has approved implementation and deployment. Only unresolved exceptions should require Taru. A customer-entered UPI reference is not evidence of payment. An explicit owner confirmation is allowed and must remain labelled owner-confirmed.

## Design and interfaces

- Add an expiring HMAC capability for one existing assessment/upgrade order. Issue it only in an internal jobs payment alert. Keep signing material and fulfilment state outside the public document root. Never put a capability in a candidate acknowledgement, URL, repository, or log.
- Add POST /api/cv-fulfilment. Supported operations: inspect, source, confirm_owner, confirm_test, claim, deliver, reconcile, exception. No bank-verification operation is implemented. Fixed-price assessment orders only can reach delivery in this release; other products retain their existing owners.
- Use the existing order tables as the customer/payment record. A private per-order journal owns the new delivery state; existing CV audit/email/report tables receive event receipts. No new CRM, lead list or publisher.
- Persist an exclusive delivery claim and an attempted-delivery state before SMTP. An uncertain send cannot be replayed automatically. Reconciliation requires verified evidence from the jobs copy. Cross-order reference reuse is rejected.
- The connected ChatGPT task prepares structured, source-cited assessment content and runs the repository's ReportLab renderer. The website validates the source hash, evidence, three-page PDF, lease and zero external API cost before mailing. No browser/admin approval is a routine step.
- One synthetic internal fixture uses zero money and jobs@hirednext.info only. It is marked internal_test in the existing order row and excluded from cash/revenue. Fixture creation is idempotent.

## Task 1: access and payment/delivery policy
- [ ] Add failing PHP behaviour tests for expired/wrong-order tokens, pending payment, amount mismatch, reference conflict, duplicate claims, duplicate delivery, factual evidence, source hash and nonzero API cost.
- [ ] Implement access/policy and private locked journal.
- [ ] Run tests and inspect failures before proceeding.

## Task 2: website handoff and renderer
- [ ] Add order adapter, internal capability notice, fixed API controller and SMTP PDF delivery.
- [ ] Keep existing checkout amounts and customer acknowledgement wording; prevent verified orders being downgraded by another submission.
- [ ] Add the three-page renderer and a synthetic fixture. Render and inspect all three pages.
- [ ] Add a once-only deployment self-test that sends only to jobs.

## Task 3: connected bridge and execution owner
- [ ] Replace the failed read-only SSH probe in n8n with an authenticated HTTPS bridge to the fixed website endpoint. Validate node schema, publish and verify responses.
- [ ] Deploy a bounded PR after PHP tests, syntax checks and relevant existing regression tests.
- [ ] Run the zero-value internal order through inspect, confirmation, claim and delivery; repeat delivery to prove suppression; verify the jobs mailbox attachment.
- [ ] Update the existing Capture CV Orders owner with the verified interface and bounded workflow. Keep the source triggers and no-new-spend / no-duplicate-work constraints.

Completion evidence must distinguish a working synthetic delivery, active event handling, real paid orders, and bank reconciliation. No real revenue can be claimed from the fixture.
