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
        $plan = CvUpgradePlans::get($tier);
        if (!$plan || $tier === 'priority_599') {
            return redirect()->to('/services/cv-assessment');
        }

        return view('pages/services/cv-service-start', [
            'title' => $plan['name'] . ' | HiredNext',
            'metaDescription' => $plan['description'],
            'canonical' => base_url('services/candidates'),
            'currentPage' => 'services',
            'settings' => $this->loadWebsiteSettings(),
            'tier' => $tier,
            'plan' => $plan,
        ]);
    }

    public function submit(string $tier)
    {
        $plan = CvUpgradePlans::get($tier);
        if (!$plan || $tier === 'priority_599') {
            return redirect()->to('/services/cv-assessment');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[6]',
        ]);
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
        $lead = [
            'name' => trim((string) $this->request->getPost('name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'assessment_plan' => $tier,
            'job_slug' => null,
            'job_title' => trim((string) $this->request->getPost('target_role')) ?: null,
            'message' => trim((string) $this->request->getPost('message')) ?: null,
            'resume_path' => 'writable/uploads/cv-assessments/' . $storedName,
            'amount' => (int) $plan['amount'],
            'payment_status' => 'awaiting_payment',
            'payment_id' => null,
            'status' => 'new',
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $db->table('cv_assessment_leads')->insert($lead);
        $leadId = (int) $db->insertID();

        $token = bin2hex(random_bytes(24));
        $orderId = (int) (new CvUpgradeOrderModel())->insert([
            'lead_id' => $leadId,
            'token' => $token,
            'tier' => $tier,
            'service_name' => $plan['name'],
            'amount' => $plan['amount'],
            'status' => 'offered',
            'offered_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ], true);

        (new CvAuditService())->record($leadId, 'public_service_started', [
            'order_id' => $orderId,
            'tier' => $tier,
            'service_name' => $plan['name'],
            'amount' => $plan['amount'],
            'resume_name' => $originalName,
        ], null, 'web', 'awaiting_payment');

        $this->sendStartEmails($lead, $plan, $leadId, $token, $uploadDir . '/' . $storedName);

        return redirect()->to('/cv-upgrade/' . $token);
    }

    private function sendStartEmails(array $lead, array $plan, int $leadId, string $token, string $resumePath): void
    {
        $checkout = base_url('cv-upgrade/' . $token);
        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo($lead['email']);
        $email->setReplyTo('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setSubject('Your HiredNext career service request | ' . $plan['name']);
        $email->setMessage("Dear {$lead['name']},\n\nWe have received your current CV and your request for {$plan['name']} (₹" . number_format((int)$plan['amount']) . ").\n\nComplete the secure HiredNext payment step here:\n{$checkout}\n\nPlease save jobs@hirednext.info to your contacts. All communication about this service will come from this address.\n\nRegards,\nHiredNext Jobs Team\n");
        $email->send(false);

        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo('tarushikha@hirednext.info');
        $email->setReplyTo($lead['email'], $lead['name']);
        $email->setSubject('NEW PAID SERVICE REQUEST — ' . $plan['name'] . ' — ' . $lead['name']);
        $email->setMessage("Candidate: {$lead['name']}\nEmail: {$lead['email']}\nPhone: {$lead['phone']}\nService: {$plan['name']}\nAmount: ₹" . number_format((int)$plan['amount']) . "\nLead ID: {$leadId}\nStatus: awaiting payment\n");
        if (is_file($resumePath)) $email->attach($resumePath);
        $email->send(false);
    }
}
