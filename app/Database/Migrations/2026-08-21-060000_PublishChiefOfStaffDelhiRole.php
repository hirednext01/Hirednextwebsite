<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublishChiefOfStaffDelhiRole extends Migration
{
    private const SLUG = 'chief-of-staff-to-managing-director-delhi';

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
            'title' => 'Chief of Staff to the Managing Director',
            'slug' => self::SLUG,
            'location' => 'Delhi',
            'type' => 'full-time',
            'department' => "Managing Director's Office",
            'experience' => '5–8 years',
            'status' => 'open',
            'description' => <<<'HTML'
<p>HiredNext is hiring a <strong>Chief of Staff to the Managing Director</strong> for a company based in Delhi.</p>

<h3>Role overview</h3>
<p>This is a hands-on execution role for someone who can bring structure to the MD’s office, anticipate priorities and ensure that important commitments move to completion. The role combines business coordination, disciplined follow-through and trusted executive support.</p>

<h3>Key responsibilities</h3>
<ul>
    <li>Translate the MD’s priorities into clear actions, owners, timelines and follow-through.</li>
    <li>Coordinate closely with finance and other functional teams to obtain inputs, track decisions and close pending matters.</li>
    <li>Build practical systems for business reviews, meetings, documentation, calendars and priority tracking.</li>
    <li>Prepare concise briefs, management information, presentations and decision-ready updates for the MD.</li>
    <li>Monitor critical commitments and proactively flag delays, dependencies and decisions required.</li>
    <li>Coordinate important internal and external meetings and ensure actions are documented and completed.</li>
    <li>Manage selected personal scheduling and logistics for the MD with maturity, discretion and clear professional boundaries.</li>
    <li>Handle confidential business and personal information with absolute integrity.</li>
</ul>

<h3>Candidate profile</h3>
<ul>
    <li>5–8 years of relevant experience in an MD/CEO office, executive office, business coordination, PMO or high-ownership executive-assistance role.</li>
    <li>Exceptionally proactive, organised and dependable; able to anticipate needs without waiting for repeated direction.</li>
    <li>Strong follow-through and confidence coordinating with finance and cross-functional stakeholders.</li>
    <li>Excellent written and verbal communication, sound judgement and attention to detail.</li>
    <li>Comfortable switching between business priorities, executive coordination and selected personal support.</li>
    <li>Hands-on and execution-oriented; this is not a purely strategic or advisory Chief of Staff position.</li>
    <li>Must be based in Delhi NCR and able to work from Delhi.</li>
</ul>

<h3>What will make you successful</h3>
<p>You notice what may be missed, close loops without being chased, communicate early when something is at risk and make the MD’s office more organised and effective every week.</p>

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
