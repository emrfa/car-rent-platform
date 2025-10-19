<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create the new table for storing multiple images per car
        Schema::create('car_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->timestamps();
        });

        // Remove the old 'image' column from the main cars table
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    public function down(): void
    {
        // Define the reverse operations for rollback
        Schema::dropIfExists('car_images');

        Schema::table('cars', function (Blueprint $table) {
            $table->string('image')->nullable()->after('price_per_day');
        });
    }
};