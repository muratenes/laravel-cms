<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->nullable();
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
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
