<?php

namespace App\Models;

use App\Utils\Concerns\Models\SettingLanguages;
use App\Utils\Concerns\SettingCurrencyConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Config extends Model
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

    protected $guarded = ['id'];

    public static function setCache(self $config, $lang = null): Config
    {
        $lang = !$lang ? config('admin.default_language') : $lang;
        Cache::set("site.config.{$lang}", $config, (60 * 5));

        return $config;
    }

    public static function getCache($lang = null): Config
    {
        $lang = $lang ?: (curLangId() ?: config('admin.default_language'));
        $cache = Cache::get('site.config.' . $lang);
        if (!$cache) {
            $item = self::where('lang', $lang)->first();
            $cache = self::setCache($item ?: self::first(), $lang);
        }

        return $cache;
    }
}
