<?php

namespace App\Controllers\Api;

use App\Libraries\BlogSearchOptimizer;

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

            foreach (['title', 'content'] as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            $slug = $data['slug'] ?? $this->generateSlug($data['title']);

            if ($db->table('blog_posts')->where('slug', $slug)->get()->getRowArray()) {
                $slug .= '-' . time();
            }

            $status = $data['status'] ?? 'draft';
            $category = trim((string)($data['category'] ?? '')) ?: 'Recruitment';
            $base = [
                'title' => $data['title'],
                'slug' => $slug,
                'content' => $data['content'],
                'excerpt' => trim((string)($data['excerpt'] ?? '')),
                'featured_image' => $data['featured_image'] ?? '',
                'category' => $category,
                'tags' => trim((string)($data['tags'] ?? '')),
                'author_name' => trim((string)($data['author_name'] ?? '')) ?: 'HiredNext Editorial',
                'meta_title' => trim((string)($data['meta_title'] ?? '')),
                'meta_description' => trim((string)($data['meta_description'] ?? '')),
                'meta_keywords' => trim((string)($data['meta_keywords'] ?? '')),
            ];

            $optimized = (new BlogSearchOptimizer())->optimise($base, $status === 'published');
            $insertData = array_merge($base, $optimized, [
                'status' => $status,
                'sort_order' => $data['sort_order'] ?? 0,
                'published_at' => $status === 'published' ? date('Y-m-d H:i:s') : null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $result = $db->table('blog_posts')->insert($insertData);
            if (!$result) {
                return $this->errorResponse('Failed to create blog post', 500);
            }

            $insertData['id'] = $db->insertID();
            if ($status === 'published') {
                $this->notifyIndexNow(base_url('blog/' . $slug));
            }
            return $this->successResponse($insertData, 'Blog post created successfully');
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
            foreach (['title', 'content'] as $field) {
                if (empty($data[$field])) {
                    return $this->errorResponse("Field '$field' is required", 422);
                }
            }

            $db = \Config\Database::connect();
            $existing = $db->table('blog_posts')
                ->where('id', $id)
                ->where('status !=', 'archived')
                ->get()
                ->getRowArray();

            if (!$existing) {
                return $this->errorResponse('Blog post not found', 404);
            }

            $slug = $data['slug'] ?? $this->generateSlug($data['title']);
            if ($db->table('blog_posts')->where('slug', $slug)->where('id !=', $id)->get()->getRowArray()) {
                $slug .= '-' . time();
            }

            $status = $data['status'] ?? $existing['status'] ?? 'draft';
            $category = trim((string)($data['category'] ?? '')) ?: 'Recruitment';
            $base = [
                'title' => $data['title'],
                'slug' => $slug,
                'content' => $data['content'],
                'excerpt' => trim((string)($data['excerpt'] ?? '')),
                'featured_image' => $data['featured_image'] ?? '',
                'category' => $category,
                'tags' => trim((string)($data['tags'] ?? '')),
                'author_name' => trim((string)($data['author_name'] ?? '')) ?: 'HiredNext Editorial',
                'meta_title' => trim((string)($data['meta_title'] ?? '')),
                'meta_description' => trim((string)($data['meta_description'] ?? '')),
                'meta_keywords' => trim((string)($data['meta_keywords'] ?? '')),
            ];

            $optimized = (new BlogSearchOptimizer())->optimise($base, $status === 'published');
            $updateData = array_merge($base, $optimized, [
                'status' => $status,
                'sort_order' => $data['sort_order'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if ($status === 'published' && ($existing['status'] ?? '') !== 'published') {
                $updateData['published_at'] = date('Y-m-d H:i:s');
            }

            $result = $db->table('blog_posts')->where('id', $id)->update($updateData);
            if (!$result) {
                return $this->errorResponse('Failed to update blog post', 500);
            }

            $updateData['id'] = $id;
            if ($status === 'published') {
                $this->notifyIndexNow(base_url('blog/' . $slug));
                if (!empty($existing['slug']) && $existing['slug'] !== $slug) {
                    $this->notifyIndexNow(base_url('blog/' . $existing['slug']));
                }
            }
            return $this->successResponse($updateData, 'Blog post updated successfully');
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
            $existing = $db->table('blog_posts')->where('id', $id)->get()->getRowArray();
            if (!$existing) {
                return $this->errorResponse('Blog post not found', 404);
            }

            if (($existing['status'] ?? '') === 'archived') {
                return $this->successResponse([], 'Blog post already archived');
            }

            $result = $db->table('blog_posts')->where('id', $id)->update([
                'status' => 'archived',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if (!$result) {
                return $this->errorResponse('Failed to archive blog post', 500);
            }

            if (!empty($existing['slug'])) {
                $this->notifyIndexNow(base_url('blog/' . $existing['slug']));
            }
            return $this->successResponse([], 'Blog post archived successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error archiving blog post: ' . $e->getMessage(), 500);
        }
    }

    private function generateSlug($title)
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }

    private function notifyIndexNow($url)
    {
        try {
            $config = config('SearchDiscovery');
            if (!$config || empty($config->indexNowKey) || empty($config->indexNowEndpoint)) {
                return;
            }

            $host = parse_url(base_url(), PHP_URL_HOST);
            if (!$host) {
                return;
            }

            $client = \Config\Services::curlrequest([
                'timeout' => 3,
                'connect_timeout' => 2,
                'http_errors' => false,
            ]);

            $client->post($config->indexNowEndpoint, [
                'json' => [
                    'host' => $host,
                    'key' => $config->indexNowKey,
                    'keyLocation' => rtrim(base_url(), '/') . '/' . $config->indexNowKey . '.txt',
                    'urlList' => [(string)$url],
                ],
            ]);
        } catch (\Throwable $e) {
            // Indexing notifications must never block blog publishing.
        }
    }
}
