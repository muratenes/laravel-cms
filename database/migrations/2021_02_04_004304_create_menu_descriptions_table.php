<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('menu_descriptions', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('title', 40)->nullable();
            $table->string('href', 255)->nullable();
            $table->unsignedTinyInteger('lang')->default(\App\Models\Ayar::LANG_TR);

//            $table->foreign('menu_id')->references('id')->on('menus');

            $table->unsignedSmallInteger('menu_id')->nullable()->index();
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('menu_descriptions');
    }
}
