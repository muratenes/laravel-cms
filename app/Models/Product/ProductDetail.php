<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function subDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductSubDetail::class, 'parent_detail');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product');
    }

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class, 'parent_attribute');
    }

    public function subDetailsForSync(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ProductSubDetail::class, 'product_sub_details', 'parent_detail', 'sub_attribute');
    }
}
