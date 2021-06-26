<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunImages extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('urun_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product')->unsigned();
            $table->string('image', 100);

            $table->foreign('product')->references('id')->on('urunler')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('urun_images');
    }
}
