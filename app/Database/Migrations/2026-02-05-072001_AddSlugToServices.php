<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSlugToServices extends Migration
{
    public function up()
    {
        $this->forge->addColumn('services', [
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'title',
                'unique' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('services', 'slug');
    }
}
