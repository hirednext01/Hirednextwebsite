<?php

namespace App\Models;

use CodeIgniter\Model;

class CvUpgradeOrderModel extends Model
{
    protected $table = 'cv_upgrade_orders';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'lead_id', 'token', 'tier', 'service_name', 'amount', 'status', 'payment_reference',
        'offered_at', 'submitted_at', 'verified_at', 'delivered_at', 'created_at', 'updated_at',
    ];
    protected $useTimestamps = false;
}
