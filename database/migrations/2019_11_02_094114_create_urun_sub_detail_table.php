<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunSubDetailTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('urun_sub_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_detail');
            $table->unsignedInteger('sub_attribute');

            $table->foreign('parent_detail')->references('id')->on('urun_detail')->onDelete('cascade');
            $table->foreign('sub_attribute')->references('id')->on('urun_sub_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('urun_sub_detail');
    }
}
