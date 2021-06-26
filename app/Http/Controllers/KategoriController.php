<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Interfaces\UrunlerInterface;

class KategoriController extends Controller
{
    protected KategoriInterface $model;
    private UrunlerInterface $productService;

    public function __construct(KategoriInterface $model, UrunlerInterface $productService)
    {
        $this->model = $model;
        $this->productService = $productService;
    }

    public function index($categorySlug)
    {
        $category = $this->model->find($categorySlug, 'slug', ['sub_categories']);
        $data = $this->model->getProductsAndAttributeSubAttributesByCategory($category, $category->sub_categories);
        $bestSellers = $this->productService->getBestSellersProducts($category->id);

        return view('site.kategori.kategori', compact('category', 'data', 'bestSellers'));
    }

    public function productFilterWithAjax()
    {
        $slug = request('slug');
        $order = request('orderBy');
        $selectedSubAttributeListFromRequest = request()->get('secimler');
        $selectedBrandIdListFromRequest = request()->get('brands');
        $currentPage = request()->get('page', 1);
        $subAttributeIdList = [];
        if (null !== $selectedSubAttributeListFromRequest) {
            foreach ($selectedSubAttributeListFromRequest as $s) {
                if (null !== $s) {
                    $subAttributeIdList[] = array_map('intval', explode(',', $s));
                }
            }
        }
        $data = $this->model->getProductsAttributesSubAttributesProductFilterWithAjax($slug, $order, $subAttributeIdList, $selectedBrandIdListFromRequest, $currentPage);

        return response()->json($data);
    }
}
