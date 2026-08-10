<?php

namespace App\Models;

use CodeIgniter\Model;

class UserSessionModel extends Model
{
    protected $table = 'user_sessions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id', 'token', 'ip_address', 'user_agent', 'expires_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;

    public function createSession($userId, $token, $ipAddress = null, $userAgent = null)
    {
        // Set expiration to 24 hours from now
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $data = [
            'user_id' => $userId,
            'token' => $token,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'expires_at' => $expiresAt,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Disable timestamps for this insert to avoid conflicts
        $this->useTimestamps = false;
        $result = $this->insert($data);
        $this->useTimestamps = true;
        
        return $result;
    }

    public function validateToken($token)
    {
        $session = $this->where('token', $token)
                       ->where('expires_at >', date('Y-m-d H:i:s'))
                       ->first();

        return $session;
    }

    public function getUserByToken($token)
    {
        $session = $this->validateToken($token);
        if (!$session) {
            return false;
        }

        $userModel = new UserModel();
        return $userModel->find($session['user_id']);
    }

    public function deleteSession($token)
    {
        return $this->where('token', $token)->delete();
    }

    public function deleteUserSessions($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }

    public function cleanupExpiredSessions()
    {
        return $this->where('expires_at <', date('Y-m-d H:i:s'))->delete();
    }

    public function getActiveSessions($userId = null)
    {
        $query = $this->where('expires_at >', date('Y-m-d H:i:s'));
        
        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->findAll();
    }
}
