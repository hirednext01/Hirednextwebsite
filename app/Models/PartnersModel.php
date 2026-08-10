<?php

namespace App\Models;

use CodeIgniter\Model;

class PartnersModel extends Model
{
    protected $table            = 'partners';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'logo',
        'type',
        'description',
        'website_url',
        'status',
        'sort_order',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|min_length[3]|max_length[255]',
        'type' => 'required|in_list[lab,pharma,surgical]',
        'status' => 'required|in_list[active,inactive]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get active partners by type
     */
    public function getActiveByType($type)
    {
        return $this->where('type', $type)
                    ->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get all active partners
     */
    public function getAllActive()
    {
        return $this->where('status', 'active')
                    ->orderBy('type', 'ASC')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}

