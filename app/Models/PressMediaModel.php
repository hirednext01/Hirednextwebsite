<?php

namespace App\Models;

use CodeIgniter\Model;

class PressMediaModel extends Model
{
    protected $table = 'press_media';
    protected $primaryKey = 'id';
    protected $allowedFields = ['image_url', 'media_link', 'description', 'status', 'sort_order'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
