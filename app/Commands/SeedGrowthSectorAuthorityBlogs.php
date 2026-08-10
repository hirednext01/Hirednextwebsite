<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SeedGrowthSectorAuthorityBlogs extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'blog:seed-growth-sectors';
    protected $description = 'Publish IT, BFSI/NBFC, pharma, GCC and semiconductor authority blogs without overwriting existing posts.';
    protected $usage = 'blog:seed-growth-sectors [--dry-run]';

    public function run(array $params)
    {
        $dryRun = in_array('--dry-run', $params, true);
        $db = \Config\Database::connect();

        if (!$db->tableExists('blog_posts')) {
            CLI::error('blog_posts table not found. No changes made.');
            return;
        }

        $config = config('GrowthSectorAuthorityBlogs');
        if (!$config || empty($config->posts) || !is_array($config->posts)) {
            CLI::error('Growth-sector authority blog configuration is empty. No changes made.');
            return;
        }

        $published = 0;
        $skipped = 0;

        foreach ($config->posts as $post) {
            $slug = trim((string)($post['slug'] ?? ''));
            $title = trim((string)($post['title'] ?? ''));
            $content = (string)($post['content'] ?? '');

            if ($slug === '' || $title === '' || trim($content) === '') {
                CLI::write('Skip invalid configured post: ' . ($title ?: $slug ?: 'untitled'), 'red');
                $skipped++;
                continue;
            }

            $existing = $db->table('blog_posts')
                ->select('id, title, slug')
                ->where('slug', $slug)
                ->get()
                ->getRowArray();

            if ($existing) {
                CLI::write('Already exists — untouched: ' . $existing['title'], 'yellow');
                $skipped++;
                continue;
            }

            if ($dryRun) {
                CLI::write('[DRY RUN] Would publish: ' . $title, 'green');
                $published++;
                continue;
            }

            $now = date('Y-m-d H:i:s');
            $insert = [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'excerpt' => trim((string)($post['excerpt'] ?? '')),
                'featured_image' => trim((string)($post['featured_image'] ?? '')),
                'category' => trim((string)($post['category'] ?? 'Recruitment')) ?: 'Recruitment',
                'tags' => trim((string)($post['tags'] ?? '')),
                'author_name' => trim((string)($post['author_name'] ?? 'HiredNext Editorial')) ?: 'HiredNext Editorial',
                'meta_title' => trim((string)($post['meta_title'] ?? $title)),
                'meta_description' => trim((string)($post['meta_description'] ?? $post['excerpt'] ?? '')),
                'meta_keywords' => trim((string)($post['meta_keywords'] ?? $post['tags'] ?? '')),
                'status' => 'published',
                'sort_order' => 0,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (!$db->table('blog_posts')->insert($insert)) {
                CLI::write('Failed to publish: ' . $title, 'red');
                continue;
            }

            $published++;
            CLI::write('Published: ' . $title, 'green');
            $this->notifyIndexNow(base_url('blog/' . $slug));
        }

        CLI::newLine();
        CLI::write('Growth-sector posts configured: ' . count($config->posts), 'yellow');
        CLI::write(($dryRun ? 'Would publish: ' : 'Published: ') . $published, 'green');
        CLI::write('Existing/invalid posts skipped without changes: ' . $skipped, 'yellow');
        if ($dryRun) {
            CLI::write('Dry run only. Database was not changed.', 'yellow');
        }
    }

    private function notifyIndexNow(string $url): void
    {
        try {
            $config = config('SearchDiscovery');
            if (!$config || empty($config->indexNowKey) || empty($config->indexNowEndpoint)) {
                return;
            }

            $host = parse_url(base_url(), PHP_URL_HOST);
            if (!$host) {
                return;
            }

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
            // Discovery notification must never block publishing.
        }
    }
}
