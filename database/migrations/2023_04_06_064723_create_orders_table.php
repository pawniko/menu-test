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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('from_currency')->default(config('currency.default'));
            $table->unsignedBigInteger('purchased_currency_id');
            $table->decimal('currency_amount',14, 6);
            $table->decimal('exchange_rate', 14, 6);
            $table->decimal('surcharge_percent',5);
            $table->decimal('surcharge_amount', 14, 6);
            $table->integer('discount_percent')->nullable();
            $table->decimal('discount_amount', 14, 6)->nullable();
            $table->decimal('total_paid_amount', 14, 6);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('purchased_currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
