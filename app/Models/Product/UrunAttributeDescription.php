<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunAttributeDescription extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * ana dilindeki attribute
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(UrunAttribute::class, 'attribute_id', 'id');
    }
}
