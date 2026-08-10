<?php

namespace App\Controllers\Api;

class PressMediaApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $items = $db->table('press_media')
                ->orderBy('sort_order', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();

            return $this->successResponse($items, 'Press & Media items retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving press & media items: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Item ID is required', 400);
            }

            $db = \Config\Database::connect();
            $item = $db->table('press_media')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$item) {
                return $this->errorResponse('Item not found', 404);
            }

            return $this->successResponse($item, 'Press & Media item retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving press & media item: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);

            $required = ['image_url', 'media_link', 'description'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            if (!filter_var($data['media_link'], FILTER_VALIDATE_URL)) {
                return $this->errorResponse('Media link must be a valid URL', 422);
            }

            $db = \Config\Database::connect();
            $insertData = [
                'image_url' => trim((string) $data['image_url']),
                'media_link' => trim((string) $data['media_link']),
                'description' => trim((string) $data['description']),
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $result = $db->table('press_media')->insert($insertData);
            if (!$result) {
                return $this->errorResponse('Failed to create press & media item', 500);
            }

            $insertData['id'] = $db->insertID();
            return $this->successResponse($insertData, 'Press & Media item created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating press & media item: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Item ID is required', 400);
            }

            $data = $this->request->getJSON(true);

            $required = ['image_url', 'media_link', 'description'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            if (!filter_var($data['media_link'], FILTER_VALIDATE_URL)) {
                return $this->errorResponse('Media link must be a valid URL', 422);
            }

            $db = \Config\Database::connect();
            $existing = $db->table('press_media')->where('id', $id)->get()->getRowArray();
            if (!$existing) {
                return $this->errorResponse('Item not found', 404);
            }

            $updateData = [
                'image_url' => trim((string) $data['image_url']),
                'media_link' => trim((string) $data['media_link']),
                'description' => trim((string) $data['description']),
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $result = $db->table('press_media')->where('id', $id)->update($updateData);
            if (!$result) {
                return $this->errorResponse('Failed to update press & media item', 500);
            }

            $updateData['id'] = (int) $id;
            return $this->successResponse($updateData, 'Press & Media item updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating press & media item: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Item ID is required', 400);
            }

            $db = \Config\Database::connect();
            $existing = $db->table('press_media')->where('id', $id)->get()->getRowArray();
            if (!$existing) {
                return $this->errorResponse('Item not found', 404);
            }

            $result = $db->table('press_media')->where('id', $id)->delete();
            if (!$result) {
                return $this->errorResponse('Failed to delete press & media item', 500);
            }

            return $this->successResponse([], 'Press & Media item deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting press & media item: ' . $e->getMessage(), 500);
        }
    }
}
