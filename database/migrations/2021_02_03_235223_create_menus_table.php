<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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

        Schema::create('menus_descriptions', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('menu_id');
            $table->string('title', 40);
            $table->string('href', 255)->nullable();

            $table->foreign('menu_id')->references('id')->on('menus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus_descriptions');
        Schema::dropIfExists('menus');
    }
}
