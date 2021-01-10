<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTakimimizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('takimimiz', function (Blueprint $table) {
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('takimimiz');
    }
}
