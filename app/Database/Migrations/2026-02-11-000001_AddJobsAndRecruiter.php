<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJobsAndRecruiter extends Migration
{
    public function up()
    {
        // Update users.role enum to include recruiter
        $this->forge->modifyColumn('users', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'manager', 'editor', 'recruiter'],
                'default' => 'editor',
            ],
        ]);

        // Jobs table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['full-time', 'part-time', 'contract', 'intern'],
                'default' => 'full-time',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'department' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'experience' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'open', 'closed'],
                'default' => 'draft',
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('created_by');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jobs');

        // Job applications table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true,
            ],
            'linkedin' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'resume_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'resume_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'resume_size' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['new', 'reviewed', 'shortlisted', 'rejected', 'hired'],
                'default' => 'new',
            ],
            'review_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'reviewed_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'reviewed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('job_id');
        $this->forge->addKey('reviewed_by');
        $this->forge->addForeignKey('job_id', 'jobs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reviewed_by', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('job_applications');
    }

    public function down()
    {
        $this->forge->dropTable('job_applications', true);
        $this->forge->dropTable('jobs', true);

        // Revert users.role enum
        $this->forge->modifyColumn('users', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'manager', 'editor'],
                'default' => 'editor',
            ],
        ]);
    }
}
