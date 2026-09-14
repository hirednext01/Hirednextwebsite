# Rebuild Automation Implementation Plan

> For agentic workers: use superpowers:executing-plans to implement these tasks inline.

**Goal:** Fulfil the existing ₹1,799 rebuild from confirmed order through questions, two CV variants and two versioned revision rounds without routine founder work.

**Architecture:** Extend the deployed scoped order API and private locked order journal. Reuse CV Studio's document table and DOCX renderer; the existing ChatGPT task writes from the source CV and customer answers and renders PDF locally. The website alone sends the branded questionnaire, reminders and completed files.

**Tech Stack:** CodeIgniter PHP, existing MySQL tables, local Python/ReportLab, existing jobs mail, existing n8n bridge and ChatGPT event task.

**Spec:** User's approved instruction in this conversation: finish the existing automated paid CV services, no new spend, HiredNext email colours, only unresolved issues to Taru. Existing offer scope is in `app/Services/Cv/CvUpgradePlans.php`.

## Global constraints

- Assessment remains ₹599; rebuild remains ₹1,799 including assessment, two finished variants and two revision rounds. Do not introduce a new purchase or change legacy delivery owners.
- No paid model API, new subscription, credits, gateway or remote font. Accept exact owner confirmation and continue.
- The original CV and customer answer provenance are immutable. No invented achievements, employers, titles, qualifications or results. No hiring guarantees or founder review claims.
- All external messages use the canonical order recipient. Journal every send before attempting it; uncertainty requires receipt reconciliation. Internal fixtures are zero value, jobs only and never revenue.

## Task 1 — Extend order policy and persist rebuilds

Files: `CvFulfilmentPolicy.php`, `CvFulfilmentOrders.php`, new `CvRebuildPolicy.php`; test `tests/cv_rebuild_automation_test.php`.

Interfaces: `CvRebuildPolicy::templates(array): array`; `CvRebuildPolicy::reply(array $order,array $request): array`; `CvRebuildPolicy::bundle(array $order,array $state,array $bundle,array $source): array`; `CvFulfilmentOrders::hasExistingRebuild(array): bool`; `CvFulfilmentOrders::rebuildDelivered(array,array,array,int): array`.

- [ ] Add failing behaviour cases for unpaid work, exact ₹1,799 confirmation, wrong sender, duplicate customer reply, two distinct template directions, missing evidence/assessment, altered source/answers, duplicate delivery and a third revision.
- [ ] Map approved fixed prices in the shared payment policy. Rebuild document ownership is scoped to its upgrade order, so an earlier assessment report does not block a separately purchased rebuild.
- [ ] Save each delivered variant in `cv_documents` with its template, revision round, delivery ID and original source/answer hashes; preserve prior versions.

```php
$price = ['priority_599'=>599,'rebuild_1799'=>1799][$order['service']] ?? null;
if ($price === null || (int)$order['amount'] !== ($order['is_test'] ? 0 : $price)) {
    throw new DomainException('existing_service_owner_required');
}
```

## Task 2 — Rebuild state and mail delivery

Files: new `CvRebuildService.php`, `CvRebuildMailer.php`; route through `CvFulfilmentService.php` after the existing order capability is validated.

Interfaces: `dispatch(array $order,array $request): array`; actions `inspect`, `confirm_owner`, `confirm_test`, `source`, `intake`, `answers`, `claim`, `deliver`, `request_revision`, `remind`, `reconcile`, `exception`.

- [ ] Implement awaiting-payment → ready → awaiting-answers → ready → processing → delivered. Retain a one-hour exclusive lease and a pre-send uncertain state.
- [ ] Send tailored questions once. Accept a reply only with canonical sender and real Gmail message provenance; hash the answer set. Offer the existing three design directions and produce the selected two, defaulting only when the customer has no preference.
- [ ] Send at most two unanswered-question reminders, after 24 and 72 hours. Store their attempt IDs before sending.
- [ ] Require exactly two distinct finished variants; initial delivery also includes the three-page assessment. Generate the DOCX files with the existing renderer, persist all files privately and deliver PDF/DOCX pairs with clear variant explanations.
- [ ] Permit revision rounds 1 and 2 only on a new genuine customer request. Use a new delivery ID per round and never reopen a sent version. Reconciliation checks a real recipient/message/operation receipt and never blindly resends.

```php
if (isset($state['reply_ids'][$request['gmail_message_id']])) { return $this->snapshot($order,$state); }
if (($state['round'] ?? 0) >= 2) { throw new DomainException('included_revisions_exhausted'); }
```

## Task 3 — Local rendering and verified fixture

Files: `scripts/render_cv_rebuild.py`, synthetic fixture JSON, new `CvRebuildSelfTest.php`; relevant Hostinger test step.

- [ ] Render standard linear CV content in two selected existing directions with visible company spacing, no fabricated facts, and no HiredNext marketing inside the candidate's CV.
- [ ] Include source/answer/content fingerprints in PDF metadata; reject overflow rather than clipping. Inspect both designs and verify extracted text.
- [ ] Exercise one zero-value upgrade order through questions, answer capture, delivery and duplicate suppression. Verify the actual received attachment bytes and document contents. Verify revision counters and uncertainty locally without sending extra customer mail.

## Task 4 — Existing event owner and follow-ups

- [ ] Extend the existing Fulfil CV Assessments task to own the rebuild states and HN-CV-REBUILD threads. Keep existing triggers and branding rules, and exclude existing candidate-specific delivery work.
- [ ] Update Operations Control's existing daily run to route due reminders through the same website journal, not a second sender.
- [ ] Record live evidence and unfinished/unverified commercial outcomes accurately; no test sale or guaranteed income.
