<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Basket;
use App\Models\Config;
use App\Models\FAQ;
use App\Models\Kategori;
use App\Models\Product\Product;
use App\Repositories\Interfaces\KampanyaInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use App\Repositories\Traits\SepetSupportTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    use SepetSupportTrait;

    private UrunlerInterface $_productService;
    private KampanyaInterface $_campService;

    public function __construct(UrunlerInterface $productService, KampanyaInterface $campService)
    {
//        $this->_productService = $productService;
//        $this->_campService = $campService;
    }

    public function index()
    {
        $banners = Banner::whereActive(true)->take(6)->orderByDesc('id')->get();
        $camps = []; // $this->_campService->getLatestActiveCampaigns(3);

        return view('site.index', compact('banners', 'camps'));
    }

    /**
     * hakkımızda sayfası.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $sss = FAQ::where(['lang' => curLangId(), 'active' => 1])->orderByDesc('id')->get();

        return view('site.main.about', compact('sss'));
    }

    public function sitemap()
    {
        $products = Product::orderBy('id', 'DESC')->take(1000)->get();
        $categories = Kategori::orderBy('id', 'DESC')->take(1000)->get();
        $now = Carbon::now()->toAtomString();
        $content = view('site.sitemap', compact('products', 'now', 'categories'));

        return response($content)->header('Content-Type', 'application/xml');
    }

    public function setLanguage(Request $request, $locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        $lang = Config::getLanguageIdByShortName($locale);
        session()->put('lang_id', $lang);
        session()->put('currency_id', Config::getCurrencyId());
        session()->put('product_price_currency_field', Config::getCurrencyProductPriceFieldByLang($lang));
        if ($request->user()) {
            $this->matchSessionCartWithBasketItems(Basket::getCurrentBasket());
            $request->user()->update(['locale' => Config::languages()[$lang][3]]);
        }

        return back();
    }
}
