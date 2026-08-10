<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ClientsApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $clients = $db->table('clients')
                         ->where('status !=', 'deleted')
                         ->orderBy('sort_order', 'ASC')
                         ->get()
                         ->getResultArray();

            return $this->successResponse($clients, 'Clients retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving clients: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Client ID is required', 400);
            }

            $db = \Config\Database::connect();
            $client = $db->table('clients')
                        ->where('id', $id)
                        ->where('status !=', 'deleted')
                        ->get()
                        ->getRowArray();

            if (!$client) {
                return $this->errorResponse('Client not found', 404);
            }

            return $this->successResponse($client, 'Client retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving client: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['name', 'industry'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            $insertData = [
                'name' => $data['name'],
                'logo' => $data['logo'] ?? '',
                'industry' => $data['industry'],
                'description' => $data['description'] ?? '',
                'website' => $data['website'] ?? '',
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('clients')->insert($insertData);
            
            if ($result) {
                $insertData['id'] = $db->insertID();
                return $this->successResponse($insertData, 'Client created successfully');
            } else {
                return $this->errorResponse('Failed to create client', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating client: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Client ID is required', 400);
            }

            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['name', 'industry'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            // Check if client exists
            $existing = $db->table('clients')
                          ->where('id', $id)
                          ->where('status !=', 'deleted')
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Client not found', 404);
            }

            $updateData = [
                'name' => $data['name'],
                'logo' => $data['logo'] ?? '',
                'industry' => $data['industry'],
                'description' => $data['description'] ?? '',
                'website' => $data['website'] ?? '',
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('clients')
                        ->where('id', $id)
                        ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Client updated successfully');
            } else {
                return $this->errorResponse('Failed to update client', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating client: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Client ID is required', 400);
            }

            $db = \Config\Database::connect();
            
            // Check if client exists
            $existing = $db->table('clients')
                          ->where('id', $id)
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Client not found', 404);
            }

            // Hard delete
            $result = $db->table('clients')
                        ->where('id', $id)
                        ->delete();

            if ($result) {
                return $this->successResponse([], 'Client deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete client', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting client: ' . $e->getMessage(), 500);
        }
    }
}
