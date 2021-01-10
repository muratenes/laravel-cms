<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UrunSubAttribute extends Model
{
    protected $table = "urun_sub_attributes";
    protected $guarded = [];
    public $timestamps = false;


    /**
     * diğer dillerdeki sub attribute karşılıkları
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
     * mevcut dildeki başlık getirir
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|object
     */
    public function getTitleLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang',curLangId())->first();
        return $langDescription ? ($langDescription->title ? $langDescription->title : $this->title) : $this->title;
    }

    public static function getActiveSubAttributesCache()
    {
        $cache = Cache::get('cacheActiveSubAttributesCache');
        if (is_null($cache))
            $cache = self::setCache(UrunSubAttribute::whereHas('attribute', function ($query) {
                $query->where('active', 1);
            })->get());
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
