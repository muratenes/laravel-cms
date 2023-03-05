<?php

namespace App\Repositories\Traits;

use App\Models\Config;

trait ModelCurrencyTrait
{
    /**
     * hesaplanmış kampa ürün fiyatı.
     */
    public function getCurrencySymbolAttribute()
    {
        return Config::getCurrencySymbolById($this->currency_id);
    }
}
