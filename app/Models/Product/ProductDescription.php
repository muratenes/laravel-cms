<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'tags'       => 'array',
        'properties' => 'array',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
