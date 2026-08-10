<?php

namespace App\Controllers\Api;

use App\Models\UserModel;
use App\Models\UserSessionModel;

class UsersApi extends BaseApiController
{
    protected $userModel;
    protected $sessionModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->sessionModel = new UserSessionModel();
    }

    public function index()
    {
        try {
            $users = $this->userModel->getActiveUsers();
            
            // Remove passwords from response
            foreach ($users as &$user) {
                unset($user['password']);
            }
            
            return $this->successResponse($users, 'Users retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve users: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('User ID is required', 400);
            }

            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            // Remove password from response
            unset($user['password']);

            return $this->successResponse($user, 'User retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve user: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'name' => 'required|min_length[2]|max_length[100]',
                'role' => 'permit_empty|in_list[admin,manager,editor,recruiter]'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $data = $this->request->getJSON(true);
            $data['status'] = $data['status'] ?? 'active';
            $data['role'] = $data['role'] ?? 'editor';
            
            $userId = $this->userModel->createUser($data);
            $user = $this->userModel->find($userId);
            
            // Remove password from response
            unset($user['password']);
            
            return $this->successResponse($user, 'User created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to create user: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('User ID is required', 400);
            }

            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,' . $id . ']',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
                'name' => 'required|min_length[2]|max_length[100]',
                'role' => 'permit_empty|in_list[admin,manager,editor,recruiter]'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $data = $this->request->getJSON(true);
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            $this->userModel->updateUser($id, $data);
            $user = $this->userModel->find($id);
            
            // Remove password from response
            unset($user['password']);
            
            return $this->successResponse($user, 'User updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update user: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('User ID is required', 400);
            }

            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            // Delete all sessions for this user
            $this->sessionModel->deleteUserSessions($id);
            
            // Delete user
            $this->userModel->delete($id);
            
            return $this->successResponse(null, 'User deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete user: ' . $e->getMessage(), 500);
        }
    }

    public function changeStatus($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('User ID is required', 400);
            }

            $data = $this->request->getJSON(true);
            $status = $data['status'] ?? null;

            if (!in_array($status, ['active', 'inactive'])) {
                return $this->errorResponse('Invalid status. Must be active or inactive', 400);
            }

            $this->userModel->update($id, ['status' => $status]);
            
            // If deactivating, delete all sessions
            if ($status === 'inactive') {
                $this->sessionModel->deleteUserSessions($id);
            }
            
            return $this->successResponse(null, 'User status updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update user status: ' . $e->getMessage(), 500);
        }
    }

    public function changePassword($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('User ID is required', 400);
            }

            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[new_password]'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $data = $this->request->getJSON(true);

            // Verify current password
            if (!password_verify($data['current_password'], $user['password'])) {
                return $this->errorResponse('Current password is incorrect', 400);
            }

            // Update password
            $updateData = [
                'password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->userModel->update($id, $updateData);

            return $this->successResponse(null, 'Password changed successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to change password: ' . $e->getMessage(), 500);
        }
    }

    public function resetPassword($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('User ID is required', 400);
            }

            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            $rules = [
                'new_password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[new_password]'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $data = $this->request->getJSON(true);

            // Update password
            $updateData = [
                'password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->userModel->update($id, $updateData);

            return $this->successResponse(null, 'Password reset successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to reset password: ' . $e->getMessage(), 500);
        }
    }

    public function profile()
    {
        try {
            // Get current user from session
            $userId = session()->get('user_id');
            
            if (!$userId) {
                return $this->errorResponse('User not authenticated', 401);
            }

            $user = $this->userModel->find($userId);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            // Remove password from response
            unset($user['password']);

            return $this->successResponse($user, 'Profile retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve profile: ' . $e->getMessage(), 500);
        }
    }

    public function updateProfile()
    {
        try {
            // Get current user from session
            $userId = session()->get('user_id');
            
            if (!$userId) {
                return $this->errorResponse('User not authenticated', 401);
            }

            $existingUser = $this->userModel->find($userId);
            if (!$existingUser) {
                return $this->errorResponse('User not found', 404);
            }

            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,' . $userId . ']',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
                'name' => 'required|min_length[2]|max_length[100]'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $data = $this->request->getJSON(true);

            // Remove fields that shouldn't be updated via profile
            unset($data['password'], $data['role'], $data['status']);
            $data['updated_at'] = date('Y-m-d H:i:s');

            $this->userModel->update($userId, $data);

            // Get updated user without password
            $user = $this->userModel->find($userId);
            unset($user['password']);

            return $this->successResponse($user, 'Profile updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update profile: ' . $e->getMessage(), 500);
        }
    }
}
