<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'thumbnail',
        'description',
        'content',
        'event_date',
        'location',
        'author_name',
        'status',
        'is_featured',
        'gallery_images',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'event_date' => 'date',
        'gallery_images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ActivityCategory::class, 'category_id');
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
        return 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=80';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
