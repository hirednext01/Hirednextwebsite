<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddReviewDesignationField extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('reviews')) {
            return;
        }

        $fields = array_flip($this->db->getFieldNames('reviews'));
        if (!isset($fields['designation'])) {
            $this->forge->addColumn('reviews', [
                'designation' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'name',
                ],
            ]);
        }

        // Source-linked reputation proof historically stored senior titles in
        // `location`. Backfill only external proof rows and never reinterpret
        // generic "Public ..." labels as a designation.
        $fieldsAfter = array_flip($this->db->getFieldNames('reviews'));
        if (isset($fieldsAfter['designation'], $fieldsAfter['location'], $fieldsAfter['status'])) {
            $this->db->query(
                "UPDATE reviews
                 SET designation = location
                 WHERE status = 'external'
                   AND (designation IS NULL OR designation = '')
                   AND location IS NOT NULL
                   AND location != ''
                   AND location NOT LIKE 'Public %'"
            );
        }
    }

    public function down()
    {
        if (!$this->db->tableExists('reviews')) {
            return;
        }

        $fields = array_flip($this->db->getFieldNames('reviews'));
        if (isset($fields['designation'])) {
            $this->forge->dropColumn('reviews', 'designation');
        }
    }
}
