<?php

namespace App\Repositories\Traits;

use Illuminate\Support\Facades\Cache;

trait Cachable
{
    /**
     * Session Sepetteki toplam ürün sayısı.
     *
     * @return mixed
     */
    public static function cachedAll()
    {
        return Cache::tags('eloquent')->remember(self::class, 60 * 10, function () {
            $model = new self();

            return $model->all();
        });
    }

    /**
     * @param string $column
     * @param string $value
     *
     * @return array|mixed
     */
    public static function getCachedByColumn($column, $value)
    {
        return Cache::tags('eloquent')->remember(self::class . ":{$column}:{$value}", 60 * 10, function () use ($column, $value) {
            $model = new self();

            return $model->where([$column => $value])->get();
        });
    }
}
