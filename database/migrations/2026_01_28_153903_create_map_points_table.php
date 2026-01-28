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
        Schema::create('map_points', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('coords'); // Comma-separated coordinates
            $table->integer('center_x');
            $table->integer('center_y');
            $table->string('image_url');
            $table->text('description');
            $table->text('icon')->nullable(); // HTML/SVG for icon
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_points');
    }
};
