<?php

namespace App\Commands;

use App\Libraries\BlogSearchOptimizer;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class OptimizeBlogs extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'blog:optimize';
    protected $description = 'Optimise published HiredNext blog content and metadata for SEO, AEO and GEO without changing page design.';
    protected $usage = 'blog:optimize [--dry-run]';

    public function run(array $params)
    {
        $dryRun = in_array('--dry-run', $params, true);
        $db = \Config\Database::connect();

        if (!$db->tableExists('blog_posts')) {
            CLI::error('blog_posts table not found.');
            return;
        }

        $posts = $db->table('blog_posts')
            ->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $optimizer = new BlogSearchOptimizer();
        $changed = 0;
        $unchanged = 0;

        foreach ($posts as $post) {
            $optimized = $optimizer->optimise($post, true);
            $update = [];

            foreach ($optimized as $field => $value) {
                if ((string)($post[$field] ?? '') !== (string)$value) {
                    $update[$field] = $value;
                }
            }

            if (empty($update)) {
                $unchanged++;
                CLI::write('No change: ' . ($post['title'] ?? ('Post #' . ($post['id'] ?? ''))), 'dark_gray');
                continue;
            }

            $changed++;
            $fields = implode(', ', array_keys($update));
            CLI::write(($dryRun ? '[DRY RUN] ' : '') . 'Optimise: ' . ($post['title'] ?? ('Post #' . $post['id'])) . ' [' . $fields . ']', 'green');

            if (!$dryRun) {
                $update['updated_at'] = date('Y-m-d H:i:s');
                $db->table('blog_posts')->where('id', $post['id'])->update($update);
                $this->notifyIndexNow(base_url('blog/' . $post['slug']));
            }
        }

        CLI::newLine();
        CLI::write('Published posts checked: ' . count($posts), 'yellow');
        CLI::write('Posts optimised: ' . $changed, 'green');
        CLI::write('Already optimised: ' . $unchanged, 'yellow');
        if ($dryRun) {
            CLI::write('Dry run only. No database rows were changed.', 'yellow');
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
            // Search notification failure must never stop content optimisation.
        }
    }
}
