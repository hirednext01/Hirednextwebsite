<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Advisory extends BaseController
{
    private function advisoryPlans(): array
    {
        return [
            'career-intelligence' => [
                'name' => 'Executive Career Intelligence Assessment',
                'amount' => 19999,
                'amount_label' => '₹19,999',
                'description' => 'A confidential, evidence-led assessment of your career history, market position, target direction, compensation alignment, visibility and next best intervention.',
            ],
            'career-strategy' => [
                'name' => 'Career Strategy & Market Fit',
                'amount' => 6500,
                'amount_label' => '₹6,500',
                'description' => 'A prepared 60-minute advisory session for experienced professionals who want clarity on role fit, positioning, market fit and next-step strategy.',
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
        $email->clear(true);
        $email->setFrom('partners@hirednext.info', 'HiredNext Partnerships');
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

        return redirect()->to('/hiring-discussion?submitted=1')
            ->with('success', 'Your hiring requirement has been received. HiredNext will review the mandate and contact you directly if a discussion is appropriate.');
    }

    public function index()
    {
        return view('pages/advisory', [
            'title' => 'Leadership Advisory & Executive Career Positioning | HiredNext',
            'metaDescription' => 'Evidence-led executive career intelligence, leadership positioning, one-to-one coaching and confidential CXO advisory from HiredNext.',
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
        $fields = [
            'name', 'email', 'phone', 'linkedin', 'current_role', 'designation', 'department',
            'years_experience', 'current_ctc', 'expected_ctc', 'current_location', 'preferred_location',
            'notice_period', 'education', 'college', 'course_taken', 'additional_courses',
            'target_roles', 'challenge', 'decision', 'payment_reference'
        ];
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

        if ($planKey === 'career-intelligence') {
            $requiredMissing = $requiredMissing
                || $lead['designation'] === ''
                || $lead['department'] === ''
                || $lead['current_ctc'] === ''
                || $lead['expected_ctc'] === ''
                || $lead['current_location'] === ''
                || $lead['preferred_location'] === ''
                || $lead['notice_period'] === ''
                || $lead['education'] === ''
                || $lead['college'] === ''
                || $lead['course_taken'] === '';
        }

        if ($requiredMissing) {
            return redirect()->back()->withInput()->with('error', 'Please complete the required advisory details and enter a valid UPI transaction/reference number.');
        }

        $subject = 'ACTION: ' . $plan['amount_label'] . ' advisory payment submitted — ' . $plan['name'] . ' — ' . $lead['name'];
        $message = "NEW HIREDNEXT ADVISORY PAYMENT SUBMISSION\n\n"
            . "Service: {$plan['name']}\n"
            . "Amount: {$plan['amount_label']}\n"
            . "UPI reference: {$lead['payment_reference']}\n\n"
            . "Name: {$lead['name']}\n"
            . "Email: {$lead['email']}\n"
            . "Phone: {$lead['phone']}\n"
            . "LinkedIn: {$lead['linkedin']}\n"
            . "Current role/company: {$lead['current_role']}\n"
            . "Designation: {$lead['designation']}\n"
            . "Department / function: {$lead['department']}\n"
            . "Years of experience: {$lead['years_experience']}\n"
            . "Current CTC: {$lead['current_ctc']}\n"
            . "Expected CTC: {$lead['expected_ctc']}\n"
            . "Current location: {$lead['current_location']}\n"
            . "Preferred location: {$lead['preferred_location']}\n"
            . "Notice period: {$lead['notice_period']}\n"
            . "Education: {$lead['education']}\n"
            . "College / university: {$lead['college']}\n"
            . "Course taken: {$lead['course_taken']}\n"
            . "Additional courses / certifications: {$lead['additional_courses']}\n"
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

        // Internal paid-transaction alert to Taru.
        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo('tarushikha@hirednext.info');
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->setMailType('text');
        $email->setReplyTo($lead['email'], $lead['name']);
        if (!$email->send(false)) {
            log_message('error', 'Advisory payment notification failed for ' . $lead['email'] . ': ' . $email->printDebugger(['headers']));
        }

        // Candidate acknowledgement from jobs@ for every paid advisory submission.
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo($lead['email']);
        $email->setReplyTo('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setSubject('We have received your ' . $plan['name'] . ' request | HiredNext');
        $email->setMessage(
            "Dear {$lead['name']},\n\n" .
            "Thank you for choosing HiredNext for {$plan['name']}. We have received your advisory request and UPI payment reference.\n\n" .
            "Service: {$plan['name']}\n" .
            "Amount: {$plan['amount_label']}\n" .
            "Payment reference: {$lead['payment_reference']}\n" .
            "Status: pending payment verification\n\n" .
            "Our team will verify the transaction and review the information you submitted before the advisory appointment is confirmed.\n\n" .
            "This advisory service is separate from recruitment consideration. HiredNext never charges candidates to apply for jobs or secure placement.\n\n" .
            "Regards,\nHiredNext Jobs Team\njobs@hirednext.info\nhttps://hirednext.net\n"
        );
        if (!$email->send(false)) {
            log_message('error', 'Advisory acknowledgement failed for ' . $lead['email'] . ': ' . $email->printDebugger(['headers']));
        }

        return redirect()->to('/advisory?payment=submitted&plan=' . rawurlencode($planKey))
            ->with('success', 'Your payment reference and advisory request have been received. HiredNext will verify the UPI payment before confirming the appointment.');
    }
}
