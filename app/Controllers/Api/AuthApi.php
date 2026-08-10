<?php

namespace App\Controllers\Api;

use App\Models\UserModel;
use App\Models\UserSessionModel;

class AuthApi extends BaseApiController
{
    protected $userModel;
    protected $sessionModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->sessionModel = new UserSessionModel();
    }

    public function login()
    {
        try {
            $rules = [
                'username' => 'required|min_length[3]',
                'password' => 'required|min_length[6]'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $data = $this->request->getJSON(true);
            $username = $data['username'];
            $password = $data['password'];

            // Authenticate user
            $user = $this->userModel->authenticate($username, $password);
            
            if ($user) {
                // Generate token
                $token = bin2hex(random_bytes(32));
                
                // Create session
                $ipAddress = $this->request->getIPAddress();
                $userAgent = $this->request->getUserAgent()->getAgentString();
                
                $this->sessionModel->createSession($user['id'], $token, $ipAddress, $userAgent);
                
                // Remove password from response
                unset($user['password']);
                
                return $this->successResponse([
                    'token' => $token,
                    'user' => $user
                ], 'Login successful');
            } else {
                return $this->errorResponse('Invalid credentials', 401);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Login failed: ' . $e->getMessage(), 500);
        }
    }

    public function logout()
    {
        try {
            $token = $this->request->getHeaderLine('Authorization');
            $token = str_replace('Bearer ', '', $token);
            
            if ($token) {
                $this->sessionModel->deleteSession($token);
            }
            
            return $this->successResponse(null, 'Logout successful');
        } catch (\Exception $e) {
            return $this->errorResponse('Logout failed: ' . $e->getMessage(), 500);
        }
    }

    public function me()
    {
        try {
            $token = $this->request->getHeaderLine('Authorization');
            $token = str_replace('Bearer ', '', $token);
            
            if (!$token) {
                return $this->errorResponse('No token provided', 401);
            }
            
            $user = $this->sessionModel->getUserByToken($token);
            
            if (!$user) {
                return $this->errorResponse('Invalid or expired token', 401);
            }
            
            // Remove password from response
            unset($user['password']);
            
            return $this->successResponse($user, 'User info retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get user info: ' . $e->getMessage(), 500);
        }
    }

    public function changePassword()
    {
        try {
            $rules = [
                'current_password' => 'required|min_length[6]',
                'new_password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[new_password]'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $token = $this->request->getHeaderLine('Authorization');
            $token = str_replace('Bearer ', '', $token);
            
            if (!$token) {
                return $this->errorResponse('No token provided', 401);
            }
            
            $user = $this->sessionModel->getUserByToken($token);
            
            if (!$user) {
                return $this->errorResponse('Invalid or expired token', 401);
            }

            $data = $this->request->getJSON(true);
            
            // Verify current password
            if (!$this->userModel->verifyPassword($user['id'], $data['current_password'])) {
                return $this->errorResponse('Current password is incorrect', 400);
            }
            
            // Change password
            $this->userModel->changePassword($user['id'], $data['new_password']);
            
            return $this->successResponse(null, 'Password changed successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to change password: ' . $e->getMessage(), 500);
        }
    }
}
