<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCvAnalysisTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'lead_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 40, 'default' => 'queued'],
            'service_tier' => ['type' => 'VARCHAR', 'constraint' => 40, 'default' => 'free'],
            'extracted_text' => ['type' => 'LONGTEXT', 'null' => true],
            'extraction_meta' => ['type' => 'LONGTEXT', 'null' => true],
            'provider_status_json' => ['type' => 'LONGTEXT', 'null' => true],
            'synthesis_json' => ['type' => 'LONGTEXT', 'null' => true],
            'error_message' => ['type' => 'TEXT', 'null' => true],
            'started_at' => ['type' => 'DATETIME', 'null' => true],
            'completed_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('lead_id');
        $this->forge->addKey('status');
        $this->forge->createTable('cv_analysis_runs', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'analysis_run_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'reviewer' => ['type' => 'VARCHAR', 'constraint' => 60],
            'category' => ['type' => 'VARCHAR', 'constraint' => 100],
            'finding' => ['type' => 'TEXT'],
            'evidence' => ['type' => 'TEXT'],
            'why_it_matters' => ['type' => 'TEXT'],
            'severity' => ['type' => 'VARCHAR', 'constraint' => 12, 'default' => 'medium'],
            'recommendation' => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('analysis_run_id');
        $this->forge->addKey('category');
        $this->forge->createTable('cv_analysis_findings', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'lead_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'analysis_run_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'version' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'draft'],
            'report_json' => ['type' => 'LONGTEXT', 'null' => true],
            'report_text' => ['type' => 'LONGTEXT', 'null' => true],
            'human_notes' => ['type' => 'LONGTEXT', 'null' => true],
            'approved_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'approved_at' => ['type' => 'DATETIME', 'null' => true],
            'sent_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('lead_id');
        $this->forge->addKey('analysis_run_id');
        $this->forge->addKey('status');
        $this->forge->createTable('cv_report_versions', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'lead_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'event_type' => ['type' => 'VARCHAR', 'constraint' => 80],
            'actor_type' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'system'],
            'actor_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'channel' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'outcome' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'metadata_json' => ['type' => 'LONGTEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('lead_id');
        $this->forge->addKey('event_type');
        $this->forge->createTable('cv_review_events', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'lead_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'report_version_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'event_type' => ['type' => 'VARCHAR', 'constraint' => 80],
            'recipient' => ['type' => 'VARCHAR', 'constraint' => 255],
            'subject' => ['type' => 'VARCHAR', 'constraint' => 255],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'attempted'],
            'provider_message_id' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'error_message' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('lead_id');
        $this->forge->addKey('event_type');
        $this->forge->addKey('status');
        $this->forge->createTable('cv_email_events', true);
    }

    public function down()
    {
        $this->forge->dropTable('cv_email_events', true);
        $this->forge->dropTable('cv_review_events', true);
        $this->forge->dropTable('cv_report_versions', true);
        $this->forge->dropTable('cv_analysis_findings', true);
        $this->forge->dropTable('cv_analysis_runs', true);
    }
}
