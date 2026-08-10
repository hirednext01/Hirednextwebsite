<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientsModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'industry', 'logo', 'description', 'website', 'status', 'sort_order'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveClients()
    {
        return $this->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getClientsByIndustry($industry)
    {
        return $this->where('status', 'active')
                    ->where('industry', $industry)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
