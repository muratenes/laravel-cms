<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('markalar');
    }
}
