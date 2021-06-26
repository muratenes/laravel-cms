<?php

namespace App\Models;

use App\Models\Product\Urun;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    public $timestamps = false;
    protected $table = 'favoriler';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Urun::class, 'product_id', 'id');
    }
}
