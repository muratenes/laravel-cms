<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UrunSubAttribute extends Model
{
    public $timestamps = false;
    protected $table = 'urun_sub_attributes';
    protected $guarded = [];

    /**
     * diğer dillerdeki sub attribute karşılıkları.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions()
    {
        return $this->hasMany(UrunSubAttributeDescription::class, 'sub_attribute_id', 'id')->orderBy('lang');
    }

    public function attribute()
    {
        return $this->belongsTo(UrunAttribute::class, 'parent_attribute', 'id');
    }

    /**
     * mevcut dildeki başlık getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getTitleLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang', curLangId())->first();

        return $langDescription ? ($langDescription->title ?: $this->title) : $this->title;
    }

    public static function getActiveSubAttributesCache()
    {
        $cache = Cache::get('cacheActiveSubAttributesCache');
        if (null === $cache) {
            $cache = self::setCache(self::whereHas('attribute', function ($query) {
                $query->where('active', 1);
            })->get());
        }

        return $cache;
    }

    public static function setCache($data)
    {
        return Cache::rememberForever('cacheActiveSubAttributesCache', function () use ($data) {
            return $data;
        });
    }

    public static function clearCache()
    {
        Cache::forget('cacheActiveSubAttributesCache');

        return self::getActiveSubAttributesCache();
    }
}
