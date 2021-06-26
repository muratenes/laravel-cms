<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityTownDistrictTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // ülkeler ex:Turkey,Germany
        Schema::create('countries', function (Blueprint $table) {
            $table->smallIncrements('id')->index();
            $table->string('title', 100);
            $table->string('code', 4);
            $table->boolean('active')->default(1);
        });

        // şehirler ex:Istanbul,Saxony
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->boolean('active')->default(1);
            $table->unsignedSmallInteger('country_id');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        //İlçe : ex:Kadıköy,Bautzen
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->string('title', 100);

            $table->unsignedInteger('state_id');

            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Mahalle : Kozyatağı,Bernsdorf
        Schema::create('neighborhoods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->boolean('active')->default(1);

            $table->unsignedInteger('district_id');

            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('neighborhoods');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
    }
}
