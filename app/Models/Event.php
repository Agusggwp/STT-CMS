<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'poster',
        'registration_link',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function getPosterUrlAttribute(): string
    {
        if ($this->poster && file_exists(public_path('storage/' . $this->poster))) {
            return asset('storage/' . $this->poster);
        }
        if ($this->poster && str_starts_with($this->poster, 'http')) {
            return $this->poster;
        }
        return 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1200&q=80';
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())->orderBy('event_date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString())->orderBy('event_date', 'desc');
    }
}
