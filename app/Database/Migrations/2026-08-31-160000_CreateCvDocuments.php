<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCvDocuments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'lead_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'upgrade_order_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'analysis_run_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'template_key' => ['type' => 'VARCHAR', 'constraint' => 40, 'default' => 'ats_classic'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 40, 'default' => 'draft'],
            'content_json' => ['type' => 'LONGTEXT', 'null' => true],
            'writer_panel_json' => ['type' => 'LONGTEXT', 'null' => true],
            'clarifications_json' => ['type' => 'LONGTEXT', 'null' => true],
            'branding_mode' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'remove'],
            'revision_round' => ['type' => 'INT', 'constraint' => 3, 'default' => 0],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'delivered_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('lead_id');
        $this->forge->addKey('status');
        $this->forge->addKey(['lead_id', 'created_at']);
        $this->forge->createTable('cv_documents', true);
    }

    public function down()
    {
        $this->forge->dropTable('cv_documents', true);
    }
}
