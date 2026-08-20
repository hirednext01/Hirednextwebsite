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
