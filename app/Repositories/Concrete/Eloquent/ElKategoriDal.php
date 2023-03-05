<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Kategori;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductDetail;
use App\Models\Product\ProductSubAttribute;
use App\Models\Product\ProductSubDetail;
use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use Illuminate\Support\Str;

class ElKategoriDal extends BaseRepository implements KategoriInterface
{
    protected $model;
    private UrunlerInterface $productService;

    public function __construct(Kategori $model, UrunlerInterface $productService)
    {
        $this->productService = $productService;
        parent::__construct($model);
    }

    public function getById($id, $columns = ['*'], $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = ['*'], $relations = null)
    {
        return $this->model->getByColumn($field, $value, $columns, $relations);
    }

    public function delete($id): bool
    {
        $category = $this->model->find($id);
        // $category->products()->detach();
        $category->slug = Str::random();
        $category->save();

        return (bool) $category;
    }

    public function getSubCategoriesByCategoryId($categoryId, $count = 10, $orderBy = null)
    {
        return Kategori::where(['parent_category_id' => $categoryId, 'active' => true])->orderBy('title')->get();
    }

    public function orderByProducts($orderType, $productList)
    {
        $perPage = 2;
        if ('yeni' === $orderType) {
            $products = $productList
                ->orderByDesc('updated_at')
                ->paginate($perPage)
            ;
        } elseif ('artanfiyat' === $orderType) {
            $products = $productList
                ->orderBy('price')
                ->paginate($perPage)
            ;
        } elseif ('azalanfiyat' === $orderType) {
            $products = $productList
                ->orderByDesc('price')
                ->paginate($perPage)
            ;
        } else {
            $products = $productList->paginate($perPage);
        }

        return $products;
    }

    public function getCategoriesByHasCategoryAndFilterText($category_id, $search_text, $paginate = false)
    {
        return Kategori::with('parent_category')->when(is_numeric($category_id), function ($query) use ($category_id) {
            return $query->where('parent_category_id', $category_id);
        })->where('title', 'like', "%{$search_text}%")->simplePaginate();
    }

    public function getProductsAndAttributeSubAttributesByCategory($category, $sub_categories)
    {
        $products = Product::select('id', 'title', 'image', 'tl_price', 'slug', 'tl_discount_price', 'usd_price', 'usd_discount_price', 'eur_price', 'eur_discount_price')->whereHas('categories', function ($query) use ($sub_categories, $category) {
            $sub_categories = $sub_categories->pluck('id')->toArray();
            $sub_categories[] = $category->id;
            if (\count($sub_categories) > 0) { // todo : alt kategoriler göre
                $query->whereIn('category_id', $sub_categories);
            } else {
                $query->where('category_id', $category->id);
            }
        })->whereActive(1)->orderByDesc('id');
        $productIdList = $products->pluck('id')->toArray();
        $productTotalCount = Product::whereIn('id', $productIdList)->select('id')->whereIn('id', $productIdList)->count();
        $totalPage = ceil($productTotalCount / Product::PER_PAGE);
        $productDetails = ProductDetail::select('parent_attribute', 'id')->with('subDetails')->whereIn('product', $productIdList);
        $attributesIdList = $productDetails->pluck('parent_attribute');
        $attributes = ProductAttribute::getActiveAttributesWithSubAttributesCache()->find($attributesIdList);

        $subAttributesIdList = ProductSubDetail::select('sub_attribute')->whereIn('parent_detail', $productDetails->pluck('id'))->pluck('sub_attribute');
        $subAttributes = ProductSubAttribute::getActiveSubAttributesCache()->find($subAttributesIdList);
        $brandIdList = Product::select('brand_id')->whereNotNull('brand_id')->whereIn('id', $productIdList)->distinct('brand_id')->get()->pluck('brand_id')->toArray();
        $brands = ProductBrand::getActiveBrandsCache()->find($brandIdList);
        $products = $products->skip(0)->take(Product::PER_PAGE)->get();

        return [
            'products'          => $products,
            'brands'            => $brands,
            'attributes'        => $attributes,
            'totalPage'         => 0 !== $totalPage ? $totalPage : 1,
            'productTotalCount' => $productTotalCount,
            'subAttributes'     => $subAttributes,
            'subCategories'     => $sub_categories,
            'per_page'          => Product::PER_PAGE,
            'current_page'      => 1,
        ];
    }

    public function getProductsAttributesSubAttributesProductFilterWithAjax($categorySlug, $orderType, $selectedSubAttributeIdList, $selectedBrandIdList, $currentPage = 1)
    {
        $newProductIdList = $this->productService->filterProductsFilterBySelectedSubAttributeIdList($selectedSubAttributeIdList);
        $category = Kategori::with('sub_categories')->whereSlug($categorySlug)->first();
        $products = Product::with('detail')->select('id', 'title', 'slug', 'tl_price', 'image', 'tl_discount_price')->whereHas('categories', function ($query) use ($category) {
            if (\count($category->sub_categories) > 0) {
                $sub_categories = $category->sub_categories->pluck('id')->toArray();
                $sub_categories[] = $category->id;
                $query->whereIn('category_id', $sub_categories);
            } else {
                $query->where('category_id', $category->id);
            }
        })->when(\count($selectedSubAttributeIdList) > 0, function ($q) use ($newProductIdList) {
            $q->whereIn('id', $newProductIdList);
        })->when(null !== $selectedBrandIdList, function ($q) use ($selectedBrandIdList) {
            $q->whereIn('brand_id', $selectedBrandIdList);
        })->whereActive(1)->orderBy(Product::getProductOrderType($orderType)[0], Product::getProductOrderType($orderType)[1]);
        $productIdList = $products->pluck('id')->toArray();
        $productTotalCount = Product::whereIn('id', $productIdList)->select('id')->count();
        $totalPage = ceil($productTotalCount / Product::PER_PAGE);
        $subAttributeIdList = ProductSubDetail::whereHas('parentDetail', function ($query) use ($productIdList) {
            $query->whereIn('product', $productIdList);
        })->pluck('sub_attribute')->toArray();
        $attributeIdList = ProductAttribute::getActiveAttributesWithSubAttributesCache()->whereIn('id', ProductDetail::whereIn('product', $productIdList)->pluck('parent_attribute')->toArray())->pluck('id')->toArray();
        $returnedSubAttributes = ProductSubAttribute::getActiveSubAttributesCache()->whereIn('id', $subAttributeIdList)->whereIn('parent_attribute', $attributeIdList)->pluck('id')->toArray();
        $brandIdList = Product::select('brand_id')->whereNotNull('brand_id')->whereIn('id', $productIdList)->distinct('brand_id')->get()->pluck('brand_id')->toArray();
        $products = $products->skip((1 !== $currentPage ? ($currentPage - 1) : 0) * Product::PER_PAGE)->take(Product::PER_PAGE)->get();
        $brands = ProductBrand::getActiveBrandsCache()->find($brandIdList)->pluck('id')->toArray();

        return [
            'status'                => true,
            'brands'                => $brands,
            'totalPage'             => 0 !== $totalPage ? $totalPage : 1,
            'products'              => $products,
            'productTotalCount'     => $productTotalCount,
            'returnedSubAttributes' => $returnedSubAttributes,
            'filterSideBarAttr'     => $attributeIdList,
            'per_page'              => Product::PER_PAGE,
            'current_page'          => (int) (0 !== $currentPage ? $currentPage : 1),
        ];
    }
}
