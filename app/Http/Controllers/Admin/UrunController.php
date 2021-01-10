<?php

namespace App\Http\Controllers\Admin;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\AdminProductSaveRequest;
use App\Models\Kategori;
use App\Models\Product\Urun;
use App\Models\Product\UrunMarka;
use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Interfaces\UrunFirmaInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use App\Repositories\Interfaces\UrunMarkaInterface;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use App\Utils\Concerns\Admin\ProductConcern;
use Yajra\DataTables\DataTables;

class UrunController extends AdminController
{
    use ResponseTrait;
    use ImageUploadTrait;
    use ProductConcern;

    protected UrunlerInterface $model;
    protected KategoriInterface $categoryService;
    private UrunMarkaInterface $_brandService;
    private UrunFirmaInterface $_productCompanyService;

    public function __construct(UrunlerInterface $model, KategoriInterface $categoryService, UrunMarkaInterface $brandService, UrunFirmaInterface $productCompanyService)
    {
        $this->model = $model;
        $this->_brandService = $brandService;
        $this->categoryService = $categoryService;
        $this->_productCompanyService = $productCompanyService;
        $this->middleware('admin')->except('getProductVariantPriceAndQtyWithAjax');
    }

    public function getAllProductsForSearchAjax()
    {
        $query = request()->get('text');
        $data = $this->model->getProductsBySearchTextForAjax($query);
        return response()->json($data);
    }

    public function listProducts()
    {
        $companies = $this->_productCompanyService->all();
        $categories = $this->categoryService->all();
        $brands = UrunMarka::select(['id', 'title'])->orderBy('title')->get();

        return view('admin.product.list_products', compact('categories', 'companies', 'brands'));
    }


    public function newOrEditProduct($product_id = 0)
    {
        $product = new Urun();
        $productDetails = $productVariants = $productSelectedSubAttributesIdsPerAttribute = $selectedAttributeIdList = $productSelectedSubAttributesIdsPerAttribute = [];

        if ($product_id != 0) {
            $product = $this->model->getById($product_id, null, ['categories', 'variants.urunVariantSubAttributes', 'descriptions']);
        }
        $data = [
            'categories' => $this->categoryService->all(['parent_category_id' => null]),
            'brands' => $this->_brandService->all(['active' => 1]),
            'companies' => $this->_productCompanyService->all(['active' => 1]),
            'attributes' => $this->model->getAllAttributes(),
            'subAttributes' => $this->model->getAllSubAttributes(),
            'currencies' => $this->activeCurrencies(),
            'subCategories' => [],
            'selected' => [
                'categories' => $product->categories()->pluck('category_id')->toArray()
            ]
        ];

        if ($product_id != 0) {
            $productDetails = $this->model->getProductDetailWithSubAttributes($product_id)['detail'];
            $productVariants = $product->variants;
            $productSelectedSubAttributesIdsPerAttribute = array();
            foreach ($productDetails as $index => $detail) {
                $selectedAttributeIdList = array();
                foreach ($detail['sub_details'] as $subIndex => $subDetail) {
                    array_push($selectedAttributeIdList, $subDetail['sub_attribute']);
                }
                $productSelectedSubAttributesIdsPerAttribute[$index] = $selectedAttributeIdList;
            }
            if (!config('admin.product.multiple_category')) {
                $data['subCategories'] = Kategori::where('parent_category_id', $product->parent_category_id)->get();
            }
        }
        return view('admin.product.new_edit_product',
            compact('product', 'productDetails', 'productSelectedSubAttributesIdsPerAttribute', 'productVariants', 'data'));
    }

    public function saveProduct(AdminProductSaveRequest $request, $product_id = 0)
    {
        $productRequestData = $request->validated();

        $productRequestData['slug'] = createSlugByModelAndTitle($this->model, $productRequestData['title'], $product_id);
        $productSelectedAttributesIdAnSubAttributeIdList = $this->getProductAttributeDetailFromRequest($request);
        if ($product_id != 0) {
            $entry = $this->model->updateWithCategory($productRequestData, $product_id, $request->categories, $productSelectedAttributesIdAnSubAttributeIdList);
        } else {
            $entry = $this->model->createWithCategory($productRequestData, $request->categories, $productSelectedAttributesIdAnSubAttributeIdList);
        }
        if (!$entry) return back()->withInput();

        $this->saveProductVariants($entry, $request);
        $this->syncProductForOtherLanguages($request, $entry);
        $this->uploadProductMainImageAndGallery($request, $entry);
        return redirect(route('admin.product.edit', $entry->id));

    }

    /**
     * @param ProductFilter $filter
     * @return mixed
     * @throws \Exception
     */
    public function ajax(ProductFilter $filter)
    {
        return DataTables::of(
            Urun::with(['company:id,title', 'categories', 'parent_category', 'sub_category', 'brand:id,title'])->filter($filter)
        )->make(true);

    }

    public function deleteProduct(Urun $product)
    {
        $this->model->delete($product->id);
        return redirect(route('admin.products'));
    }

    public function deleteProductDetailById($id)
    {
        return $this->model->deleteProductDetail($id);
    }

    public function getProductDetailWithSubAttributes($product_id)
    {
        return response()->json($this->model->getProductDetailWithSubAttributes($product_id));
    }

    public function deleteProductVariant($variant_id)
    {
        return $this->model->deleteProductVariant($variant_id);
    }

    public function deleteProductImage($id)
    {
        return $this->model->deleteProductImage($id);
    }
}
