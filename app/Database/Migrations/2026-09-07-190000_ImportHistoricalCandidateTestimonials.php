<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\HistoricalTestimonials;

class ImportHistoricalCandidateTestimonials extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('reviews')) {
            return;
        }

        $existingFields = array_flip($db->getFieldNames('reviews'));
        $add = [];
        $definitions = [
            'company' => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'designation' => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'original_comment' => ['type' => 'TEXT', 'null' => true],
            'evidence_image_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'placement_date' => ['type' => 'DATE', 'null' => true],
        ];
        foreach ($definitions as $field => $definition) {
            if (!isset($existingFields[$field])) {
                $add[$field] = $definition;
            }
        }
        if ($add) {
            $this->forge->addColumn('reviews', $add);
        }

        $fields = array_flip($db->getFieldNames('reviews'));
        foreach (HistoricalTestimonials::all() as $row) {
            $email = trim((string)($row['submitter_email'] ?? ''));
            $name = trim((string)($row['client_name'] ?? $row['name'] ?? ''));
            $existing = null;

            if ($email !== '' && isset($fields['submitter_email'])) {
                $existing = $db->table('reviews')->where('submitter_email', $email)->get()->getRowArray();
            }
            if (!$existing && $name !== '') {
                $existing = $db->table('reviews')->where('client_name', $name)->get()->getRowArray();
            }

            $data = array_intersect_key($row, $fields);
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data = array_intersect_key($data, $fields);

            if ($existing) {
                $db->table('reviews')->where('id', (int)$existing['id'])->update($data);
            } else {
                $db->table('reviews')->insert($data);
            }
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('reviews')) {
            return;
        }
        $fields = array_flip($db->getFieldNames('reviews'));
        if (!isset($fields['submitted_via'])) {
            return;
        }
        $db->table('reviews')->where('submitted_via', 'legacy_candidate_testimonial_form')->delete();
    }
}
