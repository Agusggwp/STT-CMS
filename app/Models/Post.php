<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'thumbnail',
        'summary',
        'content',
        'author_name',
        'status',
        'is_featured',
        'views_count',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && file_exists(public_path('storage/' . $this->thumbnail))) {
            return asset('storage/' . $this->thumbnail);
        }
        if ($this->thumbnail && str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }
        return 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
