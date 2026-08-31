<?php

namespace App\Models;

use CodeIgniter\Model;

class CvReviewEventModel extends Model
{
    protected $table = 'cv_review_events';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'lead_id', 'event_type', 'actor_type', 'actor_id', 'channel', 'outcome',
        'metadata_json', 'created_at',
    ];
    protected $useTimestamps = false;

    public function record(
        int $leadId,
        string $eventType,
        array $metadata = [],
        ?array $actor = null,
        ?string $channel = null,
        ?string $outcome = null
    ): ?int {
        $db = db_connect();
        if (!$db->tableExists($this->table)) {
            return null;
        }

        $id = $this->insert([
            'lead_id' => $leadId,
            'event_type' => $eventType,
            'actor_type' => $actor ? 'admin' : 'system',
            'actor_id' => $actor['id'] ?? null,
            'channel' => $channel,
            'outcome' => $outcome,
            'metadata_json' => $metadata ? json_encode($metadata, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null,
            'created_at' => date('Y-m-d H:i:s'),
        ], true);

        return $id ? (int) $id : null;
    }
}
