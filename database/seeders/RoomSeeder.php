<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            // Ground Floor
            [
                'floor_id' => 'ground',
                'floor_name' => 'Ground Floor',
                'floor_view' => 'Garden View',
                'floor_coords' => '1282,913,1983,913,1983,1054,1282,1054',
                'room_number' => 101,
                'room_name' => 'Room 101',
                'price' => '$120 [Mock]',
                'description' => 'Experience the serenity of our garden view rooms. Direct access to our lush tropical gardens.',
                'image_url' => '/images/rooms/ground_floor_1.png',
                'order' => 1,
            ],
            [
                'floor_id' => 'ground',
                'floor_name' => 'Ground Floor',
                'floor_view' => 'Garden View',
                'floor_coords' => '1282,913,1983,913,1983,1054,1282,1054',
                'room_number' => 102,
                'room_name' => 'Room 102',
                'price' => '$120 [Mock]',
                'description' => 'A spacious haven with detailed amenities and a private patio opening to the garden.',
                'image_url' => '/images/rooms/ground_floor_2.png',
                'order' => 2,
            ],
            [
                'floor_id' => 'ground',
                'floor_name' => 'Ground Floor',
                'floor_view' => 'Garden View',
                'floor_coords' => '1282,913,1983,913,1983,1054,1282,1054',
                'room_number' => 103,
                'room_name' => 'Room 103',
                'price' => '$125 [Mock]',
                'description' => 'Perfect for families, this room offers extra space and easy access to the pooling area.',
                'image_url' => '/images/rooms/ground_floor_1.png',
                'order' => 3,
            ],
            [
                'floor_id' => 'ground',
                'floor_name' => 'Ground Floor',
                'floor_view' => 'Garden View',
                'floor_coords' => '1282,913,1983,913,1983,1054,1282,1054',
                'room_number' => 104,
                'room_name' => 'Room 104',
                'price' => '$125 [Mock]',
                'description' => 'Enjoy the quiet corner of the ground floor with premium bedding and garden vistas.',
                'image_url' => '/images/rooms/ground_floor_2.png',
                'order' => 4,
            ],
            
            // First Floor
            [
                'floor_id' => 'first',
                'floor_name' => 'First Floor',
                'floor_view' => 'Partial Ocean View',
                'floor_coords' => '1278,778,1980,778,1980,912,1278,912',
                'room_number' => 201,
                'room_name' => 'Room 201',
                'price' => '$150 [Mock]',
                'description' => 'Elevated views of the coastline mixed with garden greenery. A balanced retreat.',
                'image_url' => '/images/rooms/first_floor_1.png',
                'order' => 5,
            ],
            [
                'floor_id' => 'first',
                'floor_name' => 'First Floor',
                'floor_view' => 'Partial Ocean View',
                'floor_coords' => '1278,778,1980,778,1980,912,1278,912',
                'room_number' => 202,
                'room_name' => 'Room 202',
                'price' => '$150 [Mock]',
                'description' => 'Modern interiors meet tropical breeze. Features a private balcony for morning coffee.',
                'image_url' => '/images/rooms/first_floor_2.png',
                'order' => 6,
            ],
            [
                'floor_id' => 'first',
                'floor_name' => 'First Floor',
                'floor_view' => 'Partial Ocean View',
                'floor_coords' => '1278,778,1980,778,1980,912,1278,912',
                'room_number' => 203,
                'room_name' => 'Room 203',
                'price' => '$155 [Mock]',
                'description' => 'Spacious double room with partial sea views and enhanced privacy.',
                'image_url' => '/images/rooms/first_floor_1.png',
                'order' => 7,
            ],
            [
                'floor_id' => 'first',
                'floor_name' => 'First Floor',
                'floor_view' => 'Partial Ocean View',
                'floor_coords' => '1278,778,1980,778,1980,912,1278,912',
                'room_number' => 204,
                'room_name' => 'Room 204',
                'price' => '$155 [Mock]',
                'description' => 'Our most popular partial view room, featuring a large balcony and king-sized bed.',
                'image_url' => '/images/rooms/first_floor_2.png',
                'order' => 8,
            ],
            
            // Second Floor
            [
                'floor_id' => 'second',
                'floor_name' => 'Second Floor',
                'floor_view' => 'Ocean View',
                'floor_coords' => '1278,654,1984,654,1984,776,1278,776',
                'room_number' => 301,
                'room_name' => 'Room 301',
                'price' => '$180 [Mock]',
                'description' => 'Unobstructed ocean views from the second floor. Listen to the waves from your room.',
                'image_url' => '/images/rooms/first_floor_1.png',
                'order' => 9,
            ],
            [
                'floor_id' => 'second',
                'floor_name' => 'Second Floor',
                'floor_view' => 'Ocean View',
                'floor_coords' => '1278,654,1984,654,1984,776,1278,776',
                'room_number' => 302,
                'room_name' => 'Room 302',
                'price' => '$180 [Mock]',
                'description' => 'Luxury living with a full sea view balcony. Perfect for couples.',
                'image_url' => '/images/rooms/first_floor_2.png',
                'order' => 10,
            ],
            [
                'floor_id' => 'second',
                'floor_name' => 'Second Floor',
                'floor_view' => 'Ocean View',
                'floor_coords' => '1278,654,1984,654,1984,776,1278,776',
                'room_number' => 303,
                'room_name' => 'Room 303',
                'price' => '$185 [Mock]',
                'description' => 'Corner room offering dual-aspect views of the ocean and the town.',
                'image_url' => '/images/rooms/first_floor_1.png',
                'order' => 11,
            ],
            [
                'floor_id' => 'second',
                'floor_name' => 'Second Floor',
                'floor_view' => 'Ocean View',
                'floor_coords' => '1278,654,1984,654,1984,776,1278,776',
                'room_number' => 304,
                'room_name' => 'Room 304',
                'price' => '$185 [Mock]',
                'description' => 'Premium ocean view room with upgraded amenities and spacious bath.',
                'image_url' => '/images/rooms/first_floor_2.png',
                'order' => 12,
            ],
            
            // Third Floor
            [
                'floor_id' => 'third',
                'floor_name' => 'Third Floor',
                'floor_view' => 'Panoramic Ocean View',
                'floor_coords' => '1282,528,1986,528,1986,654,1282,654',
                'room_number' => 401,
                'room_name' => 'Room 401',
                'price' => '$220 [Mock]',
                'description' => 'Top of the world. Our penthouse level offers breathtaking panoramic views.',
                'image_url' => '/images/rooms/top_floor_1.png',
                'order' => 13,
            ],
            [
                'floor_id' => 'third',
                'floor_name' => 'Third Floor',
                'floor_view' => 'Panoramic Ocean View',
                'floor_coords' => '1282,528,1986,528,1986,654,1282,654',
                'room_number' => 402,
                'room_name' => 'Room 402',
                'price' => '$220 [Mock]',
                'description' => 'Exclusive access and privacy. The ultimate luxury experience at Saylors.',
                'image_url' => '/images/rooms/top_floor_1.png',
                'order' => 14,
            ],
            [
                'floor_id' => 'third',
                'floor_name' => 'Third Floor',
                'floor_view' => 'Panoramic Ocean View',
                'floor_coords' => '1282,528,1986,528,1986,654,1282,654',
                'room_number' => 403,
                'room_name' => 'Room 403',
                'price' => '$230 [Mock]',
                'description' => 'Master suite with expansive living area and the best sunset views.',
                'image_url' => '/images/rooms/top_floor_1.png',
                'order' => 15,
            ],
            [
                'floor_id' => 'third',
                'floor_name' => 'Third Floor',
                'floor_view' => 'Panoramic Ocean View',
                'floor_coords' => '1282,528,1986,528,1986,654,1282,654',
                'room_number' => 404,
                'room_name' => 'Room 404',
                'price' => '$230 [Mock]',
                'description' => 'The Royal Suite. Unmatched luxury, space, and panoramic Indian Ocean vistas.',
                'image_url' => '/images/rooms/top_floor_1.png',
                'order' => 16,
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
