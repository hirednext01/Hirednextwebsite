# Automatic assessment release — 14 September 2026

The ₹599 assessment pathway is deployed. The existing order event task is enabled for routine generation, quality checks, customer questions and delivery after exact owner confirmation. Rebuild and Interview Ready paid fulfilment are outside this release.

## Deployment and test evidence

- Website PR 23: private order API, scoped access, source extraction without API fallback, exclusive delivery claims, three-page report validation, delivery journal and existing order/report updates.
- Website PR 24: corrected the attachment call after the first internal test exposed a CodeIgniter buffered-attachment error. A regression test uses the real attachment encoder and checks exact bytes. Hostinger deployment run 34827159773 succeeded.
- Published n8n workflow: `Svp6SvP0C1R4iI4X`, version `2e673798-5c30-413b-9883-1f522ba45e3b`.
- Zero-value internal order: `assessment:39`, reference `HNTEST-AUTOMATION-V2`, addressed only to jobs.
- Executions 676–679 completed inspect, test confirmation, exclusive claim and delivery. Website email event 18 records the accepted delivery.
- Received report: `HN-CV-ASSESSMENT-39.pdf`, three pages, 49,780 bytes. Gmail message `1a09f388437858e1` in jobs contains the report.
- The received MIME attachment was decoded through authorised Gmail raw-message access and compared byte for byte with the generated PDF. SHA-256: `4ecf8f47cc6e27e89aea953b1957a88351d2904e6a8c40622d1f392f2a3b0986`.
- Execution 680 repeated delivery and returned `already_delivered`, preserving email event 18.
- Internal fixture 38 exposed the attachment defect. Its immutable history is retained; it is not a valid report-delivery success. Both fixtures have zero receipts and are excluded from demand, conversion and revenue.

## Execution ownership

Existing task `6aa793c72874819199d9958bbff04200`, formerly Capture CV Orders, is now **Fulfil CV Assessments** and remains enabled. Its complete configured Gmail event set covers the internal ACTION CV order alert, the owner's exact-order reply, and assessment service threads with the fixed HN-CV report reference. The jobs and owner addresses were verified through the connected mailboxes. There is no polling schedule or second order worker.

Operations Control was updated with the live interface and evidence. Review Incoming CVs continues its general candidate review remit and excludes these paid assessment threads, preventing competing replies. Routine results stay internal; only unresolved issues requiring Taru's input are surfaced.

The live delivery test used explicit internal/manual execution. The event worker is enabled; no real customer order or unattended event-to-delivery run has yet been demonstrated by this release. No new revenue, bank feed, or automated rebuild delivery is claimed.

Use `docs/revenue/cv-fulfilment-worker.md` for the verified request shape, report contract, quality checks and reconciliation procedure. Use existing ChatGPT task capacity and local rendering; no separately billed model API or new paid integration is part of this path.
