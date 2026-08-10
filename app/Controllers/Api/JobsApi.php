<?php

namespace App\Controllers\Api;

use App\Models\JobModel;
use App\Models\JobApplicationModel;
use CodeIgniter\HTTP\ResponseInterface;

class JobsApi extends BaseApiController
{
    protected $jobModel;
    protected $applicationModel;

    public function __construct()
    {
        parent::__construct();
        $this->jobModel = new JobModel();
        $this->applicationModel = new JobApplicationModel();
    }

    public function index()
    {
        $user = $this->requireAuth();
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        if (($user['role'] ?? '') === 'admin') {
            $jobs = $this->jobModel->orderBy('created_at', 'DESC')->findAll();
        } else {
            $jobs = $this->jobModel->where('created_by', $user['id'])->orderBy('created_at', 'DESC')->findAll();
        }

        return $this->successResponse($jobs, 'Jobs retrieved successfully');
    }

    public function show($id = null)
    {
        $user = $this->requireAuth();
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        if (!$id) {
            return $this->errorResponse('Job ID is required', 400);
        }

        $job = $this->jobModel->find($id);
        if (!$job) {
            return $this->errorResponse('Job not found', 404);
        }

        if (($user['role'] ?? '') !== 'admin' && (int)$job['created_by'] !== (int)$user['id']) {
            return $this->errorResponse('Forbidden', 403);
        }

        return $this->successResponse($job, 'Job retrieved successfully');
    }

    public function create()
    {
        $user = $this->requireRole(['admin', 'recruiter']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        $data = $this->request->getJSON(true);
        $required = ['title', 'location', 'type', 'description'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->errorResponse("Field '$field' is required", 422);
            }
        }

        $slug = $data['slug'] ?? $this->generateSlug($data['title']);
        $existing = $this->jobModel->where('slug', $slug)->first();
        if ($existing) {
            $slug = $slug . '-' . time();
        }

        $insertData = [
            'title' => $data['title'],
            'slug' => $slug,
            'location' => $data['location'],
            'type' => $data['type'],
            'description' => $data['description'],
            'department' => $data['department'] ?? null,
            'experience' => $data['experience'] ?? null,
            'status' => $data['status'] ?? 'draft',
            'created_by' => $user['id'],
        ];

        $jobId = $this->jobModel->insert($insertData);
        $job = $this->jobModel->find($jobId);

        return $this->successResponse($job, 'Job created successfully', 201);
    }

    public function update($id = null)
    {
        $user = $this->requireRole(['admin', 'recruiter']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        if (!$id) {
            return $this->errorResponse('Job ID is required', 400);
        }

        $job = $this->jobModel->find($id);
        if (!$job) {
            return $this->errorResponse('Job not found', 404);
        }

        if (($user['role'] ?? '') !== 'admin' && (int)$job['created_by'] !== (int)$user['id']) {
            return $this->errorResponse('Forbidden', 403);
        }

        $data = $this->request->getJSON(true);

        $slug = $data['slug'] ?? $this->generateSlug($data['title'] ?? $job['title']);
        $existing = $this->jobModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existing) {
            $slug = $slug . '-' . time();
        }

        $updateData = [
            'title' => $data['title'] ?? $job['title'],
            'slug' => $slug,
            'location' => $data['location'] ?? $job['location'],
            'type' => $data['type'] ?? $job['type'],
            'description' => $data['description'] ?? $job['description'],
            'department' => $data['department'] ?? $job['department'],
            'experience' => $data['experience'] ?? $job['experience'],
            'status' => $data['status'] ?? $job['status'],
        ];

        $this->jobModel->update($id, $updateData);
        $job = $this->jobModel->find($id);

        return $this->successResponse($job, 'Job updated successfully');
    }

    public function delete($id = null)
    {
        $user = $this->requireRole(['admin']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        if (!$id) {
            return $this->errorResponse('Job ID is required', 400);
        }

        $job = $this->jobModel->find($id);
        if (!$job) {
            return $this->errorResponse('Job not found', 404);
        }

        $this->jobModel->delete($id);

        return $this->successResponse(null, 'Job deleted successfully');
    }

    public function applications($jobId = null)
    {
        $user = $this->requireRole(['admin', 'recruiter']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        if (!$jobId) {
            return $this->errorResponse('Job ID is required', 400);
        }

        $job = $this->jobModel->find($jobId);
        if (!$job) {
            return $this->errorResponse('Job not found', 404);
        }

        if (($user['role'] ?? '') !== 'admin' && (int)$job['created_by'] !== (int)$user['id']) {
            return $this->errorResponse('Forbidden', 403);
        }

        $apps = $this->applicationModel
            ->where('job_id', $jobId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->successResponse($apps, 'Applications retrieved successfully');
    }

    public function departments()
    {
        $user = $this->requireRole(['admin', 'recruiter']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        $db = \Config\Database::connect();
        $settings = $db->table('website_settings')
            ->where('setting_key', 'job_departments')
            ->get()
            ->getRowArray();

        $departments = [];
        if (!empty($settings['setting_value'])) {
            $departments = array_values(array_filter(array_map('trim', explode(',', $settings['setting_value']))));
        }

        if (empty($departments)) {
            $rows = $db->table('jobs')
                ->select('department')
                ->where('department IS NOT NULL', null, false)
                ->where('department !=', '')
                ->groupBy('department')
                ->orderBy('department', 'ASC')
                ->get()
                ->getResultArray();
            $departments = array_map(static fn($row) => $row['department'], $rows);
        }

        return $this->successResponse($departments, 'Departments retrieved successfully');
    }

    private function generateSlug($title)
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}
