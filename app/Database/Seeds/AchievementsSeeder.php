<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Clear existing achievements
        $db->table('achievements')->truncate();
        
        $achievements = [
            [
                'title' => 'Years of Excellence',
                'year' => '19+',
                'description' => 'Delivering world-class laboratory referrals and healthcare solutions across Oman',
                'icon' => 'fa-calendar',
                'category' => 'Achievement',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Lives Impacted',
                'year' => 'Unlimited',
                'description' => 'Providing specialized and genetic testing services to patients nationwide',
                'icon' => 'fa-heart-pulse',
                'category' => 'Achievement',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Quality Assurance',
                'year' => '100%',
                'description' => 'Maintaining the highest standards of accuracy and service excellence',
                'icon' => 'fa-award',
                'category' => 'Achievement',
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Global Partnerships',
                'year' => '50+',
                'description' => 'Collaborating with leading international laboratories and healthcare brands',
                'icon' => 'fa-handshake',
                'category' => 'Achievement',
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Established',
                'year' => '2005',
                'description' => 'Originally JV with W.J. Towell LLC',
                'icon' => 'fa-calendar',
                'category' => 'Achievement',
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Grade Classification',
                'year' => 'Excellent',
                'description' => 'Ministry of Trade & Commerce',
                'icon' => 'fa-star',
                'category' => 'Achievement',
                'status' => 'active',
                'sort_order' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Employees',
                'year' => '35',
                'description' => 'Strong team serving Oman',
                'icon' => 'fa-users',
                'category' => 'Achievement',
                'status' => 'active',
                'sort_order' => 7,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $db->table('achievements')->insertBatch($achievements);
        
        echo "Seeded " . count($achievements) . " achievements successfully.\n";
    }
}
