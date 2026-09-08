<?php

namespace Database\Seeders;

use App\Models\Floor;
use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
{
    public function run(): void
    {
        $floors = [
            ['slug' => 'ground', 'name' => 'Ground Floor', 'view' => 'Garden View', 'coords' => '9,76.4,93,76.4,93,88.4,9,88.4', 'sort_order' => 0],
            ['slug' => 'first', 'name' => 'First Floor', 'view' => 'Partial Ocean View', 'coords' => '9,61.7,93,61.7,93,76.4,9,76.4', 'sort_order' => 1],
            ['slug' => 'second', 'name' => 'Second Floor', 'view' => 'Ocean View', 'coords' => '9,47.6,93,47.6,93,61.7,9,61.7', 'sort_order' => 2],
            ['slug' => 'third', 'name' => 'Third Floor', 'view' => 'Panoramic Ocean View', 'coords' => '9,32.7,93,32.7,93,47.6,9,47.6', 'sort_order' => 3],
        ];

        foreach ($floors as $floor) {
            Floor::updateOrCreate(['slug' => $floor['slug']], $floor);
        }
    }
}
