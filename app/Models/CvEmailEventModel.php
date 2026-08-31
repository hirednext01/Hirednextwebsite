<?php

namespace App\Models;

use CodeIgniter\Model;

class CvEmailEventModel extends Model
{
    protected $table = 'cv_email_events';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'lead_id', 'report_version_id', 'event_type', 'recipient', 'subject', 'status',
        'provider_message_id', 'error_message', 'created_at', 'updated_at',
    ];
    protected $useTimestamps = false;

    public function recordAttempt(int $leadId, string $eventType, string $recipient, string $subject, ?int $reportVersionId = null): ?int
    {
        $db = db_connect();
        if (!$db->tableExists($this->table)) {
            return null;
        }

        $id = $this->insert([
            'lead_id' => $leadId,
            'report_version_id' => $reportVersionId,
            'event_type' => $eventType,
            'recipient' => $recipient,
            'subject' => $subject,
            'status' => 'attempted',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ], true);

        return $id ? (int) $id : null;
    }

    public function markSent(int $id, ?string $providerMessageId = null): void
    {
        $this->update($id, [
            'status' => 'sent',
            'provider_message_id' => $providerMessageId,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function markFailed(int $id, string $error): void
    {
        $this->update($id, [
            'status' => 'failed',
            'error_message' => mb_substr($error, 0, 2000),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
