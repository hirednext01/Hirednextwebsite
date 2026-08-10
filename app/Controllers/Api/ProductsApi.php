<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductsApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $products = $db->table('products')
                          ->where('status !=', 'deleted')
                          ->orderBy('sort_order', 'ASC')
                          ->get()
                          ->getResultArray();

            return $this->successResponse($products, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving products: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Product ID is required', 400);
            }

            $db = \Config\Database::connect();
            $product = $db->table('products')
                         ->where('id', $id)
                         ->where('status !=', 'deleted')
                         ->get()
                         ->getRowArray();

            if (!$product) {
                return $this->errorResponse('Product not found', 404);
            }

            return $this->successResponse($product, 'Product retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving product: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['name', 'description', 'category'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            $insertData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'features' => $data['features'] ?? '[]',
                'image' => $data['image'] ?? '',
                'category' => $data['category'],
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('products')->insert($insertData);
            
            if ($result) {
                $insertData['id'] = $db->insertID();
                return $this->successResponse($insertData, 'Product created successfully');
            } else {
                return $this->errorResponse('Failed to create product', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating product: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Product ID is required', 400);
            }

            $data = $this->request->getJSON(true);
            
            // Validate required fields
            $required = ['name', 'description', 'category'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            
            // Check if product exists
            $existing = $db->table('products')
                          ->where('id', $id)
                          ->where('status !=', 'deleted')
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Product not found', 404);
            }

            $updateData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'features' => $data['features'] ?? '[]',
                'image' => $data['image'] ?? '',
                'category' => $data['category'],
                'status' => $data['status'] ?? 'active',
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('products')
                        ->where('id', $id)
                        ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Product updated successfully');
            } else {
                return $this->errorResponse('Failed to update product', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating product: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Product ID is required', 400);
            }

            $db = \Config\Database::connect();
            
            // Check if product exists
            $existing = $db->table('products')
                          ->where('id', $id)
                          ->get()
                          ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Product not found', 404);
            }

            // Hard delete
            $result = $db->table('products')
                        ->where('id', $id)
                        ->delete();

            if ($result) {
                return $this->successResponse([], 'Product deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete product', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting product: ' . $e->getMessage(), 500);
        }
    }
}
