<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'alt_text',
        'caption',
        'folder',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function getUrlAttribute(): string
    {
        if ($this->file_path && file_exists(public_path('storage/' . $this->file_path))) {
            return asset('storage/' . $this->file_path);
        }
        if ($this->file_path && str_starts_with($this->file_path, 'http')) {
            return $this->file_path;
        }
        return asset('storage/' . $this->file_path);
    }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }
}
