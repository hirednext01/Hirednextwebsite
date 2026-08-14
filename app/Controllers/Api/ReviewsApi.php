<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ReviewsApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $reviews = $db->table('reviews')
                         ->where('status !=', 'deleted')
                         ->orderBy('sort_order', 'ASC')
                         ->get()
                         ->getResultArray();

            $reviews = array_map(function ($review) {
                $review['review_text'] = $review['comment'] ?? $review['review_text'] ?? '';
                $review['client_company'] = $review['project_type'] ?? $review['client_company'] ?? '';
                $review['client_position'] = $review['location'] ?? $review['client_position'] ?? '';
                return $review;
            }, $reviews);

            return $this->successResponse($reviews, 'Reviews retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving reviews: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Review ID is required', 400);
            }

            $db = \Config\Database::connect();
            $review = $db->table('reviews')
                        ->where('id', $id)
                        ->where('status !=', 'deleted')
                        ->get()
                        ->getRowArray();

            if (!$review) {
                return $this->errorResponse('Review not found', 404);
            }

            $review['review_text'] = $review['comment'] ?? $review['review_text'] ?? '';
            $review['client_company'] = $review['project_type'] ?? $review['client_company'] ?? '';
            $review['client_position'] = $review['location'] ?? $review['client_position'] ?? '';

            return $this->successResponse($review, 'Review retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving review: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['client_name'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }
            if (empty($data['review_text']) && empty($data['comment'])) {
                return $this->errorResponse("Field 'review_text' is required", 422);
            }

            // Validate rating
            $rating = $data['rating'] ?? 0;
            if (!is_numeric($rating) || $rating < 0 || $rating > 5) {
                return $this->errorResponse('Rating must be between 0 and 5', 422);
            }

            $db = \Config\Database::connect();

            $comment = $data['review_text'] ?? $data['comment'] ?? '';
            $projectType = $data['client_company'] ?? $data['project_type'] ?? null;
            $location = $data['client_position'] ?? $data['location'] ?? null;

            $insertData = [
                'client_name' => $data['client_name'],
                'rating' => $rating,
                'comment' => $comment,
                'project_type' => $projectType,
                'location' => $location,
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $insertData = $this->withOptionalProofFields($db, $insertData, $data);

            $result = $db->table('reviews')->insert($insertData);
            
            if ($result) {
                $insertData['id'] = $db->insertID();
                return $this->successResponse($insertData, 'Review created successfully');
            } else {
                return $this->errorResponse('Failed to create review', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating review: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Review ID is required', 400);
            }

            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['client_name'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }
            if (empty($data['review_text']) && empty($data['comment'])) {
                return $this->errorResponse("Field 'review_text' is required", 422);
            }

            // Validate rating
            $rating = $data['rating'] ?? 0;
            if (!is_numeric($rating) || $rating < 0 || $rating > 5) {
                return $this->errorResponse('Rating must be between 0 and 5', 422);
            }

            $db = \Config\Database::connect();
            
            // Check if review exists
            $existing = $db->table('reviews')
                          ->where('id', $id)
                          ->where('status !=', 'deleted')
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Review not found', 404);
            }

            $comment = $data['review_text'] ?? $data['comment'] ?? '';
            $projectType = $data['client_company'] ?? $data['project_type'] ?? null;
            $location = $data['client_position'] ?? $data['location'] ?? null;

            $updateData = [
                'client_name' => $data['client_name'],
                'rating' => $rating,
                'comment' => $comment,
                'project_type' => $projectType,
                'location' => $location,
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $updateData = $this->withOptionalProofFields($db, $updateData, $data);

            $result = $db->table('reviews')
                        ->where('id', $id)
                        ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Review updated successfully');
            } else {
                return $this->errorResponse('Failed to update review', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating review: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Review ID is required', 400);
            }

            $db = \Config\Database::connect();
            
            // Check if review exists
            $existing = $db->table('reviews')
                          ->where('id', $id)
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Review not found', 404);
            }

            // Hard delete
            $result = $db->table('reviews')
                        ->where('id', $id)
                        ->delete();

            if ($result) {
                return $this->successResponse([], 'Review deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete review', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting review: ' . $e->getMessage(), 500);
        }
    }

    private function withOptionalProofFields($db, array $payload, array $input): array
    {
        $availableFields = array_flip($db->getFieldNames('reviews'));
        $optionalFields = [
            'name', 'designation', 'proof_type', 'source_label', 'source_url',
            'linkedin_url', 'relationship_type', 'placement_role',
            'placement_location', 'placement_year', 'help_received',
            'submitted_via', 'publish_consent',
        ];

        foreach ($optionalFields as $field) {
            if (isset($availableFields[$field]) && array_key_exists($field, $input)) {
                $payload[$field] = $input[$field] === '' ? null : $input[$field];
            }
        }

        return $payload;
    }
}
