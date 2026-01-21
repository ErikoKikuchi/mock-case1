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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreignId('seller_user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('shipping_address_id')->nullable()->constrained()->restrictOnDelete();
            $table->enum('payment_method',['card','convenience']);
            $table->enum('status',['completed',' ']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
