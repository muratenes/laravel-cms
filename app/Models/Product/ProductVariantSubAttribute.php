<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductVariantSubAttribute extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function variant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id', 'id');
    }
}
