<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunAttributes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('urun_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 30);
            $table->boolean('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('urun_attributes');
    }
}
