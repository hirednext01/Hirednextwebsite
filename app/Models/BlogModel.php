<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = 'blog_posts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'category',
        'tags',
        'author_name',
        'status',
        'sort_order',
        'published_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get active/published blog posts
     */
    public function getPublished($limit = null, $offset = 0)
    {
        $builder = $this->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->orderBy('sort_order', 'ASC');

        if ($limit !== null) {
            return $builder->findAll($limit, $offset);
        }

        return $builder->findAll();
    }

    /**
     * Get blog post by slug
     */
    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)
            ->where('status', 'published')
            ->first();
    }
}
