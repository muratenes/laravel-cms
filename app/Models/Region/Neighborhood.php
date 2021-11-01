<?php

namespace App\Models\Region;

use App\Repositories\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use Cachable;
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
