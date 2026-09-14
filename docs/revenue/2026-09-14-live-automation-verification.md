# CV services and revenue activation — 14 September 2026

## What is live

- HiredNext website PRs 25–30 are merged and deployed. Final production source: `b6db5452ff9d7bcd28c135df69d93d708fa880d9`; Hostinger run `34836524366` succeeded.
- Candidate email uses Aptos / Segoe UI / Helvetica Neue / Arial, 16 px, line-height 1.7; HiredNext navy `#0c3466` and orange `#ff4e16`. Shared inline HTML and plain-text alternatives retain the canonical recipient and service thread.
- New website CV order/reference submissions relay through the existing n8n CV Fulfilment Bridge to jobs Gmail and record its real acknowledgement. Duplicate order/reference capture cannot emit another handoff. This does not confirm payment.
- The existing Fulfil CV Services task is enabled for new ₹599 assessments and ₹1,799 rebuilds. It owns genuine service replies, intake, two distinct PDF/Word CVs, an initial assessment and two included rebuild revision rounds. Existing candidate-specific owners remain intact.
- Operations Control retains the existing daily sweep, server-gated reminders and exclusive recovery. Review Incoming CVs excludes paid service threads. No new controller, CRM or paid tool was created.
- The existing employer Revenue Engine is active with verified-contact/intent/evidence gates, atomic send claims, actual Gmail reply suppression and a fresh-record cutoff. Paid research and automatic Happenstance calls are disconnected.

## Live internal evidence

All fixtures below are fictional, jobs-only and zero-value. No customer sale, paid customer fulfilment, bank reconciliation or commercial profit is proved by these tests.

| Check | Actual evidence | Result |
|---|---|---|
| Website → n8n → jobs → website capture | assessment:41; Gmail `1a09f99a3af54047`; deploy command reported native handoff verified | Passed |
| Rebuild intake | upgrade:6; Gmail `1a09f859bd76a909`; email_event 19 | Branded intake received and reconciled |
| Synthetic candidate reply | Gmail `1a09f85e0d25fe52` | Exact reply retained with source provenance |
| Initial rebuild packet | `HN-CV-REBUILD-UPGRADE-6-R0`; Gmail `1a09f9b713901a0a` | Five actual received files verified |
| Website completion | n8n execution 699; email_event 20; cv_documents IDs 1 and 2 | Delivered and versioned |
| Replay | n8n execution 700 | `already_delivered`; no new outbound |
| Existing assessment | assessment:39; Gmail `1a09f388437858e1`; email_event 18 | Three-page PDF previously byte-verified |
| Employer status | Revenue Engine execution 681 | 33 rows, INR 0 recorded receipts |
| Employer due sweep | Revenue Engine execution 682 | No eligible rows; no emails sent |

The live workflow calls were exercised under controlled manual orchestration using the real website, n8n and Gmail interfaces. The event tasks were then updated and their enabled state and saved instructions read back. A real paid event has not yet independently demonstrated an unattended task run.

### Received rebuild attachments

| File | Bytes | SHA-256 |
|---|---:|---|
| R0-1.pdf | 44,658 | `4968ee4a8ee4fd6e2e99c05264e8ad0202b8324c6263b02652180bd832337ced` |
| R0-2.pdf | 66,401 | `1227a61689791ebbbaa47207dc081ad5e3fd5ca042314a1ca34fa93789d6c82e` |
| R0-ASSESSMENT.pdf | 49,932 | `39fe3ee5748659515ec9525a1665f4ce4612b98b7dab48c1388baa3993afd292` |
| R0-1.docx | 3,983 | `a3ea27bddd1e468e22386682c955a3c2a09ed1eda14afcaf3dce5ec7c633976b` |
| R0-2.docx | 4,021 | `db871780da612118034ce77527d1c88ac3391048be625010b1e94bb7f9434e29` |

Each received attachment matched the reserved packet byte for byte. The CV PDFs have one page each, assessment three pages. PDF text was extracted and checked; both Word files passed ZIP integrity and document XML checks for canonical candidate, contact and employers. Visual CV/PDF layout was inspected during generation; Word application rendering was not available.

## Problems corrected during live checks

- Hostinger deployment status recording now handles an SSH retry without committing against stale main.
- Native Gmail was used for rebuild/capture after the configured PHP mail transport did not produce the test intake. The original authenticated jobs Gmail credential was independently verified.
- HTML authority filters no longer corrupt JSON containing a branded HTML email.
- Capture's IF node now compares booleans correctly. The earlier upgrade:6 capture attempt stopped before Gmail and is retained as failure history.
- Rebuild PDF metadata uses recursively canonical object keys in both Python and PHP, so JSON transport key ordering cannot invalidate a correct PDF.
- Native mail stages reserve once; a real recipient/stage/Gmail receipt is required before completion. The website never also sends PHP mail for the reserved Gmail stage.
- Local behaviour checks cover unpaid work, wrong reply sender, duplicate replies/intake, claim conflicts, uncertainty, pause, reminder limits, two revision rounds, source/answer changes, recipient mismatch, altered PDFs, unsupported numeric claims and JSON key ordering.

## Existing owners

| Owner | ID | Verified state |
|---|---|---|
| Fulfil CV Services | 6aa793c72874819199d9958bbff04200 | Enabled; four website/owner/service-reply events retained |
| Review Incoming CVs | 6a9591743b048191aa634aed0ae5a4ba | Enabled; paid service threads excluded |
| HiredNext Operations Control | 6aa1712cd8508191a2ed76eae86835e9 | Enabled; existing schedule, reminders/recovery and exception-only reporting |
| CV Fulfilment Bridge | Svp6SvP0C1R4iI4X | Active; original protected API trigger plus fixed jobs-only capture |
| Employer Revenue Engine | FpTC97xlfGg09zLR | Active version 5d8eda77-565f-4f75-aafd-9330d0f08c0f |

Employer sends are limited to newly captured eligible records after 2026-09-14T10:00:00Z. Historical rows do not trigger a campaign. RecruitOS remains the sole ATS/CRM. Existing blocked bulk imports remain blocked.

## Remaining distribution exception

LinkedIn Revenue Posts task `6aa166633a6881918aa9863e008d84c5` remains paused. The existing native publisher `YGthvUhviZPR9FLx` is active, version `9170106e-ea9f-42da-970c-a1737a1f76af`. Existing execution 666 proved a GCC talent-network post, `urn:li:share:7505130611968462848`; this work did not publish another copy.

The required recent/scheduled-post check was unavailable: the browser was unavailable and read-only probe 701 was rejected because the existing LinkedIn credential forbids HTTP-node use. That access restriction was respected and the unusable probe branch removed. No permissions were widened. LinkedIn's official [Posts API](https://learn.microsoft.com/en-us/linkedin/marketing/community-management/shares/posts-api?view=li-lms-2026-08) documents organisation-read permissions and author-view retrieval; it does not establish that this connection holds those permissions.

Correct existing publisher invocation is top-level `triggerNodeName:"POST hirednext-linkedin-publish"`, with `inputs:{webhookData:{method:"POST",body:{commentary,image_drive_file_id}}}`. Omit `inputs.type`. Resume only already-approved artwork/destinations/cadence after duplicate and queue checks are available. No new artwork, unapproved Profile360 campaign or early newsletter publication.

## Revenue and operating limits

Actual newly generated sales from this release: **none established**. Employer table recorded receipts: **INR 0** at the read-only check. Test cash and external AI API cash spend: **INR 0**. Existing overhead and commercial net profit remain unmeasured.

The pathway proceeds after an exact existing owner payment confirmation, then routine service work belongs to the system. Only unresolved confirmation, factual, capacity or delivery/access exceptions should reach Taru. No job, shortlisting, overnight income or five-times-profit promise is made. Interview Ready remains interest-only and closed for purchase; coaching follows actual demand.

