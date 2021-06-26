<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunFirma extends Model
{
    public const MODULE_NAME = 'product_company';
    protected $table = 'firmalar';
    protected $guarded = [];
}
