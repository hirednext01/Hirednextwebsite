<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublishHubliWovenManufacturingRoles extends Migration
{
    private const JOBS = [
        'dgm-operations-woven-manufacturing-hubli' => [
            'code' => 'HN-HBL-0910-01', 'title' => 'DGM – Operations', 'experience' => '15–20 years',
            'salary' => '₹2.5–3.5 lakh per month', 'qualification' => 'BE in Textile or any BE graduate', 'positions' => 1,
        ],
        'manager-industrial-engineering-woven-hubli' => [
            'code' => 'HN-HBL-0910-02', 'title' => 'Manager – IE', 'experience' => '10–15 years',
            'salary' => '₹1.5–1.75 lakh per month', 'qualification' => 'BE in Textile or any BE graduate', 'positions' => 2,
        ],
        'manager-planning-woven-manufacturing-hubli' => [
            'code' => 'HN-HBL-0910-03', 'title' => 'Manager – Planning', 'experience' => '10–15 years',
            'salary' => '₹1–1.25 lakh per month', 'qualification' => 'BE in Textile or any BE graduate', 'positions' => 1,
        ],
        'manager-quality-woven-manufacturing-hubli' => [
            'code' => 'HN-HBL-0910-04', 'title' => 'Manager – Quality', 'experience' => '10–15 years',
            'salary' => '₹1–1.25 lakh per month', 'qualification' => 'BE in Textile or any BE graduate', 'positions' => 2,
        ],
        'dispatch-executive-woven-manufacturing-hubli' => [
            'code' => 'HN-HBL-0910-05', 'title' => 'Dispatch Executive', 'experience' => '5–10 years',
            'salary' => '₹50,000–75,000 per month', 'qualification' => 'PUC / Graduate', 'positions' => 1,
        ],
        'assistant-quality-manager-woven-hubli' => [
            'code' => 'HN-HBL-0910-06', 'title' => 'Assistant Quality Manager', 'experience' => '5–10 years',
            'salary' => '₹60,000–75,000 per month', 'qualification' => 'Any graduate', 'positions' => 2,
        ],
        'assistant-production-manager-woven-hubli' => [
            'code' => 'HN-HBL-0910-07', 'title' => 'Assistant Production Manager', 'experience' => '5–10 years',
            'salary' => '₹75,000–85,000 per month', 'qualification' => 'SSLC', 'positions' => 1,
        ],
        'assistant-manager-industrial-engineering-woven-hubli' => [
            'code' => 'HN-HBL-0910-08', 'title' => 'Assistant Manager – IE', 'experience' => '5–10 years',
            'salary' => '₹75,000–85,000 per month', 'qualification' => 'BE in Textile or any BE graduate', 'positions' => 2,
        ],
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

        $builder = $db->table('jobs');
        $now = date('Y-m-d H:i:s');

        foreach (self::JOBS as $slug => $role) {
            $data = [
                'title' => $role['title'] . ' | Apparel / Garment Manufacturing',
                'slug' => $slug,
                'location' => 'Hubli / Dharwad, Karnataka',
                'type' => 'full-time',
                'department' => 'Apparel / Garment Manufacturing – Wovens',
                'experience' => $role['experience'],
                'status' => 'open',
                'description' => $this->description($slug, $role),
                'updated_at' => $now,
            ];

            $existing = $builder->select('id')->where('slug', $slug)->get()->getRowArray();
            if ($existing) {
                $builder->where('id', $existing['id'])->update($data);
                continue;
            }

            $data['created_by'] = (int) $owner['id'];
            $data['created_at'] = $now;
            $builder->insert($data);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if ($db->tableExists('jobs')) {
            $db->table('jobs')->whereIn('slug', array_keys(self::JOBS))->delete();
        }
    }

    private function description(string $slug, array $role): string
    {
        $posterUrl = base_url('theme/assets/jobs/' . $slug . '.svg');
        $title = esc($role['title']);
        $code = esc($role['code']);
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
            . '<li><strong>Salary range:</strong> ' . esc($role['salary']) . '.</li>'
            . '<li><strong>Qualification:</strong> ' . esc($role['qualification']) . '.</li>'
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
}
