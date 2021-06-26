<?php

namespace App\Repositories\Traits;

use App\Models\Ayar;

trait ModelCurrencyTrait
{
    /**
     * hesaplanmış kampa ürün fiyatı.
     */
    public function getCurrencySymbolAttribute()
    {
        return Ayar::getCurrencySymbolById($this->currency_id);
    }
}
