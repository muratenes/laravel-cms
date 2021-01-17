<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Interfaces\UrunlerInterface;

class KategoriController extends Controller
{
    protected KategoriInterface $model;
    private UrunlerInterface $_productService;

    public function __construct(KategoriInterface $model, UrunlerInterface $productService)
    {
        $this->model = $model;
        $this->_productService = $productService;
    }

    public function index($categorySlug)
    {
        // todo : get by column ekle
        $category = $this->model->getByColumn('slug', $categorySlug, null, ['sub_categories']);
        $data = $this->model->getProductsAndAttributeSubAttributesByCategory($category, $category->sub_categories);
        $bestSellers = $this->_productService->getBestSellersProducts($category->id);

        return view('site.kategori.kategori', compact('category', 'data', 'bestSellers'));
    }

    public function productFilterWithAjax()
    {
        $slug = \request('slug');
        $order = \request('orderBy');
        $selectedSubAttributeListFromRequest = \request()->get("secimler");
        $selectedBrandIdListFromRequest = \request()->get("brands");
        $currentPage = \request()->get('page', 1);
        $subAttributeIdList = [];
        if (!is_null($selectedSubAttributeListFromRequest)) {
            foreach ($selectedSubAttributeListFromRequest as $s) {
                if (!is_null($s)) {
                    array_push($subAttributeIdList, array_map('intval', explode(',', $s)));
                }
            }
        }
        $data = $this->model->getProductsAttributesSubAttributesProductFilterWithAjax($slug, $order, $subAttributeIdList, $selectedBrandIdListFromRequest, $currentPage);
        return response()->json($data);
    }

}
