<?php

namespace App\Models;

use CodeIgniter\Model;

class CvAnalysisRunModel extends Model
{
    protected $table = 'cv_analysis_runs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'lead_id', 'status', 'service_tier', 'extracted_text', 'extraction_meta',
        'provider_status_json', 'synthesis_json', 'error_message', 'started_at',
        'completed_at', 'created_at', 'updated_at',
    ];
    protected $useTimestamps = false;
}
