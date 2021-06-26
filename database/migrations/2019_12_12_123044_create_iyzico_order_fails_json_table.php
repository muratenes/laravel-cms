<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIyzicoOrderFailsJsonTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('iyzico_order_fails_json', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('full_name', 100);
            $table->integer('basket_id');
            $table->text('json_response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('iyzico_order_fails_json');
    }
}
