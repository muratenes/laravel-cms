<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunAttributeDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_attribute_descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('attribute_id')->index();
            $table->unsignedSmallInteger('lang');
            $table->string('title')->nullable();

            $table->foreign('attribute_id')->references('id')->on('urun_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urun_attribute_descriptions');
    }
}
