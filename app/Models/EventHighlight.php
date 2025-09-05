<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventHighlight extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'icon',
        'color_scheme',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('id');
    }
}
