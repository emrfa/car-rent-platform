<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Make sure this class name matches your file name
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Foreign key for the user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Foreign key for the car
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            
            $table->date('start_date');
            $table->date('end_date');
            
            // Storing price in the smallest currency unit (e.g., full Rupiah)
            // is safer than using decimals.
            $table->bigInteger('total_price');
            
            // Status for the booking (e.g., pending, confirmed, cancelled)
            $table->string('status')->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};