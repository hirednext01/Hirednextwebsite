<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Clear existing services
        $db->table('services')->truncate();

        $services = [
            [
                'icon' => 'fa-solid fa-tools',
                'title' => 'Fabrication Work',
                'slug' => 'fabrication',
                'description' => 'Precision-driven fabrication services for structural requirements.',
                'image' => 'images/fabrication/1.jpeg',
                'features' => json_encode(['Structural Steel', 'Metal Fabrication', 'Precision Welding', 'Custom Designs']),
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'icon' => 'fa-solid fa-paint-roller',
                'title' => 'Interior Work',
                'slug' => 'interior',
                'description' => 'Complete interior solutions focused on functionality and aesthetics.',
                'image' => 'images/interior/1.jpg',
                'features' => json_encode(['Space Planning', 'Custom Furniture', 'Lighting Design', 'Color Consultation']),
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'icon' => 'fa-solid fa-leaf',
                'title' => 'Plantation',
                'slug' => 'plantation',
                'description' => 'Sustainable green solutions and landscaping for urban spaces.',
                'image' => 'images/plantation/1.jpg',
                'features' => json_encode(['Vertical Gardens', 'Urban Landscaping', 'Indoor Plants', 'Maintenance']),
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'icon' => 'fa-solid fa-utensils',
                'title' => 'Metron Kitchen',
                'slug' => 'kitchen',
                'description' => 'Modern, ergonomic, and stylish cloud kitchen setups.',
                'image' => 'images/kitchen/1.jpg',
                'features' => json_encode(['Cloud Kitchens', 'Commercial Equipment', 'Ergonomic Design', 'Quick Setup']),
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'icon' => 'fa-solid fa-mobile-screen',
                'title' => 'Metron App',
                'slug' => 'app',
                'description' => 'Digital ecosystem seamlessly integrated with our physical services.',
                'image' => 'images/app/1.jpg',
                'features' => json_encode(['Project Management', 'Client Portal', 'Service Tracking', 'Digital Payments']),
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'icon' => 'fa-solid fa-building',
                'title' => 'Exterior Work',
                'slug' => 'exterior',
                'description' => 'Durable and weather-resistant solutions for strength and safety.',
                'image' => 'images/exterior/1.jpg',
                'features' => json_encode(['Façade Design', 'Weatherproofing', 'Structural Integrity', 'Exterior Finishing']),
                'status' => 'active',
                'sort_order' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $db->table('services')->insertBatch($services);

        echo "Seeded " . count($services) . " services successfully.\n";
    }
}

