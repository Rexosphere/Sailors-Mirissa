<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'alt_text',
        'badge',
        'icon',
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
