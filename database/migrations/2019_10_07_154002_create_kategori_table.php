<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kategoriler', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('slug', 70)->unique();
            $table->string('spot', 255)->nullable();
            $table->string('icon', 25)->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedSmallInteger('row')->nullable();
            $table->integer('parent_category_id')->nullable();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('kategoriler');
    }
}
