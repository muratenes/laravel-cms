<?php

namespace App\Models\Product;

use App\Utils\Concerns\Models\MultiLanguageRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductAttribute extends Model
{
    use MultiLanguageRelations;

    public const LANG_FIELDS = ['title'];

    public $timestamps = false;
    protected $guarded = [];

    public function subAttributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductSubAttribute::class, 'parent_attribute');
    }

    public function subAttributeForSync(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ProductSubAttribute::class, 'urun_sub_attributes', 'parent_attribute', 'id');
    }

    /**
     * get title of current language.
     */
    public function getTitleLangAttribute(): string
    {
        $langDescription = $this->languages()->where('lang', curLangId())->first();

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
        ProductSubAttribute::clearCache();

        return self::getActiveAttributesWithSubAttributesCache();
    }
}
