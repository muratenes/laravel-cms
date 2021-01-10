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

        Schema::create('kampanya_markalar', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('company_id');

            $table->foreign('campaign_id')->references('id')->on('kampanyalar')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('firmalar')->onDelete('cascade');
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
        Schema::dropIfExists('kampanya_markalar');
    }
}
