<?php

namespace App\Commands;

use App\Services\Cv\CvAuditService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CvQueueExisting extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'cv:queue-existing';
    protected $description = 'Backfill audit/queue visibility for existing HiredNext CV assessment records.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('cv_assessment_leads') || !$db->tableExists('cv_review_events')) {
            CLI::error('Required CV tables are not installed. Run `php spark migrate` first.');
            return;
        }

        $audit = new CvAuditService();
        $rows = $db->table('cv_assessment_leads')->orderBy('created_at', 'ASC')->get()->getResultArray();
        $added = 0;
        foreach ($rows as $lead) {
            $exists = $db->table('cv_review_events')
                ->where('lead_id', (int)$lead['id'])
                ->whereIn('event_type', ['cv_received', 'cv_received_backfill'])
                ->countAllResults();
            if ($exists > 0) {
                continue;
            }
            $audit->record((int)$lead['id'], 'cv_received_backfill', [
                'created_at' => $lead['created_at'] ?? null,
                'assessment_plan' => $lead['assessment_plan'] ?? null,
                'payment_status' => $lead['payment_status'] ?? null,
                'resume_stored' => !empty($lead['resume_path']),
            ], null, 'database', 'backfilled');
            $added++;
        }
        CLI::write('Backfilled CV audit visibility for ' . $added . ' records. Existing records were not duplicated.', 'green');
    }
}
