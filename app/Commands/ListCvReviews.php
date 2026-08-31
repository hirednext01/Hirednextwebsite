<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ListCvReviews extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'cv:reviews';
    protected $description = 'List recent HiredNext CV assessment requests from the website database.';
    protected $usage = 'cv:reviews [limit]';
    protected $arguments = [
        'limit' => 'Number of latest requests to show. Default: 20, maximum: 100.',
    ];

    public function run(array $params)
    {
        $limit = isset($params[0]) ? (int) $params[0] : 20;
        $limit = max(1, min(100, $limit));

        $db = \Config\Database::connect();
        if (!$db->tableExists('cv_assessment_leads')) {
            CLI::error('cv_assessment_leads table does not exist.');
            return;
        }

        $rows = $db->table('cv_assessment_leads')
            ->select('id, name, email, phone, assessment_plan, amount, payment_status, payment_id, status, job_title, resume_path, created_at, updated_at')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();

        if (!$rows) {
            CLI::write('No CV assessment requests found.', 'yellow');
            return;
        }

        CLI::write('LATEST HIREDNEXT CV REVIEW REQUESTS', 'green');
        CLI::write(str_repeat('-', 118));
        CLI::write(sprintf('%-5s %-22s %-30s %-16s %-14s %-20s %-20s', 'ID', 'NAME', 'EMAIL', 'PLAN', 'AMOUNT', 'PAYMENT', 'CREATED'));
        CLI::write(str_repeat('-', 118));

        foreach ($rows as $row) {
            $plan = ($row['assessment_plan'] ?? '') === 'priority_599' ? 'PRIORITY' : 'FREE';
            $amount = '₹' . number_format((float)($row['amount'] ?? 0), 0);
            CLI::write(sprintf(
                '%-5s %-22s %-30s %-16s %-14s %-20s %-20s',
                (string)($row['id'] ?? ''),
                mb_strimwidth((string)($row['name'] ?? ''), 0, 21, '…'),
                mb_strimwidth((string)($row['email'] ?? ''), 0, 29, '…'),
                $plan,
                $amount,
                mb_strimwidth((string)($row['payment_status'] ?? ''), 0, 19, '…'),
                (string)($row['created_at'] ?? '')
            ));
            CLI::write('      Phone: ' . ($row['phone'] ?? '—') . ' | Status: ' . ($row['status'] ?? '—') . ' | UPI ref: ' . (($row['payment_id'] ?? '') ?: '—'));
            CLI::write('      Job: ' . (($row['job_title'] ?? '') ?: 'Not specified') . ' | CV stored: ' . (!empty($row['resume_path']) ? 'YES' : 'NO'));
        }

        CLI::write(str_repeat('-', 118));
    }
}
