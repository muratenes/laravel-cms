<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    public const MODULE_NAME = 'advert';

    public const TYPE_HOME_1 = 'home_1';
    public const TYPE_HOME_2 = 'home_2';
    public const TYPE_HOME_3 = 'home_3';
    public const TYPE_HOME_4 = 'home_4';
    protected $guarded = ['id'];

    public static function listStatusWithId()
    {
        return [
            // index => [id,label,size]
            self::TYPE_HOME_1 => [self::TYPE_HOME_1, 'Anasayfa 1', '540x300'],
            self::TYPE_HOME_2 => [self::TYPE_HOME_2, 'Anasayfa 2', '540x300'],
            self::TYPE_HOME_3 => [self::TYPE_HOME_3, 'Anasayfa 3', '1140x300'],
            self::TYPE_HOME_4 => [self::TYPE_HOME_4, 'Anasayfa 4', '445x350'],
        ];
    }

    public static function getHtml($type)
    {
        $advert = self::where(['status' => 1, 'type' => $type])->latest()->first();

        return $advert ? view('site.advert.' . $advert->type, compact('advert')) : '';
    }
}
