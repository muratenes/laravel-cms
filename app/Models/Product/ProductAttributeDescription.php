<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeDescription extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id', 'id');
    }
}
