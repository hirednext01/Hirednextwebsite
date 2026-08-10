<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('WebsiteSettingsSeeder');
        $this->call('ServicesSeeder');
        $this->call('ClientsSeeder');
        $this->call('TeamSeeder');
        $this->call('UserSeeder');
        // Add other seeders as needed
    }
}
