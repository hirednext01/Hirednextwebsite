<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class CvReviewAdmin extends BaseController
{
    private const SESSION_KEY = 'cv_review_admin_user';

    public function index()
    {
        $user = session(self::SESSION_KEY);
        if (!$user) {
            return view('pages/admin/cv-reviews-login', [
                'title' => 'CV Reviews Admin | HiredNext',
            ]);
        }

        $db = \Config\Database::connect();
        $rows = [];
        if ($db->tableExists('cv_assessment_leads')) {
            $rows = $db->table('cv_assessment_leads')
                ->orderBy('created_at', 'DESC')
                ->limit(250)
                ->get()
                ->getResultArray();
        }

        $stats = [
            'total' => count($rows),
            'priority_requested' => 0,
            'payment_submitted' => 0,
            'paid_verified' => 0,
            'new' => 0,
        ];
        foreach ($rows as $row) {
            if (($row['assessment_plan'] ?? '') === 'priority_599') {
                $stats['priority_requested']++;
            }
            if (($row['payment_status'] ?? '') === 'pending_verification' || ($row['status'] ?? '') === 'payment_submitted') {
                $stats['payment_submitted']++;
            }
            if (in_array(($row['payment_status'] ?? ''), ['verified', 'paid'], true)) {
                $stats['paid_verified']++;
            }
            if (($row['status'] ?? '') === 'new') {
                $stats['new']++;
            }
        }

        return view('pages/admin/cv-reviews', [
            'title' => 'CV Reviews Admin | HiredNext',
            'rows' => $rows,
            'stats' => $stats,
            'adminUser' => $user,
        ]);
    }

    public function login()
    {
        $identifier = trim((string)($this->request->getPost('identifier') ?? $this->request->getPost('username')));
        $password = (string)$this->request->getPost('password');

        if ($identifier === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Enter your HiredNext admin username or email and password.');
        }

        $model = new UserModel();
        $user = str_contains($identifier, '@')
            ? $model->authenticateByEmail($identifier, $password)
            : $model->authenticate($identifier, $password);

        if (!$user || !in_array($user['role'] ?? '', ['admin', 'manager', 'recruiter'], true)) {
            return redirect()->back()->withInput()->with('error', 'Invalid admin credentials or insufficient access.');
        }

        session()->regenerate();
        session()->set(self::SESSION_KEY, [
            'id' => $user['id'],
            'name' => $user['name'] ?? $user['username'],
            'username' => $user['username'],
            'email' => $user['email'] ?? '',
            'role' => $user['role'],
        ]);

        return redirect()->to('/admin/cv-reviews');
    }

    public function logout()
    {
        session()->remove(self::SESSION_KEY);
        session()->regenerate();
        return redirect()->to('/admin/cv-reviews');
    }

    public function resume($id)
    {
        if (!session(self::SESSION_KEY)) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in to view CV files.');
        }

        $db = \Config\Database::connect();
        $row = $db->table('cv_assessment_leads')->where('id', (int)$id)->get()->getRowArray();
        if (!$row) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $stored = trim((string)($row['resume_path'] ?? ''));
        $path = $stored !== '' ? ROOTPATH . ltrim($stored, '/') : '';
        if ($path === '' || !is_file($path) || !is_readable($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^A-Za-z0-9._-]+/', '-', (string)($row['name'] ?? 'candidate'));
        $filename = trim($safeName, '-') . '-CV-' . (int)$id . ($ext !== '' ? '.' . $ext : '');

        return $this->response->download($path, null)->setFileName($filename);
    }

    public function updateStatus($id)
    {
        if (!session(self::SESSION_KEY)) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }

        $status = trim((string)$this->request->getPost('status'));
        $allowed = ['new', 'payment_submitted', 'in_review', 'completed', 'closed'];
        if (!in_array($status, $allowed, true)) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Invalid CV review status.');
        }

        $db = \Config\Database::connect();
        $db->table('cv_assessment_leads')->where('id', (int)$id)->update([
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/cv-reviews')->with('success', 'CV review status updated.');
    }
}
