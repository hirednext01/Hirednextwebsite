<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PartnersSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Clear existing partners
        $db->table('partners')->truncate();
        
        $partners = [
            [
                'name' => 'Cerba Research',
                'type' => 'lab',
                'description' => 'Leading international laboratory specializing in clinical research and diagnostic services with cutting-edge technology.',
                'logo' => 'https://placehold.co/150x80/2563eb/ffffff?text=Cerba',
                'website_url' => 'https://www.cerba.com',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Centogene',
                'type' => 'lab',
                'description' => 'Global leader in rare disease diagnostics and genetic testing with comprehensive genomic analysis capabilities.',
                'logo' => 'https://placehold.co/150x80/16a34a/ffffff?text=Centogene',
                'website_url' => 'https://www.centogene.com',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Pure Lab',
                'type' => 'lab',
                'description' => 'Specialized laboratory services focusing on clinical chemistry, hematology, and microbiology testing.',
                'logo' => 'https://placehold.co/150x80/dc2626/ffffff?text=Pure+Lab',
                'website_url' => 'https://www.purelab.com',
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'LabCorp',
                'type' => 'lab',
                'description' => 'Leading global life sciences company providing comprehensive clinical laboratory and drug development services.',
                'logo' => 'https://placehold.co/150x80/7c3aed/ffffff?text=LabCorp',
                'website_url' => 'https://www.labcorp.com',
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Mayo Clinic Laboratories',
                'type' => 'lab',
                'description' => 'World-renowned medical laboratory providing advanced diagnostic testing and clinical laboratory services.',
                'logo' => 'https://placehold.co/150x80/2563eb/ffffff?text=Mayo',
                'website_url' => 'https://www.mayocliniclabs.com',
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Quest Diagnostics',
                'type' => 'lab',
                'description' => 'Leading provider of diagnostic information services with comprehensive testing capabilities.',
                'logo' => 'https://placehold.co/150x80/16a34a/ffffff?text=Quest',
                'website_url' => 'https://www.questdiagnostics.com',
                'status' => 'active',
                'sort_order' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        // Insert partners
        $db->table('partners')->insertBatch($partners);
        
        echo "Seeded " . count($partners) . " partners successfully.\n";
    }
}

