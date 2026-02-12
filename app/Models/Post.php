<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'featured_image',
        'video_path',
        'bridge_text',
        'scroll_text',
        'next_post_id',
        'sort_order',
        'views',
        'is_active',
        'meta_title',
        'meta_description',
        'focus_keyword',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views' => 'integer',
        'sort_order' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * Get the next post in the arbitrage loop
     */
    public function nextPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'next_post_id');
    }

    /**
     * Scope for active posts only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered posts
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Scope for published posts
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }
}
