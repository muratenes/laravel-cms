<?php

namespace App\Models\Product;

use App\Models\Ayar;
use Illuminate\Database\Eloquent\Model;

class UrunVariant extends Model
{
    protected $table = "urun_variants";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function urunVariantSubAttributes()
    {
        return $this->hasMany(UrunVariantSubAttribute::class, 'variant_id');
    }

    public function urunVariantSubAttributesForSync()
    {
        return $this->belongsToMany(UrunVariantSubAttribute::class, 'urun_variant_sub_attributes', 'variant_id', 'sub_attr_id');
    }

    /**
     * @param int $productID
     * @param array|null $subAttributeIdList ürün attribute id list
     * @param int|null $currency
     * @return \Illuminate\Database\Eloquent\Builder|mixed|null
     */
    public static function urunHasVariant($productID, ?array $subAttributeIdList, $currency = null)
    {
        if (!$subAttributeIdList) return null;
        $currency = $currency ?? currentCurrencyID();
        sort($subAttributeIdList);
        $subAttributeIdList = array_filter($subAttributeIdList);
        $subAttributeIdList = array_map('intval', $subAttributeIdList);
        foreach (Urun::with('variants')->find($productID)->variants as $variant) {
            if ($variant->urunVariantSubAttributes->sortBy('sub_attr_id')->pluck('sub_attr_id')->toArray() == $subAttributeIdList and $variant->currency == $currency) {
                return $variant;
            }
        }
    }

}
