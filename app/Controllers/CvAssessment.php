<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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
        $paymentReference = trim((string) $this->request->getPost('payment_reference'));
        if ($plan === 'priority_599' && $paymentReference === '') {
            return redirect()->back()->withInput()->with('errors', ['payment_reference' => 'Please enter the UPI transaction/reference number after paying ₹599.']);
        }

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
            'payment_status' => $plan === 'free' ? 'not_required' : 'pending_verification',
            'payment_id' => $plan === 'priority_599' ? $paymentReference : null,
            'status' => 'new',
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $db->table('cv_assessment_leads')->insert($lead);
        $leadId = $db->insertID();

        $subject = $plan === 'priority_599'
            ? 'New ₹599 Priority CV Assessment Lead #' . $leadId . ' — payment verification needed'
            : 'New Free CV Assessment Lead #' . $leadId;

        $email = \Config\Services::email();
        $email->setTo('tarushikha@hirednext.info');
        $email->setSubject($subject);
        $email->setMessage(
            "New HiredNext CV assessment lead\n\n" .
            "Name: {$lead['name']}\n" .
            "Email: {$lead['email']}\n" .
            "Phone: {$lead['phone']}\n" .
            "Service: " . ($plan === 'priority_599' ? '₹599 Priority / 12 hours' : 'Free / 7–10 days') . "\n" .
            "Job: " . ($lead['job_title'] ?: 'Not specified') . "\n" .
            "UPI reference: " . ($paymentReference ?: 'Not required') . "\n" .
            "Payment status: {$lead['payment_status']}\n" .
            "Lead ID: {$leadId}\n\n" .
            "Message:\n" . ($lead['message'] ?: '—')
        );
        $email->attach($uploadDir . '/' . $storedName, 'attachment', $resume->getClientName());
        if (!$email->send()) {
            log_message('error', 'CV assessment notification email failed for lead #' . $leadId . ': ' . $email->printDebugger(['headers']));
        }

        if ($plan === 'priority_599') {
            return redirect()->to('/cv-assessment?payment=verification_pending')->with('success', 'Your priority CV assessment request is saved. We will verify your ₹599 UPI payment and begin the 12-hour assessment after verification.');
        }

        return redirect()->to('/cv-assessment?submitted=1')->with('success', 'Your CV assessment request has been received. We will email you after review.');
    }
}
