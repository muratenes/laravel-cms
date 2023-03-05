<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSubAttributes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_sub_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_attribute')->unsigned();
            $table->string('title', 50);

            $table->foreign('parent_attribute')->references('id')->on('product_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('product_sub_attributes');
    }
}
