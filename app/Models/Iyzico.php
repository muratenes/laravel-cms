<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iyzico extends Model
{
    public $timestamps = false;
    protected $table = 'iyzico';
    protected $fillable = ['siparis_id', 'transaction_id', 'price', 'paidPrice', 'installment', 'paymentId', 'basketId', 'status', 'iyzicoJson'];

    protected $casts = [
        'iyzicoJson' => 'array',
    ];

    public static function getMdStatusByParam($param)
    {
        $list = self::mdStatusList();

        return $list[$param] ?? 'hata oluştu';
    }

    public static function getOptions()
    {
        $options = new \Iyzipay\Options();
        $options->setApiKey(config('admin.iyzico.api_key'));
        $options->setSecretKey(config('admin.iyzico.api_secret'));
        $options->setBaseUrl(config('admin.iyzico.base_url'));

        return $options;
    }

    public static function mdStatusList()
    {
        return [
            0 => '3-D Secure imzası geçersiz veya doğrulama',
            2 => 'Kart sahibi veya bankası sisteme kayıtlı değil',
            3 => 'Kartın bankası sisteme kayıtlı değil',
            4 => 'Doğrulama denemesi, kart sahibi sisteme daha sonra kayıt olmayı seçmiş',
            5 => 'Doğrulama yapılamıyor',
            6 => '3-D Secure hatası',
            7 => 'Sistem Hatası',
            8 => 'Bilinmeyen kart no',
        ];
    }

    protected function siparis()
    {
        return $this->belongsTo(Siparis::class, 'siparis_id', 'id');
    }
}
