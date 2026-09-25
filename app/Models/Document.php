<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'file_path',
        'file_size',
        'downloads_count',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
        'downloads_count' => 'integer',
    ];

    public function getFileUrlAttribute(): string
    {
        if ($this->file_path && file_exists(public_path('storage/' . $this->file_path))) {
            return asset('storage/' . $this->file_path);
        }
        return '#';
    }
}
