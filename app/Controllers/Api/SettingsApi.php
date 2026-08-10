<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class SettingsApi extends BaseApiController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            
            $settings = $db->table('website_settings')
                          ->get()
                          ->getResultArray();
            
            // Convert to key-value pairs
            $settingsData = [];
            foreach ($settings as $setting) {
                $settingsData[$setting['setting_key']] = $setting['setting_value'];
            }
            
            return $this->successResponse($settingsData, 'Settings retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving settings: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            $data = $this->request->getJSON(true);
            
            if (empty($data)) {
                return $this->errorResponse('No settings data provided', 400);
            }
            
            $db = \Config\Database::connect();
            $db->transStart();
            
            foreach ($data as $key => $value) {
                // Convert boolean to string for storage
                if (is_bool($value)) {
                    $value = $value ? '1' : '0';
                }
                
                $existing = $db->table('website_settings')
                              ->where('setting_key', $key)
                              ->get()
                              ->getRowArray();
                
                if ($existing) {
                    // Update existing setting
                    $db->table('website_settings')
                       ->where('setting_key', $key)
                       ->update([
                           'setting_value' => $value,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
                } else {
                    // Create new setting
                    $db->table('website_settings')->insert([
                        'setting_key' => $key,
                        'setting_value' => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                return $this->errorResponse('Failed to update settings', 500);
            }
            
            return $this->successResponse([], 'Settings updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating settings: ' . $e->getMessage(), 500);
        }
    }
}
