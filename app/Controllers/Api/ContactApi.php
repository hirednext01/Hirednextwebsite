<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ContactApi extends BaseApiController
{
    public function submit()
    {
        try {
            // Handle both JSON and FormData
            $data = $this->request->getJSON(true);
            if (empty($data) || !is_array($data)) {
                // If no JSON, try getting POST data (FormData)
                $data = $this->request->getPost();
            }

            // Debug logging
            log_message('info', 'Contact form received data: ' . json_encode($data));

            // Ensure data is an array
            if (!is_array($data)) {
                $data = [];
            }

            // Map form fields to database fields
            // Form sends: firstName, lastName, email, phone, company, service, message
            // Database expects: name, email, phone, company, subject, message
            $firstName = trim($data['firstName'] ?? $data['first_name'] ?? '');
            $lastName = trim($data['lastName'] ?? $data['last_name'] ?? '');
            $name = trim($firstName . ' ' . $lastName);
            if (empty($name) && isset($data['name'])) {
                $name = trim($data['name']);
            }

            $email = trim($data['email'] ?? '');
            $phone = trim($data['phone'] ?? '');
            $company = trim($data['company'] ?? '');
            $service = trim($data['service'] ?? '');
            $message = trim($data['message'] ?? '');

            // Use service as subject if provided, otherwise use default
            $subject = !empty($service) ? $service : ($data['subject'] ?? 'General Inquiry');

            // Validate required fields
            if (empty($name)) {
                return $this->errorResponse("Name is required", 422);
            }
            if (empty($email)) {
                return $this->errorResponse("Email is required", 422);
            }
            if (empty($message)) {
                return $this->errorResponse("Message is required", 422);
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->errorResponse('Please provide a valid email address', 422);
            }

            $db = \Config\Database::connect();

            // Get client information
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
                'priority' => 'medium',
                'ip_address' => $request->getIPAddress(),
                'user_agent' => $request->getUserAgent(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('contact_messages')->insert($insertData);

            if ($result) {
                $insertData['id'] = $db->insertID();

                // Send notification email (optional - can be implemented later)
                // $this->sendNotificationEmail($insertData);

                return $this->successResponse(
                    ['lead_id' => $insertData['id']],
                    'Thank you for your message! We will get back to you soon.'
                );
            } else {
                return $this->errorResponse('Failed to submit your message. Please try again.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Contact form submission error: ' . $e->getMessage());
            log_message('error', 'Contact form submission data: ' . json_encode($data ?? []));
            log_message('error', 'Contact form stack trace: ' . $e->getTraceAsString());
            return $this->errorResponse('An error occurred while submitting your message: ' . $e->getMessage(), 500);
        }
    }

    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $leads = $db->table('contact_messages')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();

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
            $lead = $db->table('contact_messages')
                ->where('id', $id)
                ->get()
                ->getRowArray();

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

            // Check if lead exists
            $existing = $db->table('contact_messages')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Contact lead not found', 404);
            }

            $updateData = [
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Only update allowed fields
            $allowedFields = ['status'];
            foreach ($allowedFields as $field) {
                if (isset($data[$field])) {
                    $updateData[$field] = htmlspecialchars(trim($data[$field]));
                }
            }

            $result = $db->table('contact_messages')
                ->where('id', $id)
                ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Contact lead updated successfully');
            } else {
                return $this->errorResponse('Failed to update contact lead', 500);
            }
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

            // Check if lead exists
            $existing = $db->table('contact_messages')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Contact lead not found', 404);
            }

            $result = $db->table('contact_messages')
                ->where('id', $id)
                ->delete();

            if ($result) {
                return $this->successResponse([], 'Contact lead deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete contact lead', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting contact lead: ' . $e->getMessage(), 500);
        }
    }

    private function sendNotificationEmail($leadData)
    {
        // This can be implemented later with CodeIgniter's Email library
        // For now, we'll just log the new lead
        log_message('info', 'New contact lead received: ' . json_encode($leadData));
    }
}
