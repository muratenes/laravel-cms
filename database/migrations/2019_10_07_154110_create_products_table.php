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
            $table->string('title', 200);
            $table->string('slug', 230);
            $table->text('desc')->nullable();
            $table->boolean('active')->default(1);
            $table->string('image', 100)->nullable();
            $table->json('tags')->nullable();
            $table->unsignedSmallInteger('qty')->default(1);

            // Fiyat bilgileri
            $table->float('tl_price', 8, 2)->unsigned()->nullable();
            $table->float('tl_discount_price', 8, 2)->unsigned()->nullable();

            $table->float('usd_price', 8, 2)->unsigned()->nullable();
            $table->float('usd_discount_price', 8, 2)->unsigned()->nullable();

            $table->float('eur_price', 8, 2)->unsigned()->nullable();
            $table->float('eur_discount_price', 8, 2)->unsigned()->nullable();

            // Other columns

            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->decimal('buying_price', 8, 2)->nullable();
            $table->string('spot', 255)->nullable();
            $table->string('code', 50)->nullable();
            $table->json('properties')->nullable();

            // Multiple category
            if (! config('admin.product.multiple_category')) {
                $table->unsignedInteger('parent_category_id')->nullable();
                $table->unsignedInteger('sub_category_id')->nullable();

                $table->foreign('parent_category_id')->references('id')->on('kategoriler');
                $table->foreign('sub_category_id')->references('id')->on('kategoriler');
            }

            // CARGO PRICE

            $table->float('cargo_price', 8, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('product_companies')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('product_brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
