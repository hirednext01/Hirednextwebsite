<?php

namespace App\Controllers\Api;

class ContactApi extends BaseApiController
{
    public function submit()
    {
        try {
            $data = $this->request->getJSON(true);
            if (empty($data) || !is_array($data)) {
                $data = $this->request->getPost();
            }
            if (!is_array($data)) {
                $data = [];
            }

            $firstName = trim($data['firstName'] ?? $data['first_name'] ?? '');
            $lastName = trim($data['lastName'] ?? $data['last_name'] ?? '');
            $name = trim($firstName . ' ' . $lastName);
            if ($name === '' && isset($data['name'])) {
                $name = trim((string) $data['name']);
            }

            $email = trim((string) ($data['email'] ?? ''));
            $phone = trim((string) ($data['phone'] ?? ''));
            $company = trim((string) ($data['company'] ?? $data['subject'] ?? ''));
            $service = trim((string) ($data['service'] ?? ''));
            $message = trim((string) ($data['message'] ?? ''));
            $subject = $service !== '' ? $service : trim((string) ($data['subject'] ?? 'General Inquiry'));

            if ($name === '') {
                return $this->formError('Name is required', 422);
            }
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->formError('Please provide a valid email address', 422);
            }
            if ($message === '') {
                return $this->formError('Message is required', 422);
            }

            $db = \Config\Database::connect();
            $request = \Config\Services::request();
            $insertData = [
                'name' => htmlspecialchars($name),
                'email' => htmlspecialchars($email),
                'phone' => htmlspecialchars($phone),
                'company' => htmlspecialchars($company),
                'subject' => htmlspecialchars($subject),
                'message' => htmlspecialchars($message),
                'source' => 'website_contact_form',
                'status' => 'new',
                'priority' => in_array($service, ['Executive Search', 'Permanent Hiring', 'RPO Solutions'], true) ? 'high' : 'medium',
                'ip_address' => $request->getIPAddress(),
                'user_agent' => (string) $request->getUserAgent(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if (!$db->table('contact_messages')->insert($insertData)) {
                return $this->formError('Failed to submit your message. Please try again.', 500);
            }

            $insertData['id'] = $db->insertID();
            $this->sendNotificationEmail($insertData);

            if (!$this->request->isAJAX() && $this->request->getJSON(true) === null) {
                return redirect()->to('/contact?submitted=1')->with('success', 'Thank you! Your inquiry has been received.');
            }

            return $this->successResponse(
                ['lead_id' => $insertData['id']],
                'Thank you for your message! We will get back to you soon.'
            );
        } catch (\Throwable $e) {
            log_message('error', 'Contact form submission error: ' . $e->getMessage());
            return $this->formError('An error occurred while submitting your message.', 500);
        }
    }

    private function formError(string $message, int $status)
    {
        if (!$this->request->isAJAX() && $this->request->getJSON(true) === null) {
            return redirect()->back()->withInput()->with('errors', [$message]);
        }
        return $this->errorResponse($message, $status);
    }

    private function sendNotificationEmail(array $leadData): void
    {
        try {
            $mail = \Config\Services::email();
            $mail->setFrom('partners@hirednext.info', 'HiredNext Recruitment');
            $mail->setTo('tarushikha@hirednext.info');
            $mail->setReplyTo((string) $leadData['email'], (string) $leadData['name']);
            $mail->setSubject('[HiredNext Website Lead] ' . (string) $leadData['subject']);
            $mail->setMessage(
                "New website inquiry received.\n\n" .
                'Lead ID: ' . (string) $leadData['id'] . "\n" .
                'Name: ' . (string) $leadData['name'] . "\n" .
                'Email: ' . (string) $leadData['email'] . "\n" .
                'Phone: ' . (string) ($leadData['phone'] ?? '') . "\n" .
                'Company: ' . (string) ($leadData['company'] ?? '') . "\n" .
                'Service: ' . (string) $leadData['subject'] . "\n" .
                'Priority: ' . (string) $leadData['priority'] . "\n\n" .
                "Message:\n" . html_entity_decode((string) $leadData['message']) . "\n\n" .
                'Source: hirednext.net'
            );

            if (!$mail->send()) {
                log_message('error', 'Founder notification email failed for website lead ID ' . (string) $leadData['id']);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Founder notification email exception for website lead ID ' . (string) ($leadData['id'] ?? '') . ': ' . $e->getMessage());
        }
    }

    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $leads = $db->table('contact_messages')->orderBy('created_at', 'DESC')->get()->getResultArray();
            $leads = array_map(function ($lead) {
                $lead['phone'] = $lead['phone'] ?? '';
                $lead['company'] = $lead['company'] ?? '';
                $lead['source'] = $lead['source'] ?? 'website';
                $lead['priority'] = $lead['priority'] ?? 'medium';
                $lead['assigned_to'] = $lead['assigned_to'] ?? '';
                $lead['notes'] = $lead['notes'] ?? '';
                $lead['user_agent'] = $lead['user_agent'] ?? '';
                return $lead;
            }, $leads);
            return $this->successResponse($leads, 'Contact leads retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving contact leads: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Contact lead ID is required', 400);
            }
            $db = \Config\Database::connect();
            $lead = $db->table('contact_messages')->where('id', $id)->get()->getRowArray();
            if (!$lead) {
                return $this->errorResponse('Contact lead not found', 404);
            }
            $lead['phone'] = $lead['phone'] ?? '';
            $lead['company'] = $lead['company'] ?? '';
            $lead['source'] = $lead['source'] ?? 'website';
            $lead['priority'] = $lead['priority'] ?? 'medium';
            $lead['assigned_to'] = $lead['assigned_to'] ?? '';
            $lead['notes'] = $lead['notes'] ?? '';
            $lead['user_agent'] = $lead['user_agent'] ?? '';
            return $this->successResponse($lead, 'Contact lead retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving contact lead: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Contact lead ID is required', 400);
            }
            $data = $this->request->getJSON(true);
            $db = \Config\Database::connect();
            $existing = $db->table('contact_messages')->where('id', $id)->get()->getRowArray();
            if (!$existing) {
                return $this->errorResponse('Contact lead not found', 404);
            }
            $updateData = ['updated_at' => date('Y-m-d H:i:s')];
            foreach (['status'] as $field) {
                if (isset($data[$field])) {
                    $updateData[$field] = htmlspecialchars(trim($data[$field]));
                }
            }
            if (!$db->table('contact_messages')->where('id', $id)->update($updateData)) {
                return $this->errorResponse('Failed to update contact lead', 500);
            }
            $updateData['id'] = $id;
            return $this->successResponse($updateData, 'Contact lead updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating contact lead: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Contact lead ID is required', 400);
            }
            $db = \Config\Database::connect();
            $existing = $db->table('contact_messages')->where('id', $id)->get()->getRowArray();
            if (!$existing) {
                return $this->errorResponse('Contact lead not found', 404);
            }
            if (!$db->table('contact_messages')->where('id', $id)->delete()) {
                return $this->errorResponse('Failed to delete contact lead', 500);
            }
            return $this->successResponse([], 'Contact lead deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting contact lead: ' . $e->getMessage(), 500);
        }
    }
}
