<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'title',
        'image',
        'tier',
        'website_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByTier($query, $tier)
    {
        return $query->where('tier', $tier);
    }
}
