<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'position_id',
        'name',
        'position_title',
        'period',
        'photo',
        'bio',
        'phone',
        'email',
        'social_links',
        'order',
        'is_active',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function position()
    {
        return $this->belongsTo(OrganizationalPosition::class, 'position_id');
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path('storage/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }
        if ($this->photo && str_starts_with($this->photo, 'http')) {
            return $this->photo;
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=8B1E24&color=ffffff&size=512';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }
}
