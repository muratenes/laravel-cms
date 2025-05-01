<?php

namespace App\Models;

use App\User;
use App\Utils\Enum\TransactionType;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $product_id
 * @property float $per_price
 * @property int $quantity
 * @property int $user_id
 * @property float $amount
 * @property TransactionType $type
 * @property-read \App\Models\Product $product
 * @property-read User $user
 * @property-read \App\Models\Vendor $vendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePerPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereVendorId($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'type' => TransactionType::class,
    ];

    public function vendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
