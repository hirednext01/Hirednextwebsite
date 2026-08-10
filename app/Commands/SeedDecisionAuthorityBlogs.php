<?php

namespace App\Commands;

use App\Libraries\BlogSearchOptimizer;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SeedDecisionAuthorityBlogs extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'blog:seed-decision-authority';
    protected $description = 'Publish or refresh HiredNext high-intent employer decision blogs by slug.';
    protected $usage = 'blog:seed-decision-authority [--dry-run]';

    public function run(array $params)
    {
        $dryRun = in_array('--dry-run', $params, true);
        $db = \Config\Database::connect();

        if (!$db->tableExists('blog_posts')) {
            CLI::error('blog_posts table not found. No changes made.');
            return;
        }

        $config = config('DecisionAuthorityBlogs');
        if (!$config || empty($config->posts) || !is_array($config->posts)) {
            CLI::error('Decision authority blog configuration is empty. No changes made.');
            return;
        }

        $optimizer = new BlogSearchOptimizer();
        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($config->posts as $post) {
            $slug = trim((string)($post['slug'] ?? ''));
            $title = trim((string)($post['title'] ?? ''));
            $content = trim((string)($post['content'] ?? ''));

            if ($slug === '' || $title === '' || $content === '') {
                CLI::write('Skipped invalid configured post: ' . ($title ?: $slug ?: 'untitled'), 'red');
                $skipped++;
                continue;
            }

            $base = [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'excerpt' => trim((string)($post['excerpt'] ?? '')),
                'featured_image' => trim((string)($post['featured_image'] ?? '')) ?: 'https://hirednext.net/theme/assets/home.jpeg',
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
                'updated_at' => $now,
            ]);

            $existing = $db->table('blog_posts')
                ->select('id, title, slug, status, published_at')
                ->where('slug', $slug)
                ->get()
                ->getRowArray();

            if ($dryRun) {
                CLI::write('[DRY RUN] ' . ($existing ? 'Would refresh: ' : 'Would publish: ') . $title, 'yellow');
                $existing ? $updated++ : $created++;
                continue;
            }

            if ($existing) {
                if (empty($existing['published_at'])) {
                    $payload['published_at'] = $now;
                }
                $ok = $db->table('blog_posts')->where('id', $existing['id'])->update($payload);
                if (!$ok) {
                    CLI::write('Failed to refresh: ' . $title, 'red');
                    $skipped++;
                    continue;
                }
                $updated++;
                CLI::write('Refreshed: ' . $title, 'green');
            } else {
                $payload['published_at'] = $now;
                $payload['created_at'] = $now;
                $ok = $db->table('blog_posts')->insert($payload);
                if (!$ok) {
                    CLI::write('Failed to publish: ' . $title, 'red');
                    $skipped++;
                    continue;
                }
                $created++;
                CLI::write('Published: ' . $title, 'green');
            }

            $this->notifyIndexNow(base_url('blog/' . $slug));
        }

        CLI::newLine();
        CLI::write('Decision authority posts configured: ' . count($config->posts), 'yellow');
        CLI::write(($dryRun ? 'Would publish: ' : 'Published: ') . $created, 'green');
        CLI::write(($dryRun ? 'Would refresh: ' : 'Refreshed: ') . $updated, 'green');
        CLI::write('Skipped/failed: ' . $skipped, $skipped ? 'red' : 'yellow');
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
            // Search discovery notifications must never block publishing.
        }
    }
}
