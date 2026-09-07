<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TestimonialAdmin extends BaseController
{
    private const SESSION_KEY = 'cv_review_admin_user';

    public function index()
    {
        $user = $this->adminUser();
        if (!$user) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }

        $db = \Config\Database::connect();
        $rows = $db->tableExists('reviews')
            ? $db->table('reviews')->orderBy('created_at', 'DESC')->limit(300)->get()->getResultArray()
            : [];

        $stats = ['pending' => 0, 'active' => 0, 'external' => 0, 'rejected' => 0, 'total' => count($rows)];
        foreach ($rows as $row) {
            $status = strtolower(trim((string)($row['status'] ?? 'pending')));
            if (isset($stats[$status])) {
                $stats[$status]++;
            }
        }

        return view('pages/admin/testimonials', [
            'title' => 'Testimonials Admin | HiredNext',
            'rows' => $rows,
            'stats' => $stats,
            'adminUser' => $user,
        ]);
    }

    public function detail($id)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }

        $db = \Config\Database::connect();
        $row = $db->table('reviews')->where('id', (int)$id)->get()->getRowArray();
        if (!$row) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('pages/admin/testimonial-detail', [
            'title' => 'Testimonial #' . (int)$id . ' | HiredNext Admin',
            'row' => $row,
            'adminUser' => $user,
        ]);
    }

    public function save($id)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }

        $db = \Config\Database::connect();
        $row = $db->table('reviews')->where('id', (int)$id)->get()->getRowArray();
        if (!$row) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $allowedFields = array_flip($db->getFieldNames('reviews'));
        $input = [
            'client_name' => trim((string)$this->request->getPost('client_name')),
            'name' => trim((string)$this->request->getPost('client_name')),
            'company' => trim((string)$this->request->getPost('company')),
            'designation' => trim((string)$this->request->getPost('designation')),
            'comment' => trim((string)$this->request->getPost('comment')),
            'linkedin_url' => trim((string)$this->request->getPost('linkedin_url')),
            'source_url' => trim((string)$this->request->getPost('source_url')),
            'source_label' => trim((string)$this->request->getPost('source_label')),
            'placement_role' => trim((string)$this->request->getPost('placement_role')),
            'placement_location' => trim((string)$this->request->getPost('placement_location')),
            'placement_year' => trim((string)$this->request->getPost('placement_year')),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $input = array_intersect_key($input, $allowedFields);

        if (($input['comment'] ?? '') === '') {
            return redirect()->back()->with('error', 'Display copy cannot be blank.');
        }

        $db->table('reviews')->where('id', (int)$id)->update($input);
        return redirect()->to('/admin/testimonials/' . (int)$id)->with('success', 'Testimonial updated.');
    }

    public function status($id)
    {
        $user = $this->requireAdminRedirect();
        if (!is_array($user)) {
            return $user;
        }

        $status = strtolower(trim((string)$this->request->getPost('status')));
        $allowed = ['pending', 'active', 'rejected'];
        if (!in_array($status, $allowed, true)) {
            return redirect()->back()->with('error', 'Invalid testimonial status.');
        }

        $db = \Config\Database::connect();
        $row = $db->table('reviews')->where('id', (int)$id)->get()->getRowArray();
        if (!$row) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $db->table('reviews')->where('id', (int)$id)->update([
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $message = $status === 'active' ? 'Testimonial approved and published.' : ucfirst($status) . ' status saved.';
        return redirect()->to('/admin/testimonials/' . (int)$id)->with('success', $message);
    }

    private function adminUser(): ?array
    {
        $user = session(self::SESSION_KEY);
        return is_array($user) ? $user : null;
    }

    private function requireAdminRedirect()
    {
        $user = $this->adminUser();
        return $user ?: redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
    }
}
