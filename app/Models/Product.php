<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_products')
            ->withPivot('price')
            ->withTimestamps();
    }
}
