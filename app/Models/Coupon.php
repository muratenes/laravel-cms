<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $perPage = 20;
    protected $table = "kuponlar";
    public $timestamps = false;
    public $guarded = [];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Kategori::class, 'kuponlar_kategori', "coupon_id", 'category_id');
    }


    /**
     * kullanıcı kupona sahip ise indirim tutarını gönderir
     * @return int
     */
    public static function getCouponDiscountPrice()
    {
        $coupon = session()->get('coupon');
        return $coupon ? $coupon['discount_price'] : 0;
    }
}
