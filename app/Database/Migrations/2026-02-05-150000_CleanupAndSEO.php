<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CleanupAndSEO extends Migration
{
    public function up()
    {
        // 1. Drop unused tables
        $this->forge->dropTable('achievements', true);
        $this->forge->dropTable('industries', true);
        $this->forge->dropTable('partners', true);

        // 2. Add SEO fields to blog_posts
        $fields = [
            'meta_title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'author_name'
            ],
            'meta_description' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'meta_title'
            ],
            'meta_keywords' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'meta_description'
            ],
        ];
        $this->forge->addColumn('blog_posts', $fields);
    }

    public function down()
    {
        // Add back (simplified) if needed, but usually not for cleanup
        $this->forge->dropColumn('blog_posts', ['meta_title', 'meta_description', 'meta_keywords']);
    }
}
