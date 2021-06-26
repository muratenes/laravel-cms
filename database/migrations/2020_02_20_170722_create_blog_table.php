<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->string('image', 255)->nullable();
            $table->string('slug', 255);
            $table->json('tags')->nullable();
            $table->text('desc')->nullable();
            $table->unsignedInteger('parent')->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedSmallInteger('lang')->default(config('admin.default_language'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('blog');
    }
}
