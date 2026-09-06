<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
            'assessment_plan' => 'permit_empty|in_list[priority_599]',
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $plan = 'priority_599';
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
            'first_touch_source' => trim((string) $this->request->getPost('first_touch_source')) ?: null,
            'first_touch_medium' => trim((string) $this->request->getPost('first_touch_medium')) ?: null,
            'first_touch_campaign' => trim((string) $this->request->getPost('first_touch_campaign')) ?: null,
            'first_touch_content' => trim((string) $this->request->getPost('first_touch_content')) ?: null,
            'latest_touch_source' => trim((string) $this->request->getPost('latest_touch_source')) ?: null,
            'latest_touch_medium' => trim((string) $this->request->getPost('latest_touch_medium')) ?: null,
            'latest_touch_campaign' => trim((string) $this->request->getPost('latest_touch_campaign')) ?: null,
            'latest_touch_content' => trim((string) $this->request->getPost('latest_touch_content')) ?: null,
            'resume_path' => 'writable/uploads/cv-assessments/' . $storedName,
            'amount' => $plan === 'priority_599' ? 599 : 0,
            'payment_status' => $plan === 'free' ? 'not_required' : 'awaiting_payment',
            'payment_id' => null,
            // This is a checkout draft only. The assessment is submitted and
            // notifications are sent after a payment reference is supplied.
            'status' => 'checkout_started',
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $db->table('cv_assessment_leads')->insert($lead);
        $leadId = (int)$db->insertID();

        $audit = new CvAuditService();
        $audit->record($leadId, 'checkout_started', [
            'assessment_plan' => $plan,
            'job_title' => $lead['job_title'],
            'resume_name' => $originalName,
            'resume_stored' => true,
            'first_touch' => [
                'source' => $lead['first_touch_source'], 'medium' => $lead['first_touch_medium'],
                'campaign' => $lead['first_touch_campaign'], 'content' => $lead['first_touch_content'],
            ],
            'latest_touch' => [
                'source' => $lead['latest_touch_source'], 'medium' => $lead['latest_touch_medium'],
                'campaign' => $lead['latest_touch_campaign'], 'content' => $lead['latest_touch_content'],
            ],
        ], null, 'web', 'awaiting_payment');

        return redirect()->to('/cv-payment/' . $leadId)->with(
            'success',
            'Your CV is held securely for checkout. Your assessment request will be submitted only after you pay ₹599 and enter the UPI transaction/reference number.'
        );
    }
}
