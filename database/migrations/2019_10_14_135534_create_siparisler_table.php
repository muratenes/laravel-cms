<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiparislerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siparisler', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sepet_id')->unsigned()->unique();

            // işlem yapılan para değerlerine göre
            $table->unsignedSmallInteger('currency_id')->default(\App\Models\Ayar::CURRENCY_TL);
            $table->unsignedFloat('order_price', 8, 2);
            $table->unsignedFloat('cargo_price', 8, 2);
            $table->unsignedFloat('coupon_price', 8, 2)->nullable();
            $table->unsignedFloat('order_total_price', 8, 2);

            // iade edilen tutar
            $table->unsignedFloat('refunded_amount', 8, 2)->default(0);

            // türk lirası karşılıkları
            $table->unsignedFloat('real_order_price', 8, 2)->nullable();
            $table->unsignedFloat('real_cargo_price', 8, 2)->nullable();
            $table->unsignedFloat('real_coupon_price', 8, 2)->nullable();
            $table->unsignedFloat('real_order_total_price', 8, 2)->nullable();

            // genel
            $table->unsignedSmallInteger('status')->default(\App\Models\SepetUrun::STATUS_ONAY_BEKLIYOR);
            $table->ipAddress('ip_adres')->nullable();
            $table->string('full_name', 80);
            $table->string('adres', 255);
            $table->string('fatura_adres', 255);
            $table->string('phone', 30);
            $table->boolean('is_payment')->default(0);
            $table->string('email', 40)->nullable();
            $table->string('order_note', 255)->nullable();
            $table->uuid('hash');
            $table->unsignedInteger('delivery_address_id');
            $table->unsignedInteger('invoice_address_id');


            $table->unsignedSmallInteger('installment_count')->default(1);

            // invoice columns
            $table->string('full_name_invoice', 40)->nullable();
            $table->string('phone_invoice', 20)->nullable();
            $table->string('email_invoice', 40)->nullable();

            // cargo columns
            $table->unsignedSmallInteger('cargo_id')->nullable();
            $table->string('cargo_code',100)->nullable();

            $table->json('snapshot')->nullable();


            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sepet_id')->references('id')->on('sepet')->onDelete('cascade');
            $table->foreign('delivery_address_id')->references('id')->on('kullanici_adres')->onDelete('cascade');
            $table->foreign('invoice_address_id')->references('id')->on('kullanici_adres')->onDelete('cascade');
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siparisler');
    }
}
