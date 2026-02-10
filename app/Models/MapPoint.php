<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapPoint extends Model
{
    protected $fillable = [
        'name',
        'coords',
        'center_x',
        'center_y',
        'image_url',
        'description',
        'icon',
    ];
}
