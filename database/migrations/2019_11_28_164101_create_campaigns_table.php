<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('image', 80)->nullable();
            $table->string('slug', 70)->unique();
            $table->string('spot', 250)->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('active')->default(1);
            $table->unsignedSmallInteger('discount_type');
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('min_price')->nullable();
            $table->unsignedSmallInteger('currency_id')->default(config('admin.default_currency'));
            $table->decimal('discount_amount', 8, 2);

            $table->unsignedSmallInteger('lang')->default(config('admin.default_language'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
