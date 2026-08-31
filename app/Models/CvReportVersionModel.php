<?php

namespace App\Models;

use CodeIgniter\Model;

class CvReportVersionModel extends Model
{
    protected $table = 'cv_report_versions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'lead_id', 'analysis_run_id', 'version', 'status', 'report_json', 'report_text',
        'human_notes', 'approved_by', 'approved_at', 'sent_at', 'created_at', 'updated_at',
    ];
    protected $useTimestamps = false;
}
