<?php

namespace App\Models;

use App\Utils\Concerns\Models\SettingLanguages;
use App\Utils\Concerns\SettingCurrencyConcern;
use Illuminate\Database\Eloquent\Model;

class Ayar extends Model
{
    use SettingCurrencyConcern;
    use SettingLanguages;

    public const LANG_TR = 1;
    public const LANG_EN = 2;
    public const LANG_DE = 3;
    public const LANG_FR = 4;

    public const CURRENCY_TL = 1;
    public const CURRENCY_USD = 2;
    public const CURRENCY_EURO = 3;
    public $timestamps = false;

    protected $table = 'ayarlar';
    protected $guarded = ['id'];

    /**
     * önbelleğe ayarları atar.
     *
     * @param $config
     * @param null $lang
     *
     * @return mixed
     */
    public static function setCache($config, $lang = null)
    {
        $lang = ! $lang ? config('admin.default_language') : $lang;
        \Cache::set("site.config.{$lang}", $config, (60 * 5));

        return $config;
    }

    /**
     * Önbellekte bulunan ayarları getiri.
     *
     * @param null $lang
     *
     * @return mixed
     */
    public static function getCache($lang = null)
    {
        $lang = $lang ?: (curLangId() ?: config('admin.default_language'));
        $cache = \Cache::get('site.config.' . $lang);
        if (! $cache) {
            $item = self::where('lang', $lang)->first();
            $cache = self::setCache($item ?: self::first(), $lang);
        }

        return $cache;
    }
}
