<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Product\Urun;
use App\Repositories\Interfaces\KampanyaInterface;
use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use Illuminate\Http\Request;

class AramaController extends Controller
{

    private UrunlerInterface $_productService;

    public function __construct(UrunlerInterface $productService)
    {
        $this->_productService = $productService;
    }

    public function ara(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('cat', null);
        $data = $this->_productService->getProductsAndAttributeSubAttributesByFilter($category, $query);
        request()->flash();
        $bestSellers = $this->_productService->getBestSellersProducts();
        return view('site.arama.arama', compact('data', 'bestSellers'));
    }

    public function headerSearchBarOnChangeWithAjax()
    {
        $categories = Kategori::getAllActiveCategoriesCache()->toArray();
        return response()->json($categories);
    }


    public function searchPageFilterWithAjax(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('cat', null);
        $orderType = $request->get('orderBy', null);
        $currentPage = $request->get('page', 1);
        $selectedSubAttributeListFromRequest = $request->get("secimler");
        $selectedBrandIdListFromRequest = $request->get("brands");
        $subAttributeIdList = [];
        if (!is_null($selectedSubAttributeListFromRequest)) {
            foreach ($selectedSubAttributeListFromRequest as $s) {
                if (!is_null($s)) {
                    array_push($subAttributeIdList, array_map('intval', explode(',', $s)));
                }
            }
        }
        $data = $this->_productService->getProductsAndAttributeSubAttributesByFilter($categoryId, $query, $currentPage, $subAttributeIdList, $selectedBrandIdListFromRequest, $orderType);
        return response()->json($data);
    }
}
