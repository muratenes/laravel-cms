<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Campaign;
use App\Models\Order;
use App\Repositories\Interfaces\CampaignInterface;
use Illuminate\Support\Facades\Cache;

class ElCampaignDal extends BaseRepository implements CampaignInterface
{
    public function __construct(Campaign $model)
    {
        parent::__construct($model);
    }

    public function getCampaignDetail(string $slug, Order $order = null, $selectedSubAttributeList = null, $category = null, $brandIdList = null)
    {
    }

    public function getLatestActiveCampaigns(int $qty)
    {
        $cache = Cache::get("cacheLatestActiveCampaigns{$qty}");
        if (null === $cache) {
            $cache = Cache::remember("cacheLatestActiveCampaigns{$qty}", 24 * 60, function () {
                return Campaign::select('title', 'slug', 'image')->whereActive(1)->get();
            });
        }

        return $cache;
    }
}
