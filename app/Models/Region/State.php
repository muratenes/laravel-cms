<?php

namespace App\Models\Region;

use App\Repositories\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use Cachable;

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
