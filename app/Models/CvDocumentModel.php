<?php

namespace App\Models;

use CodeIgniter\Model;

class CvDocumentModel extends Model
{
    protected $table = 'cv_documents';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'lead_id', 'upgrade_order_id', 'analysis_run_id', 'template_key', 'status',
        'content_json', 'writer_panel_json', 'clarifications_json', 'branding_mode',
        'revision_round', 'created_by', 'created_at', 'updated_at', 'delivered_at',
    ];
}
