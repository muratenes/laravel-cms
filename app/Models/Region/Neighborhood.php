<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
