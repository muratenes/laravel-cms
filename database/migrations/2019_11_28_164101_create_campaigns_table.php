<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kampanyalar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('image', 80)->nullable();
            $table->string('slug', 70)->unique();
            $table->string('spot', 250)->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('active')->default(1);
            $table->unsignedSmallInteger('discount_type');
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('min_price')->nullable();
            $table->unsignedSmallInteger('currency_id')->default(config('admin.default_currency'));
            $table->decimal('discount_amount', 8, 2);

            $table->unsignedSmallInteger('lang')->default(config('admin.default_language'));

        });

        Schema::create('kampanya_urunler', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('product_id');

            $table->foreign('campaign_id')->references('id')->on('kampanyalar')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('urunler')->onDelete('cascade');
        });

        Schema::create('kampanya_kategoriler', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('category_id');

            $table->foreign('campaign_id')->references('id')->on('kampanyalar')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('kategoriler')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kampanyalar');
        Schema::dropIfExists('kampanya_urunler');
        Schema::dropIfExists('kampanya_kategoriler');
    }
}
