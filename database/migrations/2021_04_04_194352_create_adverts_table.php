<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('sub_title', 255)->nullable();
            $table->string('redirect_to', 255)->nullable();
            $table->string('redirect_to_label', 100)->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->string('type', 50);
            $table->unsignedTinyInteger('lang')->default(admin('default_language'));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adverts');
    }
}
