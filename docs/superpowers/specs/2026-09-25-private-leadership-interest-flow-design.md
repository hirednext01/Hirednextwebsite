# Private Leadership Interest Flow Design

## Purpose

Replace the current payment-first CXO leadership intake with a selective, confidential interest flow. A senior leader should be able to express interest quickly, receive an authoritative private brief immediately, and enter a manually accepted engagement without public bank details or premature payment.

## Positioning

HiredNext is an executive-search and leadership-advisory firm. It does not publicly circulate leadership profiles or imply that senior leaders are openly available. Leadership work is handled privately, under NDA where required, and grounded in evidence of mandate, scale, judgement and outcomes.

The public experience must feel selective and discreet. It must not resemble a mass-market CV-writing checkout.

## User Journey

1. A visitor selects **Show interest** or **Find out more** on the CXO / Global Leadership Positioning page.
2. A short private-interest form opens on the same page or a dedicated HiredNext route.
3. The visitor submits identity, leadership context, contact details and an optional CV.
4. HiredNext stores one durable enquiry record and sends an acknowledgement from `jobs@hirednext.info`.
5. The acknowledgement includes or links to the **HiredNext Private Leadership Positioning Brief**.
6. HiredNext reviews suitability before requesting payment.
7. An accepted leader receives the NDA, confirmed scope, pro forma invoice and bank-transfer instructions privately.
8. The leader pays by NEFT or IMPS and provides the payment reference.
9. HiredNext verifies actual bank credit before marking the engagement paid.
10. The accepted engagement moves into the existing fulfilment owner. No duplicate CRM, order system or inbox owner is created.

## Public Form

### Required fields

- Full name
- Email address
- Phone number
- LinkedIn profile URL
- Current title and organisation
- Target appointment or mandate
- Preferred geography
- Consent to be contacted about this enquiry

### Leadership context

- Current organisational level
- Scale of responsibility
- Commercial or P&L ownership, where relevant
- Team and organisational complexity
- Geographic scope
- Stakeholder level
- Functional-to-enterprise transition, where relevant
- Specific positioning or career challenge
- Whether an NDA is required before detailed disclosure

### Optional upload

- Current CV in PDF, DOC or DOCX, up to the existing safe upload limit

The form must not request bank details, display HiredNext bank details, or require payment before the enquiry is submitted.

## Immediate Response

The acknowledgement must be sent only after a durable request record is created. It should:

- Confirm receipt without implying acceptance
- Set an expected review window
- Explain that leadership engagements are accepted selectively
- Include the private leadership brief
- State that NDA, scope, invoice and bank instructions follow only after acceptance
- Avoid promising introductions, appointments, reach, interviews or recruitment outcomes

## Private Leadership Positioning Brief

The PDF is an editorial proposal, not a public price card. It should cover:

- HiredNext's confidential leadership philosophy
- Leadership evidence diagnostic
- Executive CV and leadership case-study architecture
- LinkedIn positioning created under NDA where required
- Board, founder, investor, PE and portfolio-company readability
- Executive-search discoverability without signalling public availability
- Optional ongoing LinkedIn maintenance
- Thought-leadership planning and authority content
- Relationship and stakeholder mapping
- Preparation for relevant professional conversations
- Considered introductions only where HiredNext has genuine relevance and permission
- Confidentiality boundaries and what is never published without approval
- The acceptance, NDA, scope, invoice, bank-transfer and kickoff sequence

The brief must distinguish positioning and relationship development from guaranteed access or guaranteed outcomes.

## Internal States

Use one canonical lifecycle:

1. `interest_received`
2. `brief_sent`
3. `under_review`
4. `accepted`
5. `nda_sent`
6. `scope_and_invoice_sent`
7. `payment_verification_pending`
8. `paid_verified`
9. `diagnostic_in_progress`
10. `positioning_in_progress`
11. `delivered`
12. `ongoing_advisory`
13. `declined_or_closed`

Status changes must be durable and auditable. A transaction reference or screenshot alone must never set `paid_verified`.

## Payment Handoff

Bank instructions are sent privately only after manual acceptance. The acceptance communication contains:

- HiredNext Recruitment as the beneficiary name
- Pro forma invoice number
- Accepted scope and fee
- NEFT or IMPS bank instructions
- Required payment-reference format
- Request for the transaction reference
- Statement that fulfilment begins after actual bank-credit verification

No Paytm route is used for this engagement. Bank data must not appear in public HTML, page source, downloadable public files or analytics payloads.

## Ongoing Advisory

After delivery, an accepted leader may be offered a separate ongoing engagement covering:

- LinkedIn profile maintenance
- Executive thought-leadership planning
- Authority-content development
- Target-audience and relationship mapping
- Private outreach preparation
- Relevant conversation development
- Considered introductions where appropriate
- Monthly positioning review

This is optional and separately scoped. It does not guarantee introductions, investor access, appointments or recruitment outcomes.

## Ownership and Integration

- The existing HiredNext site/database remains the source of truth for public requests.
- `jobs@hirednext.info` sends candidate-facing acknowledgements and accepted-engagement communications.
- Existing fulfilment ownership receives accepted and paid engagements.
- Recruit OS remains the only ATS/CRM for recruitment records. The flow must not create a second recruitment CRM.
- Candidate-service consent and recruitment consent remain separate.

## Error Handling

- If the PDF email fails, retain the request and mark `brief_send_failed` for recovery.
- If upload fails, preserve the form text and allow resubmission without duplicating the enquiry.
- Deduplicate by normalised email, phone and LinkedIn URL while preserving genuine updated submissions.
- If the bank transfer cannot be verified, keep the engagement at `payment_verification_pending` and do not start fulfilment.
- If the request is unsuitable, send a courteous closure without exposing internal reasoning or bank details.

## Security and Privacy

- Validate file type, size and upload integrity using existing secure-upload patterns.
- Never include bank details in public pages, public PDFs or URL parameters.
- Limit staff access to leadership submissions and uploaded materials.
- Record NDA requirement before detailed evidence is requested.
- Do not publish or circulate a leader's identity, profile or evidence without explicit consent.

## Verification

The implementation is complete only when tests prove:

- Interest submission creates one durable record before email is sent.
- The acknowledgement and private brief are triggered once.
- Public pages contain no bank details and no payment-first language.
- A request can be reviewed and accepted without payment.
- Payment cannot become verified from a typed reference alone.
- Accepted engagements hand off to the existing fulfilment owner.
- Duplicate submissions do not create duplicate outreach.
- The live leadership page exposes an easy **Show interest** and **Find out more** path.
