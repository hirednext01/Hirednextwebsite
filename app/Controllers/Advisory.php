<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Advisory extends BaseController
{
    private function advisoryPlans(): array
    {
        return [
            'career-strategy' => [
                'name' => 'Career Strategy & Market Fit',
                'amount' => 6500,
                'amount_label' => '₹6,500',
                'description' => 'Researched career strategy for experienced professionals who want clarity on role fit, positioning, market fit and next-step strategy.',
            ],
            'cxo-advisory' => [
                'name' => 'CXO Strategic Advisory',
                'amount' => 12500,
                'amount_label' => '₹12,500',
                'description' => 'Confidential strategic advisory for CXOs and senior leaders navigating high-stakes career, role, compensation, transition or positioning decisions.',
            ],
        ];
    }

    public function gateway()
    {
        return view('pages/speak-to-hirednext', [
            'title' => 'Speak to HiredNext | Hiring, Jobs & Strategic Advisory',
            'metaDescription' => 'Choose the right HiredNext route for a hiring mandate, career strategy, CXO strategic advisory or current job opportunities.',
            'canonical' => base_url('speak-to-hirednext'),
            'currentPage' => 'contact',
            'settings' => $this->loadWebsiteSettings(),
        ]);
    }

    public function hiringDiscussion()
    {
        return view('pages/hiring-discussion', [
            'title' => 'Discuss a Hiring Mandate | HiredNext Recruitment',
            'metaDescription' => 'Share your active or upcoming hiring requirement with HiredNext before scheduling a recruitment discussion.',
            'canonical' => base_url('hiring-discussion'),
            'currentPage' => 'contact',
            'settings' => $this->loadWebsiteSettings(),
        ]);
    }

    public function submitHiringDiscussion()
    {
        $fields = ['name', 'email', 'company', 'designation', 'role', 'location', 'compensation', 'timeline', 'brief'];
        $lead = [];
        foreach ($fields as $field) {
            $lead[$field] = trim((string) $this->request->getPost($field));
        }

        if ($lead['name'] === '' || !filter_var($lead['email'], FILTER_VALIDATE_EMAIL) || $lead['company'] === '' || $lead['role'] === '' || $lead['location'] === '' || $lead['brief'] === '') {
            return redirect()->back()->withInput()->with('error', 'Please complete the required hiring details.');
        }

        $subject = 'Lead generated through website';
        $message = "NEW HIREDNEXT WEBSITE HIRING LEAD\n\n"
            . "Name: {$lead['name']}\n"
            . "Work email: {$lead['email']}\n"
            . "Company: {$lead['company']}\n"
            . "Designation: {$lead['designation']}\n"
            . "Role(s): {$lead['role']}\n"
            . "Location(s): {$lead['location']}\n"
            . "Compensation / seniority: {$lead['compensation']}\n"
            . "Hiring timeline: {$lead['timeline']}\n\n"
            . "Mandate brief:\n{$lead['brief']}\n\n"
            . "Source: hirednext.net/hiring-discussion\n";

        $email = \Config\Services::email();
        $email->setTo('tarushikha@hirednext.info');
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->setMailType('text');
        $email->setReplyTo($lead['email'], $lead['name']);
        $sent = $email->send(false);

        try {
            $db = \Config\Database::connect();
            $db->table('contact_messages')->insert([
                'name' => htmlspecialchars($lead['name']),
                'email' => htmlspecialchars($lead['email']),
                'subject' => $subject,
                'message' => htmlspecialchars($message),
                'status' => 'new',
                'ip_address' => $this->request->getIPAddress(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Hiring lead database save failed: ' . $e->getMessage());
        }

        if (!$sent) {
            log_message('error', 'Hiring lead email failed for ' . $lead['email']);
        }

        return redirect()->to('https://calendly.com/tarushikha-hirednext/30min');
    }

    public function index()
    {
        return view('pages/advisory', [
            'title' => 'Career Strategy & CXO Strategic Advisory | HiredNext',
            'metaDescription' => 'Limited researched career strategy and confidential CXO advisory appointments from HiredNext for experienced professionals and senior leaders.',
            'canonical' => base_url('advisory'),
            'currentPage' => 'advisory',
            'settings' => $this->loadWebsiteSettings(),
        ]);
    }

    public function payment(string $planKey)
    {
        $plans = $this->advisoryPlans();
        if (!isset($plans[$planKey])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('pages/advisory-payment', [
            'title' => 'Complete Advisory Payment | HiredNext',
            'metaDescription' => 'Secure HiredNext UPI payment and advisory request submission.',
            'canonical' => base_url('advisory'),
            'currentPage' => 'advisory',
            'settings' => $this->loadWebsiteSettings(),
            'planKey' => $planKey,
            'plan' => $plans[$planKey],
        ]);
    }

    public function submitAdvisoryPayment()
    {
        $plans = $this->advisoryPlans();
        $planKey = trim((string) $this->request->getPost('plan'));
        if (!isset($plans[$planKey])) {
            return redirect()->to('/advisory')->with('error', 'Please choose a valid advisory service.');
        }

        $plan = $plans[$planKey];
        $fields = ['name', 'email', 'phone', 'linkedin', 'current_role', 'years_experience', 'target_roles', 'challenge', 'decision', 'payment_reference'];
        $lead = [];
        foreach ($fields as $field) {
            $lead[$field] = trim((string) $this->request->getPost($field));
        }

        $requiredMissing = $lead['name'] === ''
            || !filter_var($lead['email'], FILTER_VALIDATE_EMAIL)
            || $lead['phone'] === ''
            || $lead['linkedin'] === ''
            || $lead['current_role'] === ''
            || $lead['years_experience'] === ''
            || $lead['target_roles'] === ''
            || $lead['challenge'] === ''
            || strlen($lead['payment_reference']) < 6;

        if ($planKey === 'cxo-advisory' && $lead['decision'] === '') {
            $requiredMissing = true;
        }

        if ($requiredMissing) {
            return redirect()->back()->withInput()->with('error', 'Please complete the required advisory details and enter a valid UPI transaction/reference number.');
        }

        $subject = $plan['amount_label'] . ' advisory payment submitted — ' . $plan['name'];
        $message = "NEW HIREDNEXT ADVISORY PAYMENT SUBMISSION\n\n"
            . "Service: {$plan['name']}\n"
            . "Amount: {$plan['amount_label']}\n"
            . "UPI reference: {$lead['payment_reference']}\n\n"
            . "Name: {$lead['name']}\n"
            . "Email: {$lead['email']}\n"
            . "Phone: {$lead['phone']}\n"
            . "LinkedIn: {$lead['linkedin']}\n"
            . "Current role/company: {$lead['current_role']}\n"
            . "Years of experience: {$lead['years_experience']}\n"
            . "Target roles/industries: {$lead['target_roles']}\n\n"
            . "Challenge to solve:\n{$lead['challenge']}\n\n"
            . ($lead['decision'] !== '' ? "Decision / desired outcome:\n{$lead['decision']}\n\n" : '')
            . "Payment status: pending verification\n"
            . "Source: hirednext.net/advisory/payment/{$planKey}\n";

        try {
            $db = \Config\Database::connect();
            $db->table('contact_messages')->insert([
                'name' => htmlspecialchars($lead['name']),
                'email' => htmlspecialchars($lead['email']),
                'subject' => $subject,
                'message' => htmlspecialchars($message),
                'status' => 'new',
                'ip_address' => $this->request->getIPAddress(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Advisory payment submission database save failed: ' . $e->getMessage());
        }

        $email = \Config\Services::email();
        $email->setTo('tarushikha@hirednext.info');
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->setMailType('text');
        $email->setReplyTo($lead['email'], $lead['name']);
        if (!$email->send(false)) {
            log_message('error', 'Advisory payment notification failed for ' . $lead['email']);
        }

        return redirect()->to('/advisory?payment=submitted&plan=' . rawurlencode($planKey))
            ->with('success', 'Your payment reference and advisory request have been received. HiredNext will verify the UPI payment before confirming the appointment.');
    }
}
