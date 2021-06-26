<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkalarTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('markalar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('slug', 70)->unique();
            $table->boolean('active')->default(1);
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('markalar');
    }
}
