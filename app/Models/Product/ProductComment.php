<?php

namespace App\Models\Product;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    public $timestamps = true;
    protected $guarded = [];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
