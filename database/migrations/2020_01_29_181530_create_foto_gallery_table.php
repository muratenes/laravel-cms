<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('image', 200)->nullable();
            $table->string('slug', 130);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('gallery_id');
            $table->string('image');

            $table->foreign('gallery_id')->references('id')->on('gallery')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gallery');
        Schema::dropIfExists('gallery_images');
    }
}
