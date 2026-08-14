<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewsModel extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'client_name', 'name', 'designation', 'client_position', 'client_company',
        'rating', 'review_text', 'comment', 'client_image', 'project_type',
        'proof_type', 'source_label', 'source_url', 'linkedin_url',
        'relationship_type', 'placement_role', 'placement_location', 'placement_year',
        'submitter_email', 'submitter_phone', 'help_received', 'future_support',
        'publish_consent', 'submitted_via', 'status', 'sort_order',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveReviews()
    {
        return $this->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getReviewsByRating($rating)
    {
        return $this->where('status', 'active')
                    ->where('rating', $rating)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
