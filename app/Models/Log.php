<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Log extends Model
{
    protected $table = "log";
    protected $guarded = [];
    protected $perPage = 20;

    const TYPE_GENERAL = 1;
    const TYPE_SEND_MAIL = 2;
    const TYPE_WRONG_LOGIN = 3;
    const TYPE_CREATE_OBJECT = 4;
    const TYPE_UPDATE_OBJECT = 5;
    const TYPE_DELETE_OBJECT = 6;
    const TYPE_IYZICO = 7;
    const TYPE_IYZICO_INFO = 8;
    const TYPE_ORDER_UPDATE = 9;
    const TYPE_BASKET = 10;
    const TYPE_ORDER = 11;

    public static function listTypesWithId()
    {
        return [
            self::TYPE_GENERAL => [self::TYPE_GENERAL, 'Genel Hata'],
            self::TYPE_SEND_MAIL => [self::TYPE_SEND_MAIL, 'Mail Hatası'],
            self::TYPE_WRONG_LOGIN => [self::TYPE_WRONG_LOGIN, 'Hatalı Giriş'],
            self::TYPE_CREATE_OBJECT => [self::TYPE_CREATE_OBJECT, 'Nesne Oluşturma Hatası'],
            self::TYPE_UPDATE_OBJECT => [self::TYPE_UPDATE_OBJECT, 'Nesne Güncelleme Hatası'],
            self::TYPE_DELETE_OBJECT => [self::TYPE_DELETE_OBJECT, 'Nesne Silme Hatası'],
            self::TYPE_IYZICO => [self::TYPE_IYZICO, 'İyzico Hatası'],
            self::TYPE_IYZICO_INFO => [self::TYPE_IYZICO, 'İyzico Log'],
            self::TYPE_BASKET => [self::TYPE_BASKET, 'Basket Log'],
            self::TYPE_ORDER => [self::TYPE_ORDER, 'Order Log'],
            self::TYPE_ORDER_UPDATE => [self::TYPE_IYZICO, 'Sipariş Güncellendi'],
        ];
    }

    public static function typeLabelStatic($param = self::TYPE_GENERAL)
    {
        $list = self::listTypesWithId();
        return @$list[$param][1];
    }

    public function getLabelAttribute()
    {
        return isset(self::listTypesWithId()[$this->type]) ? self::listTypesWithId()[$this->type][1] : '-';
    }


    public static function addLog($message, $exception, $type = Log::TYPE_GENERAL, $code = null, $url = null, $user_id = null)
    {
        Log::create([
            'type' => $type,
            'message' => substr($message, 0, 250),
            'exception' => substr((string)$exception, 0, 65000),
            'user_id' => $user_id == null ? Auth::user() ? Auth::user()->id : 0 : $user_id,
            'code' => $code == null ? Str::random(16) : $code,
            'url' => $url == null ? substr(request()->fullUrl(), 0, 150) : substr($url, 0, 150)
        ]);
    }

    /**
     * @param string|null $message iyzico ile ilgili içerik
     * @param string|null $exception data veya hata string olabilir
     * @param null $relatedID sepet id veya order id olabilir
     * @param int $type related id sepet id ise TYPE_BASKET değilse ilgili log gönderilmelidir
     * @param null $userID
     */
    public static function addIyzicoLog($message = null, $exception = null, $relatedID = null, $type = self::TYPE_BASKET, $userID = null)
    {
        try {
            Log::create([
                'type' => $type,
                'message' => $message ? substr($message, 0, 250) : null,
                'exception' => $exception ? substr((string)$exception, 0, 65000) : $exception,
                'user_id' => $userID == null ? Auth::user() ? Auth::user()->id : 0 : $userID,
                'code' => $relatedID,
                'url' => substr(request()->fullUrl(), 0, 150)
            ]);
        } catch (\Exception $exception) {

        }
    }

}
