<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunYorumsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('urun_yorumlar', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('product_id');
            $table->boolean('active')->default(0);
            $table->boolean('is_read')->default(0);
            $table->string('message', 255);
            $table->unsignedTinyInteger('point')->default(5);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('urunler')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('urun_yorumlar');
    }
}
