<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTestimonialRelationshipFields extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('reviews')) {
            return;
        }

        $fields = array_flip($this->db->getFieldNames('reviews'));
        $columns = [];

        if (!isset($fields['relationship_type'])) {
            $columns['relationship_type'] = [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'submitted_via',
            ];
        }
        if (!isset($fields['placement_role'])) {
            $columns['placement_role'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'relationship_type',
            ];
        }
        if (!isset($fields['placement_location'])) {
            $columns['placement_location'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'placement_role',
            ];
        }
        if (!isset($fields['placement_year'])) {
            $columns['placement_year'] = [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
                'after' => 'placement_location',
            ];
        }

        if ($columns) {
            $this->forge->addColumn('reviews', $columns);
        }

        $fieldsAfter = array_flip($this->db->getFieldNames('reviews'));
        if (!isset($fieldsAfter['relationship_type'])) {
            return;
        }

        // Preserve every existing review while classifying only rows whose
        // relationship is already explicit in the stored evidence.
        if (isset($fieldsAfter['submitted_via'])) {
            $this->db->query(
                "UPDATE reviews
                 SET relationship_type = 'placed_candidate'
                 WHERE (relationship_type IS NULL OR relationship_type = '')
                   AND submitted_via = 'candidate_placement_testimonial_form'"
            );
        }

        if (isset($fieldsAfter['submitted_via'], $fieldsAfter['help_received'])) {
            $this->db->query(
                "UPDATE reviews
                 SET relationship_type = 'placed_candidate'
                 WHERE (relationship_type IS NULL OR relationship_type = '')
                   AND submitted_via = 'candidate_testimonial_form'
                   AND help_received = 'Helped me get hired'"
            );
            $this->db->query(
                "UPDATE reviews
                 SET relationship_type = 'candidate_professional'
                 WHERE (relationship_type IS NULL OR relationship_type = '')
                   AND submitted_via = 'candidate_testimonial_form'"
            );
        }

        if (isset($fieldsAfter['status'], $fieldsAfter['proof_type'])) {
            $this->db->query(
                "UPDATE reviews
                 SET relationship_type = 'candidate_professional'
                 WHERE (relationship_type IS NULL OR relationship_type = '')
                   AND status = 'external'
                   AND proof_type IN ('Candidate Experience', 'Career & Recruitment Support')"
            );
            $this->db->query(
                "UPDATE reviews
                 SET relationship_type = 'employer'
                 WHERE (relationship_type IS NULL OR relationship_type = '')
                   AND status = 'external'
                   AND proof_type IN (
                       'Employer Recruitment Experience',
                       'Employer Recruitment Delivery',
                       'Apparel & Textile Recruitment',
                       'Talent Evaluation',
                       'Recruitment Experience'
                   )"
            );
            $this->db->query(
                "UPDATE reviews
                 SET relationship_type = 'candidate_professional'
                 WHERE (relationship_type IS NULL OR relationship_type = '')
                   AND status = 'external'"
            );
        }
    }

    public function down()
    {
        if (!$this->db->tableExists('reviews')) {
            return;
        }

        $fields = array_flip($this->db->getFieldNames('reviews'));
        foreach (['placement_year', 'placement_location', 'placement_role', 'relationship_type'] as $field) {
            if (isset($fields[$field])) {
                $this->forge->dropColumn('reviews', $field);
            }
        }
    }
}
