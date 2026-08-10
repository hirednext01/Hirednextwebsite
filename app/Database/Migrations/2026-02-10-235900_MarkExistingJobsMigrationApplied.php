<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MarkExistingJobsMigrationApplied extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        $exists = $db->table('migrations')
            ->where('version', '2026-02-11-000001')
            ->countAllResults();

        if ($exists === 0) {
            $db->table('migrations')->insert([
                'version'   => '2026-02-11-000001',
                'class'     => 'AddJobsAndRecruiter',
                'group'     => 'default',
                'namespace' => 'App',
                'time'      => time(),
                'batch'     => 5,
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();

        $db->table('migrations')
            ->where('version', '2026-02-11-000001')
            ->delete();
    }
}
