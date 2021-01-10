<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    protected $table = "favoriler";
    protected $guarded = [];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Urun::class, 'product_id', 'id');
    }
}
