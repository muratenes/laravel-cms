<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIyzicoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('iyzico', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('siparis_id')->unsigned()->unique();
            $table->string('conversationId', 20)->nullable();
            $table->string('price', 15)->nullable();
            $table->string('paidPrice', 15)->nullable();
            $table->string('installment', 5)->nullable();
            $table->string('paymentId', 15)->nullable();
            $table->string('basketId', 15)->nullable();
            $table->string('status', 50)->nullable();
            $table->text('iyzicoJson')->nullable();

            $table->foreign('siparis_id')->references('id')->on('siparisler')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('iyzico');
    }
}
