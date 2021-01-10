<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrunDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product')->unsigned();
            $table->integer('parent_attribute')->unsigned();

            $table->foreign('product')->references('id')->on('urunler')->onDelete('cascade');
            $table->foreign('parent_attribute')->references('id')->on('urun_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urun_detail');
    }
}
