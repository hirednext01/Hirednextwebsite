<?php

namespace App\Models;

use CodeIgniter\Model;

class CvAnalysisFindingModel extends Model
{
    protected $table = 'cv_analysis_findings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'analysis_run_id', 'reviewer', 'category', 'finding', 'evidence',
        'why_it_matters', 'severity', 'recommendation', 'created_at',
    ];
    protected $useTimestamps = false;
}
