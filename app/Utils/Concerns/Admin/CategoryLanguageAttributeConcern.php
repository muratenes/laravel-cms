<?php

namespace App\Utils\Concerns\Admin;


use Illuminate\Database\Eloquent\Model;

trait CategoryLanguageAttributeConcern
{
    /**
     * mevcut dildeki başlık getirir
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|object
     */
    public function getTitleLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang',curLangId())->first();
        return $langDescription ? ($langDescription->title ? $langDescription->title : $this->title) : $this->title;
    }

    /**
     * mevcut dildeki kısa açıklama getirir
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|object
     */
    public function getSpotLangAttribute()
    {
        $langDescription = $this->descriptions()->where('lang',curLangId())->first();
        return $langDescription ? ($langDescription->spot ? $langDescription->spot : $this->spot) : $this->spot;
    }
}
