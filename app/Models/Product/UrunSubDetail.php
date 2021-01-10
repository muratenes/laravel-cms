<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunSubDetail extends Model
{
    protected $table = "urun_sub_detail";
    public $timestamps = false;


    public function parentDetail()
    {
        return $this->belongsTo(UrunDetail::class, 'parent_detail');
    }

    public function parentSubAttribute()
    {
        return $this->belongsTo(UrunSubAttribute::class, 'sub_attribute');
    }
}
