<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Floor extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'view',
        'coords',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class)->ordered();
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Outline points as percentages of the building illustration (x,y pairs), or [] when unset.
     *
     * @return list<float>
     */
    public function coordinates(): array
    {
        if (trim((string) $this->coords) === '') {
            return [];
        }

        return array_map('floatval', explode(',', $this->coords));
    }

    /**
     * Bounding box of the outline as percentages: [x, y, width, height], or null when unset.
     *
     * @return array{x: float, y: float, w: float, h: float}|null
     */
    public function band(): ?array
    {
        $points = $this->coordinates();
        if (count($points) < 4) {
            return null;
        }

        $xs = [];
        $ys = [];
        foreach (array_chunk($points, 2) as [$x, $y]) {
            $xs[] = $x;
            $ys[] = $y;
        }

        return [
            'x' => round(min($xs), 2),
            'y' => round(min($ys), 2),
            'w' => round(max($xs) - min($xs), 2),
            'h' => round(max($ys) - min($ys), 2),
        ];
    }
}
