<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SeedReputationProof extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'proof:seed-reputation';
    protected $description = 'Seed source-linked public LinkedIn reputation proof without touching unrelated reviews.';
    protected $usage = 'proof:seed-reputation [--dry-run]';

    public function run(array $params)
    {
        $dryRun = in_array('--dry-run', $params, true);
        $db = \Config\Database::connect();

        if (!$db->tableExists('reviews')) {
            CLI::error('reviews table not found. No changes made.');
            return;
        }

        $fields = array_flip($db->getFieldNames('reviews'));
        foreach (['name', 'proof_type', 'source_label', 'source_url'] as $requiredField) {
            if (!isset($fields[$requiredField])) {
                CLI::error('Review proof fields are not installed. Run: php spark migrate');
                return;
            }
        }

        $config = config('ReputationProof');
        if (!$config || empty($config->items) || !is_array($config->items)) {
            CLI::error('Reputation proof configuration is empty. No changes made.');
            return;
        }

        $inserted = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($config->items as $item) {
            $name = trim((string)($item['name'] ?? ''));
            $sourceUrl = trim((string)($item['source_url'] ?? ''));
            $excerpt = trim((string)($item['excerpt'] ?? ''));

            if ($name === '' || $sourceUrl === '' || $excerpt === '') {
                CLI::write('Skip invalid proof item: ' . ($name ?: $sourceUrl ?: 'unnamed'), 'red');
                $skipped++;
                continue;
            }

            $sourceLabel = trim((string)($item['source_label'] ?? 'External source'));
            $proofType = trim((string)($item['proof_type'] ?? 'External Recommendation'));
            $designation = trim((string)($item['designation'] ?? ''));
            $payload = [
                'client_name' => $name,
                'name' => $name,
                'comment' => $excerpt,
                // Public LinkedIn recommendations/posts do not carry a star rating.
                'rating' => 0,
                'project_type' => $proofType,
                'proof_type' => $proofType,
                // The testimonial view uses this legacy display field for role/designation.
                // Prefer a verified senior designation when one is available.
                'location' => $designation !== '' ? $designation : 'Public ' . $sourceLabel,
                'source_label' => $sourceLabel,
                'source_url' => $sourceUrl,
                // Keep source-backed recommendations separate from rated reviews
                // so the approved Home testimonial cards never imply fake stars.
                'status' => 'external',
                'sort_order' => (int)($item['sort_order'] ?? -50),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $existing = $db->table('reviews')
                ->select('id, client_name, source_url')
                ->where('source_url', $sourceUrl)
                ->where('client_name', $name)
                ->get()
                ->getRowArray();

            if ($dryRun) {
                CLI::write('[DRY RUN] ' . ($existing ? 'Would update: ' : 'Would insert: ') . $name, 'yellow');
                $existing ? $updated++ : $inserted++;
                continue;
            }

            if ($existing) {
                $db->table('reviews')->where('id', $existing['id'])->update($payload);
                CLI::write('Updated source-linked proof: ' . $name, 'green');
                $updated++;
            } else {
                $payload['created_at'] = date('Y-m-d H:i:s');
                $db->table('reviews')->insert($payload);
                CLI::write('Inserted source-linked proof: ' . $name, 'green');
                $inserted++;
            }
        }

        CLI::newLine();
        CLI::write('Reputation proof items configured: ' . count($config->items), 'yellow');
        CLI::write(($dryRun ? 'Would insert: ' : 'Inserted: ') . $inserted, 'green');
        CLI::write(($dryRun ? 'Would update: ' : 'Updated: ') . $updated, 'green');
        CLI::write('Invalid items skipped: ' . $skipped, 'yellow');
        if ($dryRun) {
            CLI::write('Dry run only. Database was not changed.', 'yellow');
        }
    }
}
