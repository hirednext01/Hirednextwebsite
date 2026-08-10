<?php

namespace App\Controllers\Api;

use App\Models\PartnersModel;

class PartnersApi extends BaseApiController
{
    protected $partnersModel;

    public function __construct()
    {
        parent::__construct();
        $this->partnersModel = new PartnersModel();
    }

    public function index()
    {
        try {
            $type = $this->request->getGet('type');
            
            if ($type) {
                $partners = $this->partnersModel->getActiveByType($type);
            } else {
                $partners = $this->partnersModel->where('status !=', 'deleted')
                                                ->orderBy('sort_order', 'ASC')
                                                ->orderBy('type', 'ASC')
                                                ->findAll();
            }

            return $this->successResponse($partners, 'Partners retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving partners: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Partner ID is required', 400);
            }

            $partner = $this->partnersModel->find($id);

            if (!$partner) {
                return $this->errorResponse('Partner not found', 404);
            }

            return $this->successResponse($partner, 'Partner retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving partner: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['name', 'type'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $insertData = [
                'name' => $data['name'],
                'logo' => $data['logo'] ?? '',
                'type' => $data['type'],
                'description' => $data['description'] ?? '',
                'website_url' => $data['website_url'] ?? '',
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
            ];

            $result = $this->partnersModel->insert($insertData);
            
            if ($result) {
                $insertData['id'] = $this->partnersModel->getInsertID();
                return $this->successResponse($insertData, 'Partner created successfully');
            } else {
                return $this->errorResponse('Failed to create partner', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating partner: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Partner ID is required', 400);
            }

            $data = $this->request->getJSON(true);
            
            // Check if partner exists
            $existing = $this->partnersModel->find($id);

            if (!$existing) {
                return $this->errorResponse('Partner not found', 404);
            }

            $updateData = [];
            if (isset($data['name'])) $updateData['name'] = $data['name'];
            if (isset($data['logo'])) $updateData['logo'] = $data['logo'];
            if (isset($data['type'])) $updateData['type'] = $data['type'];
            if (isset($data['description'])) $updateData['description'] = $data['description'];
            if (isset($data['website_url'])) $updateData['website_url'] = $data['website_url'];
            if (isset($data['status'])) $updateData['status'] = $data['status'];
            if (isset($data['sort_order'])) $updateData['sort_order'] = $data['sort_order'];

            $result = $this->partnersModel->update($id, $updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Partner updated successfully');
            } else {
                return $this->errorResponse('Failed to update partner', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating partner: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Partner ID is required', 400);
            }

            $existing = $this->partnersModel->find($id);

            if (!$existing) {
                return $this->errorResponse('Partner not found', 404);
            }

            $result = $this->partnersModel->delete($id);

            if ($result) {
                return $this->successResponse([], 'Partner deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete partner', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting partner: ' . $e->getMessage(), 500);
        }
    }
}

