<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Add new fields
            $table->string('room_type')->default('double')->after('floor_coords');
            $table->json('images')->nullable()->after('image_url');
            $table->json('facilities')->nullable()->after('description');
        });

        // Migrate existing image_url to images array
        DB::table('rooms')->get()->each(function ($room) {
            if ($room->image_url) {
                DB::table('rooms')
                    ->where('id', $room->id)
                    ->update(['images' => json_encode([$room->image_url])]);
            }
        });

        // Consolidate duplicate floor_id + room_type combinations
        $rooms = DB::table('rooms')->get();
        $grouped = [];
        
        foreach ($rooms as $room) {
            $key = $room->floor_id . '_' . $room->room_type;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'id' => $room->id,
                    'images' => json_decode($room->images, true) ?? [],
                ];
            } else {
                // Merge images from duplicate entries
                $existingImages = json_decode($room->images, true) ?? [];
                $grouped[$key]['images'] = array_merge($grouped[$key]['images'], $existingImages);
                
                // Delete the duplicate
                DB::table('rooms')->where('id', $room->id)->delete();
            }
        }
        
        // Update remaining records with merged images
        foreach ($grouped as $data) {
            DB::table('rooms')
                ->where('id', $data['id'])
                ->update(['images' => json_encode(array_values(array_unique($data['images'])))]);
        }

        Schema::table('rooms', function (Blueprint $table) {
            // Keep `room_number` and `room_name` for compatibility with existing seeders and views.
            // NOTE: Do not add a unique constraint on floor_id + room_type because multiple rooms
            // can share the same type on the same floor.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Re-add room_number and room_name columns
            $table->integer('room_number')->after('floor_coords');
            $table->string('room_name')->after('room_number');
            
            // Drop new fields
            $table->dropColumn(['room_type', 'images', 'facilities']);
        });
    }
};
