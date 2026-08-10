<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ServicesApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $services = $db->table('services')
                ->where('status !=', 'deleted')
                ->orderBy('sort_order', 'ASC')
                ->get()
                ->getResultArray();

            return $this->successResponse($services, 'Services retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving services: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Service ID is required', 400);
            }

            $db = \Config\Database::connect();
            $service = $db->table('services')
                ->where('id', $id)
                ->where('status !=', 'deleted')
                ->get()
                ->getRowArray();

            if (!$service) {
                return $this->errorResponse('Service not found', 404);
            }

            return $this->successResponse($service, 'Service retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving service: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);

            // Validate required fields
            $required = ['title', 'description'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();

            $imageValue = '';
            if (isset($data['image'])) {
                if (is_array($data['image'])) {
                    // Store multiple images as JSON without schema change
                    $imageValue = json_encode(array_values($data['image']));
                } else {
                    $imageValue = trim((string) $data['image']);
                }
            }

            $insertData = [
                'title' => $data['title'],
                'slug' => $data['slug'] ?? url_title($data['title'], '-', true),
                'description' => $data['description'],
                'image' => $imageValue,
                'gallery' => isset($data['gallery']) ? (is_array($data['gallery']) ? json_encode($data['gallery']) : $data['gallery']) : '[]',
                'features' => $data['features'] ?? '[]',
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('services')->insert($insertData);

            if ($result) {
                $insertData['id'] = $db->insertID();
                return $this->successResponse($insertData, 'Service created successfully');
            } else {
                return $this->errorResponse('Failed to create service', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating service: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Service ID is required', 400);
            }

            $data = $this->request->getJSON(true);

            // Validate required fields
            $required = ['title', 'description'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();

            // Check if service exists
            $existing = $db->table('services')
                ->where('id', $id)
                ->where('status !=', 'deleted')
                ->get()
                ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Service not found', 404);
            }

            $imageValue = '';
            if (isset($data['image'])) {
                if (is_array($data['image'])) {
                    $imageValue = json_encode(array_values($data['image']));
                } else {
                    $imageValue = trim((string) $data['image']);
                }
            }

            $updateData = [
                'title' => $data['title'],
                'slug' => $data['slug'] ?? url_title($data['title'], '-', true),
                'description' => $data['description'],
                'image' => $imageValue,
                'gallery' => isset($data['gallery']) ? (is_array($data['gallery']) ? json_encode($data['gallery']) : $data['gallery']) : '[]',
                'features' => $data['features'] ?? '[]',
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('services')
                ->where('id', $id)
                ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Service updated successfully');
            } else {
                return $this->errorResponse('Failed to update service', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating service: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Service ID is required', 400);
            }

            $db = \Config\Database::connect();

            // Check if service exists
            $existing = $db->table('services')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Service not found', 404);
            }

            // Hard delete
            $result = $db->table('services')
                ->where('id', $id)
                ->delete();

            if ($result) {
                return $this->successResponse([], 'Service deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete service', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting service: ' . $e->getMessage(), 500);
        }
    }
}
