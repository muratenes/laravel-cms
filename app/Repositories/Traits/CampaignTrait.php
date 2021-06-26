<?php

namespace App\Repositories\Traits;

use App\Models\Kampanya;
use App\Models\Product\Urun;

trait CampaignTrait
{
    /**
     * hesaplanmış kampa ürün fiyatı.
     *
     * @param Kampanya $campaign
     * @param Urun     $product
     * @param string   $productDiscountPriceField ürün para birimi indirimli sutun adı
     *
     * @return float
     */
    public function getDiscountPrice(Kampanya $campaign, Urun $product, string $productDiscountPriceField)
    {
        if (Kampanya::DISCOUNT_TYPE_PRICE === $campaign->discount_type) {
            if ($campaign->discount_amount >= $product->{$productDiscountPriceField}) {
                return null;
            }

            return $product->{$productDiscountPriceField} - $campaign->discount_amount;
        }

        return $product->{$productDiscountPriceField} - ($product->{$productDiscountPriceField} * $campaign->discount_amount / 100);
    }

//    public function getProducts(Kampanya $campaign)
//    {
//        return Urun::where(function ($query) use ($campaign) {
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
