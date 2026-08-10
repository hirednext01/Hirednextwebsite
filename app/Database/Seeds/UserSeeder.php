<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Clear existing users
        $db->query('SET FOREIGN_KEY_CHECKS = 0');
        $db->table('users')->truncate();
        $db->query('SET FOREIGN_KEY_CHECKS = 1');

        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@metronworld.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'name' => 'Administrator',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'editor',
                'email' => 'editor@metronworld.com',
                'password' => password_hash('editor123', PASSWORD_DEFAULT),
                'name' => 'Content Editor',
                'role' => 'editor',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $db->table('users')->insertBatch($users);

        echo "Seeded " . count($users) . " users successfully.\n";
    }
}
