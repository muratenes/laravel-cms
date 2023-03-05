<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductInfo extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'properties'     => 'array',
        'oems'           => 'array',
        'supported_cars' => 'array',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id')->withDefault();
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductCompany::class, 'company_id')->withDefault();
    }
}
