<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'album_id',
        'image_path',
        'caption',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function album()
    {
        return $this->belongsTo(GalleryAlbum::class, 'album_id');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image_path && file_exists(public_path('storage/' . $this->image_path))) {
            return asset('storage/' . $this->image_path);
        }
        if ($this->image_path && str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        return 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80';
    }
}
