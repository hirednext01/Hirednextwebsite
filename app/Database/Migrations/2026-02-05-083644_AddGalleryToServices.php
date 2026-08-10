<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGalleryToServices extends Migration
{
    public function up()
    {
        $fields = [
            'gallery' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'features'
            ],
        ];
        $this->forge->addColumn('services', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('services', 'gallery');
    }
}
