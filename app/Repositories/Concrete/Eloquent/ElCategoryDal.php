<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\ProductInterface;
use Illuminate\Support\Str;

class ElCategoryDal extends BaseRepository implements CategoryInterface
{
    private ProductInterface $productService;

    public function __construct(Kategori $model, ProductInterface $productService)
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

    // TODO : Refactor
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

    // TODO : REFACTOR
    public function getProductsAndAttributeSubAttributesByCategory($category, $sub_categories)
    {
    }

    // TODO : REFACTOR
    public function getProductsAttributesSubAttributesProductFilterWithAjax($categorySlug, $orderType, $selectedSubAttributeIdList, $selectedBrandIdList, $currentPage = 1)
    {
    }
}
