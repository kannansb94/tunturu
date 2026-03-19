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
            $table->unsignedBigInteger('approved_by')->nullable()->after('donated_by');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->timestamp('rejected_at')->nullable()->after('approved_at');
            $table->string('donor_location')->nullable()->after('rejected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['approved_by', 'approved_at', 'rejected_at', 'donor_location']);
        });
    }
};
