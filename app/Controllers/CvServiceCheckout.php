<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CvUpgradeOrderModel;
use App\Services\Cv\CvAuditService;
use App\Services\Cv\CvUpgradePlans;

class CvServiceCheckout extends BaseController
{
    public function start(string $tier)
    {
        $canonicalTier = CvUpgradePlans::canonicalTier($tier);
        $plan = CvUpgradePlans::get($canonicalTier);
        if (!$plan || $canonicalTier === 'priority_992') {
            return redirect()->to('/services/cv-assessment');
        }
        if ($tier !== $canonicalTier) {
            return redirect()->to('/career-services/start/' . $canonicalTier);
        }

        return view('pages/services/cv-service-start', [
            'title' => $plan['name'] . ' | HiredNext',
            'metaDescription' => $plan['description'],
            'canonical' => base_url($canonicalTier === 'leadership_17500' ? 'leadership-advisory/cxo-global-leadership-positioning' : ($canonicalTier === 'linkedin_8999' ? 'services/linkedin-profile-build' : 'services/candidates')),
            'currentPage' => 'services',
            'settings' => $this->loadWebsiteSettings(),
            'tier' => $canonicalTier,
            'plan' => $plan,
        ]);
    }

    public function submit(string $tier)
    {
        $canonicalTier = CvUpgradePlans::canonicalTier($tier);
        $plan = CvUpgradePlans::get($canonicalTier);
        if (!$plan || $canonicalTier === 'priority_992') {
            return redirect()->to('/services/cv-assessment');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[6]',
        ];
        if ($canonicalTier === 'leadership_17500') {
            foreach (\App\Services\Cv\LeadershipContext::FIELDS as $field => $label) {
                $rules[$field] = in_array($field, ['leadership_level', 'leadership_scope', 'leadership_target'], true)
                    ? 'required|max_length[1000]' : 'permit_empty|max_length[1000]';
            }
        }
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $resume = $this->request->getFile('resume');
        if (!$resume || !$resume->isValid() || $resume->hasMoved()) {
            return redirect()->back()->withInput()->with('errors', ['resume' => 'Please upload your current CV so HiredNext can prepare the service around your actual profile.']);
        }
        if ($resume->getSizeByUnit('mb') > 5 || !in_array(strtolower($resume->getExtension()), ['pdf', 'doc', 'docx'], true)) {
            return redirect()->back()->withInput()->with('errors', ['resume' => 'Please upload a PDF, DOC or DOCX CV up to 5MB.']);
        }

        $uploadDir = WRITEPATH . 'uploads/cv-assessments';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0750, true);
        $storedName = $resume->getRandomName();
        $originalName = $resume->getClientName();
        $resume->move($uploadDir, $storedName);

        $db = db_connect();
        $now = date('Y-m-d H:i:s');
        $message = trim((string) $this->request->getPost('message'));
        if ($canonicalTier === 'leadership_17500') {
            $message = \App\Services\Cv\LeadershipContext::appendToMessage($this->request->getPost(), $message);
        }
        $lead = [
            'name' => trim((string) $this->request->getPost('name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'assessment_plan' => $canonicalTier,
            'job_slug' => null,
            'job_title' => trim((string) $this->request->getPost('target_role')) ?: null,
            'message' => $message ?: null,
            'resume_path' => 'writable/uploads/cv-assessments/' . $storedName,
            'amount' => (int) $plan['amount'],
            'payment_status' => 'awaiting_payment',
            'payment_id' => null,
            'status' => 'checkout_started',
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $db->table('cv_assessment_leads')->insert($lead);
        $leadId = (int) $db->insertID();

        $token = bin2hex(random_bytes(24));
        $orderId = (int) (new CvUpgradeOrderModel())->insert([
            'lead_id' => $leadId,
            'token' => $token,
            'tier' => $canonicalTier,
            'service_name' => $plan['name'],
            'amount' => $plan['amount'],
            'status' => 'offered',
            'offered_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ], true);

        (new CvAuditService())->record($leadId, 'public_service_checkout_started', [
            'order_id' => $orderId,
            'tier' => $canonicalTier,
            'service_name' => $plan['name'],
            'amount' => $plan['amount'],
            'resume_name' => $originalName,
        ], null, 'web', 'awaiting_payment');

        return redirect()->to('/cv-upgrade/' . $token);
    }
}

