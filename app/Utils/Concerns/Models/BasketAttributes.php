<?php

namespace App\Utils\Concerns\Models;

use App\Models\SepetUrun;

trait BasketAttributes
{
    /**
     * sepette bulunan ürünlerin alt toplam değeri.
     *
     * @return mixed
     */
    public function getSubTotalAttribute()
    {
        return $this->basket_items()->get()->sum(function ($item) {
            return $item->sub_total;
        });
    }

    /**
     * sepette bulunan ürünlerin son toplam değeri.
     *
     * @return mixed
     */
    public function getTotalAttribute()
    {
        return $this->basket_items()->get()->sum(function ($item) {
            return $item->total;
        })
        - ($this->coupon ? $this->coupon->discount_price : 0);
    }

    /**
     * sepette bulunan ürünlerin toplam kargo değeri.
     *
     * @return mixed
     */
    public function getCargoTotalAttribute()
    {
        return $this->basket_items()->get()->sum(function ($item) {
            return $item->cargo_price * $item->qty;
        });
    }

    /**
     * sepette bulunan ürünlerin sayısı.
     *
     * @return mixed
     */
    public function getItemCountAttribute()
    {
        return $this->hasMany(SepetUrun::class)->count();
    }

    /**
     * sepette bulunan ürünlerin toplam adetlerini getirir.
     *
     * @return mixed
     */
    public function getItemQuantityCountAttribute()
    {
        return $this->hasMany(SepetUrun::class)->sum('qty');
    }

    /**
     * sepette bulunan ürünlerin alt toplam değeri.
     *
     * @return mixed
     */
    public function getCouponPriceAttribute()
    {
        return $this->coupon ? $this->coupon->discount_price : 0;
    }
}
