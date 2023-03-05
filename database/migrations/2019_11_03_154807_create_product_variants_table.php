<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price', 8, 2);
            $table->unsignedInteger('qty');
            $table->integer('product_id', false, true);

            $table->unsignedSmallInteger('currency')->default(config('admin.default_currency'));

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('product_variant_sub_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variant_id')->unsigned();
            $table->integer('sub_attr_id')->unsigned();

            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('sub_attr_id')->references('id')->on('product_sub_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_variant_sub_attributes');
    }
}
