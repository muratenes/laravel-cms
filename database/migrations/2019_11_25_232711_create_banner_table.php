<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('sub_title', 255)->nullable();
            $table->string('sub_title_2', 255)->nullable();
            $table->string('image', 100)->nullable();
            $table->string('link', 100)->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedSmallInteger('lang')->default(config('admin.default_language'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner');
    }
}
