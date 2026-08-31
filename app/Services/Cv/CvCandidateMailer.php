<?php

namespace App\Services\Cv;

use App\Models\CvEmailEventModel;
use App\Models\CvReportVersionModel;
use App\Models\CvUpgradeOrderModel;

class CvCandidateMailer
{
    private CvAuditService $audit;

    public function __construct()
    {
        $this->audit = new CvAuditService();
    }

    public function sendReport(int $leadId, int $reportVersionId, ?array $actor = null): bool
    {
        $db = db_connect();
        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->get()->getRowArray();
        $reportVersion = (new CvReportVersionModel())->find($reportVersionId);
        if (!$lead || !$reportVersion || (int) ($reportVersion['lead_id'] ?? 0) !== $leadId) {
            throw new \RuntimeException('Candidate/report record not found.');
        }

        $report = json_decode((string) ($reportVersion['report_json'] ?? ''), true);
        if (!is_array($report)) {
            throw new \RuntimeException('Approved report content is invalid.');
        }

        $subject = 'Your HiredNext CV Assessment Report | ' . ($lead['name'] ?? 'Candidate');
        $html = view('pages/admin/cv-report-letterhead', [
            'lead' => $lead,
            'report' => $report,
            'reportVersion' => $reportVersion,
            'showControls' => false,
        ]);

        $eventId = $this->emailAttempt($leadId, 'report_delivery', (string) $lead['email'], $subject, $reportVersionId);
        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo($lead['email']);
        $email->setReplyTo('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setSubject($subject);
        $email->setMailType('html');
        $email->setMessage($html);
        $email->setAltMessage((string) ($reportVersion['report_text'] ?? 'Your HiredNext CV Assessment Report is ready.'));
        $sent = $email->send(false);

        if ($sent) {
            $this->emailSent($eventId);
            (new CvReportVersionModel())->update($reportVersionId, [
                'status' => 'sent',
                'sent_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $this->audit->record($leadId, 'report_sent', ['report_version_id' => $reportVersionId, 'recipient' => $lead['email']], $actor, 'email', 'sent');
            $this->sendInternalReportAlert($lead, $report, $reportVersionId);
            return true;
        }

        $error = $email->printDebugger(['headers']);
        $this->emailFailed($eventId, $error);
        $this->audit->record($leadId, 'send_failed', ['report_version_id' => $reportVersionId, 'error' => mb_substr($error, 0, 800)], $actor, 'email', 'failed');
        return false;
    }

    public function createAndSendOffer(int $leadId, string $tier, ?array $actor = null): array
    {
        $plan = CvUpgradePlans::get($tier);
        if (!$plan) {
            throw new \RuntimeException('Unknown CV service tier.');
        }

        $db = db_connect();
        if (!$db->tableExists('cv_upgrade_orders')) {
            throw new \RuntimeException('CV upgrade table is not installed. Run `php spark migrate`.');
        }
        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->get()->getRowArray();
        if (!$lead) {
            throw new \RuntimeException('CV review request not found.');
        }

        $orderModel = new CvUpgradeOrderModel();
        $order = $orderModel
            ->where('lead_id', $leadId)
            ->where('tier', $tier)
            ->whereIn('status', ['offered', 'payment_submitted', 'verified', 'in_fulfilment'])
            ->orderBy('id', 'DESC')
            ->first();

        if (!$order) {
            $now = date('Y-m-d H:i:s');
            $orderId = (int) $orderModel->insert([
                'lead_id' => $leadId,
                'token' => bin2hex(random_bytes(24)),
                'tier' => $tier,
                'service_name' => $plan['name'],
                'amount' => $plan['amount'],
                'status' => 'offered',
                'offered_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ], true);
            $order = $orderModel->find($orderId);
        }

        $checkoutUrl = base_url('cv-upgrade/' . $order['token']);
        $reason = $this->offerReason($leadId, $tier, $plan);
        $subject = 'Optional next step from your HiredNext CV assessment';
        $html = $this->offerHtml($lead, $plan, $reason, $checkoutUrl);
        $eventId = $this->emailAttempt($leadId, 'upgrade_offer_' . $tier, (string) $lead['email'], $subject, null);

        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo($lead['email']);
        $email->setReplyTo('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setSubject($subject);
        $email->setMailType('html');
        $email->setMessage($html);
        $email->setAltMessage(
            "Dear " . ($lead['name'] ?? 'Candidate') . ",\n\n" .
            "Based on your HiredNext CV assessment, an optional next step is {$plan['name']} for ₹" . number_format((int) $plan['amount']) . ".\n" .
            "Reason: {$reason}\n\nComplete only if useful to you: {$checkoutUrl}\n\nPaid services are optional and unrelated to recruitment consideration or placement.\n"
        );
        $sent = $email->send(false);

        if ($sent) {
            $this->emailSent($eventId);
            $this->audit->record($leadId, 'upgrade_offered', ['tier' => $tier, 'order_id' => $order['id'], 'amount' => $plan['amount']], $actor, 'email', 'sent');
        } else {
            $error = $email->printDebugger(['headers']);
            $this->emailFailed($eventId, $error);
            $this->audit->record($leadId, 'upgrade_offer_failed', ['tier' => $tier, 'order_id' => $order['id'], 'error' => mb_substr($error, 0, 800)], $actor, 'email', 'failed');
        }

        return ['sent' => $sent, 'order' => $order, 'checkout_url' => $checkoutUrl];
    }

    public function sendUpgradePaymentAcknowledgement(array $lead, array $order): bool
    {
        $subject = 'HiredNext has received your payment reference | ' . ($order['service_name'] ?? 'CV service');
        $amount = '₹' . number_format((int) ($order['amount'] ?? 0));
        $html = $this->simpleLetterheadHtml(
            'Payment reference received',
            'Dear ' . esc($lead['name'] ?? 'Candidate') . ',<br><br>' .
            'Thank you. HiredNext has received the payment reference you submitted for <strong>' . esc($order['service_name'] ?? '') . '</strong> (' . esc($amount) . ').<br><br>' .
            'Reference: <strong>' . esc($order['payment_reference'] ?? '') . '</strong><br>' .
            'Status: pending verification.<br><br>' .
            'Once verified, the service will move into the appropriate review/fulfilment queue.<br><br>' .
            '<span style="font-size:12px;color:#667085">This professional service is optional and has no bearing on HiredNext job applications, interviews or placement.</span>'
        );
        $eventId = $this->emailAttempt((int) $lead['id'], 'upgrade_payment_ack', (string) $lead['email'], $subject, null);
        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo($lead['email']);
        $email->setReplyTo('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setSubject($subject);
        $email->setMailType('html');
        $email->setMessage($html);
        $sent = $email->send(false);
        $sent ? $this->emailSent($eventId) : $this->emailFailed($eventId, $email->printDebugger(['headers']));
        return $sent;
    }

    public function sendInternalUpgradeAlert(array $lead, array $order): bool
    {
        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo('tarushikha@hirednext.info');
        $email->setReplyTo($lead['email'] ?? 'jobs@hirednext.info', $lead['name'] ?? 'Candidate');
        $email->setSubject('ACTION: CV service payment reference — ' . ($order['service_name'] ?? '') . ' — ' . ($lead['name'] ?? 'Candidate'));
        $email->setMailType('text');
        $email->setMessage(
            "HIREDNEXT CV SERVICE PAYMENT — ACTION REQUIRED\n\n" .
            "Candidate: " . ($lead['name'] ?? '') . "\n" .
            "Email: " . ($lead['email'] ?? '') . "\n" .
            "Phone: " . ($lead['phone'] ?? '') . "\n" .
            "Service: " . ($order['service_name'] ?? '') . "\n" .
            "Amount: ₹" . number_format((int) ($order['amount'] ?? 0)) . "\n" .
            "UPI reference: " . ($order['payment_reference'] ?? '') . "\n" .
            "Status: pending verification\n" .
            "CV Review ID: " . ($lead['id'] ?? '') . "\n"
        );
        $resume = ROOTPATH . ltrim((string) ($lead['resume_path'] ?? ''), '/');
        if (is_file($resume) && is_readable($resume)) {
            $email->attach($resume);
        }
        return $email->send(false);
    }

    private function sendInternalReportAlert(array $lead, array $report, int $reportVersionId): void
    {
        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo('tarushikha@hirednext.info');
        $email->setSubject('CV report sent — ' . ($lead['name'] ?? 'Candidate') . ' — ' . ($report['report_id'] ?? ''));
        $email->setMailType('text');
        $email->setMessage(
            "A HiredNext CV assessment report has been sent.\n\n" .
            "Candidate: " . ($lead['name'] ?? '') . "\n" .
            "Email: " . ($lead['email'] ?? '') . "\n" .
            "Report ID: " . ($report['report_id'] ?? '') . "\n" .
            "Report version: {$reportVersionId}\n" .
            "Recommendation: " . (($report['recommended_next_step']['service'] ?? '') ?: 'No paid rebuild automatically recommended') . "\n"
        );
        $email->send(false);
    }

    private function offerReason(int $leadId, string $tier, array $plan): string
    {
        $report = (new CvReportVersionModel())->where('lead_id', $leadId)->orderBy('version', 'DESC')->first();
        if ($report) {
            $data = json_decode((string) ($report['report_json'] ?? ''), true);
            $next = is_array($data) ? ($data['recommended_next_step'] ?? []) : [];
            $map = [
                'priority_599' => null,
                'ats_999' => 'ats_optimisation',
                'rebuild_1799' => 'professional_rebuild',
                'executive_2499' => 'executive_rebuild',
            ];
            if (($map[$tier] ?? 'not-match') !== 'not-match' && (($map[$tier] ?? null) === null || ($next['classification'] ?? '') === $map[$tier])) {
                return trim((string) ($next['reason'] ?? $plan['description']));
            }
        }
        return (string) $plan['description'];
    }

    private function offerHtml(array $lead, array $plan, string $reason, string $checkoutUrl): string
    {
        $amount = '₹' . number_format((int) $plan['amount']);
        $body = 'Dear ' . esc($lead['name'] ?? 'Candidate') . ',<br><br>' .
            'Your HiredNext CV review indicates that the following optional service may be useful:<br><br>' .
            '<div style="border:1px solid #dde3eb;border-left:4px solid #ff4e16;padding:16px;margin:16px 0"><strong style="font-size:18px;color:#0c3466">' . esc($plan['name']) . ' · ' . esc($amount) . '</strong><br><span style="color:#667085">' . esc($plan['delivery']) . '</span><br><br><strong>Why this is being recommended:</strong><br>' . esc($reason) . '</div>' .
            '<a href="' . esc($checkoutUrl) . '" style="display:inline-block;background:#0c3466;color:white;text-decoration:none;padding:12px 18px;border-radius:6px;font-weight:700">View HiredNext checkout</a><br><br>' .
            'You can also create a richer professional profile at <a href="https://www.theprofile360.in">TheProfile360.in</a> and add your improved CV there once ready.<br><br>' .
            '<span style="font-size:12px;color:#667085">This service is optional and is completely separate from recruitment consideration, interviews or placement through HiredNext.</span>';
        return $this->simpleLetterheadHtml('Optional next step from your CV assessment', $body);
    }

    private function simpleLetterheadHtml(string $title, string $body): string
    {
        return '<div style="max-width:720px;margin:0 auto;background:#fff;border:1px solid #e0e6ee;font-family:Arial,Helvetica,sans-serif;color:#172033">' .
            '<div style="padding:24px 30px;border-bottom:2px solid #0c3466"><div style="font-size:26px;font-weight:800;color:#0c3466">HIRED<span style="color:#ff4e16">NEXT</span></div><div style="font-size:10px;letter-spacing:2px;font-weight:700;color:#0c3466">RECRUITMENT</div></div>' .
            '<div style="padding:30px"><h1 style="font-family:Georgia,serif;font-size:24px;color:#0c3466;margin:0 0 20px">' . esc($title) . '</h1><div style="font-size:14px;line-height:1.65">' . $body . '</div></div>' .
            '<div style="padding:12px 30px;border-top:1px solid #e0e6ee;font-size:11px;color:#667085">Confidential · HiredNext Recruitment · hirednext.net · jobs@hirednext.info</div></div>';
    }

    private function emailAttempt(int $leadId, string $eventType, string $recipient, string $subject, ?int $reportVersionId): ?int
    {
        try {
            return (new CvEmailEventModel())->recordAttempt($leadId, $eventType, $recipient, $subject, $reportVersionId);
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function emailSent(?int $eventId): void
    {
        if ($eventId) {
            (new CvEmailEventModel())->markSent($eventId);
        }
    }

    private function emailFailed(?int $eventId, string $error): void
    {
        if ($eventId) {
            (new CvEmailEventModel())->markFailed($eventId, $error);
        }
    }
}
