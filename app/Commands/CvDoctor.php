<?php

namespace App\Commands;

use App\Services\Cv\Provider\AnthropicProvider;
use App\Services\Cv\Provider\GeminiProvider;
use App\Services\Cv\Provider\OpenAiProvider;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CvDoctor extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'cv:doctor';
    protected $description = 'Check HiredNext CV agent readiness without displaying any secret values.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        CLI::write('HIREDNEXT CV AGENT READINESS', 'green');
        CLI::write(str_repeat('-', 72));

        $tables = [
            'cv_assessment_leads', 'cv_analysis_runs', 'cv_analysis_findings',
            'cv_report_versions', 'cv_review_events', 'cv_email_events', 'cv_upgrade_orders',
        ];
        foreach ($tables as $table) {
            $ok = $db->tableExists($table);
            CLI::write(sprintf('%-34s %s', $table, $ok ? 'READY' : 'MISSING'), $ok ? 'green' : 'red');
        }

        CLI::write(str_repeat('-', 72));
        CLI::write('CV EXTRACTION');
        foreach (['pdftotext', 'antiword', 'catdoc'] as $binary) {
            $path = $this->binary($binary);
            CLI::write(sprintf('%-34s %s', $binary, $path ?: 'NOT FOUND'), $path ? 'green' : 'yellow');
        }
        CLI::write(sprintf('%-34s %s', 'PHP ZipArchive (DOCX)', class_exists(\ZipArchive::class) ? 'READY' : 'MISSING'), class_exists(\ZipArchive::class) ? 'green' : 'red');

        CLI::write(str_repeat('-', 72));
        CLI::write('REVIEWERS');
        CLI::write(sprintf('%-34s %s', 'HiredNext deterministic rules', 'READY'), 'green');
        foreach ([new OpenAiProvider(), new AnthropicProvider(), new GeminiProvider()] as $provider) {
            CLI::write(sprintf('%-34s %s', strtoupper($provider->name()), $provider->configured() ? 'CONFIGURED' : 'NOT CONFIGURED'), $provider->configured() ? 'green' : 'yellow');
        }

        CLI::write(str_repeat('-', 72));
        CLI::write('This command never prints API keys or passwords.', 'cyan');
    }

    private function binary(string $name): ?string
    {
        foreach (["/usr/bin/{$name}", "/usr/local/bin/{$name}", "/bin/{$name}"] as $path) {
            if (is_executable($path)) {
                return $path;
            }
        }
        if (function_exists('shell_exec')) {
            $path = trim((string)@shell_exec('command -v ' . escapeshellarg($name) . ' 2>/dev/null'));
            if ($path !== '' && is_executable($path)) {
                return $path;
            }
        }
        return null;
    }
}
