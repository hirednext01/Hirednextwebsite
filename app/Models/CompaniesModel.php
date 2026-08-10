<?php

namespace App\Models;

use CodeIgniter\Model;

class CompaniesModel extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 'industry', 'logo', 'description', 'website', 'status', 'sort_order'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'industry' => 'required|min_length[3]|max_length[100]',
        'description' => 'permit_empty|max_length[1000]',
        'logo' => 'permit_empty|max_length[255]',
        'website' => 'permit_empty|valid_url|max_length[255]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Company name is required',
            'min_length' => 'Company name must be at least 3 characters long',
            'max_length' => 'Company name cannot exceed 100 characters'
        ],
        'industry' => [
            'required' => 'Industry is required',
            'min_length' => 'Industry must be at least 3 characters long',
            'max_length' => 'Industry cannot exceed 100 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getActiveCompanies()
    {
        return $this->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function getCompaniesByIndustry($industry)
    {
        return $this->where('industry', $industry)
                   ->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function getCompaniesByStatus($status = 'active')
    {
        return $this->where('status', $status)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }
}
