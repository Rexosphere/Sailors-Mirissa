<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experiences = [
            [
                'title' => 'Coconut Tree Hill',
                'description' => 'The iconic palm-fringed viewpoint.',
                'image_url' => '/images/galle.avif',
                'alt_text' => 'Coconut palms on a red dirt hill overlooking the ocean',
                'badge' => 'Top Spot',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" /></svg>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Secret Beach',
                'description' => 'A secluded paradise away from crowds.',
                'image_url' => '/images/photos/hero-background.avif',
                'alt_text' => 'Secluded beach cove with turquoise water and rocks',
                'badge' => 'Hidden Gem',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>',
                'sort_order' => 2,
            ],
            [
                'title' => 'Parrot Rock',
                'description' => 'Panoramic views of Mirissa Bay.',
                'image_url' => '/images/matara.avif',
                'alt_text' => 'Small rocky island accessible from the beach at low tide',
                'badge' => null,
                'icon' => null,
                'sort_order' => 3,
            ],
            [
                'title' => 'Mirissa Harbor',
                'description' => 'The heart of the local fishing industry.',
                'image_url' => '/images/road.avif',
                'alt_text' => 'Colorful fishing boats in a harbor',
                'badge' => null,
                'icon' => null,
                'sort_order' => 4,
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::create($experience);
        }
    }
}
