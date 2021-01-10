<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    protected $perPage = 20;
    protected $table = "kuponlar_kategori";
    public $timestamps = false;
    public $guarded = [];
}
