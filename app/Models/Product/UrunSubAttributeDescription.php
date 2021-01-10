<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunSubAttributeDescription extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * ana dilindeki sub attribute
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sub_attribute()
    {
        return $this->belongsTo(UrunAttribute::class, 'sub_attribute_id', 'id');
    }
}
