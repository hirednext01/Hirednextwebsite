<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WebsiteSettingsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Clear existing settings
        $db->table('website_settings')->truncate();

        $settings = [
            [
                'setting_key' => 'site_name',
                'setting_value' => 'Metron World Group – Legacy Since 1960',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'site_description',
                'setting_value' => 'Metron World Group is a legacy-driven multi-service organization delivering integrated infrastructure and digital solutions since 1960.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'site_keywords',
                'setting_value' => 'infrastructure, interior design, fabrication, plantation, delhi ncr, metron world',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'company_name',
                'setting_value' => 'Metron World Group',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'company_address',
                'setting_value' => 'Jalpura, Bishrakh Road, Sector 1, Greater Noida – 201306',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'contact_phone',
                'setting_value' => '+91 98100 90506',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'contact_email',
                'setting_value' => 'info@metronworld.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'hero_badge',
                'setting_value' => 'Established 1960',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'legacy_years',
                'setting_value' => '60+',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'legacy_years_num',
                'setting_value' => '60',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'experience_years_num',
                'setting_value' => '17',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'projects_delivered_num',
                'setting_value' => '500',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'verticals_count',
                'setting_value' => '6',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $db->table('website_settings')->insertBatch($settings);

        echo "Seeded " . count($settings) . " website settings successfully.\n";
    }
}

