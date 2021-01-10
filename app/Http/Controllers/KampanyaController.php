<?php

namespace App\Http\Controllers;

use App\Models\Product\Urun;
use App\Repositories\Interfaces\KampanyaInterface;
use Illuminate\Http\Request;

class KampanyaController extends Controller
{
    private KampanyaInterface $_campaignService;

    public function __construct(KampanyaInterface $campaignService)
    {
        $this->_campaignService = $campaignService;
    }

    public function list()
    {
        $list = $this->_campaignService->all(['active' => 1]);
        return view('site.kampanyalar.listCampaigns', compact('list'));
    }

    public function detail($slug, $category = null)
    {
        $data = $this->_campaignService->getCampaignDetail($slug, null, null, $category);
        return view('site.kampanyalar.campaignDetail', compact('lastPage', 'data'));
    }

    public function campaignsFilterWithAjax(Request $request)
    {
        $order = $request->get('orderBy');
        $slug = $request->get('slug');
        $category = $request->get('category');
        $brandIdList = $request->get('brands', null);
        $selectedSubAttributeListFromRequest = $request->get("secimler");
        $subAttributeIdList = [];
        if (!is_null($selectedSubAttributeListFromRequest)) {
            foreach ($selectedSubAttributeListFromRequest as $s) {
                if (!is_null($s)) {
                    array_push($subAttributeIdList, array_map('intval', explode(',', $s)));
                }
            }
        }
        $data = $this->_campaignService->getCampaignDetail($slug, $order, $subAttributeIdList, $category, $brandIdList);
        return response()->json($data);
    }
}
