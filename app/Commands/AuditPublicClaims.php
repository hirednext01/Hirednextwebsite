<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;

class AuditPublicClaims extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'seo:audit-claims';
    protected $description = 'Flag unsupported or inconsistent public claims before deployment.';
    protected $usage = 'seo:audit-claims';

    public function run(array $params)
    {
        $facts = config('BrandFacts');
        if (!$facts) {
            CLI::error('BrandFacts config is unavailable.');
            return;
        }

        $patterns = [
            '1500+ placements' => '/1500\s*\+|placements\s*:\s*1500\s*\+/i',
            '98% success rate' => '/98\s*%|success\s*rate\s*:\s*98\s*%/i',
            '21-day average hiring speed' => '/21\s*(?:day|days)/i',
            '12 sectors' => '/12\s+sectors?/i',
            '25+ industries' => '/25\s*\+\s*industr(?:y|ies)/i',
            'guaranteed success wording' => '/success\s+guaranteed|guaranteed\s+success/i',
        ];

        $roots = [
            APPPATH . 'Views',
            APPPATH . 'Controllers',
            APPPATH . 'Config',
        ];

        $excludePaths = [
            realpath(APPPATH . 'Config/BrandFacts.php'),
            realpath(__FILE__),
        ];

        $findings = [];

        foreach ($roots as $root) {
            if (!is_dir($root)) {
                continue;
            }

            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $fileInfo) {
                if (!$fileInfo->isFile() || strtolower($fileInfo->getExtension()) !== 'php') {
                    continue;
                }

                $path = $fileInfo->getRealPath();
                if (!$path || in_array($path, $excludePaths, true)) {
                    continue;
                }

                $content = @file_get_contents($path);
                if ($content === false) {
                    continue;
                }

                $lines = preg_split('/\R/u', $content) ?: [];
                foreach ($patterns as $label => $pattern) {
                    foreach ($lines as $index => $line) {
                        if (!preg_match($pattern, $line)) {
                            continue;
                        }

                        $relative = str_replace(ROOTPATH, '', $path);
                        $findings[] = [
                            'claim' => $label,
                            'file' => $relative,
                            'line' => $index + 1,
                            'text' => trim(strip_tags($line)),
                        ];
                    }
                }
            }
        }

        CLI::write('HiredNext public claims audit', 'yellow');
        CLI::write($facts->numericClaimPolicy, 'white');
        CLI::newLine();

        if (!$findings) {
            CLI::write('PASS: No flagged unsupported public claims were found in public site code.', 'green');
            return;
        }

        CLI::write('REVIEW REQUIRED: ' . count($findings) . ' flagged claim occurrence(s) found.', 'red');
        foreach ($findings as $finding) {
            CLI::write(
                '- ' . $finding['claim'] . ' — ' . $finding['file'] . ':' . $finding['line'] . ' — ' . $finding['text'],
                'yellow'
            );
        }

        CLI::newLine();
        CLI::write('These claims are not automatically deleted. Verify a source of record before publishing or strengthening them.', 'white');
    }
}
