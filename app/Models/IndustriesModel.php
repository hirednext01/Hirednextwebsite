<?php

namespace App\Models;

use CodeIgniter\Model;

class IndustriesModel extends Model
{
    protected $table = 'industries';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 'description', 'icon', 'image', 'status', 'sort_order'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'description' => 'permit_empty|max_length[1000]',
        'icon' => 'permit_empty|max_length[100]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Industry name is required',
            'min_length' => 'Industry name must be at least 3 characters long',
            'max_length' => 'Industry name cannot exceed 100 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getActiveIndustries()
    {
        return $this->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function getIndustriesByStatus($status = 'active')
    {
        return $this->where('status', $status)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }
}
