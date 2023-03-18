<?php

namespace App\Http\Controllers\Admin;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\AdminProductSaveRequest;
use App\Models\Kategori;
use App\Models\Product\Product;
use App\Models\Product\ProductBrand;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\ProductAttributeInterface;
use App\Repositories\Interfaces\ProductBrandInterface;
use App\Repositories\Interfaces\ProductCompanyInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use App\Utils\Concerns\Admin\ProductConcern;
use App\Utils\Concerns\Models\MultiLanguageHelper;
use Yajra\DataTables\DataTables;

class ProductController extends AdminController
{
    use ImageUploadTrait;
    use MultiLanguageHelper;
    use ProductConcern;
    use ResponseTrait;

    protected ProductInterface $model;
    protected CategoryInterface $categoryService;
    private ProductBrandInterface $brandService;
    private ProductCompanyInterface $productCompanyService;
    private ProductAttributeInterface $productAttributeService;

    public function __construct(
        ProductInterface $model,
        CategoryInterface $categoryService,
        ProductBrandInterface $brandService,
        ProductCompanyInterface $productCompanyService,
        ProductAttributeInterface $productAttributeService
    ) {
        $this->model = $model;
        $this->brandService = $brandService;
        $this->categoryService = $categoryService;
        $this->productCompanyService = $productCompanyService;
        $this->productAttributeService = $productAttributeService;
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
        $companies = $this->productCompanyService->all();
        $categories = $this->categoryService->all();
        $brands = ProductBrand::select(['id', 'title'])->orderBy('title')->get();

        return view('admin.product.list_products', compact('categories', 'companies', 'brands'));
    }

    public function newOrEditProduct($product_id = 0)
    {
        $product = new Product();
        $productDetails = $productVariants = $productSelectedSubAttributesIdsPerAttribute = $selectedAttributeIdList = $productSelectedSubAttributesIdsPerAttribute = [];

        if (0 !== $product_id) {
            $product = $this->model->find($product_id, 'id', ['categories', 'variants.productVariantSubAttributes', 'languages']);
        }
        $data = [
            'categories'    => $this->categoryService->all(['parent_category_id' => null]),
            'brands'        => $this->brandService->all(['active' => 1]),
            'companies'     => $this->productCompanyService->all(['active' => 1]),
            'attributes'    => $this->productAttributeService->all(),
            'subAttributes' => $this->productAttributeService->getAllSubAttributes(),
            'currencies'    => $this->activeCurrencies(),
            'subCategories' => [],
            'selected'      => [
                'categories' => $product->categories()->pluck('category_id')->toArray(),
            ],
        ];

        if (0 !== $product_id) {
            $productDetails = $this->model->getProductDetailWithSubAttributes($product_id)['detail'];
            $productVariants = $product->variants;
            $productSelectedSubAttributesIdsPerAttribute = [];
            foreach ($productDetails as $index => $detail) {
                $selectedAttributeIdList = [];
                foreach ($detail['sub_details'] as $subIndex => $subDetail) {
                    $selectedAttributeIdList[] = $subDetail['sub_attribute'];
                }
                $productSelectedSubAttributesIdsPerAttribute[$index] = $selectedAttributeIdList;
            }
            if (! config('admin.product.multiple_category')) {
                $data['subCategories'] = Kategori::where('parent_category_id', $product->parent_category_id)->get();
            }
        }

        return view(
            'admin.product.new_edit_product',
            compact('product', 'productDetails', 'productSelectedSubAttributesIdsPerAttribute', 'productVariants', 'data')
        );
    }

    public function saveProduct(AdminProductSaveRequest $request, $product_id = 0)
    {
        $productRequestData = $request->validated();

        $productRequestData['slug'] = createSlugByModelAndTitle($this->model, $productRequestData['title'], $product_id);
        $productSelectedAttributesIdAnSubAttributeIdList = $this->getProductAttributeDetailFromRequest($request);
        if (0 !== $product_id) {
            $entry = $this->model->updateWithCategory($productRequestData, $product_id, $request->categories, $productSelectedAttributesIdAnSubAttributeIdList);
        } else {
            $entry = $this->model->createWithCategory($productRequestData, $request->categories, $productSelectedAttributesIdAnSubAttributeIdList);
        }
        if (! $entry) {
            return back()->withInput();
        }

        $this->saveProductVariants($entry, $request);
        $this->syncModelForOtherLanguages($request, $entry);
        $this->uploadProductMainImageAndGallery($request, $entry);

        return redirect(route('admin.product.edit', $entry->id));
    }

    /**
     * @param ProductFilter $filter
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function ajax(ProductFilter $filter)
    {
        return DataTables::of(
            Product::with(['company:id,title', 'categories', 'parent_category', 'sub_category', 'brand:id,title'])->filter($filter)
        )->make(true);
    }

    public function deleteProduct(Product $product)
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
