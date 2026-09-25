<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationalPosition extends Model
{
    protected $fillable = [
        'name',
        'code',
        'level',
        'order',
    ];

    protected $casts = [
        'level' => 'integer',
        'order' => 'integer',
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'position_id')->orderBy('order', 'asc');
    }
}
