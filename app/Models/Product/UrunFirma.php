<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunFirma extends Model
{
    protected $table = "firmalar";
    protected $guarded = [];
    const MODULE_NAME = 'product_company';
}
