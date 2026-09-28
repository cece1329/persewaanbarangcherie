<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('rental_price_per_day', 12, 2);
            $table->decimal('deposit_fee', 12, 2);
            $table->string('size')->default('M'); // XS, S, M, L, XL, Free Size
            $table->string('color')->nullable();
            $table->string('chest_size')->nullable();
            $table->string('waist_size')->nullable();
            $table->string('length')->nullable();
            $table->string('fabric')->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->integer('stock')->default(1);
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->string('status')->default('available'); // available, rented, maintenance
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dresses');
    }
};
