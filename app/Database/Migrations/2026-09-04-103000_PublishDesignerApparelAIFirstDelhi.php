<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublishDesignerApparelAIFirstDelhi extends Migration
{
    private const SLUG = 'designer-apparel-ai-first-delhi';

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
            'title' => 'Designer — Apparel / AI-First',
            'slug' => self::SLUG,
            'location' => 'Delhi',
            'type' => 'full-time',
            'department' => 'Apparel Design / Buying House',
            'experience' => '7+ years',
            'status' => 'open',
            'description' => <<<'HTML'
<p><strong>CONFIDENTIAL SEARCH</strong></p>
<p><strong>Buying House | Delhi</strong></p>
<p><strong>Designer — Apparel / AI-First</strong></p>

<p>HiredNext is managing a confidential search for a buying house in Delhi seeking a hands-on apparel designer who can combine strong product fundamentals with AI-enabled design execution.</p>

<p>This role is suited to someone who can work lean, move quickly and take ownership across design, fabric, tech packs and digital tools while supporting international buyer requirements.</p>

<h3>What we are looking for</h3>
<ul>
    <li><strong>7+ years of relevant apparel design experience.</strong></li>
    <li>Strong hands-on capability in <strong>fabric sourcing</strong>.</li>
    <li>Good working knowledge of <strong>tech pack creation</strong>.</li>
    <li>Proficiency in <strong>Adobe Illustrator and Adobe Photoshop</strong>.</li>
    <li>Hands-on use of <strong>ChatGPT or other AI design tools</strong> as part of the design workflow.</li>
    <li>Graphics capability alongside apparel design is a strong plus, particularly for a lean team environment.</li>
    <li>Extensive exposure to <strong>UK and European brands</strong>, with experience relevant to markets such as <strong>France and Spain</strong>.</li>
</ul>

<h3>Location and travel</h3>
<ul>
    <li><strong>Delhi office location</strong> — candidates should be comfortable working from Delhi.</li>
    <li><strong>Frequent travel to Dhaka</strong> will be an important part of the role, and candidates must be comfortable with this requirement.</li>
</ul>

<h3>Compensation</h3>
<p><strong>As per market</strong>, aligned to experience, capability and fit.</p>

<h3>Who will fit this role well</h3>
<p>A strong apparel designer who understands product end to end, can source and translate fabric ideas into executable tech packs, is digitally fluent, and is already using AI as a practical design tool rather than treating it as a future concept.</p>

<p>Candidates who can additionally handle graphics will have a clear advantage because the team is being built lean.</p>

<h3>How to apply confidentially</h3>
<p>Apply through the form on this page or email <strong>jobs@hirednext.info</strong>.</p>
<p>Please share your CV, portfolio, current location, current compensation, expected compensation, notice period, and confirmation that you are comfortable with the Delhi office location and frequent travel to Dhaka.</p>

<p>HiredNext never charges candidates to apply for a role or secure placement.</p>
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
