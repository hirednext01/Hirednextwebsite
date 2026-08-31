<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CvAnalysisFindingModel;
use App\Models\CvAnalysisRunModel;
use App\Models\CvEmailEventModel;
use App\Models\CvReportVersionModel;
use App\Models\CvUpgradeOrderModel;
use App\Models\UserModel;
use App\Services\Cv\CvAnalysisOrchestrator;
use App\Services\Cv\CvAuditService;
use App\Services\Cv\CvCandidateMailer;
use App\Services\Cv\CvUpgradePlans;
use App\Services\Cv\Provider\AnthropicProvider;
use App\Services\Cv\Provider\GeminiProvider;
use App\Services\Cv\Provider\OpenAiProvider;

class CvReviewAdmin extends BaseController
{
    private const SESSION_KEY = 'cv_review_admin_user';

    public function index()
    {
        $user = $this->adminUser();
        if (!$user) {
            return view('pages/admin/cv-reviews-login', ['title' => 'CV Reviews Admin | HiredNext']);
        }

        $db = \Config\Database::connect();
        $rows = $db->tableExists('cv_assessment_leads')
            ? $db->table('cv_assessment_leads')->orderBy('created_at', 'DESC')->limit(250)->get()->getResultArray()
            : [];

        $analysisReady = $db->tableExists('cv_analysis_runs') && $db->tableExists('cv_report_versions');
        $upgradeReady = $db->tableExists('cv_upgrade_orders');
        $runModel = $analysisReady ? new CvAnalysisRunModel() : null;
        $reportModel = $analysisReady ? new CvReportVersionModel() : null;
        $orderModel = $upgradeReady ? new CvUpgradeOrderModel() : null;

        $stats = [
            'total' => count($rows),
            'queued' => 0,
            'analysing' => 0,
            'ready' => 0,
            'sent' => 0,
            'failed' => 0,
            'payment_submitted' => 0,
            'paid_verified' => 0,
        ];

        foreach ($rows as &$row) {
            $run = $analysisReady ? $runModel->where('lead_id', (int)$row['id'])->orderBy('id', 'DESC')->first() : null;
            $report = $analysisReady ? $reportModel->where('lead_id', (int)$row['id'])->orderBy('version', 'DESC')->first() : null;
            $order = $upgradeReady ? $orderModel->where('lead_id', (int)$row['id'])->orderBy('id', 'DESC')->first() : null;

            $row['analysis_status'] = $run['status'] ?? 'not_started';
            $row['report_status'] = $report['status'] ?? null;
            $row['latest_order'] = $order;
            $row['last_action_at'] = $report['updated_at'] ?? $run['updated_at'] ?? $row['updated_at'] ?? $row['created_at'] ?? null;

            if (!$run) {
                $stats['queued']++;
            } elseif (in_array($row['analysis_status'], ['queued', 'extracting', 'reviewing'], true)) {
                $stats['analysing']++;
            } elseif (in_array($row['analysis_status'], ['extract_failed', 'provider_failed', 'synthesis_failed'], true)) {
                $stats['failed']++;
            }

            if ($report && in_array($report['status'] ?? '', ['draft', 'approved'], true)) {
                $stats['ready']++;
            }
            if (($report['status'] ?? '') === 'sent') {
                $stats['sent']++;
            }
            if (($row['payment_status'] ?? '') === 'pending_verification' || ($row['status'] ?? '') === 'payment_submitted') {
                $stats['payment_submitted']++;
            }
            if (in_array(strtolower((string)($row['payment_status'] ?? '')), ['verified', 'paid', 'captured'], true)) {
                $stats['paid_verified']++;
            }
        }
        unset($row);

        return view('pages/admin/cv-reviews', [
            'title' => 'CV Reviews Admin | HiredNext',
            'rows' => $rows,
            'stats' => $stats,
            'adminUser' => $user,
            'analysisReady' => $analysisReady,
            'providers' => $this->providerConfiguration(),
        ]);
    }

    public function detail($id)
    {
        $user = $this->adminUser();
        if (!$user) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }

        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')->where('id', (int)$id)->get()->getRowArray();
        if (!$lead) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $analysisReady = $db->tableExists('cv_analysis_runs') && $db->tableExists('cv_report_versions');
        $run = $analysisReady ? (new CvAnalysisRunModel())->where('lead_id', (int)$id)->orderBy('id', 'DESC')->first() : null;
        $reportVersion = $analysisReady ? (new CvReportVersionModel())->where('lead_id', (int)$id)->orderBy('version', 'DESC')->first() : null;
        $findings = ($run && $db->tableExists('cv_analysis_findings'))
            ? (new CvAnalysisFindingModel())->where('analysis_run_id', (int)$run['id'])->orderBy('id', 'ASC')->findAll()
            : [];
        $report = $reportVersion ? $this->decode((string)($reportVersion['report_json'] ?? '')) : [];
        $timeline = $db->tableExists('cv_review_events') ? (new CvAuditService())->timeline((int)$id) : [];
        $emails = $db->tableExists('cv_email_events')
            ? (new CvEmailEventModel())->where('lead_id', (int)$id)->orderBy('created_at', 'DESC')->findAll(200)
            : [];
        $orders = $db->tableExists('cv_upgrade_orders')
            ? (new CvUpgradeOrderModel())->where('lead_id', (int)$id)->orderBy('created_at', 'DESC')->findAll(50)
            : [];

        return view('pages/admin/cv-review-detail', [
            'title' => 'CV Review #' . (int)$id . ' | HiredNext Admin',
            'lead' => $lead,
            'run' => $run,
            'reportVersion' => $reportVersion,
            'report' => $report,
            'findings' => $findings,
            'timeline' => $timeline,
            'emails' => $emails,
            'orders' => $orders,
            'adminUser' => $user,
            'analysisReady' => $analysisReady,
            'providers' => $this->providerConfiguration(),
            'upgradePlans' => CvUpgradePlans::all(),
        ]);
    }

    public function analyse($id)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }
        $force = $this->request->getPost('force') === '1';
        try {
            (new CvAnalysisOrchestrator())->analyseLead((int)$id, $user, $force);
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('success', 'CV analysis completed and the HiredNext draft report is ready for review.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'Analysis could not complete: ' . $e->getMessage());
        }
    }

    public function saveReport($id)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }
        $reportModel = new CvReportVersionModel();
        $reportVersion = $reportModel->where('lead_id', (int)$id)->orderBy('version', 'DESC')->first();
        if (!$reportVersion) {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'No draft report exists yet.');
        }

        $report = $this->decode((string)($reportVersion['report_json'] ?? ''));
        $report['recruiter_summary'] = trim((string)$this->request->getPost('recruiter_summary')) ?: ($report['recruiter_summary'] ?? '');
        $report['overall_verdict'] = trim((string)$this->request->getPost('overall_verdict')) ?: ($report['overall_verdict'] ?? '');
        $humanNotes = trim((string)$this->request->getPost('human_notes'));

        $reportModel->update((int)$reportVersion['id'], [
            'report_json' => $this->json($report),
            'report_text' => $this->reportText($report),
            'human_notes' => $humanNotes ?: null,
            'status' => 'draft',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        (new CvAuditService())->record((int)$id, 'human_review_saved', ['report_version_id' => $reportVersion['id']], $user, 'admin', 'saved');
        return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('success', 'HiredNext report edits saved.');
    }

    public function approveReport($id)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }
        $model = new CvReportVersionModel();
        $report = $model->where('lead_id', (int)$id)->orderBy('version', 'DESC')->first();
        if (!$report) {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'No report exists to approve.');
        }
        $model->update((int)$report['id'], [
            'status' => 'approved',
            'approved_by' => (int)$user['id'],
            'approved_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        (new CvAuditService())->record((int)$id, 'report_approved', ['report_version_id' => $report['id']], $user, 'admin', 'approved');
        return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('success', 'Report approved. It has not been emailed yet.');
    }

    public function sendReport($id)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }
        $report = (new CvReportVersionModel())->where('lead_id', (int)$id)->orderBy('version', 'DESC')->first();
        if (!$report || ($report['status'] ?? '') !== 'approved') {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'Approve the HiredNext report before sending it.');
        }
        try {
            $sent = (new CvCandidateMailer())->sendReport((int)$id, (int)$report['id'], $user);
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with($sent ? 'success' : 'error', $sent ? 'HiredNext letterhead report sent and logged.' : 'Email send failed; the failure is recorded in Email History.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'Could not send report: ' . $e->getMessage());
        }
    }

    public function printReport($id)
    {
        if (!$this->adminUser()) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }
        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')->where('id', (int)$id)->get()->getRowArray();
        $reportVersion = (new CvReportVersionModel())->where('lead_id', (int)$id)->orderBy('version', 'DESC')->first();
        if (!$lead || !$reportVersion) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('pages/admin/cv-report-letterhead', [
            'lead' => $lead,
            'reportVersion' => $reportVersion,
            'report' => $this->decode((string)$reportVersion['report_json']),
            'showControls' => true,
        ]);
    }

    public function markPaymentVerified($id)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }
        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')->where('id', (int)$id)->get()->getRowArray();
        if (!$lead) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Candidate not found.');
        }
        if (empty($lead['payment_id'])) {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'No UPI reference has been submitted for this direct priority request.');
        }
        $db->table('cv_assessment_leads')->where('id', (int)$id)->update([
            'payment_status' => 'verified',
            'status' => 'in_review',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        (new CvAuditService())->record((int)$id, 'payment_verified', ['payment_reference' => $lead['payment_id'], 'amount' => $lead['amount'] ?? 599], $user, 'admin', 'verified');
        return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('success', 'Payment marked verified. This CV is now eligible for priority analysis.');
    }

    public function offer($id, string $tier)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }
        try {
            $result = (new CvCandidateMailer())->createAndSendOffer((int)$id, $tier, $user);
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with($result['sent'] ? 'success' : 'error', $result['sent'] ? 'Optional HiredNext service offer sent and logged.' : 'Offer email failed; failure is logged.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'Offer could not be created: ' . $e->getMessage());
        }
    }

    public function verifyUpgrade($id, $orderId)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }
        $orderModel = new CvUpgradeOrderModel();
        $order = $orderModel->find((int)$orderId);
        if (!$order || (int)$order['lead_id'] !== (int)$id || empty($order['payment_reference'])) {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'Upgrade payment reference not found.');
        }
        $now = date('Y-m-d H:i:s');
        $orderModel->update((int)$orderId, ['status' => 'verified', 'verified_at' => $now, 'updated_at' => $now]);
        if (($order['tier'] ?? '') === 'priority_599') {
            $db = \Config\Database::connect();
            $db->table('cv_assessment_leads')->where('id', (int)$id)->update([
                'assessment_plan' => 'priority_599',
                'amount' => 599,
                'payment_status' => 'verified',
                'payment_id' => $order['payment_reference'],
                'status' => 'in_review',
                'updated_at' => $now,
            ]);
        }
        (new CvAuditService())->record((int)$id, 'upgrade_payment_verified', ['order_id' => (int)$orderId, 'tier' => $order['tier'], 'amount' => $order['amount']], $user, 'admin', 'verified');
        return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('success', 'Upgrade payment marked verified.');
    }

    public function updateUpgradeStatus($id, $orderId)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }
        $status = trim((string)$this->request->getPost('status'));
        if (!in_array($status, ['in_fulfilment', 'delivered', 'cancelled'], true)) {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'Invalid fulfilment status.');
        }
        $model = new CvUpgradeOrderModel();
        $order = $model->find((int)$orderId);
        if (!$order || (int)$order['lead_id'] !== (int)$id) {
            return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('error', 'Upgrade order not found.');
        }
        $update = ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')];
        if ($status === 'delivered') {
            $update['delivered_at'] = date('Y-m-d H:i:s');
        }
        $model->update((int)$orderId, $update);
        (new CvAuditService())->record((int)$id, $status === 'delivered' ? 'rewrite_delivered' : 'upgrade_status_changed', ['order_id' => (int)$orderId, 'tier' => $order['tier'], 'status' => $status], $user, 'admin', $status);
        return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('success', 'CV service fulfilment status updated.');
    }

    public function login()
    {
        $identifier = trim((string)($this->request->getPost('identifier') ?? $this->request->getPost('username')));
        $password = (string)$this->request->getPost('password');
        if ($identifier === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Enter your HiredNext admin username or email and password.');
        }
        $model = new UserModel();
        $user = str_contains($identifier, '@') ? $model->authenticateByEmail($identifier, $password) : $model->authenticate($identifier, $password);
        if (!$user || !in_array($user['role'] ?? '', ['admin', 'manager', 'recruiter'], true)) {
            return redirect()->back()->withInput()->with('error', 'Invalid admin credentials or insufficient access.');
        }
        session()->regenerate();
        session()->set(self::SESSION_KEY, [
            'id' => $user['id'], 'name' => $user['name'] ?? $user['username'], 'username' => $user['username'],
            'email' => $user['email'] ?? '', 'role' => $user['role'],
        ]);
        return redirect()->to('/admin/cv-reviews');
    }

    public function logout()
    {
        session()->remove(self::SESSION_KEY);
        session()->regenerate();
        return redirect()->to('/admin/cv-reviews');
    }

    public function resume($id)
    {
        if (!$this->adminUser()) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in to view CV files.');
        }
        $db = \Config\Database::connect();
        $row = $db->table('cv_assessment_leads')->where('id', (int)$id)->get()->getRowArray();
        if (!$row) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $stored = trim((string)($row['resume_path'] ?? ''));
        $path = $stored !== '' ? ROOTPATH . ltrim($stored, '/') : '';
        if ($path === '' || !is_file($path) || !is_readable($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^A-Za-z0-9._-]+/', '-', (string)($row['name'] ?? 'candidate'));
        $filename = trim($safeName, '-') . '-CV-' . (int)$id . ($ext !== '' ? '.' . $ext : '');
        return $this->response->download($path, null)->setFileName($filename);
    }

    public function updateStatus($id)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }
        $status = trim((string)$this->request->getPost('status'));
        $allowed = ['new', 'payment_submitted', 'in_review', 'completed', 'closed'];
        if (!in_array($status, $allowed, true)) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Invalid CV review status.');
        }
        $db = \Config\Database::connect();
        $db->table('cv_assessment_leads')->where('id', (int)$id)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
        (new CvAuditService())->record((int)$id, 'lead_status_changed', ['status' => $status], $user, 'admin', $status);
        return redirect()->to('/admin/cv-reviews/' . (int)$id)->with('success', 'CV review status updated.');
    }

    private function adminUser(): ?array
    {
        $user = session(self::SESSION_KEY);
        return is_array($user) ? $user : null;
    }

    private function requireAdminRedirect()
    {
        $user = $this->adminUser();
        return $user ?: redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
    }

    private function providerConfiguration(): array
    {
        $providers = [new OpenAiProvider(), new AnthropicProvider(), new GeminiProvider()];
        $out = [];
        foreach ($providers as $provider) {
            $out[$provider->name()] = $provider->configured();
        }
        return $out;
    }

    private function decode(string $value): array
    {
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function json(array $value): string
    {
        return (string)json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    }

    private function reportText(array $report): string
    {
        $lines = [
            'HIREDNEXT CV ASSESSMENT REPORT',
            'Candidate: ' . ($report['candidate_name'] ?? ''),
            'Report ID: ' . ($report['report_id'] ?? ''),
            '',
            'RECRUITER SUMMARY',
            $report['recruiter_summary'] ?? '',
            '',
            'OVERALL VERDICT',
            $report['overall_verdict'] ?? '',
            '',
        ];
        foreach (($report['priority_changes'] ?? []) as $i => $finding) {
            $lines[] = ($i + 1) . '. ' . ($finding['finding'] ?? '');
            $lines[] = 'Evidence: ' . ($finding['evidence'] ?? '');
            $lines[] = 'Why it matters: ' . ($finding['why_it_matters'] ?? '');
            $lines[] = 'Recommended change: ' . ($finding['recommendation'] ?? '');
            $lines[] = '';
        }
        return implode("\n", $lines);
    }
}
