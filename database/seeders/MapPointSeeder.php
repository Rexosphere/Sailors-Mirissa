<?php

namespace Database\Seeders;

use App\Models\MapPoint;
use Illuminate\Database\Seeder;

class MapPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapPoints = [
            [
                'name' => 'Parrot Island',
                'coords' => '834,2339,1470,2155,1803,2247,1590,2339,1046,2403',
                'center_x' => 1350,
                'center_y' => 2300,
                'image_url' => '/images/photos/hero-background.avif',
                'description' => 'A small rocky island accessible by foot during low tide. Known for its colorful parrots and stunning sunset views.',
                'icon' => '<img src="/images/icons/hawaii/white-parrot.avif" class="w-full h-full object-contain" alt="Parrot">',
            ],
            [
                'name' => 'Saylors Mirissa',
                'coords' => '3293,1965,3562,1972,3541,2205,3279,2198',
                'center_x' => 3420,
                'center_y' => 2090,
                'image_url' => '/images/photos/360-panaroma.avif',
                'description' => 'Your home base in paradise. Perfectly located in the heart of Mirissa with easy access to all major attractions.',
                'icon' => '<img src="/images/icons/hawaii/white-hotel.avif" class="w-full h-full object-contain" alt="Hotel">',
            ],
            [
                'name' => 'Coconut Tree Hill',
                'coords' => '5767,4558,5710,4912,6530,5286,7300,6000,7979,6000,7979,4678,7519,4735,7032,4742,6191,4502',
                'center_x' => 6500,
                'center_y' => 4700,
                'image_url' => '/images/photos/hero-background.avif',
                'description' => 'Instagram-famous viewpoint with iconic coconut trees overlooking the ocean. Best visited at sunrise or sunset.',
                'icon' => '<img src="/images/icons/hawaii/white-coconut-tree.avif" class="w-full h-full object-contain" alt="Coconut Tree">',
            ],
            [
                'name' => 'Sandy Beach',
                'coords' => '1223,1760,2057,1852,2247,1958,2163,2177,1823,2226,1449,2141,827,2332,106,1795,530,1774',
                'center_x' => 1176,
                'center_y' => 2050,
                'image_url' => '/images/photos/hero-background.avif',
                'description' => 'A pristine stretch of golden sand perfect for sunbathing and swimming. One of Mirissa\'s most beautiful beaches with calm waters.',
                'icon' => '<img src="/images/icons/hawaii/white-sun.avif" class="w-full h-full object-contain" alt="Sun">',
            ],
            [
                'name' => 'Surf Beach',
                'coords' => '2052,2177,3187,2261,3392,2375,3371,2601,2466,2664,1753,2254',
                'center_x' => 2620,
                'center_y' => 2420,
                'image_url' => '/images/photos/hero-background.avif',
                'description' => 'Popular surf spot with consistent waves perfect for beginners and intermediate surfers. Surf lessons available.',
                'icon' => '<img src="/images/icons/hawaii/white-surfboard.avif" class="w-full h-full object-contain" alt="Surfboard">',
            ],
            [
                'name' => 'Turtle Beach',
                'coords' => '3367,2650,4155,2756,5428,3102,6170,3413,7011,3951,7265,4410,6876,4650,2580,2721',
                'center_x' => 4900,
                'center_y' => 3650,
                'image_url' => '/images/photos/hero-background.avif',
                'description' => 'Protected nesting ground for sea turtles. Visit during nesting season to witness baby turtles making their way to the ocean.',
                'icon' => '<img src="/images/icons/hawaii/white-turtle.avif" class="w-full h-full object-contain" alt="Turtle">',
            ],
        ];

        foreach ($mapPoints as $mapPoint) {
            MapPoint::create($mapPoint);
        }
    }
}
