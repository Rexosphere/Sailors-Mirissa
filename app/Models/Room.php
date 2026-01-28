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
        'room_number',
        'room_name',
        'price',
        'description',
        'image_url',
        'order',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('order', 'asc');
        });
    }
}
