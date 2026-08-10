<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJobsAndRecruiter extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // Preserve the existing production users table and only ensure the
        // recruiter role is available when the table already exists.
        if ($db->tableExists('users')) {
            $this->forge->modifyColumn('users', [
                'role' => [
                    'type' => 'ENUM',
                    'constraint' => ['admin', 'manager', 'editor', 'recruiter'],
                    'default' => 'editor',
                ],
            ]);
        }

        // Production already has recruiter-created jobs. Never recreate,
        // truncate or replace this table if it exists.
        if (!$db->tableExists('jobs')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'title' => ['type' => 'VARCHAR', 'constraint' => 255],
                'slug' => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
                'location' => ['type' => 'VARCHAR', 'constraint' => 255],
                'type' => ['type' => 'ENUM', 'constraint' => ['full-time', 'part-time', 'contract', 'intern'], 'default' => 'full-time'],
                'description' => ['type' => 'TEXT'],
                'department' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'experience' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'status' => ['type' => 'ENUM', 'constraint' => ['draft', 'open', 'closed'], 'default' => 'draft'],
                'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('created_by');
            $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('jobs');
        }

        // Preserve all existing applications against their exact jobs.
        if (!$db->tableExists('job_applications')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'job_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'name' => ['type' => 'VARCHAR', 'constraint' => 100],
                'email' => ['type' => 'VARCHAR', 'constraint' => 100],
                'phone' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
                'linkedin' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'message' => ['type' => 'TEXT', 'null' => true],
                'resume_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'resume_name' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'resume_size' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
                'status' => ['type' => 'ENUM', 'constraint' => ['new', 'reviewed', 'shortlisted', 'rejected', 'hired'], 'default' => 'new'],
                'review_notes' => ['type' => 'TEXT', 'null' => true],
                'reviewed_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                'reviewed_at' => ['type' => 'DATETIME', 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('job_id');
            $this->forge->addKey('reviewed_by');
            $this->forge->addForeignKey('job_id', 'jobs', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('reviewed_by', 'users', 'id', 'SET NULL', 'SET NULL');
            $this->forge->createTable('job_applications');
        }
    }

    public function down()
    {
        // Intentionally non-destructive. These tables may contain recruiter-created
        // production jobs and candidate applications that pre-date migration tracking.
    }
}
