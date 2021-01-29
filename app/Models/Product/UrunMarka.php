<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UrunMarka extends Model
{
    protected $table = "markalar";
    protected $guarded = [];
    public $timestamps = false;


    public static function getActiveBrandsCache()
    {
        $cache = Cache::get('cacheActiveBrands');
        if (is_null($cache))
            $cache = self::setCache(UrunMarka::where(['active' => 1])->get());
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
