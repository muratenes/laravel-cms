<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $type
 * @property string|null $message
 * @property string|null $exception
 * @property string|null $code
 * @property string|null $url
 * @property string|null $exception_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $label
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereExceptionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereUserId($value)
 * @mixin \Eloquent
 */
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
//        try {
//            self::create([
//                'type'           => $type,
//                'message'        => mb_substr($message, 0, 250),
//                'exception'      => mb_substr((string) $exception, 0, 65000),
//                'user_id'        => null === $user_id ? (\Auth::user() ? \Auth::user()->id : null) : $user_id,
//                'code'           => null === $code ? Str::random() : $code,
//                'url'            => null === $url ? mb_substr(request()->fullUrl(), 0, 150) : mb_substr($url, 0, 150),
//                'exception_type' => mb_substr($exception, 0, 150),
//            ]);
//            self::checkLogCount();
//        } catch (\Exception $exception) {
//            if (\in_array('slack', config('logging.channels.' . config('logging.default') . '.channels'), true)) {
//                \Illuminate\Support\Facades\Log::channel('single')->error('slack', ['message' => $exception->getMessage()]);
//            }
//            \Illuminate\Support\Facades\Log::channel('single')->critical($exception->getMessage(), $exception->getTrace());
//        }
    }


    protected static function checkLogCount()
    {
        $count = self::count();
        if ($count > 1500) {
            self::truncate();
        }
    }
}
