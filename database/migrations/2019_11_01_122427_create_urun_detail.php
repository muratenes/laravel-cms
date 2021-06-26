<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunDetail extends Migration
{
    /**
     * Run the migrations.
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
     */
    public function down()
    {
        Schema::dropIfExists('urun_detail');
    }
}
