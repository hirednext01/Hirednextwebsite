<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewsModel extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['client_name', 'client_position', 'client_company', 'rating', 'review_text', 'client_image', 'status', 'sort_order'];
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
