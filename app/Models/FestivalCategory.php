<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FestivalCategory extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'slug',
        'content',
        'color_scheme',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('title') && empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
