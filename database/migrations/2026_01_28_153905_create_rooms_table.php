<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('floor_id'); // ground, first, second, third
            $table->string('floor_name'); // Ground Floor, First Floor, etc.
            $table->string('floor_view'); // Garden View, Ocean View, etc.
            $table->text('floor_coords'); // Comma-separated coordinates for floor polygon
            $table->integer('room_number');
            $table->string('room_name');
            $table->string('price');
            $table->text('description');
            $table->string('image_url');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
