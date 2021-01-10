<?php

namespace App\Models;

use App\Models\Product\Urun;
use Illuminate\Database\Eloquent\Model;

class Kampanya extends Model
{
    const MODULE_NAME = 'campaign';

    protected $table = "kampanyalar";
    protected $guarded = [];
    public $timestamps = false;

    const DISCOUNT_TYPE_PRICE = 1;
    const DISCOUNT_TYPE_PERCENT = 2;


    public static function listStatus()
    {
        return [
            self::DISCOUNT_TYPE_PRICE => 'Fiyat Indirimi',
            self::DISCOUNT_TYPE_PERCENT => 'Yüzdelik Indirim',
        ];
    }

    public function statusLabel()
    {
        $list = self::listStatus();
        return $list[$this->discount_type];
    }


    public function campaignProducts()
    {
        return $this->belongsToMany(Urun::class, 'kampanya_urunler', 'campaign_id', 'product_id');
    }

    public function campaignCategories()
    {
        return $this->belongsToMany(Kategori::class, 'kampanya_kategoriler', 'campaign_id', 'category_id');
    }

    public function campaignCompanies()
    {
        return $this->belongsToMany(UrunFirma::class, 'kampanya_markalar', 'campaign_id', 'company_id');
    }

    public static function removeCampaignAllProductDiscounts($campaign, $oldCampaignMinPrice = null)
    {
        $categoryIdList = $campaign->campaignCategories->pluck('id')->toArray();
        $productIdList = $campaign->campaignProducts->pluck('id')->toArray();
        $companyIdList = $campaign->campaignCompanies->pluck('id')->toArray();
        $products = Urun::whereHas('categories', function ($query) use ($categoryIdList) {
            return $query->whereIn('category_id', is_null($categoryIdList) ? [] : $categoryIdList);
        })->when(count($productIdList) > 0, function ($query) use ($productIdList) {
            $query->whereIn('id', $productIdList);
        })
            ->when(count($companyIdList) > 0, function ($query) use ($companyIdList) {
                $query->WhereHas('info', function ($query) use ($companyIdList) {
                    $query->whereIn('company_id', is_null($companyIdList) ? [] : $companyIdList);
                });
            })->when(!is_null($campaign->min_price), function ($query) use ($campaign, $oldCampaignMinPrice) {
                $query->where([['price', '>=', is_null($oldCampaignMinPrice) ? $campaign->min_price : $oldCampaignMinPrice]]);
            });
        $products->update(['discount_price' => null]);
    }

    public static function forgetCaches()
    {
        \Cache::forget('cacheLatestActiveCampaigns3');
        \Cache::forget('cacheLatestActiveCampaigns4');
        \Cache::forget('cacheLatestActiveCampaigns5');
    }
}
