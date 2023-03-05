<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductSubDetail extends Model
{
    public $timestamps = false;

    public function parentDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'parent_detail');
    }

    public function parentSubAttribute()
    {
        return $this->belongsTo(ProductSubAttribute::class, 'sub_attribute');
    }
}
