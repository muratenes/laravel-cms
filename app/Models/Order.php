<?php

namespace App\Models;

use App\User;
use App\Utils\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use Filterable;

    protected $guarded = ['id'];


    public function vendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
