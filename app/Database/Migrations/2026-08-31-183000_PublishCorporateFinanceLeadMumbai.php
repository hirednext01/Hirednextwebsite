<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublishCorporateFinanceLeadMumbai extends Migration
{
    private const SLUG = 'corporate-finance-lead-mumbai';

    public function up()
    {
        $db = \Config\Database::connect();

        if (!$db->tableExists('jobs') || !$db->tableExists('users')) {
            return;
        }

        $owner = $db->table('users')
            ->select('id')
            ->whereIn('role', ['admin', 'recruiter'])
            ->orderBy('id', 'ASC')
            ->get()
            ->getRowArray();

        if (empty($owner['id'])) {
            return;
        }

        $now = date('Y-m-d H:i:s');
        $job = [
            'title' => 'Corporate Finance Lead',
            'slug' => self::SLUG,
            'location' => 'Mumbai',
            'type' => 'full-time',
            'department' => 'Corporate Finance / FP&A',
            'experience' => '3–6 years',
            'status' => 'open',
            'description' => <<<'HTML'
<p><strong>Job code: HN-CFL-0831</strong></p>
<p>HiredNext is managing a confidential search for a <strong>Corporate Finance Lead</strong> based in Mumbai. The role will drive financial planning, performance tracking and strategic insights, translating numbers into clear business decisions while strengthening financial discipline.</p>

<h3>Key responsibilities</h3>
<ul>
    <li>Lead annual budgeting and periodic forecasting across functions and business units.</li>
    <li>Track performance against plan, investigate key variances and recommend corrective actions.</li>
    <li>Build robust financial models to support business decisions and growth planning.</li>
    <li>Own and publish monthly financial reports and MIS.</li>
    <li>Deep-dive into business performance, identify risks and opportunities, and track agreed actions to closure.</li>
    <li>Analyse data to uncover trends, inefficiencies and growth levers.</li>
    <li>Partner with business teams to improve unit economics, margins and cost structures.</li>
    <li>Prepare investor updates, board presentations and founder-level reviews with clear financial storytelling.</li>
    <li>Manage end-to-end external audits and strengthen processes and controls in response to audit findings.</li>
</ul>

<h3>Candidate profile</h3>
<ul>
    <li><strong>Qualification:</strong> Chartered Accountant.</li>
    <li><strong>Experience:</strong> 3–6 years in Corporate Finance or FP&amp;A.</li>
    <li><strong>Mandatory industry background:</strong> Retail / Quick Commerce / FMCG / Hospitality.</li>
    <li>Hands-on SAP experience.</li>
    <li>Strong financial modelling, forecasting and analytical capability.</li>
    <li>Ability to translate data into clear business insights and drive decisions to execution.</li>
    <li>Strong communication for founder, investor and leadership interactions.</li>
    <li>Proven team-handling and stakeholder-management experience.</li>
    <li>High-growth or startup experience is advantageous.</li>
</ul>

<h3>Location and compensation</h3>
<p><strong>Mumbai | ₹30–35 LPA</strong>, depending on experience and fit.</p>

<p>The employer identity will be shared only with appropriately shortlisted candidates. HiredNext does not charge candidates to apply for a role or secure placement.</p>
HTML,
            'updated_at' => $now,
        ];

        $existing = $db->table('jobs')
            ->select('id')
            ->where('slug', self::SLUG)
            ->get()
            ->getRowArray();

        if ($existing) {
            $db->table('jobs')->where('id', $existing['id'])->update($job);
            return;
        }

        $job['created_by'] = (int) $owner['id'];
        $job['created_at'] = $now;
        $db->table('jobs')->insert($job);
    }

    public function down()
    {
        $db = \Config\Database::connect();

        if ($db->tableExists('jobs')) {
            $db->table('jobs')->where('slug', self::SLUG)->delete();
        }
    }
}
