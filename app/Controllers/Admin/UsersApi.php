<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseApiController;
use App\Models\UserModel;

class UsersApi extends BaseApiController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        try {
            $users = $this->userModel->findAll();
            
            // Remove password from response
            foreach ($users as &$user) {
                unset($user['password']);
            }
            
            return $this->respond([
                'status' => 'success',
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return $this->fail('Failed to fetch users: ' . $e->getMessage());
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->failValidationError('User ID is required');
            }

            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->failNotFound('User not found');
            }

            // Remove password from response
            unset($user['password']);

            return $this->respond([
                'status' => 'success',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return $this->fail('Failed to fetch user: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);

            // Validation rules
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'name' => 'required|min_length[2]|max_length[100]',
                'role' => 'required|in_list[admin,editor,viewer]',
                'status' => 'required|in_list[active,inactive]'
            ];

            if (!$this->validateRequest($data, $rules)) {
                return $this->failValidationError('Validation failed');
            }

            // Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['created_at'] = date('Y-m-d H:i:s');

            $userId = $this->userModel->insert($data);

            if (!$userId) {
                return $this->fail('Failed to create user');
            }

            // Get created user without password
            $user = $this->userModel->find($userId);
            unset($user['password']);

            return $this->respondCreated([
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return $this->fail('Failed to create user: ' . $e->getMessage());
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->failValidationError('User ID is required');
            }

            $existingUser = $this->userModel->find($id);
            if (!$existingUser) {
                return $this->failNotFound('User not found');
            }

            $data = $this->request->getJSON(true);

            // Validation rules for update
            $rules = [
                'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
                'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
                'name' => 'required|min_length[2]|max_length[100]',
                'role' => 'required|in_list[admin,editor,viewer]',
                'status' => 'required|in_list[active,inactive]'
            ];

            // Only validate password if provided
            if (isset($data['password']) && !empty($data['password'])) {
                $rules['password'] = 'min_length[6]';
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                unset($data['password']);
            }

            if (!$this->validateRequest($data, $rules)) {
                return $this->failValidationError('Validation failed');
            }

            $data['updated_at'] = date('Y-m-d H:i:s');

            if (!$this->userModel->update($id, $data)) {
                return $this->fail('Failed to update user');
            }

            // Get updated user without password
            $user = $this->userModel->find($id);
            unset($user['password']);

            return $this->respond([
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return $this->fail('Failed to update user: ' . $e->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->failValidationError('User ID is required');
            }

            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->failNotFound('User not found');
            }

            // Prevent deleting the last admin user
            if ($user['role'] === 'admin') {
                $adminCount = $this->userModel->where('role', 'admin')->where('status', 'active')->countAllResults();
                if ($adminCount <= 1) {
                    return $this->fail('Cannot delete the last admin user');
                }
            }

            if (!$this->userModel->delete($id)) {
                return $this->fail('Failed to delete user');
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->fail('Failed to delete user: ' . $e->getMessage());
        }
    }

    public function changePassword($id = null)
    {
        try {
            if (!$id) {
                return $this->failValidationError('User ID is required');
            }

            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->failNotFound('User not found');
            }

            $data = $this->request->getJSON(true);

            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[new_password]'
            ];

            if (!$this->validateRequest($data, $rules)) {
                return $this->failValidationError('Validation failed');
            }

            // Verify current password
            if (!password_verify($data['current_password'], $user['password'])) {
                return $this->fail('Current password is incorrect');
            }

            // Update password
            $updateData = [
                'password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->userModel->update($id, $updateData)) {
                return $this->fail('Failed to change password');
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'Password changed successfully'
            ]);
        } catch (\Exception $e) {
            return $this->fail('Failed to change password: ' . $e->getMessage());
        }
    }

    public function resetPassword($id = null)
    {
        try {
            if (!$id) {
                return $this->failValidationError('User ID is required');
            }

            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->failNotFound('User not found');
            }

            $data = $this->request->getJSON(true);

            $rules = [
                'new_password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[new_password]'
            ];

            if (!$this->validateRequest($data, $rules)) {
                return $this->failValidationError('Validation failed');
            }

            // Update password
            $updateData = [
                'password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->userModel->update($id, $updateData)) {
                return $this->fail('Failed to reset password');
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'Password reset successfully'
            ]);
        } catch (\Exception $e) {
            return $this->fail('Failed to reset password: ' . $e->getMessage());
        }
    }

    public function profile()
    {
        try {
            // Get current user from session/token
            $userId = session()->get('user_id') ?? $this->getUserIdFromToken();
            
            if (!$userId) {
                return $this->fail('User not authenticated');
            }

            $user = $this->userModel->find($userId);
            if (!$user) {
                return $this->failNotFound('User not found');
            }

            // Remove password from response
            unset($user['password']);

            return $this->respond([
                'status' => 'success',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return $this->fail('Failed to fetch profile: ' . $e->getMessage());
        }
    }

    public function updateProfile()
    {
        try {
            // Get current user from session/token
            $userId = session()->get('user_id') ?? $this->getUserIdFromToken();
            
            if (!$userId) {
                return $this->fail('User not authenticated');
            }

            $existingUser = $this->userModel->find($userId);
            if (!$existingUser) {
                return $this->failNotFound('User not found');
            }

            $data = $this->request->getJSON(true);

            // Validation rules for profile update
            $rules = [
                'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$userId}]",
                'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
                'name' => 'required|min_length[2]|max_length[100]'
            ];

            if (!$this->validateRequest($data, $rules)) {
                return $this->failValidationError('Validation failed');
            }

            // Remove fields that shouldn't be updated via profile
            unset($data['password'], $data['role'], $data['status']);
            $data['updated_at'] = date('Y-m-d H:i:s');

            if (!$this->userModel->update($userId, $data)) {
                return $this->fail('Failed to update profile');
            }

            // Get updated user without password
            $user = $this->userModel->find($userId);
            unset($user['password']);

            return $this->respond([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return $this->fail('Failed to update profile: ' . $e->getMessage());
        }
    }

    private function validateRequest($data, $rules)
    {
        $validation = \Config\Services::validation();
        $validation->setRules($rules);
        return $validation->run($data);
    }

    private function getUserIdFromToken()
    {
        // This would implement JWT token parsing if using JWT
        // For now, return null as we're using sessions
        return null;
    }
}
