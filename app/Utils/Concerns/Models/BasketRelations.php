<?php

namespace App\Utils\Concerns\Models;

use App\Models\Coupon;
use App\Models\SepetUrun;
use App\Models\Siparis;
use App\User;

trait BasketRelations
{
    /**
     * sipariş
     *
     * @return mixed
     */
    public function order()
    {
        return $this->hasOne(Siparis::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * sepetteki ürünler.
     *
     * @return mixed
     */
    public function basket_items()
    {
        return $this->hasMany(SepetUrun::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
