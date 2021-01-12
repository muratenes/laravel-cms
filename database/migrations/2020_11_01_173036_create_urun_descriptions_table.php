<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->nullable();
            $table->string('slug', 60)->nullable();
            $table->string('spot', 255)->nullable();
            $table->json('tags')->nullable();
            $table->json('properties')->nullable();
            $table->text('desc')->nullable();

            $table->unsignedSmallInteger('lang');

            // ücretsiz kargo için 0 girilmeli
            $table->unsignedFloat('cargo_price', 8, 2)->nullable();

            $table->unsignedInteger('product_id')->index();
            $table->foreign('product_id')->references('id')->on('urunler')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urun_descriptions');
    }
}
