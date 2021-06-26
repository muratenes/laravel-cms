<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunAttributeDescription extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    /**
     * ana dilindeki attribute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(UrunAttribute::class, 'attribute_id', 'id');
    }
}
