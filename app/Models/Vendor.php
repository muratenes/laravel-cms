<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property int $is_active
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vendor extends Model
{
    protected $guarded = ['id'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'vendor_products')
            ->withPivot('price')
            ->withTimestamps();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'id','vendor_id');
    }
}
