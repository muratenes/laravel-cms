<?php

namespace App\Jobs;

use App\Models\Kampanya;
use App\Models\Product\Urun;
use App\Repositories\Traits\CampaignTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateProductDiscountPriceBySelectedProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,CampaignTrait;


    protected $kampanya;
    protected $selectedProductIdList;

    /**
     * Create a new job instance.
     *
     * @param Kampanya $kampanya
     * @param $selectedCategoriesIdList - seçili olan kategori id listesi
     */
    public function __construct(Kampanya $kampanya, $selectedProductIdList)
    {
        $this->kampanya = $kampanya;
        $this->selectedProductIdList = $selectedProductIdList;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->kampanya->campaignProducts()->sync($this->selectedProductIdList);
        if (!$this->kampanya->active) {
            Urun::whereIn('id', $this->selectedProductIdList)
            ->update(['discount_price' => null]);
            return;
        }
        $products = $this->_getProducts();
        foreach ($products as $product) {
            $product->update([
                'discount_price' => $this->getDiscountPrice($this->kampanya,$product)
            ]);
        }
    }

    private function _getProducts()
    {
        return Urun::whereIn('id', $this->selectedProductIdList)
            ->when($this->kampanya->min_price, function ($query) {
                $query->where('price', '>', $this->kampanya->min_price);
            })
            ->get();
    }
}
