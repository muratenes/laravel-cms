<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorizablesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('categorizables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('categorizable_id');
            $table->string('categorizable_type', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('categorizables');
    }
}
