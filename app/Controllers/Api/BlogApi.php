<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class BlogApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $blogs = $db->table('blog_posts')
                ->where('status !=', 'archived')
                ->orderBy('sort_order', 'ASC')
                ->orderBy('published_at', 'DESC')
                ->get()
                ->getResultArray();

            return $this->successResponse($blogs, 'Blog posts retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving blog posts: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Blog post ID is required', 400);
            }

            $db = \Config\Database::connect();
            $blog = $db->table('blog_posts')
                ->where('id', $id)
                ->where('status !=', 'archived')
                ->get()
                ->getRowArray();

            if (!$blog) {
                return $this->errorResponse('Blog post not found', 404);
            }

            return $this->successResponse($blog, 'Blog post retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving blog post: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);

            // Validate required fields
            $required = ['title', 'content'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();

            // Generate slug from title if not provided
            $slug = $data['slug'] ?? $this->generateSlug($data['title']);

            // Check if slug already exists
            $existingSlug = $db->table('blog_posts')
                ->where('slug', $slug)
                ->get()
                ->getRowArray();

            if ($existingSlug) {
                $slug = $slug . '-' . time();
            }

            $insertData = [
                'title' => $data['title'],
                'slug' => $slug,
                'content' => $data['content'],
                'excerpt' => $data['excerpt'] ?? $this->generateExcerpt($data['content']),
                'featured_image' => $data['featured_image'] ?? '',
                'category' => $data['category'] ?? 'General',
                'tags' => $data['tags'] ?? '',
                'author_name' => $data['author_name'] ?? 'Metron Team',
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keywords' => $data['meta_keywords'] ?? null,
                'status' => $data['status'] ?? 'draft',
                'sort_order' => $data['sort_order'] ?? 0,
                'published_at' => ($data['status'] ?? 'draft') === 'published' ? date('Y-m-d H:i:s') : null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('blog_posts')->insert($insertData);

            if ($result) {
                $insertData['id'] = $db->insertID();
                return $this->successResponse($insertData, 'Blog post created successfully');
            } else {
                return $this->errorResponse('Failed to create blog post', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating blog post: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Blog post ID is required', 400);
            }

            $data = $this->request->getJSON(true);

            // Validate required fields
            $required = ['title', 'content'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();

            // Check if blog post exists
            $existing = $db->table('blog_posts')
                ->where('id', $id)
                ->where('status !=', 'archived')
                ->get()
                ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Blog post not found', 404);
            }

            // Generate slug from title if not provided
            $slug = $data['slug'] ?? $this->generateSlug($data['title']);

            // Check if slug already exists (excluding current post)
            $existingSlug = $db->table('blog_posts')
                ->where('slug', $slug)
                ->where('id !=', $id)
                ->get()
                ->getRowArray();

            if ($existingSlug) {
                $slug = $slug . '-' . time();
            }

            $updateData = [
                'title' => $data['title'],
                'slug' => $slug,
                'content' => $data['content'],
                'excerpt' => $data['excerpt'] ?? $this->generateExcerpt($data['content']),
                'featured_image' => $data['featured_image'] ?? '',
                'category' => $data['category'] ?? 'General',
                'tags' => $data['tags'] ?? '',
                'author_name' => $data['author_name'] ?? 'Metron Team',
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keywords' => $data['meta_keywords'] ?? null,
                'status' => $data['status'] ?? 'draft',
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Set published_at if status is changing to published
            if ($data['status'] === 'published' && $existing['status'] !== 'published') {
                $updateData['published_at'] = date('Y-m-d H:i:s');
            }

            $result = $db->table('blog_posts')
                ->where('id', $id)
                ->update($updateData);

            if ($result) {
                $updateData['id'] = $id;
                return $this->successResponse($updateData, 'Blog post updated successfully');
            } else {
                return $this->errorResponse('Failed to update blog post', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating blog post: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Blog post ID is required', 400);
            }

            $db = \Config\Database::connect();

            // Check if blog post exists
            $existing = $db->table('blog_posts')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Blog post not found', 404);
            }

            // Hard delete
            $result = $db->table('blog_posts')
                ->where('id', $id)
                ->delete();

            if ($result) {
                return $this->successResponse([], 'Blog post deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete blog post', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting blog post: ' . $e->getMessage(), 500);
        }
    }

    private function generateSlug($title)
    {
        // Convert to lowercase and replace spaces with hyphens
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }

    private function generateExcerpt($content, $length = 150)
    {
        // Strip HTML tags and generate excerpt
        $text = strip_tags($content);
        if (strlen($text) <= $length) {
            return $text;
        }

        $excerpt = substr($text, 0, $length);
        $lastSpace = strrpos($excerpt, ' ');

        if ($lastSpace !== false) {
            $excerpt = substr($excerpt, 0, $lastSpace);
        }

        return $excerpt . '...';
    }
}
