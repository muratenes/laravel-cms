<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductBrand extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public static function getActiveBrandsCache()
    {
        $cache = Cache::get('cacheActiveBrands');
        if (null === $cache) {
            $cache = self::setCache(self::where(['active' => 1])->get());
        }

        return $cache;
    }

    public static function setCache($data)
    {
        return Cache::rememberForever('cacheActiveBrands', function () use ($data) {
            return $data;
        });
    }

    public static function clearCache()
    {
        Cache::forget('cacheActiveBrands');

        return self::getActiveBrandsCache();
    }
}
