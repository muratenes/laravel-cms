<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunImage extends Model
{
    const MODULE_NAME = 'product_image';

    protected $table = "urun_images";
    public $timestamps = false;
    protected $guarded = [];

    // PERCENT
    const IMAGE_QUALITY = 50;
}
