<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Log extends Model
{
    public const TYPE_GENERAL = 1;
    public const TYPE_SEND_MAIL = 2;
    public const TYPE_WRONG_LOGIN = 3;
    public const TYPE_CREATE_OBJECT = 4;
    public const TYPE_UPDATE_OBJECT = 5;
    public const TYPE_DELETE_OBJECT = 6;
    public const TYPE_IYZICO = 7;
    public const TYPE_IYZICO_INFO = 8;
    public const TYPE_ORDER_UPDATE = 9;
    public const TYPE_BASKET = 10;
    public const TYPE_ORDER = 11;
    protected $table = 'log';
    protected $guarded = [];
    protected $perPage = 20;

    public static function listTypesWithId()
    {
        return [
            self::TYPE_GENERAL       => [self::TYPE_GENERAL, 'Genel Hata'],
            self::TYPE_SEND_MAIL     => [self::TYPE_SEND_MAIL, 'Mail Hatası'],
            self::TYPE_WRONG_LOGIN   => [self::TYPE_WRONG_LOGIN, 'Hatalı Giriş'],
            self::TYPE_CREATE_OBJECT => [self::TYPE_CREATE_OBJECT, 'Nesne Oluşturma Hatası'],
            self::TYPE_UPDATE_OBJECT => [self::TYPE_UPDATE_OBJECT, 'Nesne Güncelleme Hatası'],
            self::TYPE_DELETE_OBJECT => [self::TYPE_DELETE_OBJECT, 'Nesne Silme Hatası'],
            self::TYPE_IYZICO        => [self::TYPE_IYZICO, 'İyzico Hatası'],
            self::TYPE_IYZICO_INFO   => [self::TYPE_IYZICO, 'İyzico Log'],
            self::TYPE_BASKET        => [self::TYPE_BASKET, 'Basket Log'],
            self::TYPE_ORDER         => [self::TYPE_ORDER, 'Order Log'],
            self::TYPE_ORDER_UPDATE  => [self::TYPE_IYZICO, 'Sipariş Güncellendi'],
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

    public static function addLog($message, $exception, $type = self::TYPE_GENERAL, $code = null, $url = null, $user_id = null)
    {
        try {
            self::create([
                'type'           => $type,
                'message'        => mb_substr($message, 0, 250),
                'exception'      => mb_substr((string) $exception, 0, 65000),
                'user_id'        => null === $user_id ? (Auth::user() ? Auth::user()->id : null) : $user_id,
                'code'           => null === $code ? Str::random() : $code,
                'url'            => null === $url ? mb_substr(request()->fullUrl(), 0, 150) : mb_substr($url, 0, 150),
                'exception_type' => mb_substr(\get_class($exception), 0, 150),
            ]);
            self::checkLogCount();
        } catch (\Exception $exception) {
            if (\in_array('slack', config('logging.channels.' . config('logging.default') . '.channels'), true)) {
                \Illuminate\Support\Facades\Log::channel('single')->error('slack', ['message' => $exception->getMessage()]);
            }
            \Illuminate\Support\Facades\Log::channel('single')->critical($exception->getMessage(), $exception->getTrace());
        }
    }

    /**
     * @param null|string $message   iyzico ile ilgili içerik
     * @param null|string $exception data veya hata string olabilir
     * @param null        $relatedID sepet id veya order id olabilir
     * @param int         $type      related id sepet id ise TYPE_BASKET değilse ilgili log gönderilmelidir
     * @param null        $userID
     */
    public static function addIyzicoLog($message = null, $exception = null, $relatedID = null, $type = self::TYPE_BASKET, $userID = null)
    {
        try {
            self::create([
                'type'      => $type,
                'message'   => $message ? mb_substr($message, 0, 250) : null,
                'exception' => $exception ? mb_substr((string) $exception, 0, 65000) : $exception,
                'user_id'   => null === $userID ? Auth::user() ? Auth::user()->id : 0 : $userID,
                'code'      => $relatedID,
                'url'       => mb_substr(request()->fullUrl(), 0, 150),
            ]);
        } catch (\Exception $exception) {
        }
    }

    protected function checkLogCount()
    {
        $count = self::count();
        if ($count > 1500) {
            self::truncate();
        }
    }
}
