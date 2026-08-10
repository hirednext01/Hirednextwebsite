<?php

namespace App\Controllers\Api;

use App\Models\JobModel;
use App\Models\JobApplicationModel;
use CodeIgniter\HTTP\ResponseInterface;

class JobApplicationsApi extends BaseApiController
{
    protected $jobModel;
    protected $applicationModel;

    public function __construct()
    {
        parent::__construct();
        $this->jobModel = new JobModel();
        $this->applicationModel = new JobApplicationModel();
    }

    public function update($id = null)
    {
        $user = $this->requireRole(['admin', 'recruiter']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        if (!$id) {
            return $this->errorResponse('Application ID is required', 400);
        }

        $application = $this->applicationModel->find($id);
        if (!$application) {
            return $this->errorResponse('Application not found', 404);
        }

        $job = $this->jobModel->find($application['job_id']);
        if (!$job) {
            return $this->errorResponse('Job not found', 404);
        }

        if (($user['role'] ?? '') !== 'admin' && (int)$job['created_by'] !== (int)$user['id']) {
            return $this->errorResponse('Forbidden', 403);
        }

        $data = $this->request->getJSON(true);

        $updateData = [
            'status' => $data['status'] ?? $application['status'],
            'review_notes' => $data['review_notes'] ?? $application['review_notes'],
            'reviewed_by' => $user['id'],
            'reviewed_at' => date('Y-m-d H:i:s'),
        ];

        $this->applicationModel->update($id, $updateData);
        $application = $this->applicationModel->find($id);

        return $this->successResponse($application, 'Application updated successfully');
    }
}
