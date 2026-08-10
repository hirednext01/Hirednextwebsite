<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class IndustriesApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $industries = $db->table('industries')
                            ->where('status !=', 'deleted')
                            ->orderBy('sort_order', 'ASC')
                            ->get()
                            ->getResultArray();

            return $this->successResponse($industries, 'Industries retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving industries: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Industry ID is required', 400);
            }

            $db = \Config\Database::connect();
            $industry = $db->table('industries')
                          ->where('id', $id)
                          ->where('status !=', 'deleted')
                          ->get()
                          ->getRowArray();

            if (!$industry) {
                return $this->errorResponse('Industry not found', 404);
            }

            return $this->successResponse($industry, 'Industry retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving industry: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['name', 'description'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            $insertData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'icon' => $data['icon'] ?? '',
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('industries')->insert($insertData);
            
            if ($result) {
                $insertData['id'] = $db->insertID();
                return $this->successResponse($insertData, 'Industry created successfully');
            } else {
                return $this->errorResponse('Failed to create industry', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating industry: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Industry ID is required', 400);
            }

            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['name', 'description'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            // Check if industry exists
            $existing = $db->table('industries')
                          ->where('id', $id)
                          ->where('status !=', 'deleted')
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Industry not found', 404);
            }

            $updateData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'icon' => $data['icon'] ?? '',
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('industries')
                        ->where('id', $id)
                        ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Industry updated successfully');
            } else {
                return $this->errorResponse('Failed to update industry', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating industry: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Industry ID is required', 400);
            }

            $db = \Config\Database::connect();
            
            // Check if industry exists
            $existing = $db->table('industries')
                          ->where('id', $id)
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Industry not found', 404);
            }

            // Hard delete
            $result = $db->table('industries')
                        ->where('id', $id)
                        ->delete();

            if ($result) {
                return $this->successResponse([], 'Industry deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete industry', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting industry: ' . $e->getMessage(), 500);
        }
    }
}
