<?php

namespace App\Models\Product;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;

class KategoriDescription extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    /**
     * ana dilindeki sub attribute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Kategori::class, 'category_id', 'id');
    }
}
