<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public const MODULES = [
        'product',
        'category',
        'content_management',
    ];
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $appends = ['lang'];

    /**
     * üst menü
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * üst menü
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions()
    {
        return $this->hasMany(MenuDescription::class, 'menu_id', 'id');
    }

    /**
     * önbelleğe menuyü atar.
     *
     * @param $config
     * @param $lang
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return mixed
     */
    public static function setCache($config, $lang)
    {
        $lang = ! $lang ? config('admin.default_language') : $lang;
        \Cache::set('site.menu', $config, (60 * 5));

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
        $cache = \Cache::get('site.menu.' . $lang);
        if (! $cache) {
            $item = self::first();
            $cache = self::setCache($item, $lang);
        }

        return $cache;
    }

    /**
     * mevcut dildeki menüyü getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang', curLangId())->first();
//        dd(array_merge($this->getOriginal(), $langDescription->getOriginal()));
//        dd($langDescription ? array_merge($this->getOriginal(), $langDescription->getOriginal()) : $this);
        return $langDescription ? array_merge($this->getOriginal(), $langDescription->getOriginal()) : $this->getOriginal();
    }
}
