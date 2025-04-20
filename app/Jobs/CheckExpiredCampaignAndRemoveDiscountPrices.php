<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckExpiredCampaignAndRemoveDiscountPrices implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $lastFiveMinute = Carbon::now()->subMinutes(2);

        $expiredCampaigns = Campaign::whereBetween('end_date', [$lastFiveMinute, Carbon::now()])
            ->where('active', true)
            ->get()
        ;
        foreach ($expiredCampaigns as $camp) {
            $camp->active = false;
            $campaignCategoriesIDs = $camp->campaignCategories()->pluck('category_id')->toArray();
            $campaignProductIDs = $camp->campaignProducts()->pluck('product_id')->toArray();
            // kategori indirimleri silmek için
            Product::whereHas('categories', function ($query) use ($campaignCategoriesIDs) {
                $query->whereIn('category_id', $campaignCategoriesIDs);
            })->orWhereIn('id', $campaignProductIDs)
                ->update(['discount_price' => null])
            ;
            $camp->save();
        }
    }
}
