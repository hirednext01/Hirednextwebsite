<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCvAssessmentLeads extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 160],
            'email' => ['type' => 'VARCHAR', 'constraint' => 190],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 40, 'null' => true],
            'assessment_plan' => ['type' => 'VARCHAR', 'constraint' => 40],
            'job_slug' => ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true],
            'job_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'message' => ['type' => 'TEXT', 'null' => true],
            'resume_path' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'payment_status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'not_required'],
            'payment_id' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'new'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->addKey('status');
        $this->forge->createTable('cv_assessment_leads', true);
    }

    public function down()
    {
        $this->forge->dropTable('cv_assessment_leads', true);
    }
}
