<?php

namespace App\Repositories\Interfaces;

interface CampaignInterface extends BaseRepositoryInterface
{
    public function getCampaignDetail($slug, $order = null, $selectedSubAttributeList = null, $category = null, $brandIdList = null);

    public function getLatestActiveCampaigns(int $qty);
}
