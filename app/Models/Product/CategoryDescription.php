<?php

namespace App\Models\Product;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;

class CategoryDescription extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    /**
     * main language sub attribute.
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'category_id', 'id');
    }
}
