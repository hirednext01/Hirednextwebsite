<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublishBangladeshBuyingHouseRoles extends Migration
{
    private const SLUGS = [
        'product-development-manager-bangladesh-buying-house',
        'design-marketing-manager-wovens-bangladesh',
    ];

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
        $jobs = [
            [
                'title' => 'Product Development Manager – Buying House',
                'slug' => self::SLUGS[0],
                'location' => 'Bangladesh',
                'type' => 'full-time',
                'department' => 'Garments / Buying House',
                'experience' => 'Relevant leadership experience',
                'status' => 'open',
                'description' => <<<'HTML'
<p>HiredNext is hiring a <strong>Product Development Manager</strong> for a reputed buying house in Bangladesh.</p>
<h3>Role requirements</h3>
<ul>
    <li>Strong product-development experience in the garments industry.</li>
    <li>Proven experience handling US clients and understanding their product, quality and delivery expectations.</li>
    <li>Ability to lead, guide and manage a product-development team.</li>
    <li>Strong coordination skills across design, merchandising, sourcing and production teams.</li>
    <li>Experience working with a buying house is strongly preferred.</li>
    <li>Candidates must be currently based in Bangladesh.</li>
</ul>
<p>This role is suited to a hands-on product-development leader who can combine client understanding, commercial awareness and strong team management.</p>
HTML,
            ],
            [
                'title' => 'Design & Marketing Manager – Wovens',
                'slug' => self::SLUGS[1],
                'location' => 'Bangladesh',
                'type' => 'full-time',
                'department' => 'Garments / Buying House',
                'experience' => 'Strong woven-garment experience',
                'status' => 'open',
                'description' => <<<'HTML'
<p>HiredNext is hiring a <strong>Design &amp; Marketing Manager – Wovens</strong> for a reputed buying house in Bangladesh.</p>
<h3>Role requirements</h3>
<ul>
    <li>Excellent understanding of woven garments, product development, construction, fabrics and market trends.</li>
    <li>Ability to translate product and design strengths into a compelling client proposition.</li>
    <li>Strong marketing and business-development capability.</li>
    <li>Proven ability to open doors, build relationships and create business opportunities with buying houses and international buyers.</li>
    <li>Commercially sharp, relationship-driven and confident in client presentations and product discussions.</li>
    <li>Candidates must be currently based in Bangladesh.</li>
</ul>
<p>This role is ideal for someone who combines deep woven-product knowledge with the market credibility and persistence needed to win new business.</p>
HTML,
            ],
        ];

        $db->transStart();

        foreach ($jobs as $job) {
            $existing = $db->table('jobs')
                ->select('id')
                ->where('slug', $job['slug'])
                ->get()
                ->getRowArray();

            $job['updated_at'] = $now;

            if ($existing) {
                $db->table('jobs')->where('id', $existing['id'])->update($job);
                continue;
            }

            $job['created_by'] = (int) $owner['id'];
            $job['created_at'] = $now;
            $db->table('jobs')->insert($job);
        }

        $db->transComplete();
    }

    public function down()
    {
        $db = \Config\Database::connect();

        if ($db->tableExists('jobs')) {
            $db->table('jobs')->whereIn('slug', self::SLUGS)->delete();
        }
    }
}
