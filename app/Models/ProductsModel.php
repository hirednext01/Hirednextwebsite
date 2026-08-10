<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'category', 'description', 'features', 'image', 'status', 'sort_order'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveProducts()
    {
        return $this->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getProductWithFeatures($id)
    {
        $product = $this->find($id);
        if ($product && $product['features']) {
            $product['features'] = json_decode($product['features'], true);
        }
        return $product;
    }

    public function createProduct($data)
    {
        if (isset($data['features']) && is_array($data['features'])) {
            $data['features'] = json_encode($data['features']);
        }
        return $this->insert($data);
    }

    public function updateProduct($id, $data)
    {
        if (isset($data['features']) && is_array($data['features'])) {
            $data['features'] = json_encode($data['features']);
        }
        return $this->update($id, $data);
    }
}
