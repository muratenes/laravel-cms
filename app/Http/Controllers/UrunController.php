<?php

namespace App\Http\Controllers;

use App\Models\Product\Urun;
use App\Models\Product\UrunMarka;
use App\Models\Product\UrunVariant;
use App\Models\Product\UrunYorum;
use App\Repositories\Interfaces\KampanyaInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UrunController extends Controller
{
    use ResponseTrait;

    protected UrunlerInterface $model;
    private KampanyaInterface $_campaignService;

    public function __construct(UrunlerInterface $model)
    {
        $this->model = $model;
    }

    public function detail(Urun $product)
    {
        $featuredProducts = [];// $this->model->getFeaturedProducts($product->categories[0]->id, 5, $product->id, 'detail', ['title', 'tl_price', 'tl_discount_price', 'image', 'slug', 'id']);
        $featuredProductTitle = "Benzer Ürünler";
        $bestSellers = []; //collect($this->model->getBestSellersProducts($product->categories[0]->id, 6, $product->id));
        $discount = $product->discount_price;
        $comments = $product->comments()->latest()->where('active',1)->take(5)->get();
        return view('site.urun.product', compact('product', 'discount', 'featuredProducts', 'featuredProductTitle', 'bestSellers', 'comments'));
    }

    /**
     * @param Request $request
     * @param Urun $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createComment(Request $request, Urun $product)
    {
        $validated = $request->validate([
            'message' => 'required|max:255',
            'point' => 'numeric|min:1,max:5'
        ]);
        if (UrunYorum::where(['product_id' => $product->id, 'user_id' => $request->user()->id])->count()) {
            return back()->withErrors(__('lang.you_have_already_added_comment'));
        }
        UrunYorum::create(array_merge($validated, [
            'user_id' => $request->user()->id,
            'product_id' => $product->id
        ]));
        success(__('lang.product_comment_added'));

        return back();
    }

    /**
     * @param Request $request
     * @param Urun $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkProductVariant(Request $request, Urun $product)
    {
        $selectedAttributeIdList = $request->get('subAttributeIDs');
        $variant = UrunVariant::urunHasVariant($product->id, $selectedAttributeIdList, currentCurrencyID());

        if ($variant) return $this->success([
            'variant' => $variant
        ]);

        return $this->error();
    }

    public function quickView(Urun $product)
    {
        $discount = $product->discount_price;
        return view('site.urun.partials.quickView', compact('product', 'discount'));
    }

    public function getActiveProductBrandsJson()
    {
        $brands = UrunMarka::getActiveBrandsCache();
        return response()->json($brands);
    }

}
