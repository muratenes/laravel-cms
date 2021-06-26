<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_category')->nullable();
            $table->string('title', 50);
            $table->string('slug', 70)->unique();
            $table->boolean('active')->default(true);
            $table->unsignedSmallInteger('row')->nullable();
            $table->string('spot', 255)->nullable();
            $table->string('icon', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('blog_categories');
    }
}
