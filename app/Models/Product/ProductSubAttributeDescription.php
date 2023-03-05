<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductSubAttributeDescription extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function sub_attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class, 'sub_attribute_id', 'id');
    }
}
