<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('purchase_price')->unsigned();
            $table->float('price')->unsigned();
            $table->boolean('stock_follow')->default(true);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        Schema::create('vendor_products', function (Blueprint $table) {
            $table->increments('id');

            $table->float('price')->unsigned();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('vendor_id');
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}
