<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $guarded = ['id'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'vendor_products')
            ->withPivot('price')
            ->withTimestamps();
    }
}
