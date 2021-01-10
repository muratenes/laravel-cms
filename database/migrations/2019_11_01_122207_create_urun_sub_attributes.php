<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrunSubAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_sub_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_attribute')->unsigned();
            $table->string('title', 50);

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
        Schema::dropIfExists('urun_sub_attributes');
    }
}
