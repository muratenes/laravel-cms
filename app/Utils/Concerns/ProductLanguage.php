<?php

namespace App\Utils\Concerns;


use Illuminate\Database\Eloquent\Model;

trait ProductLanguage
{
    /**
     * mevcut dildeki başlık getirir
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|object
     */
    public function getTitleLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang', curLangId())->first();
        return $langDescription ? ($langDescription->title ? $langDescription->title : $this->title) : $this->title;
    }

    /**
     * istenilen dildeki ürünün karşılığını gönderir
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|object
     */
    public function getProductLangAttribute()
    {
        $productByLang = $this->descriptions()->where('lang', curLangId())->first();
        if (!$productByLang) return $this;
        return array_merge($this->toArray(),$productByLang->toArray());
    }
}
