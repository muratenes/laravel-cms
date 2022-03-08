<?php

namespace App\Utils\Concerns\Models;

use App\Models\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

trait MultiLanguageRelations
{
    public $translated;

    /**
     * Get the another languages model instances.
     */
    public function languages()
    {
        return $this->morphMany(MultiLanguage::class, 'languageable');
    }

    /**
     * get content by current language.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getTranslateAttribute()
    {
        if (! $this->translated) {
            $langDescription = $this->languages()->firstWhere('lang', '=', curLangId());
            $this->translated = $langDescription ? array_merge($this->getOriginal(), $langDescription->getOriginal()['data']) : $this->getOriginal();
        }

        return $this->translated;
    }
}
