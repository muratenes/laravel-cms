<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAyarlarTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ayarlar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->nullable();
            $table->string('desc', 500)->nullable();
            $table->string('domain', 50)->nullable()->default('http://127.0.0.1:8000');
            $table->string('logo', 255)->nullable();
            $table->string('footer_logo', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('keywords', 255)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->string('footer_text', 250)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('mail', 50)->nullable();
            $table->string('adres', 255)->nullable();
            $table->boolean('active')->default(1);
            $table->text('about')->nullable();
            $table->float('cargo_price', 8, 2)->default(10);

            //site owner
            $table->string('full_name', 100)->nullable();
            $table->string('company_address', 250)->nullable();
            $table->string('company_phone', 50)->nullable();
            $table->string('fax', 255)->nullable();

            $table->unsignedSmallInteger('lang')->unique()->default(\App\Models\Ayar::LANG_TR);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ayarlar');
    }
}
