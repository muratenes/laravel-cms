<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('title', 40);
            $table->string('href', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedTinyInteger('order')->nullable();
            $table->unsignedSmallInteger('parent_id')->nullable();
            $table->string('module', 20)->nullable();

            $table->foreign('parent_id')->references('id')->on('menus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
