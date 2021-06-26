<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Kategori;
use App\Models\Product\Urun;
use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunDetail;
use App\Models\Product\UrunMarka;
use App\Models\Product\UrunSubAttribute;
use App\Models\Product\UrunSubDetail;
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
        //$category->products()->detach();
        $category->slug = Str::random();
        $category->save();

        return (bool) $category;
    }

    public function getSubCategoriesByCategoryId($categoryId, $count = 10, $orderBy = null)
    {
        return $this->model->all([['parent_category_id', $categoryId]])->take($count)->get();
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
        $products = Urun::select('id', 'title', 'image', 'tl_price', 'slug', 'tl_discount_price', 'usd_price', 'usd_discount_price', 'eur_price', 'eur_discount_price')->whereHas('categories', function ($query) use ($sub_categories, $category) {
            $sub_categories = $sub_categories->pluck('id')->toArray();
            $sub_categories[] = $category->id;
            if (\count($sub_categories) > 0) { // todo : alt kategoriler göre
                $query->whereIn('category_id', $sub_categories);
            } else {
                $query->where('category_id', $category->id);
            }
        })->whereActive(1)->orderByDesc('id');
        $productIdList = $products->pluck('id')->toArray();
        $productTotalCount = Urun::whereIn('id', $productIdList)->select('id')->whereIn('id', $productIdList)->count();
        $totalPage = ceil($productTotalCount / Urun::PER_PAGE);
        $productDetails = UrunDetail::select('parent_attribute', 'id')->with('subDetails')->whereIn('product', $productIdList);
        $attributesIdList = $productDetails->pluck('parent_attribute');
        $attributes = UrunAttribute::getActiveAttributesWithSubAttributesCache()->find($attributesIdList);

        $subAttributesIdList = UrunSubDetail::select('sub_attribute')->whereIn('parent_detail', $productDetails->pluck('id'))->pluck('sub_attribute');
        $subAttributes = UrunSubAttribute::getActiveSubAttributesCache()->find($subAttributesIdList);
        $brandIdList = Urun::select('brand_id')->whereNotNull('brand_id')->whereIn('id', $productIdList)->distinct('brand_id')->get()->pluck('brand_id')->toArray();
        $brands = UrunMarka::getActiveBrandsCache()->find($brandIdList);
        $products = $products->skip(0)->take(Urun::PER_PAGE)->get();

        return [
            'products'          => $products,
            'brands'            => $brands,
            'attributes'        => $attributes,
            'totalPage'         => 0 !== $totalPage ? $totalPage : 1,
            'productTotalCount' => $productTotalCount,
            'subAttributes'     => $subAttributes,
            'subCategories'     => $sub_categories,
            'per_page'          => Urun::PER_PAGE,
            'current_page'      => 1,
        ];
    }

    public function getProductsAttributesSubAttributesProductFilterWithAjax($categorySlug, $orderType, $selectedSubAttributeIdList, $selectedBrandIdList, $currentPage = 1)
    {
        $newProductIdList = $this->productService->filterProductsFilterBySelectedSubAttributeIdList($selectedSubAttributeIdList);
        $category = Kategori::with('sub_categories')->whereSlug($categorySlug)->first();
        $products = Urun::with('detail')->select('id', 'title', 'slug', 'tl_price', 'image', 'tl_discount_price')->whereHas('categories', function ($query) use ($category) {
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
        })->whereActive(1)->orderBy(Urun::getProductOrderType($orderType)[0], Urun::getProductOrderType($orderType)[1]);
        $productIdList = $products->pluck('id')->toArray();
        $productTotalCount = Urun::whereIn('id', $productIdList)->select('id')->count();
        $totalPage = ceil($productTotalCount / Urun::PER_PAGE);
        $subAttributeIdList = UrunSubDetail::whereHas('parentDetail', function ($query) use ($productIdList) {
            $query->whereIn('product', $productIdList);
        })->pluck('sub_attribute')->toArray();
        $attributeIdList = UrunAttribute::getActiveAttributesWithSubAttributesCache()->whereIn('id', UrunDetail::whereIn('product', $productIdList)->pluck('parent_attribute')->toArray())->pluck('id')->toArray();
        $returnedSubAttributes = UrunSubAttribute::getActiveSubAttributesCache()->whereIn('id', $subAttributeIdList)->whereIn('parent_attribute', $attributeIdList)->pluck('id')->toArray();
        $brandIdList = Urun::select('brand_id')->whereNotNull('brand_id')->whereIn('id', $productIdList)->distinct('brand_id')->get()->pluck('brand_id')->toArray();
        $products = $products->skip((1 !== $currentPage ? ($currentPage - 1) : 0) * Urun::PER_PAGE)->take(Urun::PER_PAGE)->get();
        $brands = UrunMarka::getActiveBrandsCache()->find($brandIdList)->pluck('id')->toArray();

        return [
            'status'                => true,
            'brands'                => $brands,
            'totalPage'             => 0 !== $totalPage ? $totalPage : 1,
            'products'              => $products,
            'productTotalCount'     => $productTotalCount,
            'returnedSubAttributes' => $returnedSubAttributes,
            'filterSideBarAttr'     => $attributeIdList,
            'per_page'              => Urun::PER_PAGE,
            'current_page'          => (int) (0 !== $currentPage ? $currentPage : 1),
        ];
    }
}
