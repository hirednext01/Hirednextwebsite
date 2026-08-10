<?php

namespace App\Controllers\Api;

use App\Models\ContactMessagesModel;

class ContactMessagesApi extends BaseApiController
{
    protected $contactMessagesModel;

    public function __construct()
    {
        parent::__construct();
        $this->contactMessagesModel = new ContactMessagesModel();
    }

    public function index()
    {
        try {
            $status = $this->request->getGet('status') ?? 'new';
            $messages = $this->contactMessagesModel->getMessagesByStatus($status);
            
            return $this->successResponse($messages, 'Contact messages retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve contact messages: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Message ID is required', 400);
            }

            $message = $this->contactMessagesModel->find($id);
            if (!$message) {
                return $this->errorResponse('Message not found', 404);
            }

            return $this->successResponse($message, 'Message retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve message: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $rules = [
                'name' => 'required|min_length[2]|max_length[100]',
                'email' => 'required|valid_email|max_length[100]',
                'phone' => 'permit_empty|max_length[20]',
                'subject' => 'required|min_length[5]|max_length[200]',
                'message' => 'required|min_length[10]'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $data = $this->request->getJSON(true);
            $data['status'] = 'new';
            $data['ip_address'] = $this->request->getIPAddress();
            
            $messageId = $this->contactMessagesModel->insert($data);
            $message = $this->contactMessagesModel->find($messageId);
            
            return $this->successResponse($message, 'Message sent successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to send message: ' . $e->getMessage(), 500);
        }
    }

    public function markAsRead($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Message ID is required', 400);
            }

            $message = $this->contactMessagesModel->find($id);
            if (!$message) {
                return $this->errorResponse('Message not found', 404);
            }

            $this->contactMessagesModel->markAsRead($id);
            
            return $this->successResponse(null, 'Message marked as read');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update message: ' . $e->getMessage(), 500);
        }
    }

    public function markAsReplied($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Message ID is required', 400);
            }

            $message = $this->contactMessagesModel->find($id);
            if (!$message) {
                return $this->errorResponse('Message not found', 404);
            }

            $this->contactMessagesModel->markAsReplied($id);
            
            return $this->successResponse(null, 'Message marked as replied');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update message: ' . $e->getMessage(), 500);
        }
    }

    public function markAsArchived($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Message ID is required', 400);
            }

            $message = $this->contactMessagesModel->find($id);
            if (!$message) {
                return $this->errorResponse('Message not found', 404);
            }

            $this->contactMessagesModel->markAsArchived($id);
            
            return $this->successResponse(null, 'Message archived');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to archive message: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Message ID is required', 400);
            }

            $message = $this->contactMessagesModel->find($id);
            if (!$message) {
                return $this->errorResponse('Message not found', 404);
            }

            $this->contactMessagesModel->delete($id);
            
            return $this->successResponse(null, 'Message deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete message: ' . $e->getMessage(), 500);
        }
    }

    public function getStats()
    {
        try {
            $stats = [
                'total' => $this->contactMessagesModel->countAllResults(),
                'new' => $this->contactMessagesModel->getUnreadCount(),
                'read' => $this->contactMessagesModel->where('status', 'read')->countAllResults(),
                'replied' => $this->contactMessagesModel->where('status', 'replied')->countAllResults(),
                'archived' => $this->contactMessagesModel->where('status', 'archived')->countAllResults()
            ];
            
            return $this->successResponse($stats, 'Stats retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get stats: ' . $e->getMessage(), 500);
        }
    }
}
