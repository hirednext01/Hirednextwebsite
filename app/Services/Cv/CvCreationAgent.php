<?php

namespace App\Services\Cv;

use App\Models\CvAnalysisRunModel;
use App\Models\CvDocumentModel;
use App\Models\CvReportVersionModel;
use App\Models\CvUpgradeOrderModel;

class CvCreationAgent
{
    private CvWriterPanel $writers;
    private CvAuditService $audit;

    public function __construct()
    {
        $this->writers = new CvWriterPanel();
        $this->audit = new CvAuditService();
    }

    public function configuration(): array
    {
        return $this->writers->configuration();
    }

    /**
     * HiredNext creates the CV from the candidate's uploaded source document.
     * The candidate never has to populate a template.
     */
    public function generate(int $leadId, string $templateKey = 'ats_classic', ?array $actor = null, ?int $orderId = null): array
    {
        $templates = ['ats_classic', 'ats_modern', 'executive_ats'];
        if (!in_array($templateKey, $templates, true)) {
            throw new \RuntimeException('Unknown HiredNext CV template.');
        }

        $db = db_connect();
        if (!$db->tableExists('cv_documents')) {
            throw new \RuntimeException('CV Studio database is not installed. Run `php spark migrate`.');
        }

        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->get()->getRowArray();
        if (!$lead) {
            throw new \RuntimeException('CV review request #' . $leadId . ' was not found.');
        }

        $runModel = new CvAnalysisRunModel();
        $run = $runModel->where('lead_id', $leadId)->orderBy('id', 'DESC')->first();
        if (!$run || trim((string) ($run['extracted_text'] ?? '')) === '') {
            (new CvAnalysisOrchestrator())->analyseLead($leadId, $actor, false);
            $run = $runModel->where('lead_id', $leadId)->orderBy('id', 'DESC')->first();
        }
        if (!$run || trim((string) ($run['extracted_text'] ?? '')) === '') {
            throw new \RuntimeException('The uploaded CV could not be converted into usable text.');
        }

        $order = null;
        if ($orderId) {
            $order = (new CvUpgradeOrderModel())->find($orderId);
            if (!$order || (int) ($order['lead_id'] ?? 0) !== $leadId) {
                throw new \RuntimeException('The selected CV service order does not belong to this candidate.');
            }
        }

        $reportVersion = (new CvReportVersionModel())
            ->where('lead_id', $leadId)
            ->orderBy('version', 'DESC')
            ->first();
        $report = $reportVersion ? json_decode((string) ($reportVersion['report_json'] ?? ''), true) : [];
        if (!is_array($report)) {
            $report = [];
        }

        $context = [
            'candidate_name' => $lead['name'] ?? '',
            'job_title_or_target' => $lead['job_title'] ?? '',
            'candidate_note' => $lead['message'] ?? '',
            'assessment_plan' => $lead['assessment_plan'] ?? '',
            'service_order' => $order ? ($order['service_name'] ?? '') : '',
            'template_direction' => $templateKey,
            'assessment_recommendation' => $report['recommended_next_step'] ?? null,
            'hirednext_findings' => array_slice($report['top_changes'] ?? [], 0, 10),
        ];

        $this->audit->record($leadId, 'cv_creation_started', [
            'template' => $templateKey,
            'order_id' => $orderId,
            'analysis_run_id' => $run['id'] ?? null,
        ], $actor, 'admin', 'started');

        $written = $this->writers->write((string) $run['extracted_text'], $context);
        $content = $written['content'];
        $clarifications = $content['clarifications'] ?? [];
        $status = $clarifications ? 'clarification_needed' : 'draft_ready';
        $now = date('Y-m-d H:i:s');

        $docModel = new CvDocumentModel();
        $documentId = (int) $docModel->insert([
            'lead_id' => $leadId,
            'upgrade_order_id' => $orderId,
            'analysis_run_id' => (int) ($run['id'] ?? 0) ?: null,
            'template_key' => $templateKey,
            'status' => $status,
            'content_json' => $this->json($content),
            'writer_panel_json' => $this->json($written['panel'] ?? []),
            'clarifications_json' => $this->json($clarifications),
            'branding_mode' => 'remove',
            'revision_round' => 0,
            'created_by' => isset($actor['id']) ? (int) $actor['id'] : null,
            'created_at' => $now,
            'updated_at' => $now,
        ], true);

        if (!$documentId) {
            throw new \RuntimeException('HiredNext could not save the generated CV draft.');
        }

        $this->audit->record($leadId, 'cv_creation_generated', [
            'document_id' => $documentId,
            'template' => $templateKey,
            'status' => $status,
            'lead_writer' => $written['lead_writer'] ?? null,
            'clarification_count' => count($clarifications),
        ], $actor, 'admin', $status);

        return [
            'document' => $docModel->find($documentId),
            'content' => $content,
            'panel' => $written['panel'] ?? [],
            'lead_writer' => $written['lead_writer'] ?? null,
        ];
    }

    private function json(array $value): string
    {
        return (string) json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
    }
}
