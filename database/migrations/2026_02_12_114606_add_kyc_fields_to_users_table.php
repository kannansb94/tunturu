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
        Schema::table('users', function (Blueprint $table) {
            $table->string('kyc_status')->default('pending')->after('address'); // pending, approved, rejected
            $table->string('aadhaar_path')->nullable()->after('kyc_status');
            $table->string('pan_path')->nullable()->after('aadhaar_path');
            $table->string('address_proof_path')->nullable()->after('pan_path');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'kyc_status',
                'aadhaar_path',
                'pan_path',
                'address_proof_path',
                'phone_verified_at'
            ]);
        });
    }
};
