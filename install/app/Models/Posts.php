<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'user_id',
        'category_id',
        'status',
        'published_at',
        'views_count',
        'is_featured',
        'meta_data',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'meta_data' => 'array',
        'views_count' => 'integer',
    ];

    protected $attributes = [
        'status' => 'draft',
        'views_count' => 0,
        'is_featured' => false,
    ];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the post.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured posts.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
