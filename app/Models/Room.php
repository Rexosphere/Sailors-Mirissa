<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    protected $fillable = [
        'floor_id',
        'room_number',
        'room_name',
        'price',
        'description',
        'image_url',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'room_number' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('room_number');
    }
}
