<?php

namespace App\Models;

use CodeIgniter\Model;

class ServicesModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $allowedFields = ['image', 'title', 'description', 'features', 'status', 'sort_order'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveServices()
    {
        return $this->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getServiceWithFeatures($id)
    {
        $service = $this->find($id);
        if ($service && $service['features']) {
            $service['features'] = json_decode($service['features'], true);
        }
        return $service;
    }

    public function createService($data)
    {
        if (isset($data['features']) && is_array($data['features'])) {
            $data['features'] = json_encode($data['features']);
        }
        return $this->insert($data);
    }

    public function updateService($id, $data)
    {
        if (isset($data['features']) && is_array($data['features'])) {
            $data['features'] = json_encode($data['features']);
        }
        return $this->update($id, $data);
    }
}
