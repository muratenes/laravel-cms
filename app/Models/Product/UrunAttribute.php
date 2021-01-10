<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UrunAttribute extends Model
{
    protected $table = "urun_attributes";
    protected $guarded = [];
    public $timestamps = false;


    /**
     * diğer dillerdeki karşılıkları
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions()
    {
        return $this->hasMany(UrunAttributeDescription::class, 'attribute_id', 'id');
    }

    public function subAttributes()
    {
        return $this->hasMany(UrunSubAttribute::class, 'parent_attribute');
    }

    public function subAttributeForSync()
    {
        return $this->belongsToMany(UrunSubAttribute::class, 'urun_sub_attributes', 'parent_attribute', 'id');
    }

    /**
     * mevcut dildeki başlık getirir
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|object
     */
    public function getTitleLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang',curLangId())->first();
        return ($langDescription and $langDescription->title) ? $langDescription->title : $this->title;
    }

    public static function getActiveAttributesWithSubAttributesCache()
    {
        $cache = Cache::get('cacheActiveAttributesWithSubAttributes');
        if (is_null($cache))
            $cache = self::setCache(UrunAttribute::with('subAttributes')->where(['active' => 1])->get());
        return $cache;
    }

    public static function setCache($data)
    {
        return Cache::rememberForever('cacheActiveAttributesWithSubAttributes', function () use ($data) {
            return $data;
        });
    }

    public static function clearCache()
    {
        Cache::forget('cacheActiveAttributesWithSubAttributes');
        UrunSubAttribute::clearCache();
        return self::getActiveAttributesWithSubAttributesCache();
    }


}
