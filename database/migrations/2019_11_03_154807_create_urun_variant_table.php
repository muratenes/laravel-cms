<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrunVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price', 8, 2);
            $table->unsignedInteger('qty');
            $table->integer('product_id', false, true);

            $table->unsignedSmallInteger('currency')->default(config('admin.default_currency'));

            $table->foreign('product_id')->references('id')->on('urunler')->onDelete('cascade');
        });

        Schema::create('urun_variant_sub_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variant_id')->unsigned();
            $table->integer('sub_attr_id')->unsigned();

            $table->foreign('variant_id')->references('id')->on('urun_variants')->onDelete('cascade');
            $table->foreign('sub_attr_id')->references('id')->on('urun_sub_attributes')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urun_variants');
        Schema::dropIfExists('urun_variant_sub_attributes');

    }
}
