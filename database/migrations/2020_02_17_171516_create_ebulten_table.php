<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbultenTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ebulten', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 150);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ebulten');
    }
}
