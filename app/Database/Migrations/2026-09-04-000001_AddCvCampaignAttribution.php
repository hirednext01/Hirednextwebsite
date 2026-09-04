<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCvCampaignAttribution extends Migration
{
    public function up()
    {
        $fields = [];
        foreach (['first_touch_source', 'first_touch_medium', 'first_touch_campaign', 'first_touch_content', 'latest_touch_source', 'latest_touch_medium', 'latest_touch_campaign', 'latest_touch_content'] as $name) {
            $fields[$name] = ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true];
        }
        $this->forge->addColumn('cv_assessment_leads', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('cv_assessment_leads', ['first_touch_source', 'first_touch_medium', 'first_touch_campaign', 'first_touch_content', 'latest_touch_source', 'latest_touch_medium', 'latest_touch_campaign', 'latest_touch_content']);
    }
}
