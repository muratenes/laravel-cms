<?php

namespace App\Services\Product;

use App\Models\Product;

class ProductService
{

    public static function products(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::with('vendors')->orderBy('name')->get();
    }
}