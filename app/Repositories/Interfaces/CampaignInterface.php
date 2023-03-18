<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface CampaignInterface
{
    public function getCampaignDetail(string $slug, Order $order = null, $selectedSubAttributeList = null, $category = null, $brandIdList = null);

    public function getLatestActiveCampaigns(int $qty);
}
