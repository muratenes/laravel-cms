<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    const TURKEY = 228;

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }
}
