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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->float('amount');
            $table->string('description')->nullable();

            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('user_id');

            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->float('amount');
            $table->string('description')->nullable();

            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('user_id');

            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('vendor_id')->index();
            $table->float('per_price');
            $table->float('per_price_purchase');
            $table->unsignedSmallInteger('quantity');
            $table->unsignedInteger('user_id');
            $table->float('amount');
            $table->timestamp('due_date');
            $table->unsignedTinyInteger('type'); // TransactionType


            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedInteger('product_id')->nullable()->index();

            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('payments');
    }
};
