<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Advisory extends BaseController
{
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
}
