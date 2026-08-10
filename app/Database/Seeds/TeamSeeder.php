<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Clear existing team members
        $db->table('team_members')->truncate();

        $team = [
            [
                'name' => 'Dr. Mujeeb Khan',
                'role' => 'Managing Director',
                'bio' => 'Visionary leader driving the growth of Metron World Group since 2017.',
                'image' => 'photo1.png',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Project Lead',
                'role' => 'Operations Manager',
                'bio' => 'Overseeing on-site execution and quality control across all verticals.',
                'image' => 'photo3.png',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Design Head',
                'role' => 'Creative Director',
                'bio' => 'Leading the interior and architectural design team.',
                'image' => 'photo4.png',
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Technical Lead',
                'role' => 'Chief Fabrication Engineer',
                'bio' => 'Expert in structural steel and precision metal works.',
                'image' => 'photo2.png',
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $db->table('team_members')->insertBatch($team);

        echo "Seeded " . count($team) . " Metron team members successfully.\n";
    }
}

