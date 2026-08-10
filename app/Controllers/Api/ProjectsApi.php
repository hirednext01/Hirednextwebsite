<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ProjectsApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();

            $status = $this->request->getGet('status');
            $category = $this->request->getGet('category');

            $builder = $db->table('projects');

            if ($status) {
                $builder->where('status', $status);
            }

            if ($category) {
                $builder->where('category', $category);
            }

            $projects = $builder->orderBy('sort_order', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();

            return $this->successResponse($projects, 'Projects retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving projects: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Project ID is required', 400);
            }

            $db = \Config\Database::connect();
            $project = $db->table('projects')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$project) {
                return $this->errorResponse('Project not found', 404);
            }

            return $this->successResponse($project, 'Project retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving project: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);

            if (empty($data)) {
                $data = $this->request->getPost();
            }

            // Validate required fields
            if (empty($data['title'])) {
                return $this->errorResponse('Title is required', 422);
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = url_title($data['title'], '-', true);
            }

            $db = \Config\Database::connect();

            // Check if slug already exists
            $existing = $db->table('projects')
                ->where('slug', $data['slug'])
                ->get()
                ->getRowArray();

            if ($existing) {
                $data['slug'] = $data['slug'] . '-' . time();
            }

            $insertData = [
                'title' => htmlspecialchars($data['title']),
                'slug' => $data['slug'],
                'description' => htmlspecialchars($data['description'] ?? ''),
                'category' => htmlspecialchars($data['category'] ?? ''),
                'client_name' => htmlspecialchars($data['client_name'] ?? ''),
                'location' => htmlspecialchars($data['location'] ?? ''),
                'completion_date' => $data['completion_date'] ?? null,
                'project_value' => $data['project_value'] ?? null,
                'images' => $data['images'] ?? null,
                'featured_image' => $data['featured_image'] ?? null,
                'tags' => $data['tags'] ?? '',
                'status' => $data['status'] ?? 'draft',
                'sort_order' => $data['sort_order'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('projects')->insert($insertData);

            if ($result) {
                $insertData['id'] = $db->insertID();
                return $this->successResponse($insertData, 'Project created successfully', 201);
            } else {
                return $this->errorResponse('Failed to create project', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating project: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Project ID is required', 400);
            }

            $data = $this->request->getJSON(true);

            if (empty($data)) {
                $data = $this->request->getPost();
            }

            $db = \Config\Database::connect();

            // Check if project exists
            $existing = $db->table('projects')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Project not found', 404);
            }

            $updateData = ['updated_at' => date('Y-m-d H:i:s')];

            // Only update provided fields
            $allowedFields = [
                'title',
                'slug',
                'description',
                'category',
                'client_name',
                'location',
                'completion_date',
                'project_value',
                'images',
                'featured_image',
                'tags',
                'status',
                'sort_order'
            ];

            foreach ($allowedFields as $field) {
                if (isset($data[$field])) {
                    if (in_array($field, ['title', 'description', 'category', 'client_name', 'location'])) {
                        $updateData[$field] = htmlspecialchars($data[$field]);
                    } else {
                        $updateData[$field] = $data[$field];
                    }
                }
            }

            $result = $db->table('projects')
                ->where('id', $id)
                ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Project updated successfully');
            } else {
                return $this->errorResponse('Failed to update project', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating project: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Project ID is required', 400);
            }

            $db = \Config\Database::connect();

            // Check if project exists
            $existing = $db->table('projects')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Project not found', 404);
            }

            $result = $db->table('projects')
                ->where('id', $id)
                ->delete();

            if ($result) {
                return $this->successResponse([], 'Project deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete project', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting project: ' . $e->getMessage(), 500);
        }
    }

    public function uploadImage()
    {
        try {
            $file = $this->request->getFile('image');

            if (!$file || !$file->isValid()) {
                return $this->errorResponse('No valid image file provided', 400);
            }

            if (!$file->isValid()) {
                return $this->errorResponse($file->getErrorString(), 400);
            }

            // Validate file type
            $validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $validTypes)) {
                return $this->errorResponse('Invalid file type. Only images are allowed.', 400);
            }

            // Generate unique filename
            $newName = $file->getRandomName();

            // Move file to uploads directory
            $uploadPath = FCPATH . 'assets/metron/images/projects/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $newName);

            $imagePath = 'images/projects/' . $newName;

            return $this->successResponse([
                'path' => $imagePath,
                'url' => base_url('assets/metron/' . $imagePath)
            ], 'Image uploaded successfully');

        } catch (\Exception $e) {
            return $this->errorResponse('Error uploading image: ' . $e->getMessage(), 500);
        }
    }
}
