<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIyzicoOrderFailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('iyzico_order_fails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('status', 15);
            $table->string('errorCode', 50)->nullable();
            $table->string('errorMessage', 255)->nullable();
            $table->string('errorGroup', 50)->nullable();
            $table->string('conversationId', 20);
            $table->integer('basket_id');
            $table->string('full_name', 100);
            $table->decimal('order_price', 8, 2);
            $table->string('paymetId', 30)->nullable();
            $table->string('paymetTransactionId', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('iyzico_order_fails');
    }
}
