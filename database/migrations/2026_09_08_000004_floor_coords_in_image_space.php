<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Floor outlines as percentages of building_transparent.png (x,y pairs),
     * so they stay aligned however the illustration is sized on screen.
     */
    public const BANDS = [
        'third' => '9,32.7,93,32.7,93,47.6,9,47.6',
        'second' => '9,47.6,93,47.6,93,61.7,9,61.7',
        'first' => '9,61.7,93,61.7,93,76.4,9,76.4',
        'ground' => '9,76.4,93,76.4,93,88.4,9,88.4',
    ];

    public function up(): void
    {
        foreach (self::BANDS as $slug => $coords) {
            DB::table('floors')->where('slug', $slug)->update(['coords' => $coords]);
        }

        DB::table('floors')->whereNotIn('slug', array_keys(self::BANDS))->update(['coords' => '']);
    }

    public function down(): void
    {
        // Previous coordinates were tied to a fixed container size and are not recoverable.
    }
};
