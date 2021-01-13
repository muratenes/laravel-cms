<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmalar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('slug', 60)->unique();
            $table->string('email', 50)->unique();
            $table->string('address', 250)->nullable();
            $table->string('phone', 30);
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('firmalar');
    }
}
