<?php

namespace App\Repositories\Traits;

use App\Models\Campaign;
use App\Models\Product\Product;

trait CampaignTrait
{
    /**
     * hesaplanmış kampa ürün fiyatı.
     *
     * @param Campaign $campaign
     * @param Product  $product
     * @param string   $productDiscountPriceField ürün para birimi indirimli sutun adı
     *
     * @return float
     */
    public function getDiscountPrice(Campaign $campaign, Product $product, string $productDiscountPriceField)
    {
        if (Campaign::DISCOUNT_TYPE_PRICE === $campaign->discount_type) {
            if ($campaign->discount_amount >= $product->{$productDiscountPriceField}) {
                return null;
            }

            return $product->{$productDiscountPriceField} - $campaign->discount_amount;
        }

        return $product->{$productDiscountPriceField} - ($product->{$productDiscountPriceField} * $campaign->discount_amount / 100);
    }

//    public function getProducts(Campaign $campaign)
//    {
//        return Product::where(function ($query) use ($campaign) {
//            $query->whereHas('categories', function ($query) use ($campaign) {
//                $query->whereIn('category_id', $campaign->campaignCategories()->pluck('category_id')->toArray());
//            })
//                ->orWhereIn('id', $campaign->campaignProducts);
//        })
//            ->when($campaign->min_price, function ($query) use ($campaign) {
//                $query->where('price', '>', $campaign->min_price);
//            })
//            ->get();
//    }
}
