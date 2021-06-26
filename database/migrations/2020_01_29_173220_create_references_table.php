<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
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
     */
    public function down()
    {
        Schema::dropIfExists('references');
    }
}
