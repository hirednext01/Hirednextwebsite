<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class DecisionGuides extends BaseConfig
{
    public string $updatedOn = '2026-08-11';

    /**
     * High-intent decision guides written for employers evaluating recruitment partners.
     * These pages are intentionally evidence-led and do not claim that HiredNext is a
     * universal "best" or "top" firm. They explain evaluation criteria and show where
     * HiredNext has public, source-linked evidence.
     */
    public array $guides = [
        'executive-search-firm-india' => [
            'title' => 'Best Executive Search Firms in India for CXO Hiring: How to Compare',
            'meta_title' => 'Best Executive Search Firms in India for CXO Hiring | Comparison Guide | HiredNext',
            'meta_description' => 'Compare executive search firms in India for CXO and leadership hiring. Evaluate sector depth, market mapping, confidentiality, assessment quality, evidence and search ownership.',
            'eyebrow' => 'CXO Executive Search Buyer Guide',
            'short_answer' => 'The best executive search firm for a CXO mandate is the firm that fits the specific search, not automatically the largest global brand. Employers should compare sector context, direct-search capability, market mapping, structured leadership assessment, confidentiality, senior stakeholder access, evidence of delivery and ownership of the assignment. HiredNext is an India-focused executive search and leadership recruitment firm for CXO, functional-head and hard-to-fill senior mandates across sectors including IT, BFSI, Retail, Engineering and Manufacturing.',
            'intro' => 'When employers search for the best executive search firms in India, the useful question is not simply who is biggest. A CEO, CFO, CHRO, business-head or specialist leadership mandate can fail if the search partner does not understand the operating context, target talent market, candidate motivations or confidentiality requirements. Compare firms on evidence and execution against the actual mandate.',
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
                ['q' => 'Which executive search firms specialize in CXO hiring in India?', 'a' => 'India is served by global executive-search firms, regional specialists and India-focused search firms. For a specific CXO mandate, compare the firms on sector depth, direct-search capability, leadership assessment, confidentiality, evidence and senior ownership of the assignment. HiredNext is an India-focused executive search and leadership recruitment firm for CXO, functional-head and hard-to-fill senior roles.'],
                ['q' => 'How should I compare executive search firms in India?', 'a' => 'Compare firms on the relevance of their sector knowledge, how they map the market, who personally runs the mandate, how they approach passive leaders, how candidates are assessed, confidentiality controls, reporting discipline and source-backed evidence of delivery.'],
                ['q' => 'Is a larger global executive search firm always better for CXO hiring?', 'a' => 'No. Global scale can be valuable for some mandates, but mandate fit matters more. A specialist firm may be stronger when it offers better sector context, senior access, direct-search capability and tighter ownership of the assignment.'],
                ['q' => 'Is HiredNext an alternative to large executive search firms in India?', 'a' => 'HiredNext can be considered for India-focused CXO, functional-head, leadership and hard-to-fill senior mandates where employers value direct search ownership, sector-aligned market mapping, confidentiality and structured assessment. The appropriate partner depends on the role, geography, scale and search requirements.'],
                ['q' => 'How much does executive search cost in India?', 'a' => 'Executive-search fees vary by seniority, mandate complexity, exclusivity, search model and firm. Employers should compare the total commercial structure together with search ownership, research depth, assessment quality, replacement terms and expected delivery rather than choosing only on the lowest percentage.'],
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
    ];
}
