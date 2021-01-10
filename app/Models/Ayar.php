<?php

namespace App\Models;

use App\Utils\Concerns\Models\SettingLanguages;
use App\Utils\Concerns\SettingCurrencyConcern;
use Illuminate\Database\Eloquent\Model;

class Ayar extends Model
{
    use SettingCurrencyConcern;
    use SettingLanguages;

    protected $table = "ayarlar";
    protected $guarded = ['id'];
    public $timestamps = false;

    const LANG_TR = 1;
    const LANG_EN = 2;
    const LANG_DE = 3;
    const LANG_FR = 4;

    const CURRENCY_TL = 1;
    const CURRENCY_USD = 2;
    const CURRENCY_EURO = 3;


    /**
     * önbelleğe ayarları atar
     * @param $config
     * @param null $lang
     * @return mixed
     */
    public static function setCache($config, $lang = null)
    {
        $lang = !$lang ? config('admin.default_language') : $lang;
        \Cache::set("site.config.{$lang}", $config, (60 * 5));
        return $config;
    }

    /**
     * Önbellekte bulunan ayarları getiri
     * @param null $lang
     * @return mixed
     */
    public static function getCache($lang = null)
    {
        $lang = $lang ? $lang : (curLangId() ? curLangId() : config('admin.default_language'));
        $cache = \Cache::get('site.config.' . $lang);
        if (!$cache) {
            $item = Ayar::where('lang', $lang)->first();
            $cache = self::setCache($item ? $item : Ayar::first(), $lang);
        }
        return $cache;
    }
}
