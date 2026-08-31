<?php

namespace App\Commands;

use App\Services\Cv\CvAnalysisOrchestrator;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CvAnalyse extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'cv:analyse';
    protected $description = 'Analyse one HiredNext CV review request or the next eligible queued CV.';
    protected $usage = 'cv:analyse [lead_id]';
    protected $arguments = ['lead_id' => 'Optional CV assessment lead ID.'];

    public function run(array $params)
    {
        $leadId = isset($params[0]) ? (int)$params[0] : 0;
        try {
            if ($leadId < 1) {
                $leadId = $this->nextLeadId();
                if ($leadId < 1) {
                    CLI::write('No eligible CV is waiting for analysis.', 'yellow');
                    return;
                }
            }
            CLI::write('Analysing CV review #' . $leadId . '...', 'cyan');
            $result = (new CvAnalysisOrchestrator())->analyseLead($leadId, null, false);
            CLI::write('Analysis status: ' . ($result['run']['status'] ?? 'unknown'), 'green');
            if (!empty($result['report']['id'])) {
                CLI::write('Draft report version ID: ' . $result['report']['id'], 'green');
            }
        } catch (\Throwable $e) {
            CLI::error('CV analysis failed: ' . $e->getMessage());
        }
    }

    private function nextLeadId(): int
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('cv_assessment_leads') || !$db->tableExists('cv_analysis_runs')) {
            return 0;
        }

        $leads = $db->table('cv_assessment_leads')->orderBy('created_at', 'ASC')->limit(500)->get()->getResultArray();
        usort($leads, static function ($a, $b) {
            $aPaid = (($a['assessment_plan'] ?? '') === 'priority_599' && in_array(strtolower((string)($a['payment_status'] ?? '')), ['verified','paid','captured'], true)) ? 0 : 1;
            $bPaid = (($b['assessment_plan'] ?? '') === 'priority_599' && in_array(strtolower((string)($b['payment_status'] ?? '')), ['verified','paid','captured'], true)) ? 0 : 1;
            return $aPaid <=> $bPaid ?: strcmp((string)($a['created_at'] ?? ''), (string)($b['created_at'] ?? ''));
        });

        foreach ($leads as $lead) {
            if (empty($lead['resume_path'])) {
                continue;
            }
            $latest = $db->table('cv_analysis_runs')->where('lead_id', (int)$lead['id'])->orderBy('id', 'DESC')->get(1)->getRowArray();
            if (!$latest || in_array($latest['status'] ?? '', ['extract_failed', 'provider_failed', 'synthesis_failed'], true)) {
                return (int)$lead['id'];
            }
        }
        return 0;
    }
}
