<?php

namespace App\Models\Product;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class UrunFirma extends Model
{
    public const MODULE_NAME = 'product_company';
    protected $table = 'firmalar';
    protected $guarded = [];

    /**
     * Get the company image.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
