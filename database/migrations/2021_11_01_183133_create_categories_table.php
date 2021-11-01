<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('slug', 120);
            $table->unsignedBigInteger('parent_category_id')->nullable();
            $table->string('categorizable_type', 100);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_category_id')->on('categories')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
