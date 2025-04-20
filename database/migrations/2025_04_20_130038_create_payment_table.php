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
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('product_id');
            $table->float('per_price');
            $table->unsignedSmallInteger('quantity');
            $table->unsignedInteger('user_id');
            $table->float('amount');
            $table->enum('type', [1, 2]); // TransactionType

            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');

            $table->float('amount');
            $table->string('description')->nullable();

            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('user_id');

            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('user_id')->references('id')->on('users');
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
