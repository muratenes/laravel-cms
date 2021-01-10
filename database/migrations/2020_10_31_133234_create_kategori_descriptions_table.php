<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->nullable();
            $table->string('spot', 255)->nullable();
            $table->unsignedSmallInteger('lang');

            $table->unsignedInteger('category_id')->nullable()->index();
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
        Schema::dropIfExists('kategori_descriptions');
    }
}
