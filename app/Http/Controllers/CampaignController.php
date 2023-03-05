<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\KampanyaInterface;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    private KampanyaInterface $_campaignService;

    public function __construct(KampanyaInterface $campaignService)
    {
        $this->_campaignService = $campaignService;
    }

    public function list()
    {
        $list = $this->_campaignService->all(['active' => 1]);

        return view('site.campaigns.listCampaigns', compact('list'));
    }

    public function detail($slug, $category = null)
    {
        $data = $this->_campaignService->getCampaignDetail($slug, null, null, $category);

        return view('site.campaigns.campaignDetail', compact('data'));
    }

    public function campaignsFilterWithAjax(Request $request)
    {
        $order = $request->get('orderBy');
        $slug = $request->get('slug');
        $category = $request->get('category');
        $brandIdList = $request->get('brands', null);
        $selectedSubAttributeListFromRequest = $request->get('secimler');
        $subAttributeIdList = [];
        if (null !== $selectedSubAttributeListFromRequest) {
            foreach ($selectedSubAttributeListFromRequest as $s) {
                if (null !== $s) {
                    $subAttributeIdList[] = array_map('intval', explode(',', $s));
                }
            }
        }
        $data = $this->_campaignService->getCampaignDetail($slug, $order, $subAttributeIdList, $category, $brandIdList);

        return response()->json($data);
    }
}
