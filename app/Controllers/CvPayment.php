<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CvEmailEventModel;
use App\Services\Cv\CvAuditService;

class CvPayment extends BaseController
{
    public function qr()
    {
        $qrFile = FCPATH . 'theme/assets/hirednext-upi-qr.svg';
        if (!is_file($qrFile) || !is_readable($qrFile)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $qrBytes = file_get_contents($qrFile);
        if ($qrBytes === false || $qrBytes === '') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return $this->response
            ->setHeader('Content-Type', 'image/svg+xml; charset=UTF-8')
            ->setHeader('Cache-Control', 'private, no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setBody($qrBytes);
    }

    public function checkout($leadId = null)
    {
        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->where('assessment_plan', 'priority_599')->get()->getRowArray();
        if (!$lead) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('pages/services/cv-payment-direct', [
            'title' => 'Complete Payment | HiredNext',
            'currentPage' => 'services',
            'lead' => $lead,
        ]);
    }

    public function verify()
    {
        $leadId = (int)$this->request->getPost('lead_id');
        $paymentReference = trim((string)$this->request->getPost('payment_reference'));
        if (!$leadId || $paymentReference === '' || strlen($paymentReference) < 6) {
            return redirect()->back()->withInput()->with('errors', ['payment' => 'Please enter the UPI transaction/reference number shown by your payment app.']);
        }

        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->where('assessment_plan', 'priority_599')->get()->getRowArray();
        if (!$lead) {
            return redirect()->to('/services/cv-assessment?payment=failed')->with('errors', ['payment' => 'We could not find this CV assessment request.']);
        }

        $db->table('cv_assessment_leads')->where('id', $leadId)->update([
            'payment_id' => $paymentReference,
            'payment_status' => 'pending_verification',
            'status' => 'payment_submitted',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $audit = new CvAuditService();
        $audit->record($leadId, 'payment_reference_submitted', [
            'service' => 'Priority CV Assessment',
            'amount' => 599,
            'payment_reference' => $paymentReference,
        ], null, 'web', 'pending_verification');

        $resumePath = ROOTPATH . ltrim((string)($lead['resume_path'] ?? ''), '/');
        $internalSubject = 'ACTION: ₹599 CV review payment submitted #' . $leadId . ' — ' . ($lead['name'] ?? 'Candidate');
        $internalEvent = $this->emailAttempt($leadId, 'internal_payment_alert', 'tarushikha@hirednext.info', $internalSubject);
        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo('tarushikha@hirednext.info');
        $email->setReplyTo($lead['email'] ?? 'jobs@hirednext.info', $lead['name'] ?? 'Candidate');
        $email->setSubject($internalSubject);
        $email->setMessage(
            "PAID HIREDNEXT CV REVIEW — QUICK ACTION REQUIRED\n\n" .
            "Lead ID: {$leadId}\nName: " . ($lead['name'] ?? '') . "\nEmail: " . ($lead['email'] ?? '') . "\nPhone: " . ($lead['phone'] ?? '') . "\n" .
            "Service: Priority CV Assessment / 12 hours\nAmount: ₹599\nUPI reference: {$paymentReference}\nPayment status: pending verification\n" .
            "Submitted: " . ($lead['created_at'] ?? '') . "\n\nMessage:\n" . (($lead['message'] ?? '') ?: '—') . "\n"
        );
        if ($resumePath !== ROOTPATH && is_file($resumePath) && is_readable($resumePath)) {
            $email->attach($resumePath);
        }
        $internalSent = $email->send(false);
        if ($internalSent) {
            $this->emailSent($internalEvent);
            $audit->record($leadId, 'payment_alert_sent', ['recipient' => 'tarushikha@hirednext.info'], null, 'email', 'sent');
        } else {
            $error = $email->printDebugger(['headers']);
            $this->emailFailed($internalEvent, $error);
            $audit->record($leadId, 'payment_alert_failed', ['error' => mb_substr($error, 0, 800)], null, 'email', 'failed');
            log_message('error', 'Priority CV payment notification failed for lead #' . $leadId . ': ' . $error);
        }

        $ackSubject = 'HiredNext has received your Priority CV Review payment reference';
        $ackEvent = $this->emailAttempt($leadId, 'priority_payment_acknowledgement', (string)$lead['email'], $ackSubject);
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo($lead['email']);
        $email->setReplyTo('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setSubject($ackSubject);
        $email->setMessage(
            "Dear " . ($lead['name'] ?? 'Candidate') . ",\n\nThank you for asking HiredNext to review your CV. We have received your ₹599 Priority CV Assessment request and UPI transaction reference.\n\n" .
            "Your payment is now pending verification. Once verified, the priority review will be taken up for the 12-hour review window.\n\nReference: {$paymentReference}\nRequest ID: {$leadId}\n\n" .
            "Please note: this is a paid professional CV-review service. HiredNext never charges candidates to apply for jobs or secure placement.\n\nRegards,\nHiredNext Jobs Team\njobs@hirednext.info\nhttps://hirednext.net\n"
        );
        $ackSent = $email->send(false);
        if ($ackSent) {
            $this->emailSent($ackEvent);
            $audit->record($leadId, 'priority_payment_acknowledgement_sent', ['recipient' => $lead['email']], null, 'email', 'sent');
        } else {
            $error = $email->printDebugger(['headers']);
            $this->emailFailed($ackEvent, $error);
            $audit->record($leadId, 'priority_payment_acknowledgement_failed', ['error' => mb_substr($error, 0, 800)], null, 'email', 'failed');
            log_message('error', 'Priority CV payment acknowledgement failed for lead #' . $leadId . ': ' . $error);
        }

        return redirect()->to('/services/cv-assessment?payment=verification_pending')->with('success', 'Thank you. Your payment reference has been received. We will verify the ₹599 payment and start your 12-hour priority CV assessment.');
    }

    private function emailAttempt(int $leadId, string $type, string $recipient, string $subject): ?int
    {
        try { return (new CvEmailEventModel())->recordAttempt($leadId, $type, $recipient, $subject); } catch (\Throwable $e) { return null; }
    }

    private function emailSent(?int $id): void
    {
        if ($id) { (new CvEmailEventModel())->markSent($id); }
    }

    private function emailFailed(?int $id, string $error): void
    {
        if ($id) { (new CvEmailEventModel())->markFailed($id, $error); }
    }
}
