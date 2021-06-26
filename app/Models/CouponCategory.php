<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    public $timestamps = false;
    public $guarded = [];
    protected $perPage = 20;
    protected $table = 'kuponlar_kategori';
}
