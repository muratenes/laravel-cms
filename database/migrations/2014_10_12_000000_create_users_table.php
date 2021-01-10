<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->string('email')->unique();
            $table->string('surname', 30)->nullable();
            $table->string('password', 60)->nullable();

            $table->string('activation_code', 60)->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_admin')->default(0);
            $table->string('token', 200)->nullable();

            $table->unsignedInteger('role_id')->index()->nullable();

            $table->integer('default_address_id')->nullable();
            $table->integer('default_invoice_address_id')->nullable();
            $table->string('phone', 15)->nullable();


            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->string('locale', 10)->default('tr');

            $table->foreign('role_id')->references('id')->on('roles');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
