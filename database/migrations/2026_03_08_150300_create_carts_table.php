<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // 'buy' or 'rent'
            $table->integer('quantity')->default(1);
            $table->timestamps();
            
            // A user can't have the same book twice in the same mode (buy/rent)
            $table->unique(['user_id', 'book_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
