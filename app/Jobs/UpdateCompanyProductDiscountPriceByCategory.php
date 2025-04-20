<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignCategory;
use App\Models\Config;
use App\Repositories\Traits\CampaignTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCompanyProductDiscountPriceByCategory // implements ShouldQueue
{
    use CampaignTrait;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected Campaign $campaign;
    /**
     * @var array id
     */
    protected array $campaignCategoriesIDList;

    /**
     * eski para birimi ID.
     *
     * @var array
     */
    protected $oldCurrencyID;

    /**
     * güncelleme öncesi min ürün tutarı.
     *
     * @var array
     */
    protected float $oldCampaignMinPrice;

    /**
     * ürün currency price field.
     *
     * @var string
     */
    protected string $productPriceField;

    /**
     * ürün currency discount price field.
     *
     * @var string
     */
    protected string $productDiscountPriceField;

    /**
     * Create a new job instance.
     *
     * @param Campaign $campaign
     * @param array    $selectedCategoriesIdList - seçili olan kategori id listesi
     * @param $oldCurrencyID
     * @param float $oldCampaignMinPrice
     */
    public function __construct(Campaign $campaign, array $selectedCategoriesIdList, $oldCurrencyID, float $oldCampaignMinPrice = 0)
    {
        // todo : genel olarak güncelleme işlemi yapılmadan önceki entry gönderilmesi lazım
        $this->campaign = $campaign;
        $this->campaignCategoriesIDList = $selectedCategoriesIdList;
        $this->oldCurrencyID = $oldCurrencyID;
        $this->productPriceField = Config::getCurrencyPrefixByCurrencyID($campaign->currency_id) . '_price';
        $this->productDiscountPriceField = Config::getCurrencyPrefixByCurrencyID($campaign->currency_id) . '_discount_price';
        $this->oldCampaignMinPrice = $oldCampaignMinPrice;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->_deleteOldCategoryProductDiscountPrices();

        $this->campaign->campaignCategories()->sync($this->campaignCategoriesIDList);
        if (! $this->campaign->active) {
            $this->products()->update([
                $this->productDiscountPriceField => null,
            ]);

            return;
        }

        $products = $this->products()->get();
        foreach ($products as $product) {
            $product->update([
                $this->productDiscountPriceField => $this->getDiscountPrice($this->campaign, $product, $this->productPriceField),
            ]);
        }
    }

    private function products()
    {
        return Product::whereHas('categories', function ($query) {
            $query->whereIn('category_id', $this->campaignCategoriesIDList);
        })
            ->where($this->productPriceField, '>', $this->campaign->min_price ?? 0)
        ;
    }

    /**
     * silinmiş kategorilerin indirim tutarlarını siler.
     */
    private function _deleteOldCategoryProductDiscountPrices()
    {
        $oldCategoriesIdList = CampaignCategory::where(['campaign_id' => $this->campaign->id])
            ->get()->pluck('category_id')->toArray();

        $deleteOldDiffPriceCategoriesIdList = array_diff($oldCategoriesIdList, $this->campaignCategoriesIDList);
        $oldPriceFieldPrefix = Config::getCurrencyPrefixByCurrencyID($this->oldCurrencyID);

        Product::whereHas('categories', function ($query) use ($deleteOldDiffPriceCategoriesIdList) {
            $query->whereIn('category_id', $deleteOldDiffPriceCategoriesIdList);
        })
            ->where($oldPriceFieldPrefix . '_price', '>', $this->oldCampaignMinPrice)
            ->update([
                $oldPriceFieldPrefix . '_discount_price' => null,
            ])
        ;
    }
}
