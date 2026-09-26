<?php

namespace App\Models;

use CodeIgniter\Model;

class JobModel extends Model
{
    private const RECRUIT_OS_JOB_CODES = [
        'fund-accounting-mumbai' => 'HN-FA-0918',
        'revenue-assurance-bengaluru' => 'HN-RA-0918',
        'divisional-merchandising-manager-gurgaon' => 'JOB-1032',
        'apparel-designer-gurgaon' => 'JOB-1033',
        'dgm-operations-woven-manufacturing-hubli' => 'HN-HBL-0910-01',
        'manager-industrial-engineering-woven-hubli' => 'HN-HBL-0910-02',
        'manager-planning-woven-manufacturing-hubli' => 'HN-HBL-0910-03',
        'manager-quality-woven-manufacturing-hubli' => 'HN-HBL-0910-04',
        'dispatch-executive-woven-manufacturing-hubli' => 'HN-HBL-0910-05',
        'assistant-quality-manager-woven-hubli' => 'HN-HBL-0910-06',
        'assistant-production-manager-woven-hubli' => 'HN-HBL-0910-07',
        'assistant-manager-industrial-engineering-woven-hubli' => 'HN-HBL-0910-08',
        'head-merchandising-dhaka-sourcing-hub' => 'HN-HM-DHK-0923',
    ];

    private const PUBLISHED_JOBS = [
        'fund-accounting-mumbai' => [
            'title' => 'Fund Accounting – Finance Professional',
            'location' => 'Mumbai',
            'type' => 'full-time',
            'department' => 'Fund Accounting / Financial Services',
            'experience' => 'CA: 0–1 year | Non-CA: 3–4 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/fund-accounting-mumbai.svg" alt="HiredNext Fund Accounting opening in Mumbai" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Job code: HN-FA-0918</strong></p><p>HiredNext Recruitment is supporting a reputed global consulting firm in building its specialist <strong>Fund Accounting</strong> team. The client name is confidential at this stage and will be shared only with relevant shortlisted candidates.</p><p>This is a direct hiring opportunity with the consulting firm. It is not temporary employment limited to one client project.</p><h3>Role overview</h3><ul><li>Manage day-to-day accounting for a private-equity fund environment.</li><li>Support periodic accounting closures and fund-related financial reporting.</li><li>Maintain complete, accurate and properly supported accounting records.</li><li>Work within a professional, client-facing consulting environment.</li></ul><h3>Who can apply</h3><ul><li><strong>Qualified CA:</strong> 0–1 year of relevant experience.</li><li><strong>Non-CA finance professional with 3–4 years</strong> of relevant fund-accounting experience.</li><li>Exposure to private-equity funds, investment funds or a similar financial-services environment is preferred.</li><li>Must be comfortable working in person from the Mumbai office.</li><li>Early joiners will be preferred.</li></ul><h3>Location, openings and compensation</h3><p><strong>Mumbai | In person | 1 opening | Up to ₹12 LPA</strong>, depending on experience and fitment.</p><h3>Information required for shortlisting</h3><ul><li>Current designation and employer.</li><li>Current location.</li><li>Qualification and year of completion.</li><li>Relevant fund-accounting or investment-fund experience.</li><li>Current CTC and expected CTC.</li><li>Notice period and earliest joining date.</li><li>Willingness to work from the Mumbai office.</li></ul><h3>How to apply</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=HN-FA-0918%20%7C%20Fund%20Accounting%20%7C%20Mumbai">jobs@hirednext.info</a> with the subject <strong>HN-FA-0918 | Fund Accounting | Mumbai</strong>. Include the shortlisting information above.</p><p>Please apply only if your experience closely matches this profile. HiredNext does not charge candidates to apply for a role or secure placement.</p>',
        ],
        'revenue-assurance-bengaluru' => [
            'title' => 'Revenue Assurance – Finance Professionals',
            'location' => 'Marathahalli, Bengaluru',
            'type' => 'full-time',
            'department' => 'Revenue Assurance / Revenue Recognition',
            'experience' => 'CA: 0–1 year | Experienced professional: 3–4 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/revenue-assurance-bengaluru.svg" alt="HiredNext Revenue Assurance openings in Bengaluru" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Job code: HN-RA-0918</strong></p><p>HiredNext Recruitment is supporting a reputed global consulting firm in building a specialist <strong>Revenue Assurance</strong> team in Bengaluru. The client name is confidential at this stage and will be shared only with relevant shortlisted candidates.</p><p>These are direct hiring opportunities with the consulting practice. The immediate assignment supports a software-company acquisition and the review of approximately <strong>2,000 customer contracts</strong>. Although the initial assignment is expected to run for approximately 2–3 months, selected professionals will remain part of the consulting practice and may subsequently work on other relevant assignments.</p><h3>Team composition</h3><ul><li><strong>Two CA fresher / early-career positions:</strong> Qualified Chartered Accountant, fresher or up to 1 year of relevant experience.</li><li><strong>One experienced Revenue Assurance position:</strong> CA qualification is not mandatory; 3–4 years of relevant experience is required.</li></ul><h3>Candidate profile</h3><ul><li>Strong understanding of financial reporting and accounting standards.</li><li>Working knowledge of <strong>IFRS 15 and Ind AS 115</strong>.</li><li>For the experienced opening: hands-on exposure to revenue assurance, revenue recognition, customer-contract review or related accounting work.</li><li>Software, SaaS, consulting or another contract-intensive business environment is preferred.</li><li>Ability to review contracts and understand their commercial and accounting implications.</li></ul><h3>Key responsibilities</h3><ul><li>Review customer contracts and identify relevant commercial terms.</li><li>Assess the appropriate revenue-recognition treatment.</li><li>Support revenue recalculation following the acquisition.</li><li>Identify inconsistencies, unsupported assumptions or accounting gaps.</li><li>Prepare accurate working papers and supporting documentation.</li><li>Coordinate with internal teams and interact with clients when required.</li></ul><h3>Location, openings and compensation</h3><p><strong>Marathahalli, Bengaluru | 3 openings | Up to ₹12 LPA</strong>, depending on experience and fitment.</p><p>Office or client-site presence will be required. This is not a permanent work-from-home opportunity.</p><h3>Information required for shortlisting</h3><ul><li>Current designation and employer.</li><li>Current location.</li><li>Qualification and year of completion.</li><li>Relevant revenue-assurance, revenue-recognition or contract-review experience.</li><li>Exposure to IFRS 15 and Ind AS 115.</li><li>Current CTC and expected CTC.</li><li>Notice period and willingness to work from Bengaluru/client site.</li></ul><h3>How to apply</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=HN-RA-0918%20%7C%20Revenue%20Assurance%20%7C%20Bengaluru">jobs@hirednext.info</a> with the subject <strong>HN-RA-0918 | Revenue Assurance | Bengaluru</strong>. Include the shortlisting information above.</p><p>Please apply only if your experience closely matches one of the profiles. HiredNext does not charge candidates to apply for a role or secure placement.</p>',
        ],
        'divisional-merchandising-manager-gurgaon' => [
            'title' => 'Divisional Merchandising Manager',
            'location' => 'Gurgaon',
            'type' => 'full-time',
            'department' => 'Apparel Merchandising / Business',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/divisional-merchandising-manager-gurgaon.svg" alt="HiredNext Divisional Merchandising Manager opening in Gurgaon" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Job code: HN-DMM-0915</strong></p><p>HiredNext is managing a confidential search for a <strong>Divisional Merchandising Manager</strong> with a reputed buying house in Gurgaon. The client identity will be shared only with appropriately shortlisted candidates.</p><h3>Role overview</h3><p>Own a merchandising division end to end: international buyer relationships, product and order execution, commercial performance, vendor development and team leadership.</p><h3>What you will own</h3><ul><li>Lead 3–4 merchandisers and manage delivery, quality and commercial discipline.</li><li>Manage international brands and retailers across product development, costing, order execution and delivery.</li><li>Own pricing, margin protection, capacity and risk decisions.</li><li>Onboard and develop vendors and factories.</li><li>Contribute to new-business development and account growth.</li></ul><h3>Candidate profile</h3><ul><li>8–12 years in apparel merchandising within buying houses or export houses.</li><li>Evidence of direct international buyer ownership and commercial decision-making.</li><li>Strong costing, pricing, margin, sourcing and vendor-development capability.</li><li>Current team-leadership responsibility; UK or Japan market exposure is an advantage.</li></ul><h3>Location and compensation</h3><p><strong>Gurgaon | ₹30–35 LPA</strong>, depending on experience and fit.</p><h3>Questions required for shortlisting</h3><ul><li>Current company, designation and location.</li><li>Total apparel-merchandising experience and years in buying or export houses.</li><li>Current and expected CTC, notice period and Gurgaon availability.</li><li>Team size currently led.</li><li>Product categories, buyers and markets handled, including UK or Japan exposure.</li><li>Approximate annual order value or business handled.</li><li>One costing or margin example, one vendor-onboarding example and one new-business win.</li></ul><h3>How to apply</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=HN-DMM-0915%20%7C%20Divisional%20Merchandising%20Manager">jobs@hirednext.info</a> with the subject <strong>HN-DMM-0915 | Divisional Merchandising Manager</strong>. Include answers to the shortlisting questions above.</p><p>The active shortlist is being built now and complete, relevant applications will be reviewed first. HiredNext does not charge candidates to apply for a role or secure placement. Any optional CV service is separate from recruitment consideration.</p>',
        ],
        'apparel-designer-gurgaon' => [
            'title' => 'Apparel Designer',
            'location' => 'Gurgaon',
            'type' => 'full-time',
            'department' => 'Apparel Design / Product Development',
            'experience' => '3–5 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/apparel-designer-gurgaon.svg" alt="HiredNext Apparel Designer opening in Gurgaon" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Job code: HN-AD-0915</strong></p><p>HiredNext is managing a confidential search for an <strong>Apparel Designer</strong> with a reputed buying house in Gurgaon. The client identity will be shared only with appropriately shortlisted candidates.</p><h3>Role overview</h3><p>Build commercially relevant apparel ranges from trend and market research through mood boards, colour stories, technical packs and sample-to-production execution.</p><h3>What you will own</h3><ul><li>Research trends and translate them into commercially relevant ranges.</li><li>Create mood boards, colour stories, sketches and presentation-ready concepts.</li><li>Develop accurate tech packs and support sampling through production.</li><li>Work closely with merchandising, sourcing and vendor teams.</li><li>Use Adobe and practical AI-assisted design tools to improve speed and quality.</li></ul><h3>Candidate profile</h3><ul><li>3–5 years of commercial apparel design and product-development experience.</li><li>Strong garment construction, fabric and fit understanding.</li><li>Hands-on Adobe Illustrator and Photoshop capability.</li><li>A portfolio showing products taken from concept to production.</li><li>UK brand or retail exposure is preferred.</li></ul><h3>Location and compensation</h3><p><strong>Gurgaon | Up to ₹12 LPA</strong>, depending on experience and fit.</p><h3>Questions required for shortlisting</h3><ul><li>Current company, designation and location.</li><li>Total apparel-design experience, current and expected CTC, notice period and Gurgaon availability.</li><li>Portfolio link and the product categories you have designed.</li><li>UK brand or retail exposure, with names only where disclosure is permitted.</li><li>Illustrator and Photoshop proficiency and the AI design tools used in real work.</li><li>One example of a range or style personally taken from concept and tech pack through sampling or production.</li></ul><h3>How to apply</h3><p>Apply through the form below or email your CV and portfolio to <a href="mailto:jobs@hirednext.info?subject=HN-AD-0915%20%7C%20Apparel%20Designer">jobs@hirednext.info</a> with the subject <strong>HN-AD-0915 | Apparel Designer</strong>. Include answers to the shortlisting questions above.</p><p>The active shortlist is being built now and complete, relevant applications will be reviewed first. HiredNext does not charge candidates to apply for a role or secure placement. Any optional CV service is separate from recruitment consideration.</p>',
        ],
        'lead-backend-engineer-nodejs-bangalore' => [
            'title' => 'Lead Backend Engineer – Node.js',
            'location' => 'Bangalore',
            'type' => 'full-time',
            'department' => 'Technology / Platform Engineering',
            'experience' => '8–12+ years',
            'description' => '<p><strong>Job code: HN-LBE-0901</strong></p><p>HiredNext is managing a confidential search for a <strong>Lead Backend Engineer – Node.js</strong> for a high-scale technology platform. The employer identity will be shared only with appropriately shortlisted candidates.</p><h3>Role overview</h3><p>Own and scale the backend architecture of a platform serving high transaction volumes. This role requires deep expertise in distributed systems, scalable microservices, performance engineering and technical leadership.</p><h3>What you will own</h3><ul><li>Own the architecture, design and development of backend systems built on Node.js.</li><li>Design resilient, fault-tolerant distributed systems and event-driven microservices.</li><li>Optimise latency, throughput, data processing and infrastructure cost at scale.</li><li>Lead database architecture across SQL and NoSQL systems, including caching and asynchronous processing.</li><li>Design secure REST and GraphQL APIs and integrations with payment gateways, ERP, CRM, OMS/WMS and third-party platforms.</li><li>Lead backend engineers, architecture reviews, code quality, testing, monitoring and documentation.</li><li>Partner with Product and Engineering leadership on roadmap planning and execution.</li></ul><h3>Candidate requirements</h3><ul><li>8–12+ years of backend engineering experience, including 5+ years of hands-on Node.js.</li><li>Strong JavaScript and TypeScript expertise.</li><li>Experience with Express.js or NestJS, PostgreSQL, MySQL, MongoDB and Redis.</li><li>Strong understanding of distributed systems, microservices, scalability, reliability and security.</li><li>Experience with Kafka, RabbitMQ and AWS SQS/SNS.</li><li>Strong ownership, problem-solving, communication and engineering-leadership capability.</li></ul><h3>Good to have</h3><ul><li>AWS, GCP or Azure experience.</li><li>Kubernetes and Docker.</li><li>Datadog, Grafana, ELK or OpenTelemetry.</li><li>Ecommerce, Retail, Marketplace, FinTech or Consumer Technology experience.</li></ul><h3>Location and compensation</h3><p><strong>Bangalore | On-site / Hybrid | ₹45–50 LPA</strong>, depending on experience and fit.</p><h3>How to apply</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=HN-LBE-0901%20%7C%20Lead%20Backend%20Engineer%20%7C%20Current%20Company">jobs@hirednext.info</a> with the subject <strong>HN-LBE-0901 | Lead Backend Engineer | Current Company</strong>. Include your current compensation, expected compensation, notice period and present location.</p><p>HiredNext does not charge candidates to apply for a role or secure placement.</p>',
        ],
        'corporate-finance-lead-mumbai' => [
            'title' => 'Corporate Finance Lead',
            'location' => 'Mumbai',
            'type' => 'full-time',
            'department' => 'Corporate Finance / FP&A',
            'experience' => '3–6 years',
            'description' => '<p><strong>Job code: HN-CFL-0831</strong></p><p>HiredNext is managing a confidential search for a <strong>Corporate Finance Lead</strong> based in Mumbai. The role will drive financial planning, performance tracking and strategic insights, translating numbers into clear business decisions while strengthening financial discipline.</p><h3>What you will own</h3><ul><li>Lead annual budgeting, periodic forecasting and performance tracking across functions and business units.</li><li>Own monthly MIS and financial reporting; investigate variances, risks and opportunities and drive corrective actions to closure.</li><li>Build financial models and analyse data to improve unit economics, margins, cost structures and growth planning.</li><li>Prepare investor updates, board presentations and founder-level reviews with clear financial storytelling.</li><li>Manage end-to-end external audits and strengthen processes and controls in response to audit findings.</li></ul><h3>Candidate profile</h3><ul><li>Chartered Accountant with 3–6 years of Corporate Finance or FP&amp;A experience.</li><li>Mandatory industry background: Retail / Quick Commerce / FMCG / Hospitality.</li><li>Hands-on SAP experience.</li><li>Strong financial modelling, forecasting, analytical and stakeholder-management capability.</li><li>Experience working with founders, investors or senior leadership; high-growth or startup exposure is advantageous.</li><li>Proven team-handling experience and the ownership to move beyond reporting and drive business impact.</li></ul><h3>Location and compensation</h3><p><strong>Mumbai | ₹30–35 LPA</strong>, depending on experience and fit.</p><h3>How to apply</h3><p>Email your CV to <a href="mailto:jobs@hirednext.info?subject=HN-CFL-0831%20%7C%20Corporate%20Finance%20Lead%20%7C%20Current%20Company">jobs@hirednext.info</a> with the subject <strong>HN-CFL-0831 | Corporate Finance Lead | Current Company</strong>. Please include your current compensation, expected compensation, notice period and present location.</p><p>The employer identity will be shared only with appropriately shortlisted candidates. HiredNext does not charge candidates to apply for a role or secure placement.</p>',
        ],
        'product-development-manager-bangladesh-buying-house' => [
            'title' => 'Product Development Manager – Buying House',
            'location' => 'Bangladesh',
            'type' => 'full-time',
            'department' => 'Garments / Buying House',
            'experience' => 'Relevant leadership experience',
            'description' => '<p>HiredNext is hiring a <strong>Product Development Manager</strong> for a reputed buying house in Bangladesh.</p><h3>Role requirements</h3><ul><li>Strong garment product-development experience.</li><li>Proven experience handling US clients.</li><li>Ability to lead a product-development team.</li><li>Buying-house experience is strongly preferred.</li><li>Candidates must be based in Bangladesh.</li></ul>',
        ],
        'design-marketing-manager-wovens-bangladesh' => [
            'title' => 'Design & Marketing Manager – Wovens',
            'location' => 'Bangladesh',
            'type' => 'full-time',
            'department' => 'Garments / Buying House',
            'experience' => 'Strong woven-garment experience',
            'description' => '<p>HiredNext is hiring a <strong>Design &amp; Marketing Manager – Wovens</strong> for a reputed buying house in Bangladesh.</p><h3>Role requirements</h3><ul><li>Excellent woven-garment, fabric and product understanding.</li><li>Strong marketing and business-development capability.</li><li>Proven ability to open doors with buying houses and international buyers.</li><li>Candidates must be based in Bangladesh.</li></ul>',
        ],
        'fabric-sourcing-rd-manager-knits-tirupur' => [
            'title' => 'Fabric Sourcing & R&D Manager – Knits',
            'location' => 'Tirupur, Tamil Nadu',
            'type' => 'full-time',
            'department' => 'Garments / Buying House',
            'experience' => '10+ years',
            'description' => '<p>HiredNext is hiring a <strong>Fabric Sourcing &amp; R&amp;D Manager – Knits</strong> for a reputed buying house in Tirupur.</p><h3>Candidate profile</h3><ul><li>10+ years in knit-fabric sourcing and R&amp;D.</li><li>Hands-on fabric development with mills in India and overseas.</li><li>Strong technical understanding of knitted fabrics and apparel.</li></ul><h3>Compensation</h3><p><strong>₹15–18 LPA</strong>.</p><h3>Mandatory application information</h3><p>Please name the Indian and overseas mills you have worked with and give two or three examples of fabrics personally developed or commercialised.</p>',
        ],
        'chief-of-staff-to-managing-director-delhi' => [
            'title' => 'Chief of Staff to the Managing Director',
            'location' => 'Delhi',
            'type' => 'full-time',
            'department' => "Managing Director's Office",
            'experience' => '5–8 years',
            'description' => '<p>HiredNext is hiring a <strong>Chief of Staff to the Managing Director</strong> for a company based in Delhi. This is a hands-on execution role for someone who can bring structure to the MD’s office, anticipate priorities and ensure that important commitments move to completion.</p><h3>What you will own</h3><ul><li>Translate the MD’s priorities into clear actions, timelines and follow-through.</li><li>Coordinate with finance and other functional teams to obtain inputs, track decisions and close pending matters.</li><li>Build practical systems for reviews, meetings, documentation, calendars and priority tracking.</li><li>Prepare briefs, management information and decision-ready updates for the MD.</li><li>Manage selected personal scheduling and logistics with maturity, discretion and professional boundaries.</li></ul><h3>Candidate profile</h3><ul><li>5–8 years of relevant experience in an MD/CEO office, executive office, business coordination, PMO or high-ownership executive-assistance role.</li><li>Exceptionally proactive, organised and dependable; able to anticipate needs without constant direction.</li><li>Strong follow-through with finance and cross-functional stakeholders.</li><li>Excellent written and verbal communication, sound judgement and absolute confidentiality.</li><li>Comfortable being hands-on; this is an execution-intensive role rather than a purely strategic advisory position.</li><li>Must be based in Delhi NCR and able to work from Delhi.</li></ul>',
        ],
        'chief-financial-officer-series-b-ipo-readiness' => [
            'title' => 'Chief Financial Officer – Series B & IPO Readiness',
            'location' => 'Confidential, India',
            'type' => 'full-time',
            'department' => 'Finance Leadership',
            'experience' => '15+ years',
            'description' => '<p>HiredNext is managing a <strong>highly confidential CFO mandate</strong> for a newly funded Series B company entering its next phase of institutional growth.</p><h3>Mandate</h3><ul><li>Build an IPO-ready finance organisation and strengthen governance, controls and reporting.</li><li>Lead fundraising, investor engagement, capital planning and board communication.</li><li>Partner with the founders to create the financial discipline required for scale and public-market readiness.</li></ul><h3>Candidate profile</h3><ul><li>15+ years of progressive finance leadership experience, including a CFO, Deputy CFO or comparable enterprise role.</li><li>Strong fundraising, investor relations, governance, compliance and financial-planning credentials.</li><li>Demonstrable IPO-readiness, public-market or comparable institutional-event experience.</li><li>CA strongly preferred; exceptional integrity and commercial judgement are essential.</li></ul><h3>Compensation</h3><p><strong>₹80 lakh–₹1.2 crore fixed, plus performance bonus and meaningful ESOPs.</strong></p><p>The employer identity will be shared only with shortlisted candidates. HiredNext does not charge candidates.</p>',
        ],
        'head-business-development-confidential-leadership-mandate' => [
            'title' => 'Head of Business Development',
            'location' => 'Confidential, India',
            'type' => 'full-time',
            'department' => 'Business Leadership',
            'experience' => '15+ years',
            'description' => '<p>HiredNext is managing a <strong>confidential Head of Business Development mandate</strong> for a growth-stage organisation.</p><h3>Mandate</h3><ul><li>Own enterprise growth, strategic accounts, partnerships and revenue expansion.</li><li>Build a disciplined commercial engine with clear pipeline quality, conversion and profitability.</li><li>Develop senior stakeholder relationships and translate market opportunity into repeatable business.</li></ul><h3>Candidate profile</h3><ul><li>15+ years in enterprise business development, strategic sales or commercial leadership.</li><li>Evidence of personally winning and expanding material accounts, not only managing inherited relationships.</li><li>Strong P&amp;L judgement, executive presence and team-building capability.</li></ul><h3>Compensation</h3><p><strong>₹45–60 LPA fixed, plus performance-linked incentives.</strong></p><p>The employer identity will be shared only with shortlisted candidates. HiredNext does not charge candidates.</p>',
        ],
        'head-operations-nbfc-confidential' => [
            'title' => 'Head of Operations – NBFC',
            'location' => 'Confidential, India',
            'type' => 'full-time',
            'department' => 'NBFC Operations',
            'experience' => '15+ years',
            'description' => '<p>HiredNext is managing a <strong>confidential Head of Operations mandate</strong> for an established NBFC.</p><h3>Mandate</h3><ul><li>Lead end-to-end lending operations across onboarding, documentation, disbursement, servicing and collections interfaces.</li><li>Strengthen controls, turnaround times, customer experience and regulatory operating discipline.</li><li>Build scalable processes, operating metrics and accountable teams across locations and products.</li></ul><h3>Candidate profile</h3><ul><li>15+ years in NBFC, lending or regulated financial-services operations.</li><li>Strong understanding of credit-process hand-offs, compliance, audits, technology-led operations and service quality.</li><li>Proven experience leading operations at meaningful scale.</li></ul><h3>Compensation</h3><p><strong>₹60–85 LPA fixed, depending on scale and mandate fit.</strong></p><p>The employer identity will be shared only with shortlisted candidates. HiredNext does not charge candidates.</p>',
        ],
        'head-credit-nbfc-confidential' => [
            'title' => 'Head of Credit – NBFC',
            'location' => 'Confidential, India',
            'type' => 'full-time',
            'department' => 'Credit & Risk',
            'experience' => '15+ years',
            'description' => '<p>HiredNext is managing a <strong>confidential Head of Credit mandate</strong> for an established NBFC.</p><h3>Mandate</h3><ul><li>Own credit policy, underwriting quality, portfolio risk and governance across lending products.</li><li>Balance prudent risk selection with sustainable business growth and customer outcomes.</li><li>Partner with business, collections, analytics and technology leaders to improve decisioning and portfolio performance.</li></ul><h3>Candidate profile</h3><ul><li>15+ years in credit underwriting and risk leadership within an NBFC, bank or scaled lending institution.</li><li>Strong portfolio analytics, policy design, regulatory understanding and credit-governance credentials.</li><li>Proven leadership across products, geographies or large credit teams.</li></ul><h3>Compensation</h3><p><strong>₹60–90 LPA fixed, depending on portfolio scale and experience.</strong></p><p>The employer identity will be shared only with shortlisted candidates. HiredNext does not charge candidates.</p>',
        ],
        'chief-human-resources-officer-confidential' => [
            'title' => 'Chief Human Resources Officer',
            'location' => 'Confidential, India',
            'type' => 'full-time',
            'department' => 'Human Resources',
            'experience' => '18+ years',
            'description' => '<p>HiredNext is managing a <strong>highly confidential CHRO mandate</strong> for a scaled organisation entering its next phase of growth and transformation.</p><h3>Mandate</h3><ul><li>Partner with the CEO and board on organisation design, leadership capability, succession and culture.</li><li>Build an evidence-led people strategy aligned with business performance and transformation priorities.</li><li>Strengthen executive hiring, rewards, talent systems, employee relations and HR governance.</li></ul><h3>Candidate profile</h3><ul><li>18+ years of progressive HR leadership with enterprise-wide responsibility.</li><li>Current or recent CHRO, HR Director or senior people-leadership experience in a complex organisation.</li><li>Strong board credibility, business judgement and a record of leading transformation at scale.</li></ul><h3>Compensation</h3><p><strong>₹70 lakh–₹1 crore fixed, plus performance-linked compensation.</strong></p><p>The employer identity will be shared only with shortlisted candidates. HiredNext does not charge candidates.</p>',
        ],
        'head-talent-acquisition-gcc' => [
            'title' => 'Head of Talent Acquisition – GCC',
            'location' => 'Confidential, India',
            'type' => 'full-time',
            'department' => 'GCC Talent Acquisition',
            'experience' => '14+ years',
            'description' => '<p>HiredNext is managing a <strong>confidential Head of Talent Acquisition mandate</strong> for a Global Capability Centre in India.</p><h3>Mandate</h3><ul><li>Own talent-acquisition strategy and delivery across technology, digital, analytics and enterprise functions.</li><li>Build a high-quality GCC hiring engine with strong workforce planning, market intelligence and stakeholder governance.</li><li>Improve hiring quality, speed, employer proposition and leadership-talent pipelines.</li></ul><h3>Candidate profile</h3><ul><li>14+ years in talent acquisition, including leadership responsibility within a GCC or large global enterprise.</li><li>Demonstrable experience scaling complex technology and specialist hiring in India.</li><li>Strong executive stakeholder management, workforce-planning and TA analytics capability.</li></ul><h3>Compensation</h3><p><strong>Up to ₹45 LPA.</strong></p><p>The employer identity will be shared only with shortlisted candidates. HiredNext does not charge candidates.</p>',
        ],
        'chro-expression-interest-upcoming-gcc-hyderabad' => [
            'title' => 'CHRO – Upcoming GCC Build | Hyderabad',
            'location' => 'Hyderabad',
            'type' => 'full-time',
            'department' => 'GCC People Leadership',
            'experience' => '18+ years',
            'description' => '<p><strong>CHRO leadership role profile.</strong> HiredNext is mapping senior people leaders for Global Capability Centres establishing or scaling operations in Hyderabad.</p><h3>Leadership context</h3><ul><li>Build the India people agenda from GCC launch through scaled operations.</li><li>Lead workforce planning, organisation design, leadership hiring and global stakeholder alignment.</li><li>Create a high-trust culture while establishing governance, rewards and talent systems at speed.</li></ul><h3>Relevant profile</h3><ul><li>18+ years in enterprise HR with senior leadership experience in a GCC, global enterprise or major capability build.</li><li>Evidence of scaling complex technology, digital or shared-services organisations in India.</li><li>Board- and CEO-level credibility with strong global matrix experience.</li></ul><h3>Confidential registration</h3><p>Use the short-message field to describe one GCC build or transformation you personally led. If relevant to your current responsibilities, you may also state whether you influence recruitment-partner empanelment or vendor onboarding. This is optional, handled separately and does not affect opportunity consideration.</p><p>HiredNext will contact you when your experience matches a relevant leadership requirement. HiredNext does not charge candidates.</p>',
        ],
        'chro-expression-interest-semiconductor-deeptech-bengaluru' => [
            'title' => 'CHRO – Semiconductor & Deep Tech | Bengaluru',
            'location' => 'Bengaluru',
            'type' => 'full-time',
            'department' => 'Semiconductor & Deep-Tech Leadership',
            'experience' => '18+ years',
            'description' => '<p><strong>CHRO leadership role profile.</strong> HiredNext is mapping senior people leaders for semiconductor, electronics and deep-technology organisations growing in Bengaluru.</p><h3>Leadership context</h3><ul><li>Build scarce engineering, R&amp;D and technical-leadership pipelines across India and global markets.</li><li>Shape an innovation-led culture, technical career architecture and retention strategy.</li><li>Lead succession, rewards, global mobility and organisation capability for long-cycle R&amp;D businesses.</li></ul><h3>Relevant profile</h3><ul><li>18+ years in HR leadership, ideally within semiconductors, electronics, engineering, product technology or deep tech.</li><li>Strong understanding of specialist engineering talent markets and technical workforce planning.</li><li>Experience partnering with global business, R&amp;D and functional leaders.</li></ul><h3>Confidential registration</h3><p>Use the short-message field to describe a scarce-talent, R&amp;D or technical-organisation challenge you solved. If relevant, you may separately indicate whether you influence recruitment-partner empanelment or vendor onboarding. This disclosure is optional and does not affect opportunity consideration.</p><p>HiredNext will contact you when your experience matches a relevant leadership requirement. HiredNext does not charge candidates.</p>',
        ],
        'chro-expression-interest-data-centre-noida' => [
            'title' => 'CHRO – Data Centre Platform | Noida',
            'location' => 'Noida',
            'type' => 'full-time',
            'department' => 'Data Centre & Infrastructure Leadership',
            'experience' => '18+ years',
            'description' => '<p><strong>CHRO leadership role profile.</strong> HiredNext is mapping senior people leaders for reputed data-centre and digital-infrastructure platforms operating from Noida/NCR.</p><h3>Leadership context</h3><ul><li>Lead the people agenda across corporate, engineering, projects, facilities and multi-site operations.</li><li>Strengthen safety culture, workforce compliance, operational capability and leadership succession.</li><li>Build scalable talent systems for rapid infrastructure expansion without compromising control or reliability.</li></ul><h3>Relevant profile</h3><ul><li>18+ years in senior HR roles within infrastructure, data centres, telecom, energy, industrial services or another asset-intensive sector.</li><li>Strong operational HR, employee relations, compliance and multi-location leadership experience.</li><li>Ability to partner credibly with business, engineering and operating leaders.</li></ul><h3>Confidential registration</h3><p>Use the short-message field to describe a multi-site, infrastructure or operational transformation you led. If relevant, you may separately indicate whether you influence recruitment-partner empanelment or vendor onboarding. This disclosure is optional and does not affect opportunity consideration.</p><p>HiredNext will contact you when your experience matches a relevant leadership requirement. HiredNext does not charge candidates.</p>',
        ],
        'chief-people-transformation-officer-expression-interest-india' => [
            'title' => 'Chief People & Transformation Officer | India',
            'location' => 'India',
            'type' => 'full-time',
            'department' => 'Enterprise Transformation',
            'experience' => '20+ years',
            'description' => '<p><strong>Chief People and Transformation leadership role profile.</strong> HiredNext is mapping board-ready people leaders for enterprises undertaking material organisation transformation.</p><h3>Leadership context</h3><ul><li>Partner with the board and CEO on organisation redesign, productivity and leadership succession.</li><li>Align workforce, operating model, capability and culture with enterprise transformation priorities.</li><li>Strengthen executive talent, rewards, governance and measurable people outcomes.</li></ul><h3>Relevant profile</h3><ul><li>20+ years of progressive HR leadership with enterprise-wide responsibility.</li><li>Current or recent CHRO, Chief People Officer or HR Director experience in a complex scaled organisation.</li><li>Evidence of leading restructuring, integration, operating-model change or enterprise transformation.</li></ul><h3>Confidential registration</h3><p>Use the short-message field to describe one board-level transformation and its measurable business outcome. If relevant, you may separately indicate whether you influence recruitment-partner empanelment or vendor onboarding. This disclosure is optional and does not affect opportunity consideration.</p><p>HiredNext will contact you when your experience matches a relevant leadership requirement. HiredNext does not charge candidates.</p>',
        ],
        'head-merchandising-dhaka-sourcing-hub' => [
            'title' => 'Head of Merchandising – Dhaka Sourcing Hub',
            'location' => 'Dhaka, Bangladesh',
            'type' => 'full-time',
            'department' => 'Apparel Sourcing / Merchandising Leadership',
            'experience' => 'Senior leadership experience',
            'description' => '<p><strong>Job code: HN-HM-DHK-0923</strong></p><p>HiredNext Recruitment is managing a confidential search for a <strong>Head of Merchandising</strong> to build and lead a sourcing hub in <strong>Dhaka, Bangladesh</strong> for a reputed organisation. The client identity will be shared only with appropriately shortlisted candidates.</p><h3>Role mandate</h3><p>This is a senior SBU leadership role for a commercially sharp sourcing and merchandising professional who can build a strong vendor ecosystem across Bangladesh and China and convert product opportunities into reliable, scalable supply.</p><h3>What you will own</h3><ul><li>Build and lead the sourcing hub from Dhaka.</li><li>Identify, assess and develop multiple factories across product categories in Bangladesh and China.</li><li>Evaluate factory capability, capacity, product strength, quality, compliance and commercial fit.</li><li>Lead product costing, price negotiation and commercial discussions with factories.</li><li>Drive product development, sampling and sourcing options for the company.</li><li>Present commercially viable product and factory options to the internal business team for order booking.</li><li>Coordinate execution once orders are booked, with strong ownership of timelines, quality and commercial commitments.</li><li>Build long-term factory relationships and continuously widen the sourcing base.</li></ul><h3>Ideal profile</h3><ul><li>Strong apparel merchandising and sourcing background with substantial factory-facing responsibility.</li><li>Excellent costing, negotiation and vendor-development capability.</li><li>Strong understanding of product construction, production feasibility and factory specialisation.</li><li>Experience working across multiple product categories and supplier bases.</li><li>Commercially mature, entrepreneurial and comfortable building a sourcing operation rather than only managing an existing setup.</li><li><strong>Indian national preferred.</strong></li><li>Must be comfortable being stationed in Dhaka and travelling to factories as required.</li></ul><h3>Location and compensation</h3><p><strong>Dhaka, Bangladesh | ₹40 lakh CTC all-inclusive + variable / commission</strong>.</p><h3>Information required for shortlisting</h3><ul><li>Current company, designation and location.</li><li>Total merchandising / sourcing experience.</li><li>Product categories handled.</li><li>Key markets, buyers and factory networks handled.</li><li>Examples of factory development or sourcing-base expansion personally led.</li><li>Current CTC, expected CTC and notice period.</li><li>Availability to relocate to and be stationed in Dhaka.</li></ul><h3>How to apply</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=HN-HM-DHK-0923%20%7C%20Head%20of%20Merchandising%20%7C%20Dhaka">jobs@hirednext.info</a> with the subject <strong>HN-HM-DHK-0923 | Head of Merchandising | Dhaka</strong>. Include the shortlisting information above.</p>',
        ],
        'critical-facilities-manager-data-center-noida' => [
            'title' => 'Critical Facilities Manager – Data Center',
            'location' => 'Noida / NCR',
            'type' => 'full-time',
            'department' => 'Role Profile | Data Center',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/critical-facilities-manager-data-center-noida.svg" alt="HiredNext Critical Facilities Manager data center talent pool in Noida NCR" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is building a specialist talent pool for senior critical facilities professionals as data center hiring expands across India. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–12 years in hyperscale, colocation or other mission critical infrastructure environments.</li><li>Hands on ownership of power, cooling, UPS, DG, HVAC, BMS and life safety systems.</li><li>Strong preventive maintenance, vendor management, compliance and incident response discipline.</li><li>Calm decision making in high availability environments where uptime is non negotiable.</li></ul><h3>Location focus</h3><p><strong>Noida / NCR</strong>, with openness to relevant data center opportunities in other major Indian hubs.</p><h3>Add your profile</h3><p>Use the application form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=Data%20Center%20Talent%20Pool%20%7C%20Critical%20Facilities%20Manager">jobs@hirednext.info</a> with the subject <strong>Data Center Talent Pool | Critical Facilities Manager</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'data-center-design-commissioning-manager-chennai' => [
            'title' => 'Data Center Design & Commissioning Manager',
            'location' => 'Chennai',
            'type' => 'full-time',
            'department' => 'Role Profile | Data Center',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/data-center-design-commissioning-manager-chennai.svg" alt="HiredNext Data Center Design and Commissioning Manager talent pool in Chennai" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is identifying senior professionals for data center design, testing and commissioning mandates. This is a specialist talent pool, not a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–12 years in data center builds, commissioning or mission critical project delivery.</li><li>Strong electrical, cooling, MEP and life safety commissioning experience.</li><li>Hands on exposure to FAT, SAT, integrated systems testing, readiness and snag closure.</li><li>Ability to coordinate consultants, contractors, OEMs, operations teams and project stakeholders through handover.</li></ul><h3>Location focus</h3><p><strong>Chennai</strong>, with openness to major data center build locations across India.</p><h3>Add your profile</h3><p>Use the application form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=Data%20Center%20Talent%20Pool%20%7C%20Design%20and%20Commissioning">jobs@hirednext.info</a> with the subject <strong>Data Center Talent Pool | Design & Commissioning</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'physical-design-engineer-advanced-nodes-bengaluru' => [
            'title' => 'Physical Design Engineer – Advanced Nodes',
            'location' => 'Bengaluru',
            'type' => 'full-time',
            'department' => 'Role Profile | Semiconductor',
            'experience' => '6–10 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/physical-design-engineer-advanced-nodes-bengaluru.svg" alt="HiredNext Physical Design Engineer advanced nodes semiconductor talent pool in Bengaluru" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is building a specialist semiconductor talent pool for experienced physical design engineers. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>6–10 years of hands on VLSI physical design experience.</li><li>Strong floorplanning, power planning, place and route, CTS, routing and timing closure capability.</li><li>Deep exposure to STA, ECO implementation, power and performance optimisation and backend signoff.</li><li>Experience on advanced technology nodes such as 5nm, 7nm or comparable modern nodes is strongly relevant.</li><li>Comfort working on complex SoCs with cross functional design, verification and implementation teams.</li></ul><h3>Location focus</h3><p><strong>Bengaluru</strong>, with flexibility for relevant semiconductor opportunities in Hyderabad and Noida.</p><h3>Add your profile</h3><p>Use the application form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=Semiconductor%20Talent%20Pool%20%7C%20Physical%20Design">jobs@hirednext.info</a> with the subject <strong>Semiconductor Talent Pool | Physical Design</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'dft-engineer-soc-scan-atpg-hyderabad' => [
            'title' => 'DFT Engineer – SoC / Scan / ATPG',
            'location' => 'Hyderabad',
            'type' => 'full-time',
            'department' => 'Role Profile | Semiconductor',
            'experience' => '6–10 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/dft-engineer-soc-scan-atpg-hyderabad.svg" alt="HiredNext DFT Engineer semiconductor talent pool in Hyderabad" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is curating a niche semiconductor pipeline for experienced Design for Test professionals. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>6–10 years of DFT experience on complex SoCs or large digital designs.</li><li>Strong scan insertion, ATPG, test coverage, diagnosis and debug experience.</li><li>Exposure to production test readiness and silicon bring up is highly relevant.</li><li>Working knowledge of established DFT tool flows from Synopsys, Cadence, Siemens Tessent or comparable environments.</li><li>Ability to work closely with RTL, verification, physical design and validation teams.</li></ul><h3>Location focus</h3><p><strong>Hyderabad</strong>, with flexibility for relevant semiconductor opportunities in Bengaluru and Noida.</p><h3>Add your profile</h3><p>Use the application form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=Semiconductor%20Talent%20Pool%20%7C%20DFT%20Engineer">jobs@hirednext.info</a> with the subject <strong>Semiconductor Talent Pool | DFT Engineer</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'transition-manager-gcc-setup-hyderabad' => [
            'title' => 'Transition Manager – GCC Setup',
            'location' => 'Hyderabad',
            'type' => 'full-time',
            'department' => 'Role Profile | GCC',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/transition-manager-gcc-setup-hyderabad.svg" alt="HiredNext Transition Manager GCC setup talent pool in Hyderabad" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is building a senior transition talent pool for companies establishing or scaling Global Capability Centres in India. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–12 years across transitions, shared services, GCC builds or operating model change.</li><li>Hands on experience migrating work into India delivery centres.</li><li>Strong process transfer, SOP readiness, governance, SLA, risk and stabilisation management.</li><li>Confidence working with cross border stakeholders and multiple functional workstreams.</li><li>Structured execution discipline from transition planning through steady state handover.</li></ul><h3>Location focus</h3><p><strong>Hyderabad</strong>, with relevance across Bengaluru, Chennai, Pune and other growing GCC hubs.</p><h3>Add your profile</h3><p>Use the application form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=GCC%20Talent%20Pool%20%7C%20Transition%20Manager">jobs@hirednext.info</a> with the subject <strong>GCC Talent Pool | Transition Manager</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'workforce-planning-talent-intelligence-manager-bengaluru' => [
            'title' => 'Workforce Planning & Talent Intelligence Manager',
            'location' => 'Bengaluru',
            'type' => 'full-time',
            'department' => 'Role Profile | GCC',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/workforce-planning-talent-intelligence-manager-bengaluru.svg" alt="HiredNext Workforce Planning and Talent Intelligence Manager GCC talent pool in Bengaluru" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is identifying senior professionals who can connect business growth plans with workforce demand, talent availability and market intelligence. This is a specialist talent pool, not a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–12 years in workforce planning, talent intelligence, people analytics, talent strategy or a closely related field.</li><li>Ability to translate business plans into workforce demand, location strategy and talent roadmaps.</li><li>Strong labour market research, supply demand analysis, skills intelligence and competitor mapping capability.</li><li>Experience partnering with Talent Acquisition, business leaders and global stakeholders in a GCC or large enterprise environment.</li><li>Clear analytical storytelling and commercial understanding, not only dashboard reporting.</li></ul><h3>Location focus</h3><p><strong>Bengaluru</strong>, with relevance across Hyderabad, Chennai and other major GCC hubs.</p><h3>Add your profile</h3><p>Use the application form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=GCC%20Talent%20Pool%20%7C%20Workforce%20Planning%20and%20Talent%20Intelligence">jobs@hirednext.info</a> with the subject <strong>GCC Talent Pool | Workforce Planning & Talent Intelligence</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'liquid-cooling-thermal-systems-manager-mumbai' => [
            'title' => 'Liquid Cooling & Thermal Systems Manager',
            'location' => 'Mumbai / Navi Mumbai',
            'type' => 'full-time',
            'department' => 'Role Profile | Data Center',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/liquid-cooling-thermal-systems-manager-mumbai.svg" alt="HiredNext liquid cooling and thermal systems data center talent pool in Mumbai" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is building a specialist pool for AI-density data center cooling and thermal infrastructure. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–12 years in data center mechanical systems, thermal engineering or mission-critical cooling.</li><li>Hands-on exposure to direct-to-chip liquid cooling, CDUs, rear-door heat exchangers, chilled-water systems or other high-density cooling architectures.</li><li>Strong understanding of rack density, thermal loads, redundancy, water constraints, controls and cooling efficiency.</li><li>Ability to work across design, commissioning, operations, OEMs and MEP partners.</li></ul><h3>Location focus</h3><p><strong>Mumbai / Navi Mumbai</strong>, with relevance to other large AI and hyperscale data center markets in India.</p><h3>Add your profile</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=Data%20Center%20Talent%20Pool%20%7C%20Liquid%20Cooling">jobs@hirednext.info</a> with the subject <strong>Data Center Talent Pool | Liquid Cooling</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'data-center-power-electrical-reliability-manager-hyderabad' => [
            'title' => 'Data Center Power & Electrical Reliability Manager',
            'location' => 'Hyderabad',
            'type' => 'full-time',
            'department' => 'Role Profile | Data Center',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/data-center-power-electrical-reliability-manager-hyderabad.svg" alt="HiredNext data center power and electrical reliability talent pool in Hyderabad" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is mapping senior power and electrical reliability specialists for large data center builds and operations. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–12 years in mission-critical electrical infrastructure, ideally in hyperscale or colocation data centers.</li><li>Strong experience with HV/LV distribution, transformers, switchgear, UPS, generators, protection systems and electrical redundancy.</li><li>Hands-on incident response, root-cause analysis, preventive maintenance and reliability improvement.</li><li>Experience with commissioning, switching procedures, vendor coordination and safety governance.</li></ul><h3>Location focus</h3><p><strong>Hyderabad</strong>, with openness to major data center markets across India.</p><h3>Add your profile</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=Data%20Center%20Talent%20Pool%20%7C%20Power%20Reliability">jobs@hirednext.info</a> with the subject <strong>Data Center Talent Pool | Power Reliability</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'high-speed-serdes-ucie-analog-design-engineer-bengaluru' => [
            'title' => 'High-Speed SerDes / UCIe Analog Design Engineer',
            'location' => 'Bengaluru',
            'type' => 'full-time',
            'department' => 'Role Profile | Semiconductor',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/high-speed-serdes-ucie-analog-design-engineer-bengaluru.svg" alt="HiredNext high-speed SerDes UCIe analog semiconductor talent pool in Bengaluru" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is building a niche pool of silicon-proven analog designers for high-speed interfaces used in AI, data center and chiplet platforms. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–12 years of analog or mixed-signal IC design experience.</li><li>Strong SerDes, UCIe, PCIe, CXL, Ethernet, USB or other high-speed I/O expertise.</li><li>Hands-on design of TX/RX front ends, equalizers, PLLs, DLLs, CDR, biasing, regulators or related PHY blocks.</li><li>Advanced-node design experience with post-layout verification, silicon bring-up and simulation-to-silicon debug.</li></ul><h3>Location focus</h3><p><strong>Bengaluru</strong>, with relevance to other semiconductor design hubs in India.</p><h3>Add your profile</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=Semiconductor%20Talent%20Pool%20%7C%20SerDes%20UCIe">jobs@hirednext.info</a> with the subject <strong>Semiconductor Talent Pool | SerDes / UCIe</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'advanced-packaging-chiplet-layout-engineer-bengaluru' => [
            'title' => 'Advanced Packaging / Chiplet Layout Engineer',
            'location' => 'Bengaluru',
            'type' => 'full-time',
            'department' => 'Role Profile | Semiconductor',
            'experience' => '8–15 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/advanced-packaging-chiplet-layout-engineer-bengaluru.svg" alt="HiredNext advanced packaging chiplet layout semiconductor talent pool in Bengaluru" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is building a specialist talent pool for package-aware chiplet and advanced-interface implementation. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–15 years in analog or mixed-signal custom layout, package-aware implementation or advanced packaging.</li><li>Experience with UCIe, SerDes or die-to-die PHY layout and successful tape-outs.</li><li>Strong micro-bump planning, bump-map architecture, package-aware floorplanning and parasitic control.</li><li>Exposure to 2.5D/3D integration, interposers, RDL, TSVs or chiplet package co-design.</li></ul><h3>Location focus</h3><p><strong>Bengaluru</strong>, with relevance to Hyderabad, Noida and emerging semiconductor packaging ecosystems.</p><h3>Add your profile</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=Semiconductor%20Talent%20Pool%20%7C%20Advanced%20Packaging%20Chiplets">jobs@hirednext.info</a> with the subject <strong>Semiconductor Talent Pool | Advanced Packaging / Chiplets</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'enterprise-agentic-ai-architect-chennai' => [
            'title' => 'Enterprise Agentic AI Architect',
            'location' => 'Chennai',
            'type' => 'full-time',
            'department' => 'Role Profile | GCC',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/enterprise-agentic-ai-architect-chennai.svg" alt="HiredNext Enterprise Agentic AI Architect GCC talent pool in Chennai" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is curating a senior AI architecture pool for capability centres building production-grade GenAI and agentic AI platforms. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–12 years in software, cloud or data engineering with deep recent ownership of enterprise AI architecture.</li><li>Production experience with LLM applications, agentic workflows, RAG, orchestration, model gateways and AI platform design.</li><li>Strong cloud architecture, APIs, observability, security, data governance and cost-control fundamentals.</li><li>Ability to move from PoC to scalable enterprise deployment across global stakeholders and product teams.</li></ul><h3>Location focus</h3><p><strong>Chennai</strong>, with relevance across Bengaluru, Hyderabad, Pune and other GCC hubs.</p><h3>Add your profile</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=GCC%20Talent%20Pool%20%7C%20Agentic%20AI%20Architect">jobs@hirednext.info</a> with the subject <strong>GCC Talent Pool | Agentic AI Architect</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
        'agentic-ai-soc-detection-response-manager-bengaluru' => [
            'title' => 'Agentic AI SOC Detection & Response Manager',
            'location' => 'Bengaluru',
            'type' => 'full-time',
            'department' => 'Role Profile | GCC',
            'experience' => '8–12 years',
            'description' => '<div class="mb-8"><img src="/theme/assets/jobs/agentic-ai-soc-detection-response-manager-bengaluru.svg" alt="HiredNext Agentic AI SOC Detection Response GCC talent pool in Bengaluru" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div><p><strong>Specialist role profile.</strong> HiredNext is building a niche cybersecurity pool for GCCs modernising security operations with AI and automation. This is not presented as a confirmed vacancy with an identified employer.</p><h3>Profile we want to identify</h3><ul><li>8–12 years in SOC engineering, detection engineering, incident response or security platform transformation.</li><li>Strong SIEM, SOAR, XDR, threat detection and response engineering experience.</li><li>Hands-on exposure to AI-assisted or agentic security workflows, automation and security operations transformation.</li><li>Ability to design use cases, controls, operating models and measurable detection-response improvements.</li></ul><h3>Location focus</h3><p><strong>Bengaluru</strong>, with relevance across major India GCC locations.</p><h3>Add your profile</h3><p>Apply through the form below or email your CV to <a href="mailto:jobs@hirednext.info?subject=GCC%20Talent%20Pool%20%7C%20Agentic%20AI%20SOC">jobs@hirednext.info</a> with the subject <strong>GCC Talent Pool | Agentic AI SOC</strong>. HiredNext does not charge candidates to add a profile or apply for recruitment mandates.</p>',
        ],
    ];

    private const HUBLI_WOVEN_JOBS = [
        'dgm-operations-woven-manufacturing-hubli' => [
            'code' => 'HN-HBL-0910-01',
            'title' => 'DGM – Operations',
            'experience' => '15–20 years',
            'salary' => '₹2.5–3.5 lakh per month',
            'qualification' => 'BE in Textile or any BE graduate',
            'positions' => 1,
        ],
        'manager-industrial-engineering-woven-hubli' => [
            'code' => 'HN-HBL-0910-02',
            'title' => 'Manager – IE',
            'experience' => '10–15 years',
            'salary' => '₹1.5–1.75 lakh per month',
            'qualification' => 'BE in Textile or any BE graduate',
            'positions' => 2,
        ],
        'manager-planning-woven-manufacturing-hubli' => [
            'code' => 'HN-HBL-0910-03',
            'title' => 'Manager – Planning',
            'experience' => '10–15 years',
            'salary' => '₹1–1.25 lakh per month',
            'qualification' => 'BE in Textile or any BE graduate',
            'positions' => 1,
        ],
        'manager-quality-woven-manufacturing-hubli' => [
            'code' => 'HN-HBL-0910-04',
            'title' => 'Manager – Quality',
            'experience' => '10–15 years',
            'salary' => '₹1–1.25 lakh per month',
            'qualification' => 'BE in Textile or any BE graduate',
            'positions' => 2,
        ],
        'dispatch-executive-woven-manufacturing-hubli' => [
            'code' => 'HN-HBL-0910-05',
            'title' => 'Dispatch Executive',
            'experience' => '5–10 years',
            'salary' => '₹50,000–75,000 per month',
            'qualification' => 'PUC / Graduate',
            'positions' => 1,
        ],
        'assistant-quality-manager-woven-hubli' => [
            'code' => 'HN-HBL-0910-06',
            'title' => 'Assistant Quality Manager',
            'experience' => '5–10 years',
            'salary' => '₹60,000–75,000 per month',
            'qualification' => 'Any graduate',
            'positions' => 2,
        ],
        'assistant-production-manager-woven-hubli' => [
            'code' => 'HN-HBL-0910-07',
            'title' => 'Assistant Production Manager',
            'experience' => '5–10 years',
            'salary' => '₹75,000–85,000 per month',
            'qualification' => 'SSLC',
            'positions' => 1,
        ],
        'assistant-manager-industrial-engineering-woven-hubli' => [
            'code' => 'HN-HBL-0910-08',
            'title' => 'Assistant Manager – IE',
            'experience' => '5–10 years',
            'salary' => '₹75,000–85,000 per month',
            'qualification' => 'BE in Textile or any BE graduate',
            'positions' => 2,
        ],
    ];
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'title', 'slug', 'location', 'type', 'description', 'department', 'experience',
        'status', 'created_by', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    private static function publishedJobs(): array
    {
        $jobs = self::PUBLISHED_JOBS + \App\Libraries\BuyingHouseDesignJobs::publishedJobs();

        foreach (self::HUBLI_WOVEN_JOBS as $slug => $role) {
            $jobs[$slug] = [
                'title' => $role['title'] . ' | Apparel / Garment Manufacturing',
                'location' => 'Hubli / Dharwad, Karnataka',
                'type' => 'full-time',
                'department' => 'Apparel / Garment Manufacturing – Wovens',
                'experience' => $role['experience'],
                'description' => self::hubliWovenDescription($slug, $role),
            ];
        }

        return $jobs;
    }

    private static function hubliWovenDescription(string $slug, array $role): string
    {
        $posterUrl = base_url('theme/assets/jobs/' . $slug . '.svg');
        $title = esc($role['title']);
        $code = esc($role['code']);
        $qualification = esc($role['qualification']);
        $salary = esc($role['salary']);
        $positions = (int) $role['positions'];
        $positionLabel = $positions === 1 ? '1 position' : $positions . ' positions';
        $subject = rawurlencode($role['code'] . ' | ' . $role['title']);

        return '<div class="mb-8"><img src="' . esc($posterUrl) . '" alt="HiredNext ' . $title . ' opening in apparel and garment manufacturing at Hubli" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div>'
            . '<p><strong>Job code: ' . $code . '</strong></p>'
            . '<p>HiredNext is managing a confidential search for an established <strong>apparel / garment manufacturer</strong> at Rayapura Industrial Area on National Highway, Hubli. The woven manufacturing facility has operated since 2018, has approximately <strong>1,500 machines</strong>, and is among the largest manufacturing units in North Karnataka.</p>'
            . '<p>The unit serves woven export customers including <strong>Levi\'s, Columbia, H&amp;M, Duluth and Target</strong>, producing shorts, pants, jeans/denim and jackets for women, men and children.</p>'
            . '<h3>Role details</h3><ul>'
            . '<li><strong>Designation:</strong> ' . $title . '.</li>'
            . '<li><strong>Experience:</strong> ' . esc($role['experience']) . '.</li>'
            . '<li><strong>Salary range:</strong> ' . $salary . '.</li>'
            . '<li><strong>Qualification:</strong> ' . $qualification . '.</li>'
            . '<li><strong>Location:</strong> Hubli / Dharwad, Karnataka.</li>'
            . '<li><strong>Languages:</strong> English, Kannada and Hindi.</li>'
            . '<li><strong>Notice period:</strong> One to two months.</li>'
            . '<li><strong>Woven experience:</strong> Minimum 5 years in woven manufacturing.</li>'
            . '<li><strong>Openings:</strong> ' . $positionLabel . '.</li>'
            . '</ul>'
            . '<h3>How to apply</h3>'
            . '<p>Apply through the form on this page or email your CV to <a href="mailto:jobs@hirednext.info?subject=' . $subject . '">jobs@hirednext.info</a> using the exact subject <strong>' . $code . ' | ' . $title . '</strong>.</p>'
            . '<p>Please include your current location, current salary, expected salary, notice period, qualification, languages and total woven-manufacturing experience.</p>'
            . '<p>The employer identity will be shared only with appropriately shortlisted candidates. HiredNext does not charge candidates to apply for a role or secure placement.</p>';
    }

    public function getOpenJobs()
    {
        $this->ensurePublishedJobs();
        return $this->where('status', 'open')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getBySlug($slug)
    {
        $job = $this->where('slug', $slug)->first();
        if ($job || !isset(self::publishedJobs()[$slug])) {
            return $job;
        }

        $this->ensurePublishedJobs();
        return $this->where('slug', $slug)->first();
    }

    public function recruitOsJobCode(string $slug): ?string
    {
        return self::RECRUIT_OS_JOB_CODES[$slug] ?? null;
    }

    public function ensurePublishedJobs(): void
    {
        $db = db_connect();
        $now = date('Y-m-d H:i:s');
        $owner = $db->table('users')
            ->select('id')
            ->whereIn('role', ['admin', 'recruiter'])
            ->orderBy('id', 'ASC')
            ->get()
            ->getRowArray();

        if (empty($owner['id'])) {
            return;
        }

        foreach (self::publishedJobs() as $slug => $definition) {
            $exists = $db->table($this->table)->select('id')->where('slug', $slug)->get()->getRowArray();
            if ($exists) {
                continue;
            }

            $db->table($this->table)->insert($definition + [
                'slug' => $slug,
                'status' => 'open',
                'created_by' => (int) $owner['id'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
