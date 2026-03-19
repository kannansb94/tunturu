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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('description')->nullable();
            $table->string('isbn')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('status')->default('available'); // available, rented, sold
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->decimal('rental_price', 10, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
