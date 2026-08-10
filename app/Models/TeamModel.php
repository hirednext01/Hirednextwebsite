<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table = 'team_members';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'role', 'bio', 'email', 'linkedin', 'image', 'status', 'sort_order'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveTeam()
    {
        return $this->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getTeamMember($id)
    {
        return $this->find($id);
    }

    public function createTeamMember($data)
    {
        return $this->insert($data);
    }

    public function updateTeamMember($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteTeamMember($id)
    {
        return $this->delete($id);
    }
}
