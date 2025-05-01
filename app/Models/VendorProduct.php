<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property float $price
 * @property int $product_id
 * @property int $vendor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorProduct whereVendorId($value)
 * @mixin \Eloquent
 */
class VendorProduct extends Model
{
    protected $guarded = ['id'];

    protected $table = 'vendor_products';


    public $timestamps = true;

    protected $fillable = ['product_id', 'vendor_id', 'price'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
