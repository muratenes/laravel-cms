<?php

namespace App\Models\Product;

use App\Utils\Concerns\Models\MultiLanguageRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UrunAttribute extends Model
{
    use MultiLanguageRelations;

    public const LANG_FIELDS = ['title'];

    public $timestamps = false;
    protected $table = 'urun_attributes';
    protected $guarded = [];

    public function subAttributes()
    {
        return $this->hasMany(UrunSubAttribute::class, 'parent_attribute');
    }

    public function subAttributeForSync()
    {
        return $this->belongsToMany(UrunSubAttribute::class, 'urun_sub_attributes', 'parent_attribute', 'id');
    }

    /**
     * mevcut dildeki başlık getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getTitleLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang', curLangId())->first();

        return ($langDescription && $langDescription->title) ? $langDescription->title : $this->title;
    }

    public static function getActiveAttributesWithSubAttributesCache()
    {
        $cache = Cache::get('cacheActiveAttributesWithSubAttributes');
        if (null === $cache) {
            $cache = self::setCache(self::with('subAttributes')->where(['active' => 1])->get());
        }

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
