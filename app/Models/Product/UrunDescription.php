<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunDescription extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'tags'       => 'array',
        'properties' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Urun::class, 'product_id', 'id');
    }
}
