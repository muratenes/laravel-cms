<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $appends = ['lang'];

    const MODULES = [
        'product',
        'category',
        'content_management'
    ];

    /**
     * üst menü
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * üst menü
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions()
    {
        return $this->hasMany(MenuDescription::class, 'menu_id', 'id');
    }

    /**
     * önbelleğe menuyü atar
     *
     * @param $config
     * @param $lang
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function setCache($config,$lang)
    {
        $lang = !$lang ? config('admin.default_language') : $lang;
        \Cache::set("site.menu", $config, (60 * 5));
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
        $cache = \Cache::get('site.menu.' . $lang);
        if (!$cache) {
            $item = Menu::first();
            $cache = self::setCache($item, $lang);
        }
        return $cache;
    }

    /**
     * mevcut dildeki menüyü getirir.
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|object
     */
    public function getLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang', curLangId())->first();
//        dd(array_merge($this->getOriginal(), $langDescription->getOriginal()));
//        dd($langDescription ? array_merge($this->getOriginal(), $langDescription->getOriginal()) : $this);
        return $langDescription ? array_merge($this->getOriginal(), $langDescription->getOriginal()) : $this->getOriginal();
    }


}
