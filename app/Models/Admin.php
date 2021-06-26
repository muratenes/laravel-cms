<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $guarded = ['id'];
    protected $table = 'admin';

    protected $casts = [
        'modules_status' => 'array',
        'modules'        => 'array',
        'dashboard'      => 'array',
        'image_quality'  => 'array',
        'menus'          => 'array',
        'site'           => 'array',
    ];

    /**
     * önbelleğe admin ayarlar atar.
     *
     * @param $config
     *
     * @return mixed
     */
    public static function setCache($config)
    {
        \Cache::set('admin', $config, (60 * 5));

        return $config;
    }

    /**
     * Önbellekte bulunan admin ayarları getirir.
     *
     * @return mixed
     */
    public static function getCache()
    {
        $cache = \Cache::get('admin');
        if (! $cache) {
            $cache = self::setCache(self::first());
        }

        return self::first(); // todo : $cache;
    }
}
