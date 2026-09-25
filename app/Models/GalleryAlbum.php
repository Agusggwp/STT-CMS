<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryAlbum extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'event_date',
        'category',
        'order',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'order' => 'integer',
    ];

    public function images()
    {
        return $this->hasMany(GalleryImage::class, 'album_id')->orderBy('order', 'asc');
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image && file_exists(public_path('storage/' . $this->cover_image))) {
            return asset('storage/' . $this->cover_image);
        }
        if ($this->cover_image && str_starts_with($this->cover_image, 'http')) {
            return $this->cover_image;
        }
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_url;
        }
        return 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1200&q=80';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
