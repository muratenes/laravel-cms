<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function productVariantSubAttributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductVariantSubAttribute::class, 'variant_id');
    }

    public function productVariantSubAttributesForSync()
    {
        return $this->belongsToMany(ProductVariantSubAttribute::class, 'urun_variant_sub_attributes', 'variant_id', 'sub_attr_id');
    }

    /**
     * @param int        $productID
     * @param null|array $subAttributeIdList ürün attribute id list
     * @param null|int   $currency
     *
     * @return null|\Illuminate\Database\Eloquent\Builder|mixed
     */
    public static function urunHasVariant($productID, ?array $subAttributeIdList, $currency = null)
    {
        if (! $subAttributeIdList) {
            return null;
        }
        $currency = $currency ?? currentCurrencyID();
        sort($subAttributeIdList);
        $subAttributeIdList = array_filter($subAttributeIdList);
        $subAttributeIdList = array_map('intval', $subAttributeIdList);
        foreach (Product::with('variants')->find($productID)->variants as $variant) {
            if ($variant->productVariantSubAttributes->sortBy('sub_attr_id')->pluck('sub_attr_id')->toArray() === $subAttributeIdList && $variant->currency === $currency) {
                return $variant;
            }
        }
    }
}
