<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class FixBlogImages extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'blog:fix-images';
    protected $description = 'Assign diverse, relevant featured images to published blog posts that are blank or reuse a duplicated image, without changing blog design.';
    protected $usage = 'blog:fix-images [--dry-run]';

    public function run(array $params)
    {
        $dryRun = in_array('--dry-run', $params, true);
        $db = \Config\Database::connect();

        if (!$db->tableExists('blog_posts')) {
            CLI::error('blog_posts table not found. No changes made.');
            return;
        }

        $config = config('BlogImages');
        if (!$config || empty($config->pool)) {
            CLI::error('Blog image library is empty. No changes made.');
            return;
        }

        $posts = $db->table('blog_posts')
            ->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $counts = [];
        foreach ($posts as $post) {
            $image = trim((string)($post['featured_image'] ?? ''));
            if ($image !== '') {
                $counts[$image] = ($counts[$image] ?? 0) + 1;
            }
        }

        $used = [];
        foreach ($posts as $post) {
            $image = trim((string)($post['featured_image'] ?? ''));
            if ($image !== '' && ($counts[$image] ?? 0) === 1) {
                $used[$image] = true;
            }
        }

        $changed = 0;
        $kept = 0;

        foreach ($posts as $post) {
            $current = trim((string)($post['featured_image'] ?? ''));
            $isDuplicate = $current !== '' && ($counts[$current] ?? 0) > 1;

            if ($current !== '' && !$isDuplicate) {
                $kept++;
                CLI::write('Keep unique image: ' . ($post['title'] ?? ('Post #' . $post['id'])), 'dark_gray');
                continue;
            }

            $replacement = $this->chooseImage($post, $config->topicImages ?? [], $config->pool, $used);
            if ($replacement === '') {
                CLI::write('No replacement available: ' . ($post['title'] ?? ('Post #' . $post['id'])), 'red');
                continue;
            }

            $changed++;
            $used[$replacement] = true;
            CLI::write(($dryRun ? '[DRY RUN] ' : '') . 'Set image: ' . ($post['title'] ?? ('Post #' . $post['id'])), 'green');

            if (!$dryRun) {
                $db->table('blog_posts')->where('id', $post['id'])->update([
                    'featured_image' => $replacement,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        CLI::newLine();
        CLI::write('Published posts checked: ' . count($posts), 'yellow');
        CLI::write(($dryRun ? 'Would change: ' : 'Images changed: ') . $changed, 'green');
        CLI::write('Unique existing images preserved: ' . $kept, 'yellow');
        if ($dryRun) {
            CLI::write('Dry run only. No database rows were changed.', 'yellow');
        }
    }

    private function chooseImage(array $post, array $topicImages, array $pool, array $used): string
    {
        $corpus = mb_strtolower(trim(implode(' ', [
            (string)($post['title'] ?? ''),
            (string)($post['category'] ?? ''),
            (string)($post['tags'] ?? ''),
            strip_tags((string)($post['excerpt'] ?? '')),
        ])));

        foreach ($topicImages as $needle => $image) {
            if (mb_strpos($corpus, mb_strtolower((string)$needle)) !== false && empty($used[$image])) {
                return $image;
            }
        }

        $slug = (string)($post['slug'] ?? $post['id'] ?? $post['title'] ?? 'blog');
        $count = count($pool);
        $start = $count > 0 ? (int)(sprintf('%u', crc32($slug)) % $count) : 0;

        for ($offset = 0; $offset < $count; $offset++) {
            $candidate = $pool[($start + $offset) % $count];
            if (empty($used[$candidate])) {
                return $candidate;
            }
        }

        return $count > 0 ? $pool[$start] : '';
    }
}
