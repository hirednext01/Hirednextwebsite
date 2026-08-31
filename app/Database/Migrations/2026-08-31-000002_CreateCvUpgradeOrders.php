<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCvUpgradeOrders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'lead_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'token' => ['type' => 'VARCHAR', 'constraint' => 64],
            'tier' => ['type' => 'VARCHAR', 'constraint' => 40],
            'service_name' => ['type' => 'VARCHAR', 'constraint' => 160],
            'amount' => ['type' => 'INT', 'constraint' => 11],
            'status' => ['type' => 'VARCHAR', 'constraint' => 40, 'default' => 'offered'],
            'payment_reference' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'offered_at' => ['type' => 'DATETIME', 'null' => true],
            'submitted_at' => ['type' => 'DATETIME', 'null' => true],
            'verified_at' => ['type' => 'DATETIME', 'null' => true],
            'delivered_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('token');
        $this->forge->addKey('lead_id');
        $this->forge->addKey('status');
        $this->forge->createTable('cv_upgrade_orders', true);
    }

    public function down()
    {
        $this->forge->dropTable('cv_upgrade_orders', true);
    }
}
