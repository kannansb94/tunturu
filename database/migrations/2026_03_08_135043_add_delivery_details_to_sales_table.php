<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('delivery_name')->nullable()->after('delivery_status');
            $table->string('delivery_phone')->nullable()->after('delivery_name');
            $table->text('delivery_address')->nullable()->after('delivery_phone');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['delivery_name', 'delivery_phone', 'delivery_address']);
        });
    }
};
