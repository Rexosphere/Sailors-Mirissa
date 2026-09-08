<?php

namespace Database\Seeders;

use App\Models\Floor;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['ground', 101, 'Room 101', '$120 [Mock]', 'Experience the serenity of our garden view rooms. Direct access to our lush tropical gardens.', '/images/rooms/ground_floor_1.png'],
            ['ground', 102, 'Room 102', '$120 [Mock]', 'A spacious haven with detailed amenities and a private patio opening to the garden.', '/images/rooms/ground_floor_2.png'],
            ['ground', 103, 'Room 103', '$125 [Mock]', 'Perfect for families, this room offers extra space and easy access to the pooling area.', '/images/rooms/ground_floor_1.png'],
            ['ground', 104, 'Room 104', '$125 [Mock]', 'Enjoy the quiet corner of the ground floor with premium bedding and garden vistas.', '/images/rooms/ground_floor_2.png'],
            ['first', 201, 'Room 201', '$150 [Mock]', 'Elevated views of the coastline mixed with garden greenery. A balanced retreat.', '/images/rooms/first_floor_1.png'],
            ['first', 202, 'Room 202', '$150 [Mock]', 'Modern interiors meet tropical breeze. Features a private balcony for morning coffee.', '/images/rooms/first_floor_2.png'],
            ['first', 203, 'Room 203', '$155 [Mock]', 'Spacious double room with partial sea views and enhanced privacy.', '/images/rooms/first_floor_1.png'],
            ['first', 204, 'Room 204', '$155 [Mock]', 'Our most popular partial view room, featuring a large balcony and king-sized bed.', '/images/rooms/first_floor_2.png'],
            ['second', 301, 'Room 301', '$180 [Mock]', 'Unobstructed ocean views from the second floor. Listen to the waves from your room.', '/images/rooms/first_floor_1.png'],
            ['second', 302, 'Room 302', '$180 [Mock]', 'Luxury living with a full sea view balcony. Perfect for couples.', '/images/rooms/first_floor_2.png'],
            ['second', 303, 'Room 303', '$185 [Mock]', 'Corner room offering dual-aspect views of the ocean and the town.', '/images/rooms/first_floor_1.png'],
            ['second', 304, 'Room 304', '$185 [Mock]', 'Premium ocean view room with upgraded amenities and spacious bath.', '/images/rooms/first_floor_2.png'],
            ['third', 401, 'Room 401', '$220 [Mock]', 'Top of the world. Our penthouse level offers breathtaking panoramic views.', '/images/rooms/top_floor_1.png'],
            ['third', 402, 'Room 402', '$220 [Mock]', 'Exclusive access and privacy. The ultimate luxury experience at Sailors.', '/images/rooms/top_floor_1.png'],
            ['third', 403, 'Room 403', '$230 [Mock]', 'Master suite with expansive living area and the best sunset views.', '/images/rooms/top_floor_1.png'],
            ['third', 404, 'Room 404', '$230 [Mock]', 'The Royal Suite. Unmatched luxury, space, and panoramic Indian Ocean vistas.', '/images/rooms/top_floor_1.png'],
        ];

        $floorIds = Floor::pluck('id', 'slug');

        foreach ($rooms as $index => [$floorSlug, $number, $name, $price, $description, $image]) {
            Room::create([
                'floor_id' => $floorIds[$floorSlug],
                'room_number' => $number,
                'room_name' => $name,
                'price' => $price,
                'description' => $description,
                'image_url' => $image,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
