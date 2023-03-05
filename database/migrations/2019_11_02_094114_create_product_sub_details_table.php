<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_sub_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_detail');
            $table->unsignedInteger('sub_attribute');

            $table->foreign('parent_detail')->references('id')->on('product_details')->onDelete('cascade');
            $table->foreign('sub_attribute')->references('id')->on('product_sub_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('product_sub_details');
    }
}
