<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class);
    }
}
