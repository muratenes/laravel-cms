<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referanslar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('desc', 255)->nullable();
            $table->string('slug', 130);
            $table->string('image', 100)->nullable();
            $table->boolean('active')->default(true);
            $table->string('link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('references');
    }
}
