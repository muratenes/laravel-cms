<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcerikYonetimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icerik_yonetim', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('image', 200)->nullable();
            $table->string('slug', 130);
            $table->string('spot', 255)->nullable();
            $table->unsignedInteger('parent')->nullable();
            $table->text('desc')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->unsignedSmallInteger('lang')->default(config('admin.default_language'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icerik_yonetim');
    }
}
