<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->string('email', 100)->unique();
            $table->string('surname', 30)->nullable();
            $table->string('password', 150)->nullable();

            $table->string('activation_code', 60)->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('token', 200)->nullable();
            $table->text('about')->nullable();

            $table->unsignedInteger('role_id')->index()->nullable();

            $table->string('phone', 50)->nullable();
            $table->unsignedInteger('vendor_id')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
