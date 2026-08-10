<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCandidateTestimonialSubmissionFields extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('reviews')) {
            return;
        }

        $fields = array_flip($this->db->getFieldNames('reviews'));
        $columns = [];

        if (!isset($fields['submitter_email'])) {
            $columns['submitter_email'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'source_url',
            ];
        }
        if (!isset($fields['submitter_phone'])) {
            $columns['submitter_phone'] = [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'submitter_email',
            ];
        }
        if (!isset($fields['help_received'])) {
            $columns['help_received'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'submitter_phone',
            ];
        }
        if (!isset($fields['future_support'])) {
            $columns['future_support'] = [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'help_received',
            ];
        }
        if (!isset($fields['publish_consent'])) {
            $columns['publish_consent'] = [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'future_support',
            ];
        }
        if (!isset($fields['submitted_via'])) {
            $columns['submitted_via'] = [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'publish_consent',
            ];
        }

        if ($columns) {
            $this->forge->addColumn('reviews', $columns);
        }
    }

    public function down()
    {
        if (!$this->db->tableExists('reviews')) {
            return;
        }

        $fields = array_flip($this->db->getFieldNames('reviews'));
        foreach (['submitted_via', 'publish_consent', 'future_support', 'help_received', 'submitter_phone', 'submitter_email'] as $field) {
            if (isset($fields[$field])) {
                $this->forge->dropColumn('reviews', $field);
            }
        }
    }
}
