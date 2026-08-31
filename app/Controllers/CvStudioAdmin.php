<?php

namespace App\Controllers;

use App\Models\CvDocumentModel;
use App\Models\CvEmailEventModel;
use App\Models\CvUpgradeOrderModel;
use App\Services\Cv\CvAuditService;
use App\Services\Cv\CvCreationAgent;
use App\Services\Cv\CvUpgradePlans;

class CvStudioAdmin extends BaseController
{
    private const SESSION_KEY = 'cv_review_admin_user';

    public function index()
    {
        $user = $this->adminUser();
        if (!$user) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }

        $db = db_connect();
        $ready = $db->tableExists('cv_documents');
        $leads = $db->tableExists('cv_assessment_leads')
            ? $db->table('cv_assessment_leads')->orderBy('created_at', 'DESC')->limit(250)->get()->getResultArray()
            : [];
        $docModel = $ready ? new CvDocumentModel() : null;

        foreach ($leads as &$lead) {
            $lead['latest_document'] = $ready
                ? $docModel->where('lead_id', (int) $lead['id'])->orderBy('id', 'DESC')->first()
                : null;
        }
        unset($lead);

        return view('pages/admin/cv-studio-index', [
            'title' => 'CV Studio | HiredNext Admin',
            'adminUser' => $user,
            'leads' => $leads,
            'studioReady' => $ready,
            'writers' => (new CvCreationAgent())->configuration(),
        ]);
    }

    public function detail($id)
    {
        $user = $this->adminUser();
        if (!$user) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }

        $db = db_connect();
        $lead = $db->table('cv_assessment_leads')->where('id', (int) $id)->get()->getRowArray();
        if (!$lead) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $documents = $db->tableExists('cv_documents')
            ? (new CvDocumentModel())->where('lead_id', (int) $id)->orderBy('id', 'DESC')->findAll(100)
            : [];
        foreach ($documents as &$doc) {
            $doc['content'] = $this->decode($doc['content_json'] ?? '');
            $doc['panel'] = $this->decode($doc['writer_panel_json'] ?? '');
            $doc['clarifications'] = $this->decode($doc['clarifications_json'] ?? '');
        }
        unset($doc);

        $orders = $db->tableExists('cv_upgrade_orders')
            ? (new CvUpgradeOrderModel())->where('lead_id', (int) $id)->orderBy('id', 'DESC')->findAll(50)
            : [];

        return view('pages/admin/cv-studio-detail', [
            'title' => 'Create CV — ' . ($lead['name'] ?? '') . ' | HiredNext Admin',
            'lead' => $lead,
            'documents' => $documents,
            'orders' => $orders,
            'writers' => (new CvCreationAgent())->configuration(),
            'pricedPlans' => CvUpgradePlans::all(),
            'executivePlan' => CvUpgradePlans::executiveInquiry(),
            'adminUser' => $user,
        ]);
    }

    public function generate($id)
    {
        $user = $this->adminUser();
        if (!$user) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }

        $template = trim((string) $this->request->getPost('template')) ?: 'ats_classic';
        $orderId = (int) ($this->request->getPost('order_id') ?: 0);
        try {
            $result = (new CvCreationAgent())->generate((int) $id, $template, $user, $orderId ?: null);
            $doc = $result['document'];
            $message = ($doc['status'] ?? '') === 'clarification_needed'
                ? 'Draft created. Important factual clarifications are flagged before delivery.'
                : 'HiredNext CV draft created and ready for your review.';
            return redirect()->to('/admin/cv-studio/' . (int) $id)->with('success', $message);
        } catch (\Throwable $e) {
            return redirect()->to('/admin/cv-studio/' . (int) $id)->with('error', 'CV creation could not complete: ' . $e->getMessage());
        }
    }

    public function preview($leadId, $documentId)
    {
        if (!$this->adminUser()) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }
        [$lead, $document, $content] = $this->documentContext((int) $leadId, (int) $documentId);
        return view('pages/admin/cv-studio-document', [
            'lead' => $lead,
            'document' => $document,
            'content' => $content,
            'preview' => true,
        ]);
    }

    public function downloadWord($leadId, $documentId)
    {
        if (!$this->adminUser()) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }
        [$lead, $document, $content] = $this->documentContext((int) $leadId, (int) $documentId);
        $html = view('pages/admin/cv-studio-document', [
            'lead' => $lead,
            'document' => $document,
            'content' => $content,
            'preview' => false,
            'wordExport' => true,
        ]);
        $safe = trim(preg_replace('/[^A-Za-z0-9]+/', '-', (string) ($lead['name'] ?? 'Candidate')), '-');
        $filename = ($safe ?: 'Candidate') . '-HiredNext-CV-' . (int) $documentId . '.doc';
        return $this->response
            ->setHeader('Content-Type', 'application/msword; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'private, no-store, no-cache, must-revalidate')
            ->setBody($html);
    }

    public function branding($leadId, $documentId)
    {
        $user = $this->adminUser();
        if (!$user) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }
        $mode = $this->request->getPost('branding_mode') === 'keep' ? 'keep' : 'remove';
        $model = new CvDocumentModel();
        $document = $model->find((int) $documentId);
        if (!$document || (int) ($document['lead_id'] ?? 0) !== (int) $leadId) {
            return redirect()->to('/admin/cv-studio/' . (int) $leadId)->with('error', 'CV document not found.');
        }
        $model->update((int) $documentId, ['branding_mode' => $mode, 'updated_at' => date('Y-m-d H:i:s')]);
        (new CvAuditService())->record((int) $leadId, 'cv_branding_updated', ['document_id' => (int) $documentId, 'branding_mode' => $mode], $user, 'admin', 'saved');
        return redirect()->to('/admin/cv-studio/' . (int) $leadId)->with('success', 'Final CV branding preference updated.');
    }

    public function deliver($leadId, $documentId)
    {
        $user = $this->adminUser();
        if (!$user) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }

        try {
            [$lead, $document, $content] = $this->documentContext((int) $leadId, (int) $documentId);
            if (($document['status'] ?? '') === 'clarification_needed') {
                return redirect()->to('/admin/cv-studio/' . (int) $leadId)->with('error', 'Resolve the factual clarification flags before delivering this CV.');
            }

            $html = view('pages/admin/cv-studio-document', [
                'lead' => $lead,
                'document' => $document,
                'content' => $content,
                'preview' => false,
                'wordExport' => true,
            ]);
            $dir = WRITEPATH . 'exports/cv-studio';
            if (!is_dir($dir)) {
                mkdir($dir, 0750, true);
            }
            $safe = trim(preg_replace('/[^A-Za-z0-9]+/', '-', (string) ($lead['name'] ?? 'Candidate')), '-');
            $path = $dir . '/' . ($safe ?: 'Candidate') . '-CV-' . (int) $documentId . '.doc';
            file_put_contents($path, $html);

            $subject = 'Your HiredNext professional CV draft | ' . ($lead['name'] ?? 'Candidate');
            $emailModel = new CvEmailEventModel();
            $eventId = $emailModel->recordAttempt((int) $leadId, 'cv_draft_delivery', (string) $lead['email'], $subject, null);

            $email = \Config\Services::email();
            $email->clear(true);
            $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
            $email->setTo($lead['email']);
            $email->setReplyTo('jobs@hirednext.info', 'HiredNext Jobs');
            $email->setSubject($subject);
            $email->setMailType('html');
            $email->setMessage(
                '<p>Dear ' . esc($lead['name'] ?? 'Candidate') . ',</p>' .
                '<p>Your HiredNext CV draft is attached for review.</p>' .
                '<p>Please review the facts, dates, titles and achievements carefully. Reply to this email with any factual corrections or revision requests included in your service.</p>' .
                '<p>Once the CV is final, you can also add it to your professional profile at <a href="https://www.theprofile360.in">TheProfile360.in</a>.</p>' .
                '<p style="font-size:12px;color:#667085">This professional CV service is optional and has no bearing on HiredNext recruitment consideration, interviews or placement.</p>' .
                '<p>Regards,<br>HiredNext Jobs Team</p>'
            );
            $email->attach($path, 'attachment', basename($path));
            $sent = $email->send(false);

            if ($eventId) {
                $sent ? $emailModel->markSent($eventId) : $emailModel->markFailed($eventId, $email->printDebugger(['headers']));
            }
            if (!$sent) {
                throw new \RuntimeException('Email send failed. The attempt has been logged.');
            }

            (new CvDocumentModel())->update((int) $documentId, [
                'status' => 'delivered',
                'delivered_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            (new CvAuditService())->record((int) $leadId, 'cv_draft_delivered', ['document_id' => (int) $documentId, 'recipient' => $lead['email']], $user, 'email', 'sent');
            @unlink($path);

            return redirect()->to('/admin/cv-studio/' . (int) $leadId)->with('success', 'Professional CV draft emailed from jobs@hirednext.info and logged.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/cv-studio/' . (int) $leadId)->with('error', 'CV delivery failed: ' . $e->getMessage());
        }
    }

    private function documentContext(int $leadId, int $documentId): array
    {
        $db = db_connect();
        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->get()->getRowArray();
        $document = (new CvDocumentModel())->find($documentId);
        if (!$lead || !$document || (int) ($document['lead_id'] ?? 0) !== $leadId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $content = $this->decode($document['content_json'] ?? '');
        return [$lead, $document, $content];
    }

    private function decode(string $json): array
    {
        $decoded = json_decode($json, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function adminUser(): ?array
    {
        $user = session(self::SESSION_KEY);
        return is_array($user) ? $user : null;
    }
}
