<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('basket_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('basket_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->unsignedSmallInteger('qty');
            $table->unsignedFloat('price', 8, 2);

            // sadece 1 ürün için olan kargo fiyatı
            $table->unsignedFloat('cargo_price', 8, 2)->default(0);

            $table->string('attributes_text', 100)->nullable();
            // kullanıcıya göstermek için kullanılan attribute text
            $table->string('attributes_text_lang', 100)->nullable();
            $table->string('status', 30);

            // iade edilen tutar
            $table->unsignedFloat('refunded_amount', 16, 8)->default(0);

            // iyzico response ürün çekilen iade edilebilir tutar
            $table->unsignedFloat('paid_price', 16, 8)->nullable();

            // iyzico payment transaction id
            $table->string('payment_transaction_id', 100)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('basket_id')->references('id')->on('baskets')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('basket_items');
    }
}
