<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Clear existing clients
        $db->table('clients')->truncate();

        $clients = [
            [
                'name' => 'Corporate Client 1',
                'logo' => 'images/logo/1.png',
                'website' => null,
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Corporate Client 2',
                'logo' => 'images/logo/2.png',
                'website' => null,
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Noida Commercial',
                'logo' => 'images/logo/3.jpeg',
                'website' => null,
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Delhi Infrastructure',
                'logo' => 'images/logo/4.jpg',
                'website' => null,
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Metron Partner',
                'logo' => 'images/logo/5.png',
                'website' => null,
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $db->table('clients')->insertBatch($clients);

        echo "Seeded " . count($clients) . " clients successfully.\n";
    }
}

