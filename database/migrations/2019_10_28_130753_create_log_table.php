<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
//            $table->string('level', 15);
            $table->unsignedSmallInteger('type')->nullable();
            $table->string('message', 250)->nullable();
            $table->text('exception')->nullable();
            $table->string('code', 30)->nullable();
            $table->string('url', 150)->nullable();
            $table->string('exception_type', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('log');
    }
}
