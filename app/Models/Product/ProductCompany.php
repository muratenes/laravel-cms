<?php

namespace App\Models\Product;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class ProductCompany extends Model
{
    public const MODULE_NAME = 'product_company';
    protected $guarded = [];


    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
