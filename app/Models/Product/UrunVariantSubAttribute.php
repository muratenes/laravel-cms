<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunVariantSubAttribute extends Model
{
    public $timestamps = false;
    protected $table = 'urun_variant_sub_attributes';
    protected $guarded = [];

    public function variant()
    {
        return $this->belongsTo(UrunVariant::class, 'variant_id', 'id');
    }
}
