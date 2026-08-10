<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class TeamApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $team = $db->table('team_members')
                      ->where('status !=', 'deleted')
                      ->orderBy('sort_order', 'ASC')
                      ->get()
                      ->getResultArray();

            return $this->successResponse($team, 'Team members retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving team members: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Team member ID is required', 400);
            }

            $db = \Config\Database::connect();
            $member = $db->table('team_members')
                        ->where('id', $id)
                        ->where('status !=', 'deleted')
                        ->get()
                        ->getRowArray();

            if (!$member) {
                return $this->errorResponse('Team member not found', 404);
            }

            return $this->successResponse($member, 'Team member retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving team member: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['name', 'role', 'bio'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            $insertData = [
                'name' => $data['name'],
                'role' => $data['role'],
                'bio' => $data['bio'],
                'image' => $data['image'] ?? '',
                'email' => $data['email'] ?? '',
                'linkedin' => $data['linkedin'] ?? '',
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('team_members')->insert($insertData);
            
            if ($result) {
                $insertData['id'] = $db->insertID();
                return $this->successResponse($insertData, 'Team member created successfully');
            } else {
                return $this->errorResponse('Failed to create team member', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating team member: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Team member ID is required', 400);
            }

            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['name', 'role', 'bio'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            // Check if team member exists
            $existing = $db->table('team_members')
                          ->where('id', $id)
                          ->where('status !=', 'deleted')
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Team member not found', 404);
            }

            $updateData = [
                'name' => $data['name'],
                'role' => $data['role'],
                'bio' => $data['bio'],
                'image' => $data['image'] ?? '',
                'email' => $data['email'] ?? '',
                'linkedin' => $data['linkedin'] ?? '',
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('team_members')
                        ->where('id', $id)
                        ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Team member updated successfully');
            } else {
                return $this->errorResponse('Failed to update team member', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating team member: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Team member ID is required', 400);
            }

            $db = \Config\Database::connect();
            
            // Check if team member exists
            $existing = $db->table('team_members')
                          ->where('id', $id)
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Team member not found', 404);
            }

            // Hard delete
            $result = $db->table('team_members')
                        ->where('id', $id)
                        ->delete();

            if ($result) {
                return $this->successResponse([], 'Team member deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete team member', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting team member: ' . $e->getMessage(), 500);
        }
    }
}
