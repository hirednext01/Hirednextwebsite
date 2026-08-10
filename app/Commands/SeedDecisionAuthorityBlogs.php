<?php

namespace App\Commands;

use App\Libraries\BlogSearchOptimizer;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SeedDecisionAuthorityBlogs extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'blog:seed-decision-authority';
    protected $description = 'Publish missing HiredNext decision blogs and correct only fallback images without overwriting existing content.';
    protected $usage = 'blog:seed-decision-authority [--dry-run]';

    /**
     * Each decision-authority article has its own featured visual.
     * Existing articles with a custom image are always preserved.
     */
    private array $featuredImages = [
        'best-executive-search-firm-india-how-to-choose' => 'https://hirednext.net/theme/assets/executive.jpeg',
        'executive-search-vs-recruitment-agency-india' => 'https://hirednext.net/theme/assets/rpo.jpeg',
        'how-to-hire-cxo-india-executive-search' => 'https://hirednext.net/theme/assets/avron.jpeg',
        'how-to-fill-hard-to-hire-roles-india' => 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&q=82&w=1400',
        'how-to-evaluate-recruitment-agency-credibility-india' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&q=82&w=1400',
        'specialist-recruitment-vs-rpo-vs-executive-search' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&q=82&w=1400',
    ];

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
        $imageCorrected = 0;
        $preserved = 0;
        $skipped = 0;

        foreach ($config->posts as $post) {
            $slug = trim((string)($post['slug'] ?? ''));
            $title = trim((string)($post['title'] ?? ''));
            $content = trim((string)($post['content'] ?? ''));
            $featuredImage = $this->featuredImages[$slug] ?? '';

            if ($slug === '' || $title === '' || $content === '' || $featuredImage === '') {
                CLI::write('Skipped invalid configured post/image: ' . ($title ?: $slug ?: 'untitled'), 'red');
                $skipped++;
                continue;
            }

            $existing = $db->table('blog_posts')
                ->select('id, title, slug, featured_image')
                ->where('slug', $slug)
                ->get()
                ->getRowArray();

            // Existing decision articles are content-locked here. We never rewrite
            // their title, content, metadata, category, author or publication date.
            if ($existing) {
                $currentImage = trim((string)($existing['featured_image'] ?? ''));

                if (!$this->isFallbackImage($currentImage)) {
                    CLI::write(($dryRun ? '[DRY RUN] Would preserve existing article: ' : 'Existing article preserved: ') . $existing['title'], 'yellow');
                    $preserved++;
                    continue;
                }

                if ($dryRun) {
                    CLI::write('[DRY RUN] Would correct featured image only: ' . $existing['title'], 'yellow');
                    $imageCorrected++;
                    continue;
                }

                $ok = $db->table('blog_posts')
                    ->where('id', $existing['id'])
                    ->update(['featured_image' => $featuredImage]);

                if (!$ok) {
                    CLI::write('Failed to correct featured image: ' . $existing['title'], 'red');
                    $skipped++;
                    continue;
                }

                $imageCorrected++;
                CLI::write('Existing article preserved; featured image corrected: ' . $existing['title'], 'green');
                $this->notifyIndexNow(base_url('blog/' . $slug));
                continue;
            }

            $base = [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'excerpt' => trim((string)($post['excerpt'] ?? '')),
                'featured_image' => $featuredImage,
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
                CLI::write('[DRY RUN] Would publish new article: ' . $title, 'green');
                $created++;
                continue;
            }

            $ok = $db->table('blog_posts')->insert($payload);
            if (!$ok) {
                CLI::write('Failed to publish: ' . $title, 'red');
                $skipped++;
                continue;
            }

            $created++;
            CLI::write('Published new article: ' . $title, 'green');
            $this->notifyIndexNow(base_url('blog/' . $slug));
        }

        CLI::newLine();
        CLI::write('Decision authority posts configured: ' . count($config->posts), 'yellow');
        CLI::write(($dryRun ? 'Would publish new: ' : 'Published new: ') . $created, 'green');
        CLI::write(($dryRun ? 'Would correct images only: ' : 'Images corrected only: ') . $imageCorrected, 'green');
        CLI::write('Existing articles preserved without content changes: ' . $preserved, 'yellow');
        CLI::write('Skipped/failed: ' . $skipped, $skipped ? 'red' : 'yellow');
        if ($dryRun) {
            CLI::write('Dry run only. Database was not changed.', 'yellow');
        }
    }

    private function isFallbackImage(string $image): bool
    {
        if ($image === '') {
            return true;
        }

        $path = parse_url($image, PHP_URL_PATH);
        if (!is_string($path) || $path === '') {
            $path = $image;
        }

        return strtolower(basename($path)) === 'home.jpeg';
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
