<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurTeamsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('our_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('position', 100)->nullable();
            $table->boolean('active')->default(true);
            $table->string('image', 250)->nullable();
            $table->text('desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('our_teams');
    }
}
