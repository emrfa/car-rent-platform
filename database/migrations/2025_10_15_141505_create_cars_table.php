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
         Schema::create('cars', function (Blueprint $table) {
             $table->id();
        $table->string('brand');
        $table->string('model');
        $table->integer('year');
        $table->string('license_plate')->unique();
        $table->decimal('price_per_day', 8, 2);
        
        // --- NEW COLUMNS ---
        $table->string('image')->nullable(); // We store the path to the image file
        $table->enum('fuel_type', ['gasoline', 'diesel', 'electric', 'hybrid']);
        $table->enum('body_type', ['sedan', 'suv', 'mpv', 'hatchback']);

        $table->string('status')->default('available');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
