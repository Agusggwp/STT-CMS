<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'page_key',
        'section_key',
        'title',
        'subtitle',
        'content',
        'type',
        'data',
        'order',
        'is_active',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
