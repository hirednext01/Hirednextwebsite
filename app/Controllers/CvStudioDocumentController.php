<?php

namespace App\Controllers;

use App\Models\CvDocumentModel;
use App\Models\CvEmailEventModel;
use App\Services\Cv\CvAuditService;
use App\Services\Cv\CvDocxRenderer;

class CvStudioDocumentController extends BaseController
{
    private const SESSION_KEY = 'cv_review_admin_user';

    public function downloadWord($leadId, $documentId)
    {
        if (!$this->adminUser()) {
            return redirect()->to('/admin/cv-reviews')->with('error', 'Please sign in first.');
        }

        try {
            [$lead, $document, $content] = $this->documentContext((int) $leadId, (int) $documentId);
            $path = $this->renderDocx($lead, $document, $content);
            $safe = $this->safeName((string) ($lead['name'] ?? 'Candidate'));
            $filename = ($safe ?: 'Candidate') . '-HiredNext-CV-' . (int) $documentId . '.docx';

            return $this->response
                ->download($path, null, true)
                ->setFileName($filename)
                ->setHeader('Cache-Control', 'private, no-store, no-cache, must-revalidate');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/cv-studio/' . (int) $leadId)->with('error', 'DOCX download failed: ' . $e->getMessage());
        }
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
                return redirect()->to('/admin/cv-studio/' . (int) $leadId)
                    ->with('error', 'Resolve the factual clarification flags before delivering this CV.');
            }

            $path = $this->renderDocx($lead, $document, $content);
            $safe = $this->safeName((string) ($lead['name'] ?? 'Candidate'));
            $filename = ($safe ?: 'Candidate') . '-HiredNext-CV-' . (int) $documentId . '.docx';

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
                '<p>Your HiredNext professional CV draft is attached as an editable DOCX for review.</p>' .
                '<p>Please check names, dates, titles, qualifications and quantified achievements carefully. Reply to this email with any factual corrections or revision requests included in your service.</p>' .
                '<p>Once finalised, you can also add the upgraded CV to your professional profile at <a href="https://www.theprofile360.in">TheProfile360.in</a>.</p>' .
                '<p style="font-size:12px;color:#667085">This professional CV service is optional and has no bearing on HiredNext recruitment consideration, interviews or placement.</p>' .
                '<p>Regards,<br>HiredNext Jobs Team</p>'
            );
            $email->attach($path, 'attachment', $filename);
            $sent = $email->send(false);

            if ($eventId) {
                $sent
                    ? $emailModel->markSent($eventId)
                    : $emailModel->markFailed($eventId, $email->printDebugger(['headers']));
            }

            if (!$sent) {
                throw new \RuntimeException('Email send failed. The attempt has been logged.');
            }

            (new CvDocumentModel())->update((int) $documentId, [
                'status' => 'delivered',
                'delivered_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            (new CvAuditService())->record(
                (int) $leadId,
                'cv_draft_delivered',
                ['document_id' => (int) $documentId, 'recipient' => $lead['email'], 'format' => 'docx'],
                $user,
                'email',
                'sent'
            );

            @unlink($path);
            return redirect()->to('/admin/cv-studio/' . (int) $leadId)
                ->with('success', 'Professional DOCX CV draft emailed from jobs@hirednext.info and logged.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/cv-studio/' . (int) $leadId)->with('error', 'CV delivery failed: ' . $e->getMessage());
        }
    }

    private function renderDocx(array $lead, array $document, array $content): string
    {
        $dir = WRITEPATH . 'exports/cv-studio';
        if (!is_dir($dir) && !mkdir($dir, 0750, true) && !is_dir($dir)) {
            throw new \RuntimeException('Unable to create CV export directory.');
        }

        $path = $dir . '/cv-' . (int) $document['id'] . '-' . bin2hex(random_bytes(6)) . '.docx';
        (new CvDocxRenderer())->render($lead, $document, $content, $path);
        return $path;
    }

    private function documentContext(int $leadId, int $documentId): array
    {
        $db = db_connect();
        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->get()->getRowArray();
        $document = (new CvDocumentModel())->find($documentId);
        if (!$lead || !$document || (int) ($document['lead_id'] ?? 0) !== $leadId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $content = json_decode((string) ($document['content_json'] ?? ''), true);
        if (!is_array($content)) {
            throw new \RuntimeException('CV document content is invalid.');
        }
        return [$lead, $document, $content];
    }

    private function adminUser(): ?array
    {
        $user = session(self::SESSION_KEY);
        return is_array($user) ? $user : null;
    }

    private function safeName(string $value): string
    {
        return trim((string) preg_replace('/[^A-Za-z0-9]+/', '-', $value), '-');
    }
}
