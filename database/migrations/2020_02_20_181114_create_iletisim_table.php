<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIletisimTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('iletisim', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('subject', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('message', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('iletisim');
    }
}
