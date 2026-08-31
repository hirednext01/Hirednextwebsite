<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CvEmailEventModel;
use App\Services\Cv\CvAuditService;

class CvAssessment extends BaseController
{
    public function submit()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[6]',
            'assessment_plan' => 'required|in_list[free,priority_599]',
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $plan = (string) $this->request->getPost('assessment_plan');
        $resume = $this->request->getFile('resume');
        if (!$resume || !$resume->isValid() || $resume->hasMoved()) {
            return redirect()->back()->withInput()->with('errors', ['resume' => 'Please upload a valid CV.']);
        }
        if ($resume->getSizeByUnit('mb') > 5) {
            return redirect()->back()->withInput()->with('errors', ['resume' => 'CV must be 5MB or smaller.']);
        }
        if (!in_array(strtolower($resume->getExtension()), ['pdf', 'doc', 'docx'], true)) {
            return redirect()->back()->withInput()->with('errors', ['resume' => 'CV must be PDF, DOC or DOCX.']);
        }

        $uploadDir = WRITEPATH . 'uploads/cv-assessments';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0750, true);
        }
        $storedName = $resume->getRandomName();
        $originalName = $resume->getClientName();
        $resume->move($uploadDir, $storedName);

        $db = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');
        $lead = [
            'name' => trim((string) $this->request->getPost('name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'assessment_plan' => $plan,
            'job_slug' => trim((string) $this->request->getPost('job_slug')) ?: null,
            'job_title' => trim((string) $this->request->getPost('job_title')) ?: null,
            'message' => trim((string) $this->request->getPost('message')) ?: null,
            'resume_path' => 'writable/uploads/cv-assessments/' . $storedName,
            'amount' => $plan === 'priority_599' ? 599 : 0,
            'payment_status' => $plan === 'free' ? 'not_required' : 'awaiting_payment',
            'payment_id' => null,
            'status' => 'new',
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $db->table('cv_assessment_leads')->insert($lead);
        $leadId = (int)$db->insertID();

        $audit = new CvAuditService();
        $audit->record($leadId, 'cv_received', [
            'assessment_plan' => $plan,
            'job_title' => $lead['job_title'],
            'resume_name' => $originalName,
            'resume_stored' => true,
        ], null, 'web', 'received');

        $serviceLabel = $plan === 'priority_599' ? '₹599 Priority CV Assessment / 12 hours' : 'Free CV Assessment / 7–10 days';
        $subject = $plan === 'priority_599'
            ? 'New ₹599 Priority CV Assessment Lead #' . $leadId . ' — awaiting payment'
            : 'New Free CV Assessment Lead #' . $leadId;

        $internalEvent = $this->emailAttempt($leadId, 'internal_cv_received', 'tarushikha@hirednext.info', $subject);
        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo('tarushikha@hirednext.info');
        $email->setReplyTo($lead['email'], $lead['name']);
        $email->setSubject($subject);
        $email->setMessage(
            "NEW HIREDNEXT CV ASSESSMENT REQUEST\n\n" .
            "Name: {$lead['name']}\nEmail: {$lead['email']}\nPhone: {$lead['phone']}\n" .
            "Service: {$serviceLabel}\nJob: " . ($lead['job_title'] ?: 'Not specified') . "\n" .
            "Payment status: {$lead['payment_status']}\nLead ID: {$leadId}\nSubmitted: {$lead['created_at']}\n\n" .
            "Message:\n" . ($lead['message'] ?: '—')
        );
        $email->attach($uploadDir . '/' . $storedName, 'attachment', $originalName);
        $internalSent = $email->send(false);
        if ($internalSent) {
            $this->emailSent($internalEvent);
            $audit->record($leadId, 'internal_cv_alert_sent', ['recipient' => 'tarushikha@hirednext.info'], null, 'email', 'sent');
        } else {
            $error = $email->printDebugger(['headers']);
            $this->emailFailed($internalEvent, $error);
            $audit->record($leadId, 'internal_cv_alert_failed', ['error' => mb_substr($error, 0, 800)], null, 'email', 'failed');
            log_message('error', 'CV assessment notification email failed for lead #' . $leadId . ': ' . $error);
        }

        $ackSubject = 'We have received your CV review request | HiredNext';
        $ackEvent = $this->emailAttempt($leadId, 'candidate_acknowledgement', $lead['email'], $ackSubject);
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo($lead['email']);
        $email->setReplyTo('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setSubject($ackSubject);

        $ackMessage = "Dear {$lead['name']},\n\nThank you for asking HiredNext to review your CV. We have received your CV and registered your request as #{$leadId}.\n\nService: {$serviceLabel}\n";
        if ($plan === 'priority_599') {
            $ackMessage .= "Payment status: awaiting payment\n\nTo activate the priority review, complete the ₹599 payment on the secure HiredNext payment page:\n" . base_url('cv-payment/' . $leadId) . "\n\n";
        } else {
            $ackMessage .= "Your review is in the free 7–10 day queue. We will contact you by email after review.\n\n";
        }
        $ackMessage .= "Please note: CV review is a professional advisory service. HiredNext never charges candidates to apply for jobs or secure placement.\n\nRegards,\nHiredNext Jobs Team\njobs@hirednext.info\nhttps://hirednext.net\n";
        $email->setMessage($ackMessage);
        $ackSent = $email->send(false);
        if ($ackSent) {
            $this->emailSent($ackEvent);
            $audit->record($leadId, 'acknowledgement_sent', ['recipient' => $lead['email']], null, 'email', 'sent');
        } else {
            $error = $email->printDebugger(['headers']);
            $this->emailFailed($ackEvent, $error);
            $audit->record($leadId, 'acknowledgement_failed', ['error' => mb_substr($error, 0, 800)], null, 'email', 'failed');
            log_message('error', 'CV assessment acknowledgement email failed for lead #' . $leadId . ': ' . $error);
        }

        if ($plan === 'priority_599') {
            return redirect()->to('/cv-payment/' . $leadId);
        }
        return redirect()->to('/services/cv-assessment?submitted=1')->with('success', 'Your CV assessment request has been received. We will email you after review.');
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
