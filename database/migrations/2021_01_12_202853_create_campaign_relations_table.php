<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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

        Schema::create('kampanya_markalar', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('company_id');

            $table->foreign('campaign_id')->references('id')->on('kampanyalar')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('firmalar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kampanya_urunler');
        Schema::dropIfExists('kampanya_kategoriler');
        Schema::dropIfExists('kampanya_markalar');
    }
}
