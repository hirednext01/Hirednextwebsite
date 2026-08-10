<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'username', 'email', 'password', 'name', 'role', 'status', 'last_login'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'name' => 'required|min_length[2]|max_length[100]',
        'role' => 'required|in_list[admin,manager,editor,recruiter]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters long',
            'max_length' => 'Username cannot exceed 50 characters',
            'is_unique' => 'Username already exists'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'Email already exists'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long'
        ],
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 2 characters long',
            'max_length' => 'Name cannot exceed 100 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function authenticate($username, $password)
    {
        $user = $this->where('username', $username)
                    ->where('status', 'active')
                    ->first();

        if ($user && password_verify($password, $user['password'])) {
            // Update last login
            $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $user;
        }

        return false;
    }

    public function authenticateByEmail($email, $password)
    {
        $user = $this->where('email', $email)
                    ->where('status', 'active')
                    ->first();

        if ($user && password_verify($password, $user['password'])) {
            // Update last login
            $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $user;
        }

        return false;
    }

    public function getActiveUsers()
    {
        return $this->where('status', 'active')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)
                   ->where('status', 'active')
                   ->first();
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)
                   ->where('status', 'active')
                   ->first();
    }

    public function createUser($data)
    {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        return $this->insert($data);
    }

    public function updateUser($id, $data)
    {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        
        return $this->update($id, $data);
    }

    public function changePassword($id, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hashedPassword]);
    }

    public function verifyPassword($id, $password)
    {
        $user = $this->find($id);
        return $user && password_verify($password, $user['password']);
    }
}
