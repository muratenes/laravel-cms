<?php

namespace App\Utils\Concerns\Models;

trait Languageable
{
    /**
     * Get language icon by lang.
     */
    public function getLangIconAttribute()
    {
        return langIcon($this->lang);
    }

    /**
     * Get language name by lang.
     */
    public function getLangNameAttribute()
    {
        return langTitle($this->lang);
    }
}
