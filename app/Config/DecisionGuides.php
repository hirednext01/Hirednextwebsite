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
            'title' => 'How to Choose an Executive Search Firm in India',
            'meta_title' => 'How to Choose an Executive Search Firm in India | HiredNext',
            'meta_description' => 'A practical employer guide to choosing an executive search firm in India: sector fit, market mapping, assessment quality, confidentiality, evidence and candidate experience.',
            'eyebrow' => 'Executive Search Buyer Guide',
            'short_answer' => 'Choose an executive search firm by matching the partner to the difficulty of the mandate, not by choosing the largest brand. For CXO, functional-head and hard-to-fill roles, look for sector context, direct-search capability, structured assessment, confidentiality, senior stakeholder access and source-backed evidence of delivery. The strongest partner should also be clear about what it can prove and what it cannot.',
            'intro' => 'A leadership search partner is being trusted with a business-critical decision. The right evaluation therefore goes beyond CV volume. Employers should test how the firm maps a market, understands role context, approaches passive candidates, assesses leadership evidence and communicates risk during the search.',
            'criteria' => [
                [
                    'title' => '1. Match the firm to the mandate',
                    'text' => 'A confidential CEO replacement, a specialist cyber-security leader and a high-volume sales hiring programme are different problems. Executive search is most useful when the role is senior, scarce, confidential or commercially important enough to justify direct market mapping and targeted outreach.',
                ],
                [
                    'title' => '2. Test real sector understanding',
                    'text' => 'Ask the recruiter to explain the talent market in your sector: adjacent companies, transferable backgrounds, role-specific constraints and likely candidate objections. Generic keyword matching is not enough for senior appointments.',
                ],
                [
                    'title' => '3. Ask how the market will be mapped',
                    'text' => 'A credible search process should identify target organisations, relevant role families, adjacent talent pools and passive candidates. The firm should be able to explain how it will widen or narrow the map as evidence develops.',
                ],
                [
                    'title' => '4. Examine assessment quality',
                    'text' => 'A shortlist is useful only when the recruiter can explain why each person fits. Look for evidence-based assessment of achievements, scale handled, decision-making context, leadership scope, motivation, compensation expectations and constraints around joining.',
                ],
                [
                    'title' => '5. Verify reputation outside the sales deck',
                    'text' => 'Source-linked recommendations, identifiable senior referees, public media contributions and transparent case evidence are stronger trust signals than unsupported success-rate claims. Check whether public evidence is traceable to the original source.',
                ],
                [
                    'title' => '6. Check confidentiality and candidate treatment',
                    'text' => 'Leadership hiring often involves sensitive replacements and passive candidates. Ask how information is disclosed, how outreach is controlled and how the recruiter keeps candidates informed without overpromising outcomes.',
                ],
                [
                    'title' => '7. Prefer evidence over impressive percentages',
                    'text' => 'If a search firm publishes placement totals, success rates or average time-to-hire figures, ask what period, role mix and denominator those numbers represent. A smaller amount of verifiable evidence is more useful than a large unsupported number.',
                ],
            ],
            'where_hirednext_fits' => 'HiredNext is positioned for executive, leadership, mid-senior and specialist recruitment in India, with sector pages covering IT & Technology, BFSI & NBFC, Retail, Garment & Textile, Engineering, Manufacturing, Pharma & Life Sciences, GCCs and Semiconductors. Public proof includes source-linked LinkedIn recommendations, external media coverage, a founder profile and a privacy-safe selected placement-evidence dataset. Employers needing very high-volume junior hiring may require a different delivery model or a dedicated RPO structure.',
            'related_links' => [
                ['label' => 'Executive Search Services', 'url' => 'services/executive-search'],
                ['label' => 'Hiring Intelligence', 'url' => 'hiring-intelligence'],
                ['label' => 'Testimonials & External Recommendations', 'url' => 'testimonials'],
                ['label' => 'Press & Media', 'url' => 'press-media'],
            ],
            'faq' => [
                ['q' => 'What should I ask an executive search firm before appointing it?', 'a' => 'Ask how it will map the market, which adjacent talent pools it will consider, who will lead the search, how candidates will be assessed, how confidentiality is handled, what evidence supports its sector claims and how progress will be reported.'],
                ['q' => 'Is a larger recruitment firm always better for executive hiring?', 'a' => 'No. Scale can help, but mandate fit matters more. A smaller specialist firm can be stronger when it has better sector context, senior access, direct-search capability and tighter ownership of the assignment.'],
                ['q' => 'What evidence should an executive search firm provide?', 'a' => 'Useful evidence includes source-linked client recommendations, identifiable senior referees where appropriate, anonymised case evidence, public thought leadership, media coverage and a clear explanation of methodology.'],
                ['q' => 'When should I use retained or focused executive search instead of regular recruitment?', 'a' => 'Use a focused executive-search approach when the role is senior, confidential, difficult to source, strategically important or dependent on passive candidates who are unlikely to respond to ordinary job advertising.'],
            ],
        ],

        'leadership-hiring-partner-india' => [
            'title' => 'What Makes a Strong Leadership Hiring Partner in India?',
            'meta_title' => 'Leadership Hiring Partner India: What Employers Should Evaluate | HiredNext',
            'meta_description' => 'A practical guide for employers evaluating leadership hiring partners in India, covering market mapping, stakeholder calibration, candidate assessment, confidentiality and evidence.',
            'eyebrow' => 'Leadership Hiring Guide',
            'short_answer' => 'A strong leadership hiring partner combines market intelligence with disciplined execution. Employers should look for a recruiter who can challenge the brief, map adjacent talent pools, approach passive candidates, assess leadership evidence rather than titles, manage confidentiality and communicate trade-offs clearly. Public, source-linked proof is more useful than generic claims of reach or speed.',
            'intro' => 'Leadership hiring fails when the search is treated as a senior version of ordinary CV sourcing. The recruiter has to understand the business problem behind the vacancy, calibrate stakeholders and translate that into a realistic talent map.',
            'criteria' => [
                ['title' => '1. Brief calibration before sourcing', 'text' => 'The recruiter should clarify what the leader must change, build or protect in the first 12–24 months. This is more useful than relying only on title, years of experience and a long competency list.'],
                ['title' => '2. Market intelligence, not database search', 'text' => 'The partner should identify direct competitors, adjacent sectors, transferable capability and likely talent gaps before deciding where to source.'],
                ['title' => '3. Evidence-led candidate conversations', 'text' => 'Senior candidates should be assessed through examples of decisions, outcomes, scale, team leadership, transformation context and constraints — not just polished interview answers.'],
                ['title' => '4. Clear stakeholder communication', 'text' => 'A good partner surfaces disagreement early: compensation versus scope, brand versus title, location versus talent availability, or transformation expectations versus the maturity of the target pool.'],
                ['title' => '5. Candidate experience as a reputation issue', 'text' => 'Senior candidates often judge the employer through the recruiter. Clear communication, realistic timelines and respectful closure matter because every approached candidate is also part of the employer brand.'],
                ['title' => '6. Proof that survives verification', 'text' => 'Look for public recommendations from senior professionals, source-linked external coverage and specific anonymised evidence. Avoid taking large success-rate numbers at face value without methodology.'],
            ],
            'where_hirednext_fits' => 'HiredNext combines executive-search and specialist-recruitment positioning with public founder authority, external media coverage, senior LinkedIn recommendations and selected anonymised joined-placement evidence. Its strongest evidence-backed areas currently include Garment & Textile, Retail and Technology, while BFSI/NBFC, Pharma & Life Sciences, GCC and Semiconductor pages describe active capability-building rather than claiming unverified placement history.',
            'related_links' => [
                ['label' => 'Services for Employers', 'url' => 'services/clients'],
                ['label' => 'Founder: Taru Shikha', 'url' => 'about/taru-shikha'],
                ['label' => 'Hiring Intelligence', 'url' => 'hiring-intelligence'],
                ['label' => 'Public Placement Evidence', 'url' => 'authority/placement-evidence.json'],
            ],
            'faq' => [
                ['q' => 'How is leadership hiring different from normal recruitment?', 'a' => 'Leadership hiring usually requires deeper role calibration, direct access to passive candidates, assessment of business outcomes and leadership context, greater confidentiality and more involvement from senior client stakeholders.'],
                ['q' => 'How should leadership candidates be assessed?', 'a' => 'Assessment should test the scale and context of achievements, decision quality, team leadership, functional depth, stakeholder complexity, transformation exposure, motivation and fit with the organisation’s immediate priorities.'],
                ['q' => 'Why does candidate experience matter more in senior hiring?', 'a' => 'Senior candidates are often well networked and may be future clients, partners or brand advocates. Poor communication during a confidential approach can damage both the recruiter and the employer.'],
            ],
        ],

        'specialist-recruitment-firm-india' => [
            'title' => 'Specialist Recruitment Firm vs Generalist Recruiter in India',
            'meta_title' => 'Specialist Recruitment Firm vs Generalist Recruiter India | HiredNext',
            'meta_description' => 'When should an employer use a specialist recruitment firm in India instead of a generalist recruiter? Compare sector depth, role scarcity, market mapping and hiring volume.',
            'eyebrow' => 'Recruitment Strategy Guide',
            'short_answer' => 'Use a specialist recruitment firm when the cost of misunderstanding the role is high: niche technology, regulated functions, senior leadership, domain-heavy manufacturing, category leadership or other hard-to-fill positions. A generalist recruiter can be more efficient for broad, repeatable hiring where the talent pool is large and the assessment criteria are straightforward.',
            'intro' => 'The choice between a specialist and a generalist recruiter should be based on hiring complexity rather than prestige. Specialist recruiters earn their value when domain context changes who should be approached, how candidates are assessed or what adjacent backgrounds are credible.',
            'criteria' => [
                ['title' => 'Use a specialist when role context changes the shortlist', 'text' => 'If two candidates with the same title can have very different relevance because of product, regulation, channel, plant environment, technology stack or customer model, sector depth becomes important.'],
                ['title' => 'Use a specialist when passive talent matters', 'text' => 'Scarce candidates are often not applying to jobs. A specialist partner should know where those people sit, how adjacent talent pools differ and what is likely to make them engage.'],
                ['title' => 'Use a generalist for repeatable volume hiring', 'text' => 'For roles with broad candidate supply, consistent requirements and repeatable screening, a generalist or high-volume delivery model can be more economical.'],
                ['title' => 'Test specialists for real depth', 'text' => 'A sector label on a website is not enough. Ask the recruiter to discuss actual role families, adjacent talent pools, market constraints and the evidence supporting its claimed expertise.'],
                ['title' => 'Combine models when the hiring portfolio is mixed', 'text' => 'Many employers need a hybrid: specialist search for leadership and hard-to-fill roles, plus generalist or RPO capacity for repeatable hiring. The operating model should follow the portfolio.'],
            ],
            'where_hirednext_fits' => 'HiredNext is designed around sector-aligned executive, mid-senior and specialist hiring rather than being positioned as a mass-market job-placement portal. Its public sector architecture covers Technology, BFSI/NBFC, Retail, Garment & Textile, Engineering, Manufacturing, Pharma & Life Sciences, GCCs and Semiconductors, with evidence claims separated from expansion-sector capability pages.',
            'related_links' => [
                ['label' => 'IT & Technology Recruitment', 'url' => 'industry/it-recruitment-services-india'],
                ['label' => 'Retail Executive Search', 'url' => 'industry/retail-executive-search'],
                ['label' => 'Garment & Textile Recruitment', 'url' => 'industry/garment-textile-recruitment-india'],
                ['label' => 'BFSI & NBFC Leadership Hiring', 'url' => 'industry/bfsi-leadership-hiring'],
            ],
            'faq' => [
                ['q' => 'What is a specialist recruitment firm?', 'a' => 'A specialist recruitment firm focuses on defined sectors, functions, role families or seniority levels and uses that context to improve market mapping, candidate outreach and assessment.'],
                ['q' => 'When is a generalist recruiter the better choice?', 'a' => 'A generalist recruiter can be the better choice for high-volume, repeatable roles with broad candidate supply and straightforward screening criteria.'],
                ['q' => 'Can an employer use both specialist and generalist recruitment firms?', 'a' => 'Yes. A common model is to use specialist firms for leadership or hard-to-fill mandates and broader recruitment or RPO partners for repeatable hiring.'],
            ],
        ],
    ];
}
