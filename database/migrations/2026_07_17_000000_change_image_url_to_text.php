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
        // image_url was string(255); MySQL truncates/rejects long URLs (e.g. Google-hosted
        // image links), while SQLite silently allowed them. Widen to TEXT to match.
        Schema::table('experiences', function (Blueprint $table) {
            $table->text('image_url')->change();
        });

        Schema::table('map_points', function (Blueprint $table) {
            $table->text('image_url')->change();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->text('image_url')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->string('image_url')->change();
        });

        Schema::table('map_points', function (Blueprint $table) {
            $table->string('image_url')->change();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->string('image_url')->change();
        });
    }
};
