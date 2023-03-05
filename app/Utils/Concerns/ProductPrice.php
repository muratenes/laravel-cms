<?php

namespace App\Utils\Concerns;

use App\Models\Config;
use Illuminate\Database\Eloquent\Model;

trait ProductPrice
{
    /**
     * 1.Ürün description kargo fiyatı var mı ? return
     * 2.Site ana dilinde ise ürün kargo fiyatı döner
     * 2 Seçili dildeki varsayılan kargo fiyatı döner.
     *
     * @return mixed
     */
    public function getLastCargoPriceAttribute()
    {
        $langDescription = $this->descriptions()->where('lang', curLangId())->first();
        if ($langDescription && null !== $langDescription->cargo_price) {
            return $langDescription->cargo_price;
        }

        if (curLangId() === config('admin.default_language') && null !== $this->cargo_price) {
            return $this->cargo_price;
        }

        return Config::getCache()->cargo_price;
    }

    /**
     * mevcut para birimindeki ürün fiyatı.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getCurrentPriceAttribute()
    {
        $priceColumnNamePrefix = Config::getCurrencyProductPrefixByID() . '_price';

        return $this->{$priceColumnNamePrefix};
    }

    /**
     * mevcut para birimindeki indiirmli ürün fiyatı.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getCurrentDiscountPriceAttribute()
    {
        $discountPriceColumnNamePrefix = Config::getCurrencyProductPrefixByID() . '_discount_price';

        return $this->{$discountPriceColumnNamePrefix};
    }

    /**
     * mevcut para birimi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getCurrentCurrencyAttribute()
    {
        return session()->get('currency_id', config('admin.default_currency'));
    }

    /**
     * mevcut para birimi sembolü
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getCurrentSymbolAttribute()
    {
        return Config::currencies()[Config::getCurrencyId()][2];
    }

    /**
     * mevcut para biriminde ürüne indirim varsa onu getirir yoksa ürün fiyatı.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getCurrentLastPriceAttribute()
    {
        $priceColumnNamePrefix = Config::getCurrencyProductPrefixByID();
        $discountPriceColumnNamePrefix = $priceColumnNamePrefix . '_discount_price';
        $priceColumnNamePrefix .= '_price';

        return $this->{$discountPriceColumnNamePrefix} ? $this->{$discountPriceColumnNamePrefix} : $this->{$priceColumnNamePrefix};
    }
}
