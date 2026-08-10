<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactMessagesModel extends Model
{
    protected $table = 'contact_messages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 'email', 'phone', 'subject', 'message', 'status', 'ip_address'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
        'subject' => 'required|min_length[5]|max_length[200]',
        'message' => 'required|min_length[10]',
        'status' => 'required|in_list[new,read,replied,archived]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 2 characters long',
            'max_length' => 'Name cannot exceed 100 characters'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'max_length' => 'Email cannot exceed 100 characters'
        ],
        'subject' => [
            'required' => 'Subject is required',
            'min_length' => 'Subject must be at least 5 characters long',
            'max_length' => 'Subject cannot exceed 200 characters'
        ],
        'message' => [
            'required' => 'Message is required',
            'min_length' => 'Message must be at least 10 characters long'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getMessagesByStatus($status = 'new')
    {
        return $this->where('status', $status)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function getRecentMessages($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getUnreadCount()
    {
        return $this->where('status', 'new')->countAllResults();
    }

    public function markAsRead($id)
    {
        return $this->update($id, ['status' => 'read']);
    }

    public function markAsReplied($id)
    {
        return $this->update($id, ['status' => 'replied']);
    }

    public function markAsArchived($id)
    {
        return $this->update($id, ['status' => 'archived']);
    }
}
