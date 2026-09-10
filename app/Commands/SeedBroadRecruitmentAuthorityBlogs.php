<?php

namespace App\Commands;

use App\Libraries\BlogSearchOptimizer;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SeedBroadRecruitmentAuthorityBlogs extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'blog:seed-broad-recruitment-authority';
    protected $description = 'Publish missing broad India recruitment authority articles without overwriting existing posts.';
    protected $usage = 'blog:seed-broad-recruitment-authority [--dry-run]';

    public function run(array $params)
    {
        $dryRun = in_array('--dry-run', $params, true);
        $db = \Config\Database::connect();

        if (!$db->tableExists('blog_posts')) {
            CLI::error('blog_posts table not found. No changes made.');
            return;
        }

        $config = config('BroadRecruitmentAuthorityBlogs');
        if (!$config || empty($config->posts) || !is_array($config->posts)) {
            CLI::error('Broad recruitment authority blog configuration is empty. No changes made.');
            return;
        }

        $optimizer = new BlogSearchOptimizer();
        $created = 0;
        $preserved = 0;
        $skipped = 0;

        foreach ($config->posts as $post) {
            $slug = trim((string)($post['slug'] ?? ''));
            $title = trim((string)($post['title'] ?? ''));
            $content = trim((string)($post['content'] ?? ''));

            if ($slug === '' || $title === '' || $content === '') {
                CLI::write('Skipped invalid configured article: ' . ($title ?: $slug ?: 'untitled'), 'red');
                $skipped++;
                continue;
            }

            $existing = $db->table('blog_posts')
                ->select('id, title, slug')
                ->where('slug', $slug)
                ->get()
                ->getRowArray();

            if ($existing) {
                CLI::write('Existing article preserved: ' . $existing['title'], 'yellow');
                $preserved++;
                continue;
            }

            $base = [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'excerpt' => trim((string)($post['excerpt'] ?? '')),
                'featured_image' => trim((string)($post['featured_image'] ?? '')),
                'category' => trim((string)($post['category'] ?? 'Recruitment Strategy')) ?: 'Recruitment Strategy',
                'tags' => trim((string)($post['tags'] ?? '')),
                'author_name' => trim((string)($post['author_name'] ?? 'Taru Shikha')) ?: 'Taru Shikha',
                'meta_title' => trim((string)($post['meta_title'] ?? $title)),
                'meta_description' => trim((string)($post['meta_description'] ?? $post['excerpt'] ?? '')),
                'meta_keywords' => trim((string)($post['meta_keywords'] ?? $post['tags'] ?? '')),
            ];

            $optimized = $optimizer->optimise($base, true);
            $now = date('Y-m-d H:i:s');
            $payload = array_merge($base, $optimized, [
                'status' => 'published',
                'sort_order' => 0,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if ($dryRun) {
                CLI::write('[DRY RUN] Would publish: ' . $title, 'green');
                $created++;
                continue;
            }

            if (!$db->table('blog_posts')->insert($payload)) {
                CLI::write('Failed to publish: ' . $title, 'red');
                $skipped++;
                continue;
            }

            $created++;
            CLI::write('Published: ' . $title, 'green');
            $this->notifyIndexNow(base_url('blog/' . $slug));
        }

        CLI::newLine();
        CLI::write('Broad authority articles configured: ' . count($config->posts), 'yellow');
        CLI::write(($dryRun ? 'Would publish: ' : 'Published: ') . $created, 'green');
        CLI::write('Existing preserved: ' . $preserved, 'yellow');
        CLI::write('Skipped/failed: ' . $skipped, $skipped ? 'red' : 'yellow');
        if ($dryRun) CLI::write('Dry run only. Database was not changed.', 'yellow');
    }

    private function notifyIndexNow(string $url): void
    {
        try {
            $config = config('SearchDiscovery');
            if (!$config || empty($config->indexNowKey) || empty($config->indexNowEndpoint)) return;
            $host = parse_url(base_url(), PHP_URL_HOST);
            if (!$host) return;

            $client = \Config\Services::curlrequest([
                'timeout' => 3,
                'connect_timeout' => 2,
                'http_errors' => false,
            ]);
            $client->post($config->indexNowEndpoint, [
                'json' => [
                    'host' => $host,
                    'key' => $config->indexNowKey,
                    'keyLocation' => rtrim(base_url(), '/') . '/' . $config->indexNowKey . '.txt',
                    'urlList' => [$url],
                ],
            ]);
        } catch (\Throwable $e) {
            // Search-discovery notification must never block publishing.
        }
    }
}
