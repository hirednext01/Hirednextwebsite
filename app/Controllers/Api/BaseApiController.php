<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserSessionModel;

class BaseApiController extends ResourceController
{
    protected $format = 'json';

    public function __construct()
    {
        // Add CORS headers as backup
        $response = service('response');
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->setHeader('Access-Control-Allow-Credentials', 'true');
    }

    protected function successResponse($data = null, $message = 'Success', $code = 200)
    {
        return $this->respond([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = 'Error', $code = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return $this->respond($response, $code);
    }

    protected function validateRequest($rules)
    {
        if (!$this->validate($rules)) {
            return $this->errorResponse('Validation failed', 422, $this->validator->getErrors());
        }
        return true;
    }

    protected function getAuthUser()
    {
        $token = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);

        if (!$token) {
            return null;
        }

        $sessionModel = new UserSessionModel();
        $user = $sessionModel->getUserByToken($token);

        if ($user) {
            unset($user['password']);
        }

        return $user ?: null;
    }

    protected function requireAuth()
    {
        $user = $this->getAuthUser();
        if (!$user) {
            return $this->errorResponse('Unauthorized', 401);
        }

        return $user;
    }

    protected function requireRole(array $roles)
    {
        $user = $this->requireAuth();
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        if (!in_array($user['role'] ?? '', $roles, true)) {
            return $this->errorResponse('Forbidden', 403);
        }

        return $user;
    }
}
