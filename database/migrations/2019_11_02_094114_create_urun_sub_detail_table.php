<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrunSubDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urun_sub_detail');
    }
}
