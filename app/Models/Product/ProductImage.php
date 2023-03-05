<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public const MODULE_NAME = 'product_image';

    // PERCENT
    public const IMAGE_QUALITY = 50;
    public $timestamps = false;

    protected $guarded = [];
}
