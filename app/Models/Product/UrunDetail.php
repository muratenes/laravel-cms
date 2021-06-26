<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunDetail extends Model
{
    public $timestamps = false;
    protected $table = 'urun_detail';
    protected $guarded = [];

    public function subDetails()
    {
        return $this->hasMany(UrunSubDetail::class, 'parent_detail');
    }

    public function product()
    {
        return $this->belongsTo(Urun::class, 'product');
    }

    public function attribute()
    {
        return $this->belongsTo(UrunAttribute::class, 'parent_attribute');
    }

    public function subDetailsForSync()
    {
        return $this->belongsToMany(UrunSubDetail::class, 'urun_sub_detail', 'parent_detail', 'sub_attribute');
    }
}
