<?php

namespace App\Services\Cv;

use App\Models\CvAnalysisFindingModel;
use App\Models\CvAnalysisRunModel;
use App\Models\CvReportVersionModel;
use App\Services\Cv\Provider\AnthropicProvider;
use App\Services\Cv\Provider\GeminiProvider;
use App\Services\Cv\Provider\OpenAiProvider;

class CvAnalysisOrchestrator
{
    private CvTextExtractor $extractor;
    private LocalRecruiterRuleEngine $localRules;
    private HiredNextReportBuilder $reportBuilder;
    private CvAuditService $audit;

    public function __construct()
    {
        $this->extractor = new CvTextExtractor();
        $this->localRules = new LocalRecruiterRuleEngine();
        $this->reportBuilder = new HiredNextReportBuilder();
        $this->audit = new CvAuditService();
    }

    public function analyseLead(int $leadId, ?array $actor = null, bool $force = false): array
    {
        $db = db_connect();
        foreach (['cv_analysis_runs', 'cv_analysis_findings', 'cv_report_versions', 'cv_review_events'] as $table) {
            if (!$db->tableExists($table)) {
                throw new \RuntimeException('CV analysis tables are not installed. Run `php spark migrate` on Hostinger first.');
            }
        }

        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->get()->getRowArray();
        if (!$lead) {
            throw new \RuntimeException('CV review request #' . $leadId . ' was not found.');
        }

        $runModel = new CvAnalysisRunModel();
        $latest = $runModel->where('lead_id', $leadId)->orderBy('id', 'DESC')->first();
        if (!$force && $latest && in_array($latest['status'] ?? '', ['extracting', 'reviewing', 'synthesis_ready', 'human_review', 'approved'], true)) {
            return $this->resultSnapshot($lead, $latest);
        }

        $tier = $this->serviceTier($lead);
        $now = date('Y-m-d H:i:s');
        $runId = (int) $runModel->insert([
            'lead_id' => $leadId,
            'status' => 'extracting',
            'service_tier' => $tier,
            'started_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ], true);
        if (!$runId) {
            throw new \RuntimeException('Unable to create CV analysis run.');
        }

        $this->audit->record($leadId, 'analysis_queued', ['run_id' => $runId, 'service_tier' => $tier], $actor, 'admin', 'queued');

        try {
            $resumePath = $this->absoluteResumePath($lead);
            $extracted = $this->extractor->extract($resumePath);
            $runModel->update($runId, [
                'status' => 'reviewing',
                'extracted_text' => $extracted['text'],
                'extraction_meta' => $this->json($extracted['meta']),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $this->audit->record($leadId, 'extraction_completed', ['run_id' => $runId, 'meta' => $extracted['meta']], $actor, 'system', 'completed');
        } catch (\Throwable $e) {
            $runModel->update($runId, [
                'status' => 'extract_failed',
                'error_message' => mb_substr($e->getMessage(), 0, 2000),
                'completed_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $this->audit->record($leadId, 'extraction_failed', ['run_id' => $runId, 'error' => $e->getMessage()], $actor, 'system', 'failed');
            throw $e;
        }

        $context = [
            'job_title' => $lead['job_title'] ?? '',
            'message' => $lead['message'] ?? '',
            'assessment_plan' => $lead['assessment_plan'] ?? '',
        ];

        $reviews = [];
        $local = $this->localRules->review($extracted['text'], $context);
        $reviews[] = $local;
        $this->storeFindings($runId, $local);
        $this->audit->record($leadId, 'provider_review_completed', ['run_id' => $runId, 'provider' => 'hirednext_rules'], $actor, 'system', 'completed');

        $providerLimit = $tier === 'priority_599' ? 3 : 2;
        $configuredUsed = 0;
        $providerStatuses = [];
        $providers = [new OpenAiProvider(), new AnthropicProvider(), new GeminiProvider()];

        foreach ($providers as $provider) {
            $name = $provider->name();
            if (!$provider->configured()) {
                $providerStatuses[$name] = ['status' => 'not_configured'];
                $this->audit->record($leadId, 'provider_review_not_configured', ['run_id' => $runId, 'provider' => $name], $actor, 'system', 'not_configured');
                continue;
            }
            if ($configuredUsed >= $providerLimit) {
                $providerStatuses[$name] = ['status' => 'skipped_tier_limit'];
                continue;
            }

            $configuredUsed++;
            try {
                $review = $this->normaliseReview($provider->review($extracted['text'], $context), $name);
                $reviews[] = $review;
                $this->storeFindings($runId, $review);
                $providerStatuses[$name] = [
                    'status' => 'completed',
                    'usage' => $review['usage'] ?? [],
                    'finding_count' => count($review['findings'] ?? []),
                ];
                $this->audit->record($leadId, 'provider_review_completed', ['run_id' => $runId, 'provider' => $name, 'finding_count' => count($review['findings'] ?? [])], $actor, 'system', 'completed');
            } catch (\Throwable $e) {
                $providerStatuses[$name] = ['status' => 'failed', 'error' => mb_substr($e->getMessage(), 0, 500)];
                $this->audit->record($leadId, 'provider_review_failed', ['run_id' => $runId, 'provider' => $name, 'error' => $e->getMessage()], $actor, 'system', 'failed');
            }
        }

        $report = $this->reportBuilder->build($lead, $reviews);
        $reportModel = new CvReportVersionModel();
        $previous = $reportModel->where('lead_id', $leadId)->orderBy('version', 'DESC')->first();
        $version = ((int) ($previous['version'] ?? 0)) + 1;
        $reportVersionId = (int) $reportModel->insert([
            'lead_id' => $leadId,
            'analysis_run_id' => $runId,
            'version' => $version,
            'status' => 'draft',
            'report_json' => $this->json($report),
            'report_text' => $report['report_text'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ], true);

        $runModel->update($runId, [
            'status' => 'synthesis_ready',
            'provider_status_json' => $this->json($providerStatuses),
            'synthesis_json' => $this->json($report),
            'completed_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->audit->record($leadId, 'synthesis_completed', [
            'run_id' => $runId,
            'report_version_id' => $reportVersionId,
            'recommended_next_step' => $report['recommended_next_step'] ?? null,
        ], $actor, 'system', 'completed');

        return [
            'lead' => $lead,
            'run' => $runModel->find($runId),
            'report' => $reportModel->find($reportVersionId),
            'provider_statuses' => $providerStatuses,
        ];
    }

    private function serviceTier(array $lead): string
    {
        $priority = ($lead['assessment_plan'] ?? '') === 'priority_599';
        $paid = in_array(strtolower((string) ($lead['payment_status'] ?? '')), ['verified', 'paid', 'captured'], true);
        if ($priority && $paid) {
            return 'priority_599';
        }
        if ($priority) {
            return 'priority_requested_unpaid';
        }
        return 'free';
    }

    private function absoluteResumePath(array $lead): string
    {
        $stored = trim((string) ($lead['resume_path'] ?? ''));
        if ($stored === '') {
            throw new \RuntimeException('No CV file is attached to this request.');
        }
        return ROOTPATH . ltrim($stored, '/');
    }

    private function storeFindings(int $runId, array $review): void
    {
        $model = new CvAnalysisFindingModel();
        foreach (($review['findings'] ?? []) as $finding) {
            if (!is_array($finding)) {
                continue;
            }
            $normal = $this->normaliseFinding($finding);
            if (!$normal) {
                continue;
            }
            $normal['analysis_run_id'] = $runId;
            $normal['reviewer'] = (string) ($review['reviewer'] ?? 'reviewer');
            $normal['created_at'] = date('Y-m-d H:i:s');
            $model->insert($normal);
        }
    }

    private function normaliseReview(array $review, string $provider): array
    {
        $review['reviewer'] = $provider;
        $review['summary'] = trim((string) ($review['summary'] ?? ''));
        $review['scores'] = is_array($review['scores'] ?? null) ? $review['scores'] : [];
        $review['strengths'] = is_array($review['strengths'] ?? null) ? $review['strengths'] : [];
        $valid = [];
        foreach (($review['findings'] ?? []) as $finding) {
            if (!is_array($finding)) {
                continue;
            }
            $normal = $this->normaliseFinding($finding);
            if ($normal) {
                $valid[] = $normal;
            }
        }
        $review['findings'] = $valid;
        if (!$valid && $review['summary'] === '') {
            throw new \RuntimeException(ucfirst($provider) . ' returned no usable findings.');
        }
        return $review;
    }

    private function normaliseFinding(array $finding): ?array
    {
        foreach (['category', 'finding', 'evidence', 'why_it_matters', 'recommendation'] as $key) {
            if (trim((string) ($finding[$key] ?? '')) === '') {
                return null;
            }
        }
        $severity = strtolower((string) ($finding['severity'] ?? 'medium'));
        if (!in_array($severity, ['low', 'medium', 'high'], true)) {
            $severity = 'medium';
        }
        return [
            'category' => mb_substr(trim((string) $finding['category']), 0, 100),
            'finding' => trim((string) $finding['finding']),
            'evidence' => trim((string) $finding['evidence']),
            'why_it_matters' => trim((string) $finding['why_it_matters']),
            'severity' => $severity,
            'recommendation' => trim((string) $finding['recommendation']),
        ];
    }

    private function resultSnapshot(array $lead, array $run): array
    {
        $report = (new CvReportVersionModel())
            ->where('lead_id', (int) $lead['id'])
            ->orderBy('version', 'DESC')
            ->first();
        return [
            'lead' => $lead,
            'run' => $run,
            'report' => $report,
            'provider_statuses' => $this->decode((string) ($run['provider_status_json'] ?? '')),
        ];
    }

    private function json(array $value): string
    {
        return (string) json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    }

    private function decode(string $value): array
    {
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }
}
