<?php

namespace App\Models\Region;

use App\Repositories\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use Cachable;
    public const TURKEY = 228;

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }
}
