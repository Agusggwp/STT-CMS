<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'content',
        'meta_title',
        'meta_description',
        'status',
        'order',
        'is_system',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    public function sections()
    {
        return $this->hasMany(PageSection::class)->orderBy('order', 'asc');
    }
}
