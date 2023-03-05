<?php

namespace App\Models;

use App\Models\Product\Product;
use App\Models\Product\ProductCompany;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public const MODULE_NAME = 'campaign';

    public const DISCOUNT_TYPE_PRICE = 1;
    public const DISCOUNT_TYPE_PERCENT = 2;
    public $timestamps = false;

    protected $guarded = [];

    public static function listStatus()
    {
        return [
            self::DISCOUNT_TYPE_PRICE   => 'Fiyat Indirimi',
            self::DISCOUNT_TYPE_PERCENT => 'Yüzdelik Indirim',
        ];
    }

    public function statusLabel()
    {
        $list = self::listStatus();

        return $list[$this->discount_type];
    }

    public function campaignProducts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'kampanya_urunler', 'campaign_id', 'product_id');
    }

    public function campaignCategories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'kampanya_kategoriler', 'campaign_id', 'category_id');
    }

    public function campaignCompanies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ProductCompany::class, 'kampanya_markalar', 'campaign_id', 'company_id');
    }

    public static function forgetCaches()
    {
        \Cache::forget('cacheLatestActiveCampaigns3');
        \Cache::forget('cacheLatestActiveCampaigns4');
        \Cache::forget('cacheLatestActiveCampaigns5');
    }
}
