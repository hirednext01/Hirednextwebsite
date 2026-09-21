<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class CareerAuthority extends BaseConfig
{
    public string $updatedOn = '2026-09-21';
    public string $reviewedBy = 'Taru Shikha';

    public array $pages = [
        'linkedin-profile-optimisation-india' => [
            'path' => 'guides/linkedin-profile-optimisation-india',
            'eyebrow' => 'LinkedIn Positioning · India',
            'title' => 'LinkedIn Profile Optimisation in India: What Senior Professionals Should Fix First',
            'meta_title' => 'LinkedIn Profile Optimisation India for Senior Professionals | HiredNext',
            'meta_description' => 'A recruiter-led guide to LinkedIn profile optimisation in India for senior professionals: headline, About, experience, proof, discoverability and leadership narrative.',
            'short_answer' => 'For a senior professional, LinkedIn optimisation is not mainly about adding keywords. It is about making level, leadership scope, commercial contribution, expertise and future direction understandable within a fast profile scan. The strongest profiles align the headline, About section, experience evidence, Featured proof and skills around one credible leadership narrative.',
            'intent' => 'People evaluating whether their current LinkedIn profile represents their career at the right level.',
            'hirednext_sees' => 'HiredNext sees senior candidates whose CV contains credible experience but whose LinkedIn profile is only a copied chronology. The gap is usually not lack of achievement. It is that the profile does not explain why the person matters, what scale they have handled, or what future conversations they are relevant for.',
            'sections' => [
                [
                    'title' => 'What should a senior LinkedIn profile communicate quickly?',
                    'body' => 'A reader should be able to understand your professional identity, operating level, functional strengths, evidence of scale and the direction of your career without reconstructing the story from ten job descriptions. A strong profile creates coherence across the headline, About section and recent roles.',
                    'points' => [
                        'Current professional identity and seniority.',
                        'The problems or mandates you are trusted to solve.',
                        'Scale: teams, markets, business size, transformation scope or decision authority where relevant.',
                        'A small number of credible outcomes rather than a wall of responsibilities.',
                        'Target direction without making the profile look like a desperate job-search announcement.',
                    ],
                ],
                [
                    'title' => 'Headline: describe the value, not every keyword',
                    'body' => 'A headline should help the right audience classify you correctly. Generic phrases such as “results-driven leader” consume space without adding evidence. Use functional identity, leadership level, a small number of relevant domains and, where appropriate, the kind of business problem you have handled.',
                    'points' => [
                        'Avoid title inflation.',
                        'Do not repeat ten disconnected skills.',
                        'Use terminology recruiters and hiring leaders actually search for.',
                        'Keep the wording consistent with the evidence visible in your experience.',
                    ],
                ],
                [
                    'title' => 'About section: make the career logic visible',
                    'body' => 'The About section should answer a different question from the CV: what does the pattern of your career mean? It can connect progression, sectors, operating environments, leadership philosophy and the kind of work you now want to be associated with.',
                    'points' => [
                        'Start with the professional identity you want the market to understand.',
                        'Use evidence of scope and outcomes without turning the section into a list of metrics.',
                        'Explain relevant transitions or breadth instead of leaving the reader to guess.',
                        'Finish with the themes, problems or mandates you are credible to discuss next.',
                    ],
                ],
                [
                    'title' => 'Experience: LinkedIn is not a pasted CV',
                    'body' => 'Recent roles should show mandate, ownership and selected evidence. Older roles can be lighter. A profile becomes difficult to scan when every job contains the same generic leadership language or a long copy-paste from the resume.',
                    'points' => [
                        'Clarify the mandate you inherited or built.',
                        'Separate team or business scope from personal contribution.',
                        'Use outcomes that can be defended in conversation.',
                        'Keep confidentiality intact where client or employer information cannot be disclosed.',
                    ],
                ],
            ],
            'comparison' => [
                'headers' => ['Weak profile pattern', 'Stronger positioning choice'],
                'rows' => [
                    ['Headline lists titles and generic skills', 'Headline communicates level, function and relevant authority'],
                    ['About section repeats the CV summary', 'About section explains career logic and leadership point of view'],
                    ['Experience lists duties', 'Experience shows mandates, scope, decisions and selected outcomes'],
                    ['Featured section is empty', 'Featured section provides relevant proof or thought leadership where available'],
                    ['Profile tries to rank for everything', 'Profile is calibrated to the conversations the professional actually wants'],
                ],
            ],
            'questions' => [
                ['q' => 'Can LinkedIn optimisation guarantee recruiter outreach?', 'a' => 'No. A stronger profile can improve clarity and discoverability, but outreach depends on demand, market conditions, search behaviour, network, activity and fit with specific opportunities.'],
                ['q' => 'Should my LinkedIn and CV be identical?', 'a' => 'No. They should be factually consistent, but they serve different reading behaviours. A CV is a targeted career document; LinkedIn is a public professional narrative and discovery surface.'],
                ['q' => 'Who may look at a senior LinkedIn profile?', 'a' => 'Depending on the context, executive-search professionals, internal talent teams, founders, business leaders, potential clients, investors, board members and industry peers may review a profile before initiating a conversation.'],
            ],
            'primary_cta' => ['label' => 'Explore LinkedIn Leadership Positioning', 'url' => 'services/linkedin-leadership-positioning'],
            'secondary_cta' => ['label' => 'See all HiredNext career services', 'url' => 'services/candidates'],
        ],
        'executive-linkedin-profile-india' => [
            'path' => 'guides/executive-linkedin-profile-india',
            'eyebrow' => 'Executive LinkedIn · India',
            'title' => 'Executive LinkedIn Profile in India: How CXO, VP and Director Profiles Should Read',
            'meta_title' => 'Executive LinkedIn Profile India: CXO, VP & Director Positioning | HiredNext',
            'meta_description' => 'How senior leaders in India should structure LinkedIn around mandate, scale, outcomes, board-level credibility and future relevance without exaggerating claims.',
            'short_answer' => 'An executive LinkedIn profile should make the leadership mandate visible: what the person was trusted to change, the scale they operated at, the decisions they owned, the stakeholders they influenced and the evidence behind important outcomes. At senior levels, a title alone is not enough because identical titles can represent very different business complexity.',
            'intent' => 'CXO, VP, Director and functional-head professionals who need their public profile to reflect seniority and leadership evidence.',
            'hirednext_sees' => 'HiredNext often sees senior leaders with credible careers whose public profiles still read like mid-career job descriptions. The missing layer is usually executive context: business size, transformation mandate, decision rights, team scale, market complexity and the evidence that explains why the role mattered.',
            'sections' => [
                [
                    'title' => 'Show the mandate behind the title',
                    'body' => '“VP Operations” or “Business Head” does not tell the reader whether the person inherited a stable operation, built a new capability, turned around performance or scaled a fast-growing business. Senior positioning improves when the mandate is explicit.',
                    'points' => [
                        'What business condition existed when you entered the role?',
                        'What were you personally accountable for changing or protecting?',
                        'What scale made the mandate complex?',
                        'Which decisions sat with you rather than the wider team?',
                    ],
                ],
                [
                    'title' => 'Use executive evidence without turning the profile into a scorecard',
                    'body' => 'Numbers are useful when they explain scale or outcomes, but a senior profile should not become a spreadsheet. Select evidence that proves the level of responsibility: revenue or cost base, organisation size, markets, sites, transformation scope, portfolio scale, major launches or measurable operating shifts where those facts are appropriate to disclose.',
                    'points' => [
                        'Use attributable facts, not inflated team achievements.',
                        'Respect confidentiality and non-disclosure obligations.',
                        'Prefer a few meaningful metrics over a dense wall of numbers.',
                        'Make the strategic implication of the evidence understandable.',
                    ],
                ],
                [
                    'title' => 'Build authority around a small number of themes',
                    'body' => 'A senior leader does not need to publish every day. The profile becomes more coherent when the About section, Featured items and occasional posts reinforce a small number of themes connected to real experience.',
                    'points' => [
                        'Operating lessons from your actual career.',
                        'Industry changes you are qualified to interpret.',
                        'Leadership or transformation principles backed by examples.',
                        'Board, governance or capability-building themes where genuinely relevant.',
                    ],
                ],
            ],
            'comparison' => [
                'headers' => ['Mid-level presentation', 'Executive presentation'],
                'rows' => [
                    ['Lists responsibilities', 'Explains mandate and decision ownership'],
                    ['Shows employer and title', 'Shows operating context and leadership scale'],
                    ['Uses broad adjectives', 'Uses specific, defensible evidence'],
                    ['Describes every task', 'Selects the few issues senior stakeholders care about'],
                    ['Ends with “open to opportunities”', 'Builds a credible point of view around future relevance'],
                ],
            ],
            'questions' => [
                ['q' => 'Should a CXO say they are open to work publicly?', 'a' => 'It depends on the search context and confidentiality required. Senior leaders can signal professional direction without necessarily making a broad public job-search announcement.'],
                ['q' => 'Should board experience appear on LinkedIn?', 'a' => 'Yes when it is real, current or relevant, and the disclosure does not breach confidentiality. Clarify whether the role is statutory, advisory, committee-based or informal rather than using an ambiguous board label.'],
                ['q' => 'Can HiredNext create achievements that sound more senior?', 'a' => 'No. Positioning should clarify verified scope and outcomes. Missing context should become an assessment question, not an invented claim.'],
            ],
            'primary_cta' => ['label' => 'Build My LinkedIn Leadership Narrative', 'url' => 'services/linkedin-leadership-positioning'],
            'secondary_cta' => ['label' => 'Explore Executive CV', 'url' => 'services/executive-cv'],
        ],
        'cv-assessment-vs-cv-rebuild' => [
            'path' => 'guides/cv-assessment-vs-cv-rebuild',
            'eyebrow' => 'CV Decision Guide',
            'title' => 'CV Assessment vs CV Rebuild: Which One Do You Actually Need?',
            'meta_title' => 'CV Assessment vs CV Rebuild: Which Should You Choose? | HiredNext',
            'meta_description' => 'Compare a CV assessment with a professional CV rebuild: what each service should deliver, who each is for, when a rewrite is unnecessary and when deeper positioning work helps.',
            'short_answer' => 'Choose a CV assessment when you want an expert diagnosis and are comfortable making the changes yourself. Choose a CV rebuild when the document needs deeper positioning, structure and evidence work and you want the finished rewrite done for you. Choose a bundle only when you genuinely want both the detailed written diagnosis and the managed rebuild.',
            'intent' => 'Candidates deciding whether they need advice, a full rewrite, or both.',
            'hirednext_sees' => 'HiredNext does not believe every CV needs a rebuild. Some documents have a sound career story and need only targeted corrections. Others hide seniority, scale and achievements so deeply that a line-by-line patch creates more work than rebuilding the narrative properly.',
            'sections' => [
                [
                    'title' => 'When an assessment is enough',
                    'body' => 'An assessment can be the right choice when the underlying chronology is clear, the document is structurally usable and you are confident rewriting the changes yourself.',
                    'points' => [
                        'You want an external recruiter-style diagnosis.',
                        'You need to know which gaps matter before redesigning anything.',
                        'You can rewrite bullets and sections yourself once the issues are clear.',
                        'The target role is defined enough to judge relevance.',
                    ],
                ],
                [
                    'title' => 'When a rebuild is the better use of effort',
                    'body' => 'A rebuild becomes more useful when the problem is not one weak section but the story across the whole document: level, progression, role relevance, evidence and hierarchy.',
                    'points' => [
                        'Important achievements are buried across several pages.',
                        'Responsibilities dominate while outcomes and scale are hard to find.',
                        'The target role requires a different emphasis from the current CV.',
                        'The document needs a new architecture rather than cosmetic formatting.',
                    ],
                ],
                [
                    'title' => 'What neither service can honestly promise',
                    'body' => 'A professional CV can improve how clearly experience is understood. It cannot control employer demand, competing candidates, interview performance, compensation fit or the final hiring decision.',
                    'points' => [
                        'No genuine provider can guarantee a shortlist from every employer.',
                        'No ATS score can predict every company’s screening logic.',
                        'No rewrite should invent achievements, metrics or titles.',
                        'The candidate still needs role relevance and interview evidence.',
                    ],
                ],
            ],
            'comparison' => [
                'headers' => ['Question', 'CV Assessment', 'CV Rebuild'],
                'rows' => [
                    ['Do I receive a detailed diagnosis?', 'Yes', 'Internal analysis is used to build the document; buy the bundle if you also want the separate detailed report'],
                    ['Who makes the changes?', 'You', 'HiredNext'],
                    ['Do I receive finished CV variants?', 'No', 'Yes'],
                    ['Best when', 'You want clarity before editing', 'You want the positioning and rewrite done for you'],
                    ['Current HiredNext base price', '₹992 + GST', '₹2,500 + GST'],
                ],
            ],
            'questions' => [
                ['q' => 'Does the rebuild include the separate detailed assessment report?', 'a' => 'The rebuild includes the analysis required to create the document. If you want the standalone detailed written assessment plus the rebuild, choose the Assessment + Rebuild Bundle.'],
                ['q' => 'Can I start with assessment and upgrade later?', 'a' => 'Yes. That is useful when you want to understand the gaps before deciding whether to rewrite the document yourself or ask HiredNext to rebuild it.'],
                ['q' => 'Is formatting the main difference?', 'a' => 'No. The deeper difference is who does the narrative, evidence and structure work. A rebuild should not be reduced to a new template.'],
            ],
            'primary_cta' => ['label' => 'Compare HiredNext CV Services', 'url' => 'services/candidates'],
            'secondary_cta' => ['label' => 'See the 5% Assessment + Rebuild Bundle', 'url' => 'services/cv-assessment-rebuild-bundle'],
        ],
        'cv-writing-vs-ai-resume-builder-india' => [
            'path' => 'guides/cv-writing-vs-ai-resume-builder-india',
            'eyebrow' => 'Human + AI Career Documents',
            'title' => 'Professional CV Writing vs AI Resume Builder in India: What Should Stay Human?',
            'meta_title' => 'CV Writing vs AI Resume Builder India: What Should Stay Human? | HiredNext',
            'meta_description' => 'Compare professional CV writing with AI resume builders in India. Learn where AI helps, where human recruiter judgement matters, and how to avoid invented achievements.',
            'short_answer' => 'AI is useful for drafting, language cleanup, structure checks and exploring alternatives. The high-risk part is judgement: deciding which career evidence matters, whether a claim is attributable, what a target role requires, what is missing, and when polished language overstates the truth. For experienced professionals, the strongest workflow combines automation with evidence-constrained human review.',
            'intent' => 'Professionals deciding whether a low-cost AI builder is enough or whether they need deeper human positioning.',
            'hirednext_sees' => 'HiredNext sees AI-generated CVs that look polished but flatten the career into generic leadership language. The problem is rarely grammar. It is selection: which facts matter, what is genuinely attributable to the candidate, what the target role needs to see and which impressive-sounding sentence cannot actually be defended in an interview.',
            'sections' => [
                [
                    'title' => 'Where AI is genuinely useful',
                    'body' => 'AI can accelerate low-risk drafting tasks when the source facts are reliable and the user remains responsible for accuracy.',
                    'points' => [
                        'Reformatting rough notes into clearer language.',
                        'Creating alternative sentence structures.',
                        'Checking consistency, spelling and section organisation.',
                        'Identifying repeated wording or overlong bullets.',
                        'Comparing a CV against a supplied job description for missing terminology.',
                    ],
                ],
                [
                    'title' => 'Where human judgement matters more',
                    'body' => 'The important decisions in a senior CV are not wordsmithing decisions. They are evidence and positioning decisions.',
                    'points' => [
                        'Separating personal contribution from team or company results.',
                        'Understanding whether the target role is actually comparable.',
                        'Deciding which achievements deserve space on page one.',
                        'Recognising when a title understates or overstates the real mandate.',
                        'Asking the follow-up question that reveals scale, complexity or commercial impact.',
                    ],
                ],
                [
                    'title' => 'The biggest AI risk: confident invention',
                    'body' => 'A generated CV may silently fill gaps with plausible numbers, ownership or outcomes. That can create a document that reads better but is harder to defend. Every strong claim should trace back to a source fact supplied or verified by the candidate.',
                    'points' => [
                        'Do not allow an AI tool to manufacture percentages or revenue figures.',
                        'Do not upgrade job titles to sound more senior.',
                        'Do not claim ownership when the candidate only supported the work.',
                        'Flag missing facts for clarification instead of guessing.',
                    ],
                ],
            ],
            'comparison' => [
                'headers' => ['Task', 'AI builder', 'Evidence-led professional review'],
                'rows' => [
                    ['Language cleanup', 'Strong', 'Strong'],
                    ['Template generation', 'Strong', 'Strong'],
                    ['Career evidence selection', 'Variable', 'Requires judgement'],
                    ['Attribution and credibility checks', 'High risk without controls', 'Human verification'],
                    ['Role-market context', 'Depends on inputs', 'Recruiter or specialist context can add depth'],
                    ['Follow-up questions', 'Can ask generic questions', 'Can probe the career story against target-role evidence'],
                ],
            ],
            'questions' => [
                ['q' => 'Is using AI on a CV a bad idea?', 'a' => 'No. AI can be useful. The issue is whether the workflow preserves factual accuracy and adds real judgement rather than merely producing polished generic language.'],
                ['q' => 'Can AI make my CV ATS friendly?', 'a' => 'It can help with structure and terminology, but no tool can guarantee compatibility with every employer system or predict every screening decision.'],
                ['q' => 'What is HiredNext’s approach?', 'a' => 'HiredNext uses technology as part of a controlled workflow while keeping source facts, recruiter judgement, human review and candidate verification central to the finished document.'],
            ],
            'primary_cta' => ['label' => 'See Professional CV Rebuild', 'url' => 'services/professional-cv-rebuild'],
            'secondary_cta' => ['label' => 'Start with CV Assessment', 'url' => 'services/cv-assessment'],
        ],
        'how-recruiters-read-senior-cv-india' => [
            'path' => 'guides/how-recruiters-read-senior-cv-india',
            'eyebrow' => 'Senior CV Evidence',
            'title' => 'How Recruiters Read a Senior CV in India: What Has to Become Visible Fast',
            'meta_title' => 'How Recruiters Read a Senior CV in India | HiredNext',
            'meta_description' => 'A recruiter-led guide to how senior CVs are read in India: role fit, level, scale, evidence, progression, credibility and what hiring managers need to understand quickly.',
            'short_answer' => 'A senior CV is usually read for evidence of level and relevance before it is read line by line. The reader is trying to understand: what this person actually owned, at what scale, in what context, with what outcomes, and whether that evidence is comparable to the mandate being hired for. A CV that forces the reader to infer those answers loses clarity even when the underlying career is strong.',
            'intent' => 'Experienced professionals who want to understand what recruiters and hiring managers need to see quickly.',
            'hirednext_sees' => 'HiredNext regularly sees strong candidates whose CVs undersell them because the document treats every responsibility as equally important. Senior readers are not looking for completeness first. They are looking for evidence that the candidate has already operated at a relevant level of complexity.',
            'sections' => [
                [
                    'title' => 'First: does the level make sense?',
                    'body' => 'The reader checks title, reporting context, team scope, business size, geography, customer or product complexity and progression. A senior title without corresponding evidence can create doubt; a modest title with strong scope can hide a good candidate.',
                    'points' => [
                        'Current and recent role level.',
                        'Team, function or business scope.',
                        'Decision ownership.',
                        'Complexity of the operating environment.',
                        'Progression across the last several roles.',
                    ],
                ],
                [
                    'title' => 'Second: is there evidence, not only responsibility?',
                    'body' => 'Responsibilities show what the job required. Evidence shows what the candidate actually contributed. Senior CVs become stronger when the reader can distinguish routine ownership from meaningful outcomes.',
                    'points' => [
                        'Growth, margin, cost, efficiency or quality outcomes where relevant.',
                        'Business, portfolio, plant, customer or programme scale.',
                        'Transformation, turnaround, launch or build-from-zero mandates.',
                        'Important decisions personally owned.',
                        'Team or stakeholder complexity.',
                    ],
                ],
                [
                    'title' => 'Third: is the evidence relevant to this role?',
                    'body' => 'A strong achievement can still be irrelevant to the mandate. The CV should make the transferable evidence obvious: not simply “I was successful,” but “this is why my success is comparable to the problem you are hiring for.”',
                    'points' => [
                        'Prioritise achievements that map to the target role.',
                        'Reduce detail that is impressive but unrelated.',
                        'Use role language accurately without keyword stuffing.',
                        'Show constraints such as market, product, regulatory or operating context when they change the meaning of the result.',
                    ],
                ],
                [
                    'title' => 'What weakens trust quickly',
                    'body' => 'Credibility matters more at senior levels because the claims will be tested in interviews and references. Overwritten executive language can be as damaging as an underwritten CV.',
                    'points' => [
                        'Numbers with no context or attribution.',
                        'Every bullet beginning with a leadership adjective.',
                        'Claims that exceed the formal or practical scope of the role.',
                        'Inconsistent dates, titles or employer names across CV and LinkedIn.',
                        'Responsibilities presented as outcomes.',
                    ],
                ],
            ],
            'comparison' => [
                'headers' => ['Reader question', 'Evidence that helps answer it'],
                'rows' => [
                    ['What level did this person actually operate at?', 'Team, reporting line, decision authority, business or functional scale'],
                    ['What did they personally change?', 'Attributable outcomes and decisions'],
                    ['Is the experience comparable to our mandate?', 'Relevant context, sector, customer, market and complexity'],
                    ['Can I trust the claim?', 'Specific wording, defensible numbers, consistent chronology'],
                    ['Why should I keep reading?', 'A clear first-page narrative around role fit and evidence'],
                ],
            ],
            'questions' => [
                ['q' => 'How long should a senior CV be?', 'a' => 'There is no universal page count. The document should be long enough to show relevant evidence and short enough that important information is not buried. For many experienced professionals, two focused pages work well, but complexity and career length can justify more.'],
                ['q' => 'Should every achievement have a number?', 'a' => 'No. Quantification is useful when the number is meaningful and verifiable. Qualitative evidence such as launching a capability, resolving a major operational issue or influencing a strategic decision can also matter.'],
                ['q' => 'Does a good CV increase shortlisting chances?', 'a' => 'A clearer CV can make relevant experience easier to recognise and reduce avoidable ambiguity. It cannot create role fit that is not there or control the employer’s final decision.'],
            ],
            'primary_cta' => ['label' => 'Get My CV Assessed', 'url' => 'services/cv-assessment'],
            'secondary_cta' => ['label' => 'See Professional CV Rebuild', 'url' => 'services/professional-cv-rebuild'],
        ],
    ];

    public function pathFor(string $slug): string
    {
        return (string)($this->pages[$slug]['path'] ?? ('guides/' . $slug));
    }
}
