<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublishTirupurFabricSourcingRole extends Migration
{
    private const SLUG = 'fabric-sourcing-rd-manager-knits-tirupur';

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
            'title' => 'Fabric Sourcing & R&D Manager – Knits',
            'slug' => self::SLUG,
            'location' => 'Tirupur, Tamil Nadu',
            'type' => 'full-time',
            'department' => 'Garments / Buying House',
            'experience' => '10+ years',
            'status' => 'open',
            'description' => <<<'HTML'
<p>HiredNext is hiring a <strong>Fabric Sourcing &amp; R&amp;D Manager – Knits</strong> for a reputed buying house in Tirupur.</p>

<h3>Role overview</h3>
<p>This role will lead fabric sourcing, research and development for knit apparel programs. The successful candidate will bring deep mill relationships, strong technical fabric understanding and a proven ability to develop commercially viable fabrics with mills in India and overseas.</p>

<h3>Key responsibilities</h3>
<ul>
    <li>Lead end-to-end sourcing and development of knitted fabrics for apparel programs.</li>
    <li>Identify, evaluate and develop mills in India and international sourcing markets.</li>
    <li>Drive fabric R&amp;D based on buyer briefs, design direction, performance requirements and commercial targets.</li>
    <li>Work closely with design, merchandising, product development, quality and production teams.</li>
    <li>Evaluate fabric construction, yarn, blends, GSM, finishes, performance, lead time, pricing and mill capability.</li>
    <li>Build a dependable mill base while improving innovation, cost, quality and speed to market.</li>
    <li>Manage sampling, trials, approvals, testing and commercialisation of new fabric developments.</li>
    <li>Track knit-fabric innovation, sustainability developments and relevant global market trends.</li>
</ul>

<h3>Candidate profile</h3>
<ul>
    <li>Minimum <strong>10 years of relevant experience</strong> in knit-fabric sourcing and R&amp;D.</li>
    <li>Strong technical understanding of knitted fabrics and knit apparel.</li>
    <li>Hands-on experience developing fabrics directly with mills.</li>
    <li>Established working relationships with mills in India; international mill-development experience is strongly preferred.</li>
    <li>Commercially strong, technically credible and confident in negotiations and cross-functional discussions.</li>
    <li>Buying-house, export-house or garment-industry experience relevant to global buyers.</li>
    <li>Current or previous experience working within the Tirupur knitwear ecosystem will be preferred.</li>
</ul>

<h3>Compensation</h3>
<p><strong>₹15–18 LPA</strong>, depending on experience and current compensation.</p>

<div class="rounded-2xl border border-orange-200 bg-orange-50 p-5 my-6">
    <h3>Mandatory application information</h3>
    <p>In the application message, candidates must clearly mention:</p>
    <ol>
        <li>The Indian mills they have sourced from or developed fabrics with.</li>
        <li>Any overseas mills or sourcing markets they have worked with.</li>
        <li>Two or three examples of knit fabrics they personally developed or commercialised.</li>
    </ol>
    <p><strong>Applications without these details may not be shortlisted by the hiring manager or HiredNext recruiter.</strong></p>
</div>

<p>HiredNext does not charge candidates to apply for a role or secure placement.</p>
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
