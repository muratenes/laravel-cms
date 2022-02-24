<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('multi_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('lang');

            $table->unsignedBigInteger('languageable_id');
            $table->string('languageable_type', 100);

            $table->json('data')->comment('model json');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('multi_languages');
    }
}
