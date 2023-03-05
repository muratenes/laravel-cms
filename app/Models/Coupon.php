<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false;
    public $guarded = [];
    protected $perPage = 20;

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'kuponlar_kategori', 'coupon_id', 'category_id');
    }

    public static function getCouponDiscountPrice(): float
    {
        $coupon = session()->get('coupon');

        return $coupon['discount_price'] ?? 0;
    }
}
