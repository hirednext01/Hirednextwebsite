<?php

namespace App\Services\Cv;

use App\Models\CvReviewEventModel;

class CvAuditService
{
    public function available(): bool
    {
        $db = db_connect();
        return $db->tableExists('cv_review_events');
    }

    public function record(
        int $leadId,
        string $eventType,
        array $metadata = [],
        ?array $actor = null,
        ?string $channel = null,
        ?string $outcome = null
    ): ?int {
        try {
            return (new CvReviewEventModel())->record($leadId, $eventType, $metadata, $actor, $channel, $outcome);
        } catch (\Throwable $e) {
            log_message('error', 'CV audit event failed for lead #' . $leadId . ': ' . $e->getMessage());
            return null;
        }
    }

    public function timeline(int $leadId): array
    {
        if (!$this->available()) {
            return [];
        }

        return (new CvReviewEventModel())
            ->where('lead_id', $leadId)
            ->orderBy('created_at', 'DESC')
            ->findAll(300);
    }
}
