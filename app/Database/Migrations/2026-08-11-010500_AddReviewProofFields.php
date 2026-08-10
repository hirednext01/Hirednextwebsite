<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddReviewProofFields extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('reviews')) {
            return;
        }

        $fields = array_flip($this->db->getFieldNames('reviews'));
        $columns = [];

        if (!isset($fields['name'])) {
            $columns['name'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'client_name',
            ];
        }
        if (!isset($fields['proof_type'])) {
            $columns['proof_type'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'project_type',
            ];
        }
        if (!isset($fields['source_label'])) {
            $columns['source_label'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'proof_type',
            ];
        }
        if (!isset($fields['source_url'])) {
            $columns['source_url'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'source_label',
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
        foreach (['source_url', 'source_label', 'proof_type', 'name'] as $field) {
            if (isset($fields[$field])) {
                $this->forge->dropColumn('reviews', $field);
            }
        }
    }
}
