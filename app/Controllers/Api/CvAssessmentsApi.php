<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;

class CvAssessmentsApi extends BaseApiController
{
    public function index()
    {
        $user = $this->requireRole(['admin', 'recruiter']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        $db = \Config\Database::connect();
        if (!$db->tableExists('cv_assessment_leads')) {
            return $this->successResponse([], 'No CV assessment table found');
        }

        $limit = (int)($this->request->getGet('limit') ?? 100);
        $limit = max(1, min(250, $limit));
        $plan = trim((string)($this->request->getGet('plan') ?? ''));
        $paymentStatus = trim((string)($this->request->getGet('payment_status') ?? ''));
        $status = trim((string)($this->request->getGet('status') ?? ''));

        $builder = $db->table('cv_assessment_leads')
            ->select('id, name, email, phone, assessment_plan, job_slug, job_title, message, amount, payment_status, payment_id, status, created_at, updated_at')
            ->orderBy('created_at', 'DESC')
            ->limit($limit);

        if ($plan !== '') {
            $builder->where('assessment_plan', $plan);
        }
        if ($paymentStatus !== '') {
            $builder->where('payment_status', $paymentStatus);
        }
        if ($status !== '') {
            $builder->where('status', $status);
        }

        $rows = $builder->get()->getResultArray();
        foreach ($rows as &$row) {
            $row['resume_available'] = true;
            $row['resume_download_url'] = base_url('api/cv-assessments/' . $row['id'] . '/resume');
        }
        unset($row);

        return $this->successResponse($rows, 'CV assessment requests retrieved');
    }

    public function show($id = null)
    {
        $user = $this->requireRole(['admin', 'recruiter']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        $db = \Config\Database::connect();
        $row = $db->table('cv_assessment_leads')->where('id', (int)$id)->get()->getRowArray();
        if (!$row) {
            return $this->errorResponse('CV assessment request not found', 404);
        }

        $row['resume_available'] = $this->resumePath($row) !== null;
        $row['resume_download_url'] = $row['resume_available'] ? base_url('api/cv-assessments/' . $row['id'] . '/resume') : null;
        return $this->successResponse($row, 'CV assessment request retrieved');
    }

    public function update($id = null)
    {
        $user = $this->requireRole(['admin', 'recruiter']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        $allowedStatuses = ['new', 'payment_submitted', 'in_review', 'completed', 'closed'];
        $data = $this->request->getJSON(true) ?: [];
        $status = trim((string)($data['status'] ?? ''));
        if (!in_array($status, $allowedStatuses, true)) {
            return $this->errorResponse('Invalid status', 422);
        }

        $db = \Config\Database::connect();
        $exists = $db->table('cv_assessment_leads')->where('id', (int)$id)->countAllResults() > 0;
        if (!$exists) {
            return $this->errorResponse('CV assessment request not found', 404);
        }

        $db->table('cv_assessment_leads')->where('id', (int)$id)->update([
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->successResponse(['id' => (int)$id, 'status' => $status], 'CV assessment status updated');
    }

    public function resume($id = null)
    {
        $user = $this->requireRole(['admin', 'recruiter']);
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        $db = \Config\Database::connect();
        $row = $db->table('cv_assessment_leads')->where('id', (int)$id)->get()->getRowArray();
        if (!$row) {
            return $this->errorResponse('CV assessment request not found', 404);
        }

        $path = $this->resumePath($row);
        if ($path === null) {
            return $this->errorResponse('CV file not found', 404);
        }

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^A-Za-z0-9._-]+/', '-', (string)($row['name'] ?? 'candidate'));
        $downloadName = trim($safeName, '-') . '-CV-' . (int)$id . ($ext !== '' ? '.' . $ext : '');

        return $this->response->download($path, null)->setFileName($downloadName);
    }

    private function resumePath(array $row): ?string
    {
        $stored = trim((string)($row['resume_path'] ?? ''));
        if ($stored === '') {
            return null;
        }

        $path = ROOTPATH . ltrim($stored, '/');
        return is_file($path) && is_readable($path) ? $path : null;
    }
}
