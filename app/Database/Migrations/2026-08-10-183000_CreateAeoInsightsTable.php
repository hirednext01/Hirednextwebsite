<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAeoInsightsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255],
            'question' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'excerpt' => ['type' => 'TEXT', 'null' => true],
            'content' => ['type' => 'LONGTEXT'],
            'industry' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'location' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'role' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'author' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'meta_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description' => ['type' => 'VARCHAR', 'constraint' => 320, 'null' => true],
            'faq_json' => ['type' => 'LONGTEXT', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['status', 'published_at']);
        $this->forge->createTable('aeo_insights', true);
    }

    public function down()
    {
        $this->forge->dropTable('aeo_insights', true);
    }
}
