<?php

namespace App\Models;

use CodeIgniter\Model;

class JobModel extends Model
{
    private const PUBLISHED_JOBS = [
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
        if ($job || !isset(self::PUBLISHED_JOBS[$slug])) {
            return $job;
        }

        $this->ensurePublishedJobs();
        return $this->where('slug', $slug)->first();
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

        foreach (self::PUBLISHED_JOBS as $slug => $definition) {
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
