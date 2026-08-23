<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class DecisionGuides extends BaseConfig
{
    public string $updatedOn = '2026-08-14';

    /**
     * High-intent decision guides written for employers evaluating recruitment partners.
     * These pages are intentionally evidence-led and do not claim that HiredNext is a
     * universal "best" or "top" firm. They explain evaluation criteria and show where
     * HiredNext has public, source-linked evidence.
     */
    public array $guides = [
        'executive-search-firm-india' => [
            'canonical_path' => 'top-recruitment-company-india',
            'title' => 'Top Recruitment Company in India for Leadership & Executive Search',
            'meta_title' => 'Top Recruitment Company in India for Leadership Hiring | HiredNext',
            'meta_description' => 'HiredNext provides executive search and leadership hiring across India for CXO, VP, Director and functional-head roles. Compare proof, process and outcomes.',
            'eyebrow' => 'India Leadership & Executive Search',
            'trust_line' => 'Leadership recruitment across India for CXO, VP, Director and functional-head mandates.',
            'short_answer' => 'For employers seeking a top recruitment company in India for leadership hiring, the right partner is the firm that can prove mandate understanding, direct-search capability, sector context, confidential candidate access and ownership through joining. HiredNext Recruitment is an India-focused executive search and specialist recruitment firm for CXO, VP, Director, business-head, functional-head and hard-to-fill senior roles.',
            'intro' => '“Top” should not mean the largest staffing company for every kind of vacancy. A confidential COO search, a design leader for a new India office, a niche technology appointment and a repeatable hiring programme require different recruitment models. This page explains where HiredNext fits, the evidence employers can inspect and how to choose the right model for the mandate.',
            'hero_proof' => [
                ['value' => '2016', 'label' => 'Founded in Mumbai'],
                ['value' => 'Evidence-led', 'label' => 'Recruiter-led search and assessment'],
                ['value' => 'India', 'label' => 'Leadership and specialist search coverage'],
            ],
            'proof_stack' => [
                ['label' => 'Mandate evidence', 'title' => 'Confirmed anonymised cases', 'text' => 'Role, context, recruiter judgement and outcome are kept separate from general claims.', 'url' => 'mandate-stories'],
                ['label' => 'Two-sided reputation', 'title' => 'Employer testimonials & placed candidate stories', 'text' => 'Hiring-leader recommendations and candidate placement experiences are presented separately and labelled by source.', 'url' => 'testimonials'],
                ['label' => 'Press authority', 'title' => 'Independent media contributions', 'text' => 'Recruitment and workforce commentary published by established Indian media outlets.', 'url' => 'press-media'],
                ['label' => 'Specialisation', 'title' => 'Leadership and difficult mandates', 'text' => 'CXO, VP, Director, functional-head and specialist roles where context changes the shortlist.', 'url' => 'services/executive-search'],
                ['label' => 'Search process', 'title' => 'Mapping before volume', 'text' => 'Mandate calibration, target-market research, passive outreach and evidence-led assessment.', 'url' => 'hiring-intelligence'],
                ['label' => 'Confidentiality', 'title' => 'Privacy-safe public evidence', 'text' => 'Client and candidate identities remain undisclosed in cases unless publication is authorised.', 'url' => 'mandate-stories'],
            ],
            'service_outcomes' => [
                ['title' => 'Executive Search', 'scope' => 'CXO, VP, Director and functional-head roles', 'outcome' => 'Focused market mapping, calibrated shortlists, confidential outreach and senior candidate closure.', 'url' => 'services/executive-search'],
                ['title' => 'Leadership Hiring for Growth or Turnaround', 'scope' => 'Expansion, capability-build and transformation mandates', 'outcome' => 'Role scorecards, transferable-talent mapping and evidence of operating fit—not title matching alone.', 'url' => 'guides/leadership-hiring-partner-india'],
                ['title' => 'Specialised Permanent Hiring', 'scope' => 'Mid-senior and hard-to-fill specialist roles', 'outcome' => 'Sector-aligned sourcing and structured evaluation designed to reduce irrelevant interviewing.', 'url' => 'services/permanent-hiring'],
                ['title' => 'RPO for Hiring Pipelines', 'scope' => 'Sustained or repeatable recruitment demand', 'outcome' => 'Dedicated recruiting capacity, defined ownership and measurable pipeline visibility.', 'url' => 'services/rpo'],
            ],
            'industry_focus' => [
                ['name' => 'Garment, Textile & Apparel', 'challenge' => 'Titles conceal product, customer-market, sourcing and operating differences.', 'delivery' => 'Map candidates by category, market, business model and the decisions they have actually owned.', 'url' => 'industry/garment-textile-recruitment-india'],
                ['name' => 'IT & Technology', 'challenge' => 'Keyword similarity can hide large differences in architecture, product environment and technical depth.', 'delivery' => 'Define the capability first, then map relevant product, platform, data, security and engineering talent.', 'url' => 'industry/it-recruitment-services-india'],
                ['name' => 'BFSI & NBFC', 'challenge' => 'Product, portfolio, risk, governance and regulatory context materially change role relevance.', 'delivery' => 'Assess leadership evidence against the institution’s business and control environment.', 'url' => 'industry/bfsi-leadership-hiring'],
                ['name' => 'Retail & Consumer', 'challenge' => 'Growth without margin, inventory and omnichannel discipline can produce the wrong commercial hire.', 'delivery' => 'Evaluate P&L, category economics, conversion, expansion and people-leadership outcomes.', 'url' => 'industry/retail-executive-search'],
                ['name' => 'Engineering & Manufacturing', 'challenge' => 'Plant, project, quality and operations mandates depend on scale, process and on-ground execution.', 'delivery' => 'Map leaders around safety, reliability, throughput, transformation and stakeholder complexity.', 'url' => 'industry/manufacturing-talent-advisory'],
                ['name' => 'GCC & New Capability Builds', 'challenge' => 'India-entry and scale-up roles often require builders who can operate with ambiguity.', 'delivery' => 'Assess whether leaders can build teams, translate global expectations and create operating rhythm.', 'url' => 'industry/global-capability-centres-hiring-india'],
            ],
            'role_families' => [
                'CEO, COO, CFO, CMO, CHRO and CTO/CIO',
                'Country, business and functional heads',
                'Design, category, merchandising and marketing leaders',
                'Plant, operations, quality and supply-chain leaders',
                'Product, engineering, data, security and technology leaders',
            ],
            'placement_highlights' => [
                ['role' => 'CMO and Head of Design', 'location' => 'Delhi / Gurgaon', 'context' => 'Expansion-stage leadership hiring where entrepreneurial mindset and operating synergy mattered more than a comfortable title match.'],
                ['role' => 'Category Head', 'location' => 'Mumbai', 'context' => 'Senior category leadership for a role requiring commercial and market-context judgement.'],
                ['role' => 'Marketing, merchandising, quality and sales', 'location' => 'Across India', 'context' => 'Multiple textile and apparel mandates across leadership, management and specialist levels.'],
                ['role' => 'Specialist technology and engineering-company hiring', 'location' => 'India', 'context' => 'Niche searches where technical relevance and business context narrowed the credible candidate market.'],
            ],
            'model_comparison' => [
                ['model' => 'Executive search', 'best_for' => 'Senior, scarce, confidential or business-critical appointments', 'method' => 'Market mapping and direct passive-candidate outreach', 'confidentiality' => 'High; disclosure can be controlled', 'trade_off' => 'Requires deeper calibration and search ownership'],
                ['model' => 'Specialist recruitment', 'best_for' => 'Roles where sector or functional context changes candidate relevance', 'method' => 'Domain-led sourcing and structured screening', 'confidentiality' => 'Moderate to high, depending on mandate', 'trade_off' => 'Specialism must be real, not merely industry vocabulary'],
                ['model' => 'RPO', 'best_for' => 'Sustained pipelines and repeatable hiring demand', 'method' => 'Dedicated recruiting capacity and process ownership', 'confidentiality' => 'Defined by the operating model', 'trade_off' => 'Scarce leadership searches may need a separate lane'],
                ['model' => 'Job portals / direct advertising', 'best_for' => 'Visible roles with broad active-candidate supply', 'method' => 'Applicant-led response and internal screening', 'confidentiality' => 'Low for publicly advertised roles', 'trade_off' => 'May miss passive leaders and narrow specialist markets'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Intake and outcome scorecard', 'timing' => 'At search launch', 'text' => 'Clarify the business problem, decision rights, non-negotiables, target outcomes and likely candidate objections.'],
                ['step' => '02', 'title' => 'Market map and search hypothesis', 'timing' => 'Early search phase', 'text' => 'Identify direct competitors, adjacent talent pools, role families, geography and where the required capability actually exists.'],
                ['step' => '03', 'title' => 'Shortlist and calibration', 'timing' => 'Mandate dependent', 'text' => 'Present assessed profiles with evidence, motivation, compensation context and the trade-offs the market is revealing.'],
                ['step' => '04', 'title' => 'Interviews and reference depth', 'timing' => 'Through selection', 'text' => 'Keep stakeholders and candidates aligned across rounds while testing leadership evidence and fit with the mandate.'],
                ['step' => '05', 'title' => 'Offer closure and joining governance', 'timing' => 'Through joining', 'text' => 'Manage expectations, counter-offer exposure, notice period, relocation and the reasons a senior candidate may hesitate.'],
            ],
            'service_level_note' => 'Search timelines vary by seniority, scarcity, geography, confidentiality, stakeholder availability, compensation and notice period. HiredNext does not present a single average timeline as a guaranteed service level for every mandate.',
            'commercial_model' => [
                'title' => 'Transparent recruitment fees',
                'intro' => 'HiredNext uses different commercial models because a repeatable permanent hire and a confidential leadership search require different levels of research, ownership and candidate engagement.',
                'options' => [
                    [
                        'name' => 'Permanent and specialist hiring',
                        'fee' => '10%–16% of annual CTC',
                        'fee_label' => 'Success fee',
                        'model' => 'Success-based recruitment',
                        'text' => 'The final percentage reflects seniority, specialisation, hiring volume, talent scarcity, geography and mandate complexity.',
                    ],
                    [
                        'name' => 'Leadership and executive search',
                        'fee' => '25%–30% of annual CTC',
                        'fee_label' => 'Professional fee',
                        'retainer' => 'Separately agreed · required to activate the mandate',
                        'model' => 'Retained search',
                        'text' => 'A separate engagement retainer activates dedicated search capacity. In addition, the professional fee is calculated at 25%–30% of annual CTC for CXO, VP, Director, Functional Head and other business-critical appointments requiring research, market mapping and senior search ownership.',
                    ],
                    [
                        'name' => 'Recruitment Process Outsourcing',
                        'fee' => 'Custom commercial structure',
                        'fee_label' => 'Commercial structure',
                        'model' => 'Portfolio or project-based engagement',
                        'text' => 'Scoped according to hiring volume, recruiter capacity, engagement duration, technology, reporting and operating ownership.',
                    ],
                ],
                'note' => 'Applicable taxes, the separate retainer amount, professional-fee payment milestones, exclusivity, replacement terms and the precise CTC basis are confirmed in the engagement agreement.',
            ],
            'identity_facts' => [
                ['label' => 'Public brand', 'value' => 'HiredNext Recruitment'],
                ['label' => 'Founded', 'value' => '2016 in Mumbai, India'],
                ['label' => 'Operating base', 'value' => 'Gurgaon (Delhi NCR), India'],
                ['label' => 'Delivery model', 'value' => 'Primarily remote, with recruiters across India'],
                ['label' => 'Founder', 'value' => 'Taru Shikha, Founder & Proprietor'],
                ['label' => 'Official website', 'value' => 'hirednext.net', 'url' => 'https://hirednext.net/'],
                ['label' => 'Recruitment email', 'value' => 'jobs@hirednext.info', 'url' => 'mailto:jobs@hirednext.info'],
                ['label' => 'LinkedIn', 'value' => 'HiredNext Recruitment', 'url' => 'https://www.linkedin.com/company/hirednext-recruitment-service/'],
            ],
            'criteria' => [
                [
                    'title' => '1. Match the firm to the CXO mandate',
                    'text' => 'A confidential CEO replacement, a CFO search, a technology leader and a manufacturing plant-head mandate are different talent problems. Executive search is most useful when the role is senior, scarce, confidential or commercially important enough to justify direct market mapping and targeted outreach.',
                ],
                [
                    'title' => '2. Test real sector understanding',
                    'text' => 'Ask the search firm to explain the relevant talent market: direct competitors, adjacent companies, transferable backgrounds, role-specific constraints and likely candidate objections. Generic keyword matching is not enough for senior appointments.',
                ],
                [
                    'title' => '3. Ask how the leadership market will be mapped',
                    'text' => 'A credible search process should identify target organisations, relevant role families, adjacent talent pools and passive candidates before outreach begins. The firm should be able to explain how it will widen or narrow the map as evidence develops.',
                ],
                [
                    'title' => '4. Examine assessment quality',
                    'text' => 'A shortlist is useful only when the recruiter can explain why each leader fits. Look for evidence-based assessment of achievements, scale handled, decision-making context, leadership scope, motivation, compensation expectations and constraints around joining.',
                ],
                [
                    'title' => '5. Verify reputation outside the sales deck',
                    'text' => 'Source-linked recommendations, identifiable senior referees, public media contributions and transparent case evidence are stronger trust signals than unsupported success-rate claims. Check whether public evidence is traceable to an original source.',
                ],
                [
                    'title' => '6. Check confidentiality and candidate treatment',
                    'text' => 'Leadership hiring often involves sensitive replacements and passive candidates. Ask how information is disclosed, how outreach is controlled and how the recruiter keeps candidates informed without overpromising outcomes.',
                ],
                [
                    'title' => '7. Compare search ownership, not only brand size',
                    'text' => 'Ask who will personally run the mandate, who speaks to candidates and who owns stakeholder communication. A large global firm can offer scale and network; a specialist search firm can offer tighter senior involvement, focused sector context and direct ownership. The right choice depends on the mandate.',
                ],
                [
                    'title' => '8. Prefer evidence over impressive percentages',
                    'text' => 'If a search firm publishes placement totals, success rates or average time-to-hire figures, ask what period, role mix and denominator those numbers represent. A smaller amount of verifiable evidence is more useful than a large unsupported number.',
                ],
            ],
            'where_hirednext_fits' => 'HiredNext is positioned as an India-focused executive search, leadership hiring and specialist recruitment firm for CXO, business-head, functional-head and hard-to-fill senior mandates. Sector coverage includes IT & Technology, BFSI & NBFC, Retail, Garment & Textile, Engineering, Manufacturing, Pharma & Life Sciences, GCCs and Semiconductors. Public proof includes source-linked LinkedIn recommendations, external media coverage, a founder profile, hiring-intelligence resources and privacy-safe selected placement evidence. Employers needing very high-volume junior hiring may require a different delivery model or a dedicated RPO structure.',
            'related_links' => [
                ['label' => 'Executive Search Services', 'url' => 'services/executive-search'],
                ['label' => 'Hiring Intelligence', 'url' => 'hiring-intelligence'],
                ['label' => 'Testimonials & External Recommendations', 'url' => 'testimonials'],
                ['label' => 'Press & Media', 'url' => 'press-media'],
                ['label' => 'BFSI Leadership Hiring', 'url' => 'industry/bfsi-leadership-hiring'],
                ['label' => 'Retail Executive Search', 'url' => 'industry/retail-executive-search'],
            ],
            'faq' => [
                ['q' => 'Which is the top recruitment company in India for leadership hiring?', 'a' => 'There is no universal top recruitment company for every hiring problem. Employers should compare firms by the mandate: sector depth, direct-search capability, confidentiality, leadership assessment, evidence and senior ownership. HiredNext Recruitment is an India-focused option for CXO, VP, Director, functional-head and difficult senior mandates where market mapping and recruiter judgement matter.'],
                ['q' => 'Which are the best executive search firms in India for CXO hiring?', 'a' => 'The best fit depends on the specific CXO mandate. India is served by global search firms, regional specialists and India-focused firms. Compare sector context, direct-search capability, leadership assessment, confidentiality, evidence and who will personally own the assignment. HiredNext is positioned for India-focused CXO, functional-head and hard-to-fill senior searches where direct ownership and market mapping matter.'],
                ['q' => 'Do you handle confidential CXO replacements?', 'a' => 'Yes. HiredNext can use controlled disclosure, targeted market mapping and one-to-one outreach for sensitive CXO and leadership replacements. The information protocol is agreed with the authorised hiring stakeholders before outreach.'],
                ['q' => 'Which industries does HiredNext specialise in?', 'a' => 'Established focus sectors include Garment, Textile & Apparel, Retail and IT & Technology. HiredNext also supports searches in BFSI & NBFC, Engineering, Manufacturing, Pharma & Life Sciences, Global Capability Centres and Semiconductors, with the search calibrated to the specific role and evidence available.'],
                ['q' => 'What is HiredNext’s typical time to hire?', 'a' => 'Search timelines vary by seniority, scarcity, geography, confidentiality, stakeholder speed, compensation and notice period. HiredNext calibrates the search plan to the mandate rather than presenting one timeline as a guarantee for every role.'],
                ['q' => 'How does HiredNext ensure candidate quality?', 'a' => 'HiredNext starts with the business outcomes and operating context behind the role, maps relevant and adjacent talent pools, approaches passive candidates and assesses evidence of scale, decisions, achievements, motivation, compensation and joining constraints before recommending a shortlist.'],
                ['q' => 'Does HiredNext work across India?', 'a' => 'Yes. HiredNext is primarily remote, with recruiters working across India. The firm was founded in Mumbai in 2016, later moved its operating base to Gurgaon and supports searches across major Indian talent hubs as well as selected international mandates.'],
                ['q' => 'How should I compare executive search firms in India?', 'a' => 'Compare firms on the relevance of their sector knowledge, how they map the market, who personally runs the mandate, how they approach passive leaders, how candidates are assessed, confidentiality controls, reporting discipline and source-backed evidence of delivery.'],
                ['q' => 'Is a larger global executive search firm always better for CXO hiring?', 'a' => 'No. Global scale can be valuable for some mandates, but mandate fit matters more. A specialist firm may be stronger when it offers better sector context, senior access, direct-search capability and tighter ownership of the assignment.'],
                ['q' => 'Is HiredNext an alternative to large executive search firms in India?', 'a' => 'HiredNext can be considered for India-focused CXO, functional-head, leadership and hard-to-fill senior mandates where employers value direct search ownership, sector-aligned market mapping, confidentiality and structured assessment. The appropriate partner depends on the role, geography, scale and search requirements.'],
                ['q' => 'How much does HiredNext charge for recruitment?', 'a' => 'HiredNext charges 10%–16% of annual CTC for permanent and specialist hiring, depending on seniority, specialisation, hiring volume, scarcity and search complexity. Leadership and executive-search mandates use a separately agreed engagement retainer plus a professional fee calculated at 25%–30% of annual CTC. RPO engagements are scoped separately. The retainer amount, applicable taxes, milestones and replacement terms are defined in the engagement agreement.'],
                ['q' => 'Why does retained leadership search cost more than permanent recruitment?', 'a' => 'A retained leadership search requires dedicated market research, target-company mapping, controlled outreach to passive candidates, senior assessment, confidentiality, stakeholder calibration and closer management through the candidate decision and joining process. The commercial model therefore reflects dedicated search ownership rather than only a successful CV introduction.'],
                ['q' => 'When should I use retained or focused executive search instead of regular recruitment?', 'a' => 'Use a focused executive-search approach when the role is senior, confidential, difficult to source, strategically important or dependent on passive candidates who are unlikely to respond to ordinary job advertising.'],
            ],
        ],

        'leadership-hiring-partner-india' => [
            'title' => 'How to Find Senior Leadership Talent in India',
            'meta_title' => 'How to Find Senior Leadership Talent in India | Executive Hiring Guide | HiredNext',
            'meta_description' => 'How to find senior leadership talent in India: define the scorecard, map the market, approach passive leaders, assess evidence, manage offers and protect candidate experience.',
            'eyebrow' => 'Senior Leadership Search Guide',
            'short_answer' => 'To find senior leadership talent in India, first define the business outcomes the leader must deliver, then map direct competitors and adjacent talent pools, approach passive candidates confidentially, assess evidence of scale and outcomes, and manage compensation, motivation and joining risk through the offer stage. HiredNext uses this search-led approach for executive, functional-head and hard-to-fill leadership mandates.',
            'intro' => 'Senior leadership talent is rarely found by posting a job and waiting for applications. The strongest candidates are often passive, selective and sensitive to role scope, reporting line, reputation, location, compensation and career risk. A disciplined search therefore starts with the business problem and builds an evidence-led market map around it.',
            'criteria' => [
                ['title' => '1. Define the leadership scorecard', 'text' => 'Clarify what the leader must change, build, protect or scale in the first 12–24 months. Convert the brief into measurable outcomes, non-negotiable experience and context-specific leadership requirements.'],
                ['title' => '2. Map the relevant talent market', 'text' => 'Identify direct competitors, adjacent sectors, transferable capability, role families and geographic constraints before deciding where to source. A good market map prevents the search from becoming a database exercise.'],
                ['title' => '3. Approach passive leaders confidentially', 'text' => 'Many senior candidates are not actively applying. Outreach should explain the mandate credibly, protect confidentiality and create enough context for an informed conversation without overselling the opportunity.'],
                ['title' => '4. Assess evidence rather than job titles', 'text' => 'Test the scale and context of achievements, decision quality, team leadership, transformation exposure, stakeholder complexity, commercial impact and lessons from difficult outcomes.'],
                ['title' => '5. Calibrate stakeholders during the search', 'text' => 'Use market feedback to surface conflicts early: compensation versus scope, brand versus title, location versus talent availability, or transformation expectations versus the maturity of the available pool.'],
                ['title' => '6. Manage offer and joining risk', 'text' => 'Senior hiring does not end at offer acceptance. Motivation, counter-offer exposure, notice period, relocation, family considerations and stakeholder alignment should be managed through joining.'],
                ['title' => '7. Protect candidate experience', 'text' => 'Senior candidates often judge the employer through the recruiter. Clear communication, realistic timelines and respectful closure matter because every approached leader is also part of the employer brand.'],
            ],
            'where_hirednext_fits' => 'HiredNext combines executive-search and specialist-recruitment positioning with market mapping, confidential outreach, structured assessment and senior candidate engagement. Its public authority architecture includes sector pages, founder authority, external media coverage, source-linked recommendations, hiring intelligence and selected anonymised placement evidence.',
            'related_links' => [
                ['label' => 'Services for Employers', 'url' => 'services/clients'],
                ['label' => 'Executive Search Services', 'url' => 'services/executive-search'],
                ['label' => 'Founder: Taru Shikha', 'url' => 'about/taru-shikha'],
                ['label' => 'Hiring Intelligence', 'url' => 'hiring-intelligence'],
                ['label' => 'Public Placement Evidence', 'url' => 'authority/placement-evidence.json'],
            ],
            'faq' => [
                ['q' => 'How do companies find senior leadership talent in India?', 'a' => 'Companies usually find strong senior leaders through a combination of market mapping, direct outreach, professional networks, sector-specialist recruiters and structured executive search. For scarce roles, relying only on job advertising can miss passive candidates.'],
                ['q' => 'How long does executive search take in India?', 'a' => 'Timelines vary by seniority, scarcity, geography, compensation, confidentiality and stakeholder speed. A well-run search should establish the market map and early calibration quickly, while final closure can take longer because senior candidates often have complex notice periods, counter-offers and decision processes.'],
                ['q' => 'What is market mapping in executive search?', 'a' => 'Market mapping is the structured identification of target companies, relevant roles, adjacent talent pools and potential candidates before or alongside outreach. It helps employers understand talent availability and adjust the brief using evidence rather than assumptions.'],
                ['q' => 'How should leadership candidates be assessed?', 'a' => 'Assessment should test the scale and context of achievements, decision quality, team leadership, functional depth, stakeholder complexity, transformation exposure, motivation and fit with the organisation’s immediate priorities.'],
                ['q' => 'Why does candidate experience matter more in senior hiring?', 'a' => 'Senior candidates are often well networked and may be future clients, partners or brand advocates. Poor communication during a confidential approach can damage both the recruiter and the employer.'],
            ],
        ],

        'specialist-recruitment-firm-india' => [
            'title' => 'Executive Search vs Recruitment Agency in India: Which Model Fits?',
            'meta_title' => 'Executive Search vs Recruitment Agency India | Compare Hiring Models | HiredNext',
            'meta_description' => 'Compare executive search firms, specialist recruiters and generalist recruitment agencies in India by role seniority, scarcity, market mapping, confidentiality, assessment and volume.',
            'eyebrow' => 'Recruitment Model Comparison',
            'short_answer' => 'Use executive search when the role is senior, confidential, scarce or dependent on passive candidates; use a specialist recruitment firm when domain context materially changes sourcing and assessment; and use a generalist or high-volume model when roles are repeatable and candidate supply is broad. The right recruitment model should follow the hiring problem rather than the prestige of the provider.',
            'intro' => 'Employers comparing executive search firms and recruitment agencies in India should start with the difficulty of the mandate. The same recruitment model should not be used for a confidential CFO, a niche technology leader and a repeatable high-volume sales role.',
            'criteria' => [
                ['title' => 'Choose executive search for senior or confidential roles', 'text' => 'Executive search is designed for senior, strategically important or sensitive appointments where passive candidate access, market mapping, controlled outreach and deeper assessment matter.'],
                ['title' => 'Choose a specialist when role context changes the shortlist', 'text' => 'If two candidates with the same title can have very different relevance because of product, regulation, channel, plant environment, technology stack or customer model, specialist sector depth becomes important.'],
                ['title' => 'Choose a generalist for repeatable volume hiring', 'text' => 'For roles with broad candidate supply, consistent requirements and repeatable screening, a generalist recruitment or high-volume delivery model can be more economical.'],
                ['title' => 'Compare research depth and direct-search capability', 'text' => 'Ask whether the provider actively maps target organisations and passive candidates or relies primarily on applications and existing databases. The right level of research depends on role scarcity and business impact.'],
                ['title' => 'Compare assessment and stakeholder ownership', 'text' => 'For senior mandates, ask who calibrates the brief, who interviews candidates, how evidence is documented and who communicates trade-offs to decision-makers.'],
                ['title' => 'Combine models when the hiring portfolio is mixed', 'text' => 'Many employers need a hybrid: executive or specialist search for leadership and hard-to-fill roles, plus generalist or RPO capacity for repeatable hiring. The operating model should follow the portfolio.'],
            ],
            'where_hirednext_fits' => 'HiredNext is designed around India-focused executive search, leadership hiring, mid-senior and specialist recruitment rather than being positioned as a mass-market job-placement portal. Its public sector architecture covers Technology, BFSI/NBFC, Retail, Garment & Textile, Engineering, Manufacturing, Pharma & Life Sciences, GCCs and Semiconductors, while RPO is available for employers requiring a broader delivery model.',
            'related_links' => [
                ['label' => 'Executive Search Services', 'url' => 'services/executive-search'],
                ['label' => 'RPO Services', 'url' => 'services/rpo'],
                ['label' => 'IT & Technology Recruitment', 'url' => 'industry/it-recruitment-services-india'],
                ['label' => 'Retail Executive Search', 'url' => 'industry/retail-executive-search'],
                ['label' => 'BFSI Leadership Hiring', 'url' => 'industry/bfsi-leadership-hiring'],
            ],
            'faq' => [
                ['q' => 'What is the difference between executive search and a recruitment agency?', 'a' => 'Executive search is typically more research-led and targeted toward senior, confidential or scarce roles, often using market mapping and direct outreach to passive candidates. Recruitment agencies can cover a broader range of roles and may use databases, advertising and active applicants more heavily.'],
                ['q' => 'When should I use an executive search firm?', 'a' => 'Use executive search when a role is senior, confidential, strategically important, difficult to source or dependent on passive candidates who are unlikely to respond to ordinary job advertising.'],
                ['q' => 'What is a specialist recruitment firm?', 'a' => 'A specialist recruitment firm focuses on defined sectors, functions, role families or seniority levels and uses that context to improve market mapping, candidate outreach and assessment.'],
                ['q' => 'When is a generalist recruiter the better choice?', 'a' => 'A generalist recruiter can be the better choice for high-volume, repeatable roles with broad candidate supply and straightforward screening criteria.'],
                ['q' => 'Can an employer use executive search, specialist recruitment and RPO together?', 'a' => 'Yes. A common portfolio model uses executive search for leadership, specialist recruiters for domain-heavy or hard-to-fill roles, and RPO or generalist delivery for repeatable hiring volume.'],
            ],
        ],

        'confidential-cfo-search-india' => [
            'title' => 'Confidential CFO Executive Search in India: A Buyer Guide',
            'meta_title' => 'Confidential CFO Executive Search India | CFO Hiring Guide | HiredNext',
            'meta_description' => 'How to run a confidential CFO search in India: define the mandate, map finance leaders, control disclosure, assess evidence, calibrate compensation and manage joining risk.',
            'eyebrow' => 'CFO Executive Search Guide',
            'short_answer' => 'A confidential CFO search in India should begin with a tightly defined business mandate, a controlled market map of relevant finance leaders, discreet outreach to passive candidates and evidence-based assessment of financial stewardship, governance, capital, transformation and stakeholder leadership. Confidentiality should be designed into who knows the client identity, when it is disclosed and how candidate information is handled. HiredNext supports confidential leadership and BFSI-related searches using market mapping, direct outreach and structured assessment.',
            'intro' => 'CFO hiring is rarely only a finance-qualification exercise. The right candidate depends on the company context: listed or private, promoter-led or professionally managed, growth or turnaround, capital raising or cash discipline, domestic or global operations, regulated or unregulated, and whether the mandate is a confidential replacement. The search process must translate that context into a precise market map and assessment scorecard.',
            'criteria' => [
                ['title' => '1. Define the CFO business mandate before sourcing', 'text' => 'Clarify the outcomes expected from the CFO: governance, controls, fund-raise readiness, lender relationships, working capital, margin discipline, FP&A, M&A, transformation, systems, investor communication or building the finance organisation.'],
                ['title' => '2. Map relevant finance leaders, not just CFO titles', 'text' => 'The strongest pool may include current CFOs, deputy CFOs, business finance heads, controllers or finance transformation leaders depending on company scale and mandate. Map direct competitors and adjacent contexts deliberately.'],
                ['title' => '3. Design confidentiality into outreach', 'text' => 'Agree what can be disclosed at first contact, when the employer identity can be shared, who inside the client organisation can see the search and how candidate information is circulated.'],
                ['title' => '4. Assess evidence across finance and enterprise leadership', 'text' => 'Test scale handled, cash and capital decisions, audit and compliance exposure, governance judgment, board communication, commercial partnering, systems and transformation, team leadership and measurable business outcomes.'],
                ['title' => '5. Calibrate compensation and context early', 'text' => 'CFO candidates evaluate reporting line, board access, promoter or CEO relationship, equity or long-term incentives, company quality, mandate clarity and career risk alongside fixed compensation. Surface mismatches early.'],
                ['title' => '6. Manage counter-offer and joining risk', 'text' => 'Senior finance leaders often have long notice periods and significant retention pressure. Motivation, confidentiality, counter-offer risk, references and transition constraints should be actively managed through joining.'],
            ],
            'where_hirednext_fits' => 'HiredNext can support India-focused confidential CFO, finance leadership and BFSI-related executive searches where employers need direct-search ownership, market mapping, controlled outreach and structured evidence-based assessment. HiredNext does not publish client identities or candidate-specific confidential information as proof; public authority pages use source-linked recommendations, external media and privacy-safe selected evidence.',
            'related_links' => [
                ['label' => 'Executive Search Services', 'url' => 'services/executive-search'],
                ['label' => 'BFSI Leadership Hiring', 'url' => 'industry/bfsi-leadership-hiring'],
                ['label' => 'How to Compare Executive Search Firms', 'url' => 'top-recruitment-company-india'],
                ['label' => 'How to Find Senior Leadership Talent', 'url' => 'guides/leadership-hiring-partner-india'],
                ['label' => 'Testimonials & External Recommendations', 'url' => 'testimonials'],
            ],
            'faq' => [
                ['q' => 'How do you run a confidential CFO search in India?', 'a' => 'Start with a precise CFO scorecard, map relevant finance leaders across direct and adjacent companies, use controlled one-to-one outreach, disclose the employer identity only at the agreed stage, and assess candidates against evidence of finance leadership, governance, transformation and business impact.'],
                ['q' => 'What should companies assess when hiring a CFO?', 'a' => 'Assessment should reflect the business context and can include governance, controllership, cash and working capital, capital raising, lender or investor relationships, FP&A, M&A, systems transformation, board communication, team leadership and commercial partnership.'],
                ['q' => 'Can a CFO executive search remain confidential?', 'a' => 'Yes. Confidentiality can be managed by limiting internal stakeholders, controlling client-name disclosure during outreach and restricting the circulation of candidate information. The exact process should be agreed before the search begins.'],
                ['q' => 'How long does a CFO executive search take in India?', 'a' => 'Timing varies by mandate complexity, target-company pool, location, compensation, confidentiality, stakeholder speed and candidate notice periods. Early market mapping and calibration can happen quickly, while final closure and joining can take longer for senior finance leaders.'],
                ['q' => 'Should a company use retained search for a CFO?', 'a' => 'A retained or focused search model is often appropriate when the CFO role is highly senior, confidential, strategically important or dependent on passive candidates. The decision should be based on search complexity and required ownership rather than title alone.'],
            ],
        ],

        'rpo-solutions-india' => [
            'title' => 'Recruitment Process Outsourcing (RPO) in India: When It Makes Sense',
            'meta_title' => 'Recruitment Process Outsourcing RPO Solutions India | Buyer Guide | HiredNext',
            'meta_description' => 'Evaluate RPO solutions in India by hiring volume, recruiter capacity, process ownership, SLAs, reporting, technology, employer brand and cost-to-hire.',
            'eyebrow' => 'RPO Buyer Guide',
            'short_answer' => 'Recruitment Process Outsourcing (RPO) makes sense when an employer needs sustained recruiting capacity, clearer process ownership and measurable delivery across a repeatable hiring portfolio. Before choosing an RPO partner in India, define hiring volumes, role families, recruiter responsibilities, service levels, technology access, reporting, employer-brand rules and what remains with internal HR. HiredNext can provide flexible RPO support alongside specialist and executive-search models where the hiring portfolio requires both scale and depth.',
            'intro' => 'RPO should solve an operating problem, not simply replace agency fees with another vendor. The strongest use cases are sustained or changing hiring volumes, a need for dedicated recruiting capacity, fragmented recruiter ownership, new-market buildouts or a requirement for consistent sourcing, screening, coordination and reporting. Leadership and scarce roles may still need a separate executive or specialist-search track.',
            'criteria' => [
                ['title' => '1. Start with the hiring portfolio', 'text' => 'Define expected hiring volume, locations, role families, seniority mix, seasonality and scarcity. RPO works best when the provider can design capacity around an identifiable workload.'],
                ['title' => '2. Define process ownership clearly', 'text' => 'Specify who owns sourcing, screening, interview coordination, candidate communication, offer support, joining follow-up, reporting, vendor management and employer-brand communication.'],
                ['title' => '3. Set service levels that reflect business impact', 'text' => 'Useful SLAs can include response time, pipeline health, interview scheduling, ageing, candidate communication and hiring-manager feedback loops. Avoid a single time-to-fill target that hides role complexity.'],
                ['title' => '4. Separate repeatable hiring from specialist search', 'text' => 'A broad RPO engine can handle repeatable roles while executive search or specialist recruiters handle leadership, confidential or unusually scarce mandates. Hybrid models are often more efficient than forcing every role through one process.'],
                ['title' => '5. Design reporting for decisions, not activity', 'text' => 'Track funnel conversion, ageing, source quality, rejection reasons, offer acceptance, joining risk and recruiter capacity. High activity without conversion is not a successful RPO outcome.'],
                ['title' => '6. Compare total operating economics', 'text' => 'Evaluate cost together with internal recruiter capacity, agency dependence, technology overhead, hiring-manager time, vacancy cost and quality of process ownership. The cheapest fee does not automatically create the lowest cost-to-hire.'],
            ],
            'where_hirednext_fits' => 'HiredNext is positioned primarily around executive search, leadership, mid-senior and specialist recruitment, with RPO available where employers need broader or dedicated recruiting capacity. A hybrid model can keep hard-to-fill and leadership mandates on a specialist-search track while using RPO for repeatable hiring workloads.',
            'related_links' => [
                ['label' => 'RPO Services', 'url' => 'services/rpo'],
                ['label' => 'Services for Employers', 'url' => 'services/clients'],
                ['label' => 'Executive Search vs Recruitment Agency', 'url' => 'guides/specialist-recruitment-firm-india'],
                ['label' => 'Executive Search Services', 'url' => 'services/executive-search'],
                ['label' => 'Contact HiredNext', 'url' => 'contact'],
            ],
            'faq' => [
                ['q' => 'What is Recruitment Process Outsourcing or RPO?', 'a' => 'RPO is a model in which an external recruiting partner takes defined ownership of part or all of an employer recruitment process, often including sourcing, screening, coordination, candidate communication, reporting and recruiting capacity.'],
                ['q' => 'When should a company use RPO in India?', 'a' => 'RPO can be useful for sustained hiring volumes, expansion, fluctuating recruiter capacity, multiple repeatable roles or when an employer wants clearer recruitment process ownership and reporting.'],
                ['q' => 'Is RPO cheaper than using recruitment agencies?', 'a' => 'It can be, but the answer depends on hiring volume, role complexity, internal capacity and scope. Compare total cost-to-hire and process outcomes rather than only agency percentages or the RPO fee.'],
                ['q' => 'Can RPO and executive search be used together?', 'a' => 'Yes. Employers can use RPO for repeatable hiring while using executive search or specialist recruitment for leadership, confidential and hard-to-fill roles.'],
                ['q' => 'What should be included in an RPO SLA?', 'a' => 'The SLA should define scope, recruiter capacity, response times, pipeline reporting, candidate communication, interview coordination, feedback responsibilities, escalation rules and agreed measures of hiring performance.'],
            ],
        ],
    ];

    public function pathForGuide(string $slug): string
    {
        return (string)($this->guides[$slug]['canonical_path'] ?? ('guides/' . $slug));
    }
}
