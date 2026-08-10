<?php

namespace App\Controllers\Api;

class AeoInsightsApi extends BaseApiController
{
    private function payload(): array
    {
        $data = $this->request->getJSON(true);
        return is_array($data) ? $data : $this->request->getPost();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $rows = $db->table('aeo_insights')->orderBy('created_at', 'DESC')->get()->getResultArray();
        return $this->successResponse($rows, 'AEO insights retrieved successfully');
    }

    public function show($id = null)
    {
        $db = \Config\Database::connect();
        $row = $db->table('aeo_insights')->where('id', $id)->get()->getRowArray();
        if (!$row) return $this->errorResponse('AEO insight not found', 404);
        return $this->successResponse($row, 'AEO insight retrieved successfully');
    }

    public function create()
    {
        $data = $this->payload();
        foreach (['title', 'content'] as $field) {
            if (empty(trim((string) ($data[$field] ?? '')))) return $this->errorResponse($field . ' is required', 422);
        }

        $slug = trim((string) ($data['slug'] ?? ''));
        if ($slug === '') $slug = url_title((string) $data['title'], '-', true);
        $status = ($data['status'] ?? 'draft') === 'published' ? 'published' : 'draft';
        $now = date('Y-m-d H:i:s');

        $insert = [
            'title' => trim($data['title']), 'slug' => $slug, 'question' => trim((string) ($data['question'] ?? '')) ?: null,
            'excerpt' => trim((string) ($data['excerpt'] ?? '')) ?: null, 'content' => $data['content'],
            'industry' => trim((string) ($data['industry'] ?? '')) ?: null, 'location' => trim((string) ($data['location'] ?? '')) ?: null,
            'role' => trim((string) ($data['role'] ?? '')) ?: null, 'author' => trim((string) ($data['author'] ?? '')) ?: null,
            'meta_title' => trim((string) ($data['meta_title'] ?? '')) ?: null, 'meta_description' => trim((string) ($data['meta_description'] ?? '')) ?: null,
            'faq_json' => isset($data['faq']) ? json_encode($data['faq'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null,
            'status' => $status, 'published_at' => $status === 'published' ? ($data['published_at'] ?? $now) : null,
            'created_at' => $now, 'updated_at' => $now,
        ];

        $db = \Config\Database::connect();
        if ($db->table('aeo_insights')->where('slug', $slug)->countAllResults() > 0) return $this->errorResponse('An insight with this slug already exists', 409);
        $db->table('aeo_insights')->insert($insert);
        $insert['id'] = $db->insertID();
        return $this->successResponse($insert, 'AEO insight created successfully', 201);
    }

    public function update($id = null)
    {
        $data = $this->payload();
        $db = \Config\Database::connect();
        $existing = $db->table('aeo_insights')->where('id', $id)->get()->getRowArray();
        if (!$existing) return $this->errorResponse('AEO insight not found', 404);

        $update = [];
        foreach (['title','slug','question','excerpt','content','industry','location','role','author','meta_title','meta_description'] as $field) {
            if (array_key_exists($field, $data)) $update[$field] = trim((string) $data[$field]);
        }
        if (array_key_exists('faq', $data)) $update['faq_json'] = json_encode($data['faq'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (isset($data['status'])) {
            $update['status'] = $data['status'] === 'published' ? 'published' : 'draft';
            if ($update['status'] === 'published' && empty($existing['published_at'])) $update['published_at'] = date('Y-m-d H:i:s');
        }
        $update['updated_at'] = date('Y-m-d H:i:s');
        $db->table('aeo_insights')->where('id', $id)->update($update);
        return $this->successResponse(array_merge(['id' => $id], $update), 'AEO insight updated successfully');
    }

    public function delete($id = null)
    {
        $db = \Config\Database::connect();
        if (!$db->table('aeo_insights')->where('id', $id)->countAllResults()) return $this->errorResponse('AEO insight not found', 404);
        $db->table('aeo_insights')->where('id', $id)->delete();
        return $this->successResponse([], 'AEO insight deleted successfully');
    }
}
