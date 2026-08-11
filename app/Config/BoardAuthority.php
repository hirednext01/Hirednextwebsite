<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class BoardAuthority extends BaseConfig
{
    /**
     * HiredNext editorial frameworks for senior hiring decisions.
     * These are operating lenses, not statistical benchmarks. They are designed to
     * show how a search partner should think when the mandate is senior, scarce,
     * confidential or commercially important.
     */
    public array $guides = [
        'executive-search-firm-india' => [
            'label' => 'HiredNext Mandate Intelligence',
            'headline' => 'The search partner should reduce hiring risk, not just produce a shortlist',
            'thesis' => 'At senior level, the recruiter is useful only if the search changes the quality of the hiring decision. A strong partner should expose contradictions in the brief, map the real talent universe, explain why credible leaders are declining, and make the trade-offs visible before the board spends months interviewing the wrong market.',
            'insights' => [
                ['title' => 'The Week-2 contradiction test', 'text' => 'One of the most revealing questions for a search firm is: “What will you do if the market contradicts our brief?” If credible leaders consistently reject the reporting line, location, compensation, authority or role design, asking for more CVs is not progress. The recruiter should return with evidence, identify the constraint and recommend what the client must change.'],
                ['title' => 'Search ownership is a governance issue', 'text' => 'For a CXO mandate, the person who owns calibration, candidate conversations and stakeholder feedback influences the outcome. A search can look senior in the pitch and become junior in execution. Employers should know who is accountable for the market map, who speaks to the candidate and who is authorised to challenge the brief.'],
                ['title' => 'The target-company list should be a hypothesis, not a prison', 'text' => 'A board may begin with ten admired competitors. That is useful as a hypothesis, but a closed list can hide better transferable talent. The stronger question is: where else does this business problem exist at comparable scale, complexity and consequence?'],
            ],
            'matrix_title' => 'Mandate friction diagnostic',
            'matrix_intro' => 'The harder the mandate scores across these dimensions, the less useful ordinary database recruitment becomes.',
            'matrix' => [
                ['dimension' => 'Scarcity', 'low' => 'Broad candidate supply', 'high' => 'Very few credible people in the market', 'implication' => 'Wider mapping and direct outreach'],
                ['dimension' => 'Confidentiality', 'low' => 'Public vacancy', 'high' => 'Incumbent or sensitive replacement', 'implication' => 'Controlled disclosure and one-to-one search'],
                ['dimension' => 'Stakeholder complexity', 'low' => 'Single hiring manager', 'high' => 'Board, promoter, investor or matrix consensus', 'implication' => 'Explicit calibration and decision governance'],
                ['dimension' => 'Career risk for candidate', 'low' => 'Obvious upward move', 'high' => 'Leaving a successful platform for ambiguity', 'implication' => 'Mandate story and conviction matter'],
                ['dimension' => 'Role ambiguity', 'low' => 'Stable remit', 'high' => 'Transformation, build or turnaround', 'implication' => 'Outcome scorecard before sourcing'],
            ],
            'mistakes_title' => 'What experienced employers still get wrong',
            'mistakes' => [
                'Confusing a longlist with market coverage. Ten CVs can still represent a very narrow search.',
                'Treating compensation as the only reason strong candidates decline when the real issue is authority, reporting line, governance or career risk.',
                'Allowing interviewer preference to mutate the brief after each meeting without formally recalibrating the scorecard.',
                'Measuring recruiter activity when the useful output is market intelligence: who exists, who is reachable, why they will or will not move, and what the mandate must change.',
            ],
            'hirednext_title' => 'Why this is the HiredNext point of view',
            'hirednext_text' => 'HiredNext is built around search ownership rather than CV volume. For difficult leadership mandates, the value we aim to create is a clearer market map, sharper mandate calibration, evidence-led candidate assessment and early visibility of search risk. The recruiter should be able to tell the client when the market disagrees with the brief — not quietly keep sourcing against it.',
        ],

        'leadership-hiring-partner-india' => [
            'label' => 'HiredNext Leadership Search Lens',
            'headline' => 'Do not search for a title. Search for evidence that the business problem has already been solved.',
            'thesis' => 'The strongest leadership searches are capability maps. They begin with what the leader must change, protect, build or scale, then identify where that capability exists — including outside the obvious competitor list and outside the obvious job title.',
            'insights' => [
                ['title' => 'Capability adjacency is often more valuable than title adjacency', 'text' => 'A candidate one level below the target title may have already owned the exact transformation, scale-up or commercial problem required. Conversely, a person with the “correct” title may have operated in a much easier environment. Senior assessment should compare complexity handled, not merely hierarchy reached.'],
                ['title' => 'Candidate conviction is part of the assessment', 'text' => 'For a passive leader, motivation is not a soft factor. Ask what they are walking away from, what they believe they will gain, what uncertainty they are accepting and which part of the mandate genuinely attracts them. A technically excellent candidate with weak conviction is a joining-risk problem waiting to happen.'],
                ['title' => 'The rejection pattern is market intelligence', 'text' => 'If credible leaders independently reject the same element — location, reporting line, title, compensation, board structure or lack of authority — that pattern is information. A search partner should aggregate it and take it back to the employer as a decision input.'],
            ],
            'matrix_title' => 'Leadership evidence scorecard',
            'matrix_intro' => 'The same job title can conceal very different levels of leadership complexity.',
            'matrix' => [
                ['dimension' => 'Scale', 'low' => 'Managed a function', 'high' => 'Owned enterprise or multi-business consequence', 'implication' => 'Test actual scope, not designation'],
                ['dimension' => 'Complexity', 'low' => 'Stable operating environment', 'high' => 'Turnaround, integration, transformation or ambiguity', 'implication' => 'Ask what changed because of the leader'],
                ['dimension' => 'Decision quality', 'low' => 'Executed established playbook', 'high' => 'Made high-consequence trade-offs with incomplete information', 'implication' => 'Probe decisions, alternatives and consequences'],
                ['dimension' => 'Stakeholders', 'low' => 'Single reporting line', 'high' => 'Board, promoter, regulators, investors, unions or matrix leaders', 'implication' => 'Assess influence without relying on authority'],
                ['dimension' => 'Team legacy', 'low' => 'Managed inherited team', 'high' => 'Built successors, upgraded capability and changed operating rhythm', 'implication' => 'Leadership is visible in the organisation left behind'],
            ],
            'mistakes_title' => 'What experienced employers still get wrong',
            'mistakes' => [
                'Writing an idealised job description that combines the experience of three different people into one impossible candidate.',
                'Using the target title as the main filter instead of defining the business outcomes the person must deliver.',
                'Assuming a passive candidate who takes the first call is already motivated to move.',
                'Waiting until offer stage to understand family, geography, notice period, long-term incentives and counter-offer exposure.',
            ],
            'hirednext_title' => 'Why this is the HiredNext point of view',
            'hirednext_text' => 'HiredNext approaches senior hiring as a market-mapping and decision-calibration exercise. We want the shortlist to explain not only who can do the role, but the evidence behind that view, the context in which the candidate succeeded, why the candidate may move and what could prevent the hire from joining.',
        ],

        'specialist-recruitment-firm-india' => [
            'label' => 'HiredNext Hiring-Model Architecture',
            'headline' => 'The wrong recruitment model creates hidden cost long before the fee becomes visible',
            'thesis' => 'Employers often compare agency percentages before deciding what type of hiring problem they actually have. The important choice is not “which recruiter is cheapest?” but “what research depth, domain context, process ownership and candidate persuasion does this role require?”',
            'insights' => [
                ['title' => 'Capacity and capability are different problems', 'text' => 'If the problem is too many repeatable vacancies, add recruiting capacity. If the problem is that very few relevant people exist, adding more recruiters can simply create more duplicated sourcing. Scarcity is a capability problem, not a headcount problem.'],
                ['title' => 'Domain knowledge matters when the title lies', 'text' => 'Two candidates with the same designation can be radically different hires because of product, regulation, channel, plant environment, customer type, technology architecture or operating scale. A specialist earns its value when those distinctions materially change the shortlist.'],
                ['title' => 'The cost of the wrong model is search delay', 'text' => 'A low-fee model is expensive if it produces weeks of irrelevant interviewing, internal stakeholder fatigue and candidate-market damage. Search economics should include management time, vacancy cost, decision delay and the risk of restarting the mandate.'],
            ],
            'matrix_title' => 'Choose the hiring model by the problem',
            'matrix_intro' => 'The best model is the lightest model that can still solve the hiring problem properly.',
            'matrix' => [
                ['dimension' => 'Generalist recruitment', 'low' => 'Broad active supply, repeatable role', 'high' => 'Low research intensity needed', 'implication' => 'Efficient when requirements are stable and supply is broad'],
                ['dimension' => 'Specialist recruitment', 'low' => 'Domain context changes relevance', 'high' => 'Sector vocabulary and adjacent pools matter', 'implication' => 'Useful when titles alone are misleading'],
                ['dimension' => 'Executive search', 'low' => 'Senior, scarce or confidential', 'high' => 'Passive market and persuasion required', 'implication' => 'Use when market mapping and controlled outreach matter'],
                ['dimension' => 'RPO', 'low' => 'Sustained hiring demand', 'high' => 'Process ownership and recruiter capacity required', 'implication' => 'Use for repeatable portfolio-level recruiting'],
                ['dimension' => 'Hybrid', 'low' => 'Mixed hiring portfolio', 'high' => 'Volume + specialist + leadership needs coexist', 'implication' => 'Separate delivery tracks instead of forcing one model onto every role'],
            ],
            'mistakes_title' => 'What experienced employers still get wrong',
            'mistakes' => [
                'Using executive-search economics for roles with abundant active supply.',
                'Using volume-recruitment methods for roles where five credible candidates may represent most of the realistic market.',
                'Choosing a sector specialist only because it knows industry terminology rather than because it can distinguish operating contexts.',
                'Forcing every vacancy through one procurement model even when the hiring portfolio contains fundamentally different search problems.',
            ],
            'hirednext_title' => 'Why this is the HiredNext point of view',
            'hirednext_text' => 'HiredNext does not believe every mandate should be sold as executive search. Our value is strongest where sector context, market mapping, senior candidate engagement or difficult-to-fill search materially changes the outcome. Repeatable volume should use a delivery model designed for repeatable volume.',
        ],

        'confidential-cfo-search-india' => [
            'label' => 'HiredNext CFO Mandate Architecture',
            'headline' => 'Revenue scale does not tell you whether a CFO has handled the complexity you are about to hire for',
            'thesis' => 'Two CFOs can both have worked in large businesses and still be entirely different hires. One may have inherited mature controls and predictable capital access; another may have rebuilt governance, repaired working capital, renegotiated lenders, professionalised the team and supported a promoter or board through change. The mandate should define the finance problem before the market is searched.',
            'insights' => [
                ['title' => 'Start with the CFO archetype', 'text' => 'A governance-heavy Steward, a Capital Navigator, an Operator/Transformer and a Commercial Finance Partner can all be excellent CFOs — but they solve different problems. If the board does not agree which problem matters most, the search will produce impressive candidates who are difficult to compare.'],
                ['title' => 'Confidentiality has rings, not a single switch', 'text' => 'Define who knows the search internally, what can be disclosed in first contact, when the company identity is revealed, who can see candidate names and when references may begin. A confidential search fails when information control is improvised candidate by candidate.'],
                ['title' => 'Ask what the CFO inherited before crediting the result', 'text' => 'Improved cash, margins, controls or reporting can mean very different things depending on starting condition. Probe what was broken, what resistance existed, what decisions the candidate personally made and what changed because of those decisions.'],
            ],
            'matrix_title' => 'CFO archetype matrix',
            'matrix_intro' => 'Most CFO mandates contain all four dimensions, but one or two usually dominate the next 24 months.',
            'matrix' => [
                ['dimension' => 'Steward / governance', 'low' => 'Controls, audit, compliance', 'high' => 'Board confidence and institutional discipline', 'implication' => 'Prioritise governance judgement and control architecture'],
                ['dimension' => 'Capital navigator', 'low' => 'Routine banking', 'high' => 'Fundraise, IPO, debt, investor or lender complexity', 'implication' => 'Test capital markets credibility and stakeholder trust'],
                ['dimension' => 'Operator / transformer', 'low' => 'Stable finance function', 'high' => 'ERP, shared services, working capital, cost or process reset', 'implication' => 'Probe change leadership and execution depth'],
                ['dimension' => 'Commercial partner', 'low' => 'Reporting-focused role', 'high' => 'Pricing, portfolio, growth, margin and business partnering', 'implication' => 'Assess commercial judgement, not only finance hygiene'],
                ['dimension' => 'Enterprise leader', 'low' => 'Finance-only remit', 'high' => 'CEO/board partner across enterprise decisions', 'implication' => 'Evaluate judgement, influence and succession potential'],
            ],
            'mistakes_title' => 'What experienced boards still get wrong',
            'mistakes' => [
                'Equating company revenue with finance complexity without examining capital structure, governance maturity, business model and starting condition.',
                'Searching only current CFO titles when a Deputy CFO, Controller or Business Finance Head may already have the exact required operating experience.',
                'Treating confidentiality as an instruction to the recruiter rather than a designed information protocol.',
                'Assessing technical finance depth thoroughly but leaving CEO chemistry, board influence and appetite for ambiguity to the final round.',
            ],
            'hirednext_title' => 'Why this is the HiredNext point of view',
            'hirednext_text' => 'For a CFO search, HiredNext wants the board to define the finance problem before the candidate universe is built. The search should compare evidence of governance, capital judgement, operating transformation and commercial leadership in the context that matters to the company — while controlling disclosure throughout a sensitive mandate.',
        ],

        'rpo-solutions-india' => [
            'label' => 'HiredNext Recruitment Operating Model',
            'headline' => 'RPO solves a recruiting operating-system problem. It does not automatically solve every talent problem.',
            'thesis' => 'The value of RPO is dedicated capacity, process ownership, visibility and consistency across sustained hiring demand. It becomes weak when it is treated as a cheaper agency label or when scarce leadership mandates are pushed through the same machine as repeatable hiring.',
            'insights' => [
                ['title' => 'Measure flow, not recruiter busyness', 'text' => 'Activity counts can look healthy while the funnel is blocked. A useful RPO dashboard should expose ageing by stage, response SLA, source-to-shortlist quality, interview conversion, offer ageing and offer-to-join risk. The question is where hiring flow is leaking.'],
                ['title' => 'Recruitment debt is real', 'text' => 'When feedback is late, candidate communication is inconsistent, duplicate agencies work the same roles and ownership is unclear, unresolved work accumulates. That recruitment debt eventually appears as candidate drop-off, hiring-manager frustration and longer vacancy periods. RPO should remove that debt by clarifying ownership.'],
                ['title' => 'Protect a separate lane for scarce mandates', 'text' => 'A high-volume operating model should not force a confidential CXO, rare technology leader or niche plant role into the same sourcing and SLA logic. Mature hiring systems route different problems into different delivery tracks.'],
            ],
            'matrix_title' => 'RPO operating-system diagnostic',
            'matrix_intro' => 'Before buying RPO, identify whether the bottleneck is capacity, process, market scarcity or decision speed.',
            'matrix' => [
                ['dimension' => 'Capacity', 'low' => 'TA team can absorb demand', 'high' => 'Sustained requisition overload', 'implication' => 'Dedicated recruiter capacity can help'],
                ['dimension' => 'Process ownership', 'low' => 'Clear accountable owner', 'high' => 'Fragmented agencies and hand-offs', 'implication' => 'RPO can create one operating rhythm'],
                ['dimension' => 'Market scarcity', 'low' => 'Broad candidate supply', 'high' => 'Very narrow or passive market', 'implication' => 'Route to specialist or executive search'],
                ['dimension' => 'Decision latency', 'low' => 'Fast feedback and offers', 'high' => 'Internal delays after shortlist', 'implication' => 'Fix governance; more sourcing will not solve it'],
                ['dimension' => 'Visibility', 'low' => 'Reliable funnel data', 'high' => 'No view of ageing or conversion', 'implication' => 'Define reporting architecture and SLAs'],
            ],
            'mistakes_title' => 'What experienced employers still get wrong',
            'mistakes' => [
                'Buying RPO to solve a hiring-manager decision problem. External recruiter capacity cannot compensate for chronic internal feedback delays.',
                'Comparing RPO only on recruiter cost while ignoring technology, governance, candidate experience and management time.',
                'Using the same SLA for abundant repeatable roles and genuinely scarce specialist mandates.',
                'Reporting CV submissions and calls instead of stage ageing, conversion quality, offer risk and hiring flow.',
            ],
            'hirednext_title' => 'Why this is the HiredNext point of view',
            'hirednext_text' => 'HiredNext sees RPO as an operating model, not a branding label. Where demand is repeatable, the goal is clear ownership, measurable flow and consistent candidate communication. Where a mandate is scarce, senior or confidential, it should move into a specialist search lane rather than being forced through volume logic.',
        ],
    ];
}
