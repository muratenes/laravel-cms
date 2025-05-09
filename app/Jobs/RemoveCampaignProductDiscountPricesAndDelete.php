<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveCampaignProductDiscountPricesAndDelete implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $campaign;

    /**
     * Create a new job instance.
     *
     * @param Campaign $kampanya
     */
    public function __construct(Campaign $kampanya)
    {
        $this->campaign = $kampanya;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $campaignCategoriesIDs = $this->campaign->campaignCategories()->pluck('category_id')->toArray();
        $campaignProductIDs = $this->campaign->campaignProducts()->pluck('product_id')->toArray();
        // kategori indirimleri silmek için
        Product::whereHas('categories', function ($query) use ($campaignCategoriesIDs) {
            $query->whereIn('category_id', $campaignCategoriesIDs);
        })->orWhereIn('id', $campaignProductIDs)
            ->update(['discount_price' => null])
        ;
        $this->campaign->campaignCategories()->detach();
        $this->campaign->campaignProducts()->detach();
        $this->campaign->delete();
    }
}
