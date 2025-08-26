<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'description',
        'images'
    ];

    protected $casts = [
        'images'        => 'array'
    ];
}
