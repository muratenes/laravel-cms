<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
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
