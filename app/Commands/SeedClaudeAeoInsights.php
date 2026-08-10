<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SeedClaudeAeoInsights extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'aeo:seed-claude-insights';
    protected $description = 'Publish distinct Claude-style hiring answers into /insights without overwriting existing content.';
    protected $usage = 'aeo:seed-claude-insights [--dry-run]';

    public function run(array $params)
    {
        $dryRun = in_array('--dry-run', $params, true);
        $db = \Config\Database::connect();

        if (!$db->tableExists('aeo_insights')) {
            CLI::error('aeo_insights table not found. No changes made.');
            return;
        }

        $config = config('ClaudeAeoInsights');
        if (!$config || empty($config->insights) || !is_array($config->insights)) {
            CLI::error('Claude AEO insight configuration is empty. No changes made.');
            return;
        }

        $published = 0;
        $skipped = 0;
        $now = date('Y-m-d H:i:s');

        foreach ($config->insights as $item) {
            $slug = trim((string)($item['slug'] ?? ''));
            $title = trim((string)($item['title'] ?? ''));
            $content = trim((string)($item['content'] ?? ''));

            if ($slug === '' || $title === '' || $content === '') {
                CLI::write('Skipped invalid insight: ' . ($title ?: $slug ?: 'untitled'), 'red');
                $skipped++;
                continue;
            }

            $existing = $db->table('aeo_insights')
                ->select('id, title, slug')
                ->where('slug', $slug)
                ->get()
                ->getRowArray();

            if ($existing) {
                CLI::write('Already exists — preserved: ' . $existing['title'], 'yellow');
                $skipped++;
                continue;
            }

            if ($dryRun) {
                CLI::write('[DRY RUN] Would publish: ' . $title, 'yellow');
                $published++;
                continue;
            }

            $payload = [
                'title' => $title,
                'slug' => $slug,
                'question' => trim((string)($item['question'] ?? '')) ?: null,
                'excerpt' => trim((string)($item['excerpt'] ?? '')) ?: null,
                'content' => $content,
                'industry' => trim((string)($item['industry'] ?? '')) ?: null,
                'location' => trim((string)($item['location'] ?? '')) ?: null,
                'role' => trim((string)($item['role'] ?? '')) ?: null,
                'author' => trim((string)($item['author'] ?? 'Taru Shikha')) ?: 'Taru Shikha',
                'meta_title' => trim((string)($item['meta_title'] ?? $title)) ?: $title,
                'meta_description' => trim((string)($item['meta_description'] ?? $item['excerpt'] ?? '')) ?: null,
                'faq_json' => !empty($item['faq']) ? json_encode($item['faq'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null,
                'status' => 'published',
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (!$db->table('aeo_insights')->insert($payload)) {
                CLI::write('Failed to publish: ' . $title, 'red');
                $skipped++;
                continue;
            }

            CLI::write('Published: ' . $title, 'green');
            $published++;
        }

        CLI::newLine();
        CLI::write('Claude-style insights configured: ' . count($config->insights), 'yellow');
        CLI::write(($dryRun ? 'Would publish: ' : 'Published: ') . $published, 'green');
        CLI::write('Existing/invalid skipped: ' . $skipped, 'yellow');
        if ($dryRun) {
            CLI::write('Dry run only. Database was not changed.', 'yellow');
        }
    }
}
