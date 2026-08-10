<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class AchievementsApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $achievements = $db->table('achievements')
                              ->where('status !=', 'deleted')
                              ->orderBy('sort_order', 'ASC')
                              ->get()
                              ->getResultArray();

            return $this->successResponse($achievements, 'Achievements retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving achievements: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Achievement ID is required', 400);
            }

            $db = \Config\Database::connect();
            $achievement = $db->table('achievements')
                             ->where('id', $id)
                             ->where('status !=', 'deleted')
                             ->get()
                             ->getRowArray();

            if (!$achievement) {
                return $this->errorResponse('Achievement not found', 404);
            }

            return $this->successResponse($achievement, 'Achievement retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving achievement: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['title', 'description', 'category', 'year'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            $insertData = [
                'title' => $data['title'],
                'description' => $data['description'],
                'year' => $data['year'],
                'category' => $data['category'],
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('achievements')->insert($insertData);
            
            if ($result) {
                $insertData['id'] = $db->insertID();
                return $this->successResponse($insertData, 'Achievement created successfully');
            } else {
                return $this->errorResponse('Failed to create achievement', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating achievement: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Achievement ID is required', 400);
            }

            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['title', 'description', 'category', 'year'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            // Check if achievement exists
            $existing = $db->table('achievements')
                          ->where('id', $id)
                          ->where('status !=', 'deleted')
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Achievement not found', 404);
            }

            $updateData = [
                'title' => $data['title'],
                'description' => $data['description'],
                'year' => $data['year'],
                'category' => $data['category'],
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('achievements')
                        ->where('id', $id)
                        ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Achievement updated successfully');
            } else {
                return $this->errorResponse('Failed to update achievement', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating achievement: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Achievement ID is required', 400);
            }

            $db = \Config\Database::connect();
            
            // Check if achievement exists
            $existing = $db->table('achievements')
                          ->where('id', $id)
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Achievement not found', 404);
            }

            // Hard delete
            $result = $db->table('achievements')
                        ->where('id', $id)
                        ->delete();

            if ($result) {
                return $this->successResponse([], 'Achievement deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete achievement', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting achievement: ' . $e->getMessage(), 500);
        }
    }
}
