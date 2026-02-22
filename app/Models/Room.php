<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'floor_id',
        'floor_name',
        'floor_view',
        'floor_coords',
        'room_type',
        'price',
        'description',
        'facilities',
        'image_url',
        'images',
        'order',
    ];

    protected $casts = [
        'images' => 'array',
        'facilities' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('order', 'asc');
        });
    }
}
