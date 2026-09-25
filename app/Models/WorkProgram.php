<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkProgram extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'objectives',
        'start_date',
        'end_date',
        'pic_name',
        'status',
        'documentation_notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'rencana' => ['label' => 'Rencana', 'class' => 'bg-neutral-100 text-neutral-700 border-neutral-300'],
            'berjalan' => ['label' => 'Sedang Berjalan', 'class' => 'bg-amber-50 text-amber-800 border-amber-300'],
            'selesai' => ['label' => 'Selesai', 'class' => 'bg-emerald-50 text-emerald-800 border-emerald-300'],
            default => ['label' => ucfirst($this->status), 'class' => 'bg-neutral-100 text-neutral-700 border-neutral-300'],
        };
    }
}
