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
            Schema::table('bookings', function (Blueprint $table) {
            // Add the insurance type column after total_price
            $table->string('insurance_type')->nullable()->after('total_price');
            // Add the insurance cost column after insurance_type
            $table->bigInteger('insurance_cost')->default(0)->after('insurance_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('bookings', function (Blueprint $table) {
            // Drop columns if migration is rolled back
            $table->dropColumn(['insurance_type', 'insurance_cost']);
        });
    }
};
