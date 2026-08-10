<?php

namespace App\Models;

use CodeIgniter\Model;

class AchievementsModel extends Model
{
    protected $table = 'achievements';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'icon', 'year', 'status', 'sort_order'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveAchievements()
    {
        return $this->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getAchievementsByYear($year)
    {
        return $this->where('status', 'active')
                    ->where('year', $year)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
