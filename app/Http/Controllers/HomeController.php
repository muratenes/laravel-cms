<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CampaignInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Traits\SepetSupportTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    use SepetSupportTrait;

    private ProductInterface $_productService;
    private CampaignInterface $_campService;

    public function __construct(ProductInterface $productService, CampaignInterface $campService)
    {
    }

    public function index()
    {
        $banners = Banner::whereActive(true)->take(6)->orderByDesc('id')->get();
        $camps = []; // $this->_campService->getLatestActiveCampaigns(3);

        return view('site.index', compact('banners', 'camps'));
    }
}
