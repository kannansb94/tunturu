<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->integer('rental_duration_days')->default(7)->after('rental_price');
            $table->decimal('late_fee_per_day', 8, 2)->default(5.00)->after('rental_duration_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['rental_duration_days', 'late_fee_per_day']);
        });
    }
};
