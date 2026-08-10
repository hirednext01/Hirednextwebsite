<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SubmitPrioritySearchDiscovery extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'seo:submit-priority';
    protected $description = 'Submit HiredNext priority commercial and authority URLs to the configured IndexNow endpoint.';
    protected $usage = 'seo:submit-priority [--dry-run]';

    public function run(array $params)
    {
        $dryRun = in_array('--dry-run', $params, true);
        $config = config('SearchDiscovery');

        if (!$config || empty($config->indexNowKey) || empty($config->indexNowEndpoint)) {
            CLI::error('SearchDiscovery configuration is missing. No URLs submitted.');
            return;
        }

        $host = parse_url(base_url(), PHP_URL_HOST);
        if (!$host) {
            CLI::error('Could not resolve the HiredNext host from base_url().');
            return;
        }

        $paths = [
            '',
            'services/clients',
            'services/executive-search',
            'industry/garment-textile-recruitment-india',
            'industry/it-recruitment-services-india',
            'industry/bfsi-leadership-hiring',
            'industry/retail-executive-search',
            'industry/pharma-life-sciences-recruitment-india',
            'industry/global-capability-centres-hiring-india',
            'industry/semiconductor-recruitment-india',
            'industry/engineering-recruitment-firm',
            'industry/manufacturing-talent-advisory',
            'blog',
            'testimonials',
            'press-media',
            'about/taru-shikha',
            'authority/media.json',
            'authority/placement-evidence.json',
        ];

        $urls = array_values(array_unique(array_map(
            static fn (string $path): string => $path === '' ? rtrim(base_url(), '/') . '/' : base_url($path),
            $paths
        )));

        CLI::write('Priority URLs: ' . count($urls), 'yellow');
        foreach ($urls as $url) {
            CLI::write(' - ' . $url);
        }

        if ($dryRun) {
            CLI::newLine();
            CLI::write('Dry run only. No discovery request sent.', 'yellow');
            return;
        }

        try {
            $client = \Config\Services::curlrequest([
                'timeout' => 10,
                'connect_timeout' => 5,
                'http_errors' => false,
            ]);

            $response = $client->post($config->indexNowEndpoint, [
                'json' => [
                    'host' => $host,
                    'key' => $config->indexNowKey,
                    'keyLocation' => rtrim(base_url(), '/') . '/' . $config->indexNowKey . '.txt',
                    'urlList' => $urls,
                ],
            ]);

            $status = $response->getStatusCode();
            if (in_array($status, [200, 202], true)) {
                CLI::newLine();
                CLI::write('IndexNow accepted the priority URL batch (HTTP ' . $status . ').', 'green');
                CLI::write('This accelerates discovery on participating search engines; it is not a ranking guarantee.', 'yellow');
                return;
            }

            CLI::error('IndexNow returned HTTP ' . $status . '. No ranking claim has been made.');
        } catch (\Throwable $e) {
            CLI::error('Search discovery submission failed: ' . $e->getMessage());
        }
    }
}
