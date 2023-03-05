<?php

namespace App\Models\Product;

use App\Utils\Concerns\Models\MultiLanguageRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductSubAttribute extends Model
{
    use MultiLanguageRelations;

    public const LANG_FIELDS = ['title'];

    public $timestamps = false;
    protected $guarded = [];

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class, 'parent_attribute', 'id');
    }


    public function getTitleLangAttribute(): string
    {
        $langDescription = $this->languages()->where('lang', curLangId())->first();

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
