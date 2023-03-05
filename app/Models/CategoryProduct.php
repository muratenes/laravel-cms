<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    public $timestamps = false;
    public $guarded = [];
    protected $perPage = 20;
    protected $table = 'category_product';
}
