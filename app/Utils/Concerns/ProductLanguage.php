<?php

namespace App\Utils\Concerns;

use Illuminate\Database\Eloquent\Model;

trait ProductLanguage
{
    /**
     * mevcut dildeki başlık getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getTitleLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang', curLangId())->first();

        return $langDescription ? ($langDescription->title ?: $this->title) : $this->title;
    }

    /**
     * istenilen dildeki ürünün karşılığını gönderir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getProductLangAttribute()
    {
        $productByLang = $this->descriptions()->where('lang', curLangId())->first();
        if (! $productByLang) {
            return $this;
        }

        return array_merge($this->toArray(), $productByLang->toArray());
    }
}
