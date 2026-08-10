<?php

namespace App\Controllers\Api;

use App\Models\UserModel;

class TestApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            
            // Test database connection
            if ($db->connect(false)) {
                $result = [
                    'message' => 'Database connection successful',
                    'database' => $db->database,
                    'hostname' => $db->hostname
                ];
                
                // Check if users table exists
                if ($db->tableExists('users')) {
                    $result['users_table'] = 'exists';
                    
                    // Count users
                    $userCount = $db->table('users')->countAllResults();
                    $result['user_count'] = $userCount;
                    
                    // Get first user
                    if ($userCount > 0) {
                        $firstUser = $db->table('users')->select('id, username, email, name, role')->get()->getRowArray();
                        $result['first_user'] = $firstUser;
                    }
                } else {
                    $result['users_table'] = 'does not exist';
                }
                
                return $this->successResponse($result, 'Database is working');
            } else {
                return $this->errorResponse('Database connection failed', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Database error: ' . $e->getMessage(), 500);
        }
    }

    public function testAuth()
    {
        try {
            $userModel = new UserModel();
            
            // Test finding admin user
            $adminUser = $userModel->where('username', 'admin')->first();
            
            if ($adminUser) {
                $result = [
                    'user_found' => true,
                    'username' => $adminUser['username'],
                    'email' => $adminUser['email'],
                    'status' => $adminUser['status'],
                    'password_hash' => substr($adminUser['password'], 0, 20) . '...',
                    'password_length' => strlen($adminUser['password'])
                ];
                
                // Test password verification
                $testPassword = 'admin123';
                $passwordValid = password_verify($testPassword, $adminUser['password']);
                $result['password_verification'] = $passwordValid;
                
                // Test authentication method
                $authResult = $userModel->authenticate('admin', 'admin123');
                $result['authentication_result'] = $authResult ? 'success' : 'failed';
                
                return $this->successResponse($result, 'Authentication test completed');
            } else {
                return $this->errorResponse('Admin user not found', 404);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Auth test error: ' . $e->getMessage(), 500);
        }
    }
}
