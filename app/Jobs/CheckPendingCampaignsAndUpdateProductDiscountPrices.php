<?php

namespace App\Jobs;

use App\Models\Kampanya;
use App\Models\Product\Urun;
use App\Repositories\Traits\CampaignTrait;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckPendingCampaignsAndUpdateProductDiscountPrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,CampaignTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lastFiveMinute = Carbon::now()->subMinutes(14);
        $now = Carbon::now();
        $pendingCampaigns = Kampanya::whereBetween('start_date',[$lastFiveMinute,$now])
            ->where('active',false)
            ->get();
        foreach ($pendingCampaigns as $campaign){
            $products = $this->getProducts($campaign);
            foreach ($products as $product){
                $product->update([
                    'discount_price' => $this->getDiscountPrice($campaign,$product)
                ]);
            }
            $campaign->update(['active'=>true]);
        }
    }

}
