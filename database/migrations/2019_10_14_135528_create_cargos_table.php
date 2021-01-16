<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $turkey = \App\Models\Region\Country::where('title', 'Turkey')->first();

        Schema::create('cargos', function (Blueprint $table) use ($turkey) {
            $table->smallIncrements('id');
            $table->string('title');
            $table->unsignedSmallInteger('country_id')->default($turkey ? $turkey->id : null);
            $table->string('cargo_tracking_url')->nullable();
            $table->unsignedFloat('cargo_free_amount')->nullable(); // belirli tutardan sonra ücretsiz

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargos');
    }
}
