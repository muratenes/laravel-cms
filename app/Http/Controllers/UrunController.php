<?php

namespace App\Http\Controllers;

use App\Models\Product\Urun;
use App\Models\Product\UrunMarka;
use App\Models\Product\UrunVariant;
use App\Models\Product\UrunYorum;
use App\Repositories\Interfaces\KampanyaInterface;
use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UrunController extends Controller
{
    use ResponseTrait;

    protected UrunlerInterface $model;
    private KategoriInterface $_categoryService;
    private KampanyaInterface $_campaignService;

    public function __construct(UrunlerInterface $model, KategoriInterface $categoryService, KampanyaInterface $campaignService)
    {
        $this->model = $model;
        $this->_categoryService = $categoryService;
        $this->_campaignService = $campaignService;
    }

    public function detail(Urun $product)
    {
        $featuredProducts = $this->model->getFeaturedProducts($product->categories[0]->id, 5, $product->id, 'detail', ['title', 'tl_price', 'tl_discount_price', 'image', 'slug', 'id']);
        $featuredProductTitle = "Benzer Ürünler";
        $bestSellers = collect($this->model->getBestSellersProducts($product->categories[0]->id, 6, $product->id));
        $discount = $product->discount_price;
        $comments = $product->getLastActive10Comments;
        return view('site.urun.product', compact('product', 'discount', 'featuredProducts', 'featuredProductTitle', 'bestSellers', 'comments'));
    }

    public function addNewComment(Request $request)
    {
        $productSlug = $request->get('product_slug');
        try {
            $message = $request->get('message');
            $user = $request->user()->id;
            $product = $request->get('product_id');
            UrunYorum::create(['message' => substr($message, 0, 255), 'product_id' => $product, 'user_id' => $user]);
            session()->flash('message', "Yorum eklendi yönetici onayından sonra burada görüntülenecektir");
            return redirect()->route('product.detail', $productSlug);

        } catch (\Exception $e) {
            session()->flash('message', "Yorum eklenirken bir hata oluştu");
            session()->flash('message_type', "danger");
            return redirect()->route('product.detail', $productSlug);
        }
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
