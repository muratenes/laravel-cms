<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunSubAttributeDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_sub_attribute_descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sub_attribute_id')->index();
            $table->unsignedSmallInteger('lang');
            $table->string('title')->nullable();

            $table->foreign('sub_attribute_id')->references('id')->on('urun_sub_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urun_sub_attribute_descriptions');
    }
}
