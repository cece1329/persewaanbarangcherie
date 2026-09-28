<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('rental_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('dress_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days')->default(1);
            $table->decimal('rental_price', 12, 2);
            $table->decimal('deposit_fee', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->string('status')->default('pending_payment'); // pending_payment, paid, shipping, in_use, returned, completed, cancelled
            $table->string('payment_method')->default('qris'); // qris, bca, mandiri, shopee_pay
            $table->string('payment_proof')->nullable();
            $table->string('shipping_method')->default('delivery'); // delivery, pickup
            $table->text('shipping_address')->nullable();
            $table->text('notes')->nullable();
            $table->string('return_tracking_number')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
