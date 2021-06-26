<?php

namespace App\Repositories\Interfaces;

interface KategoriInterface
{
    public function getSubCategoriesByCategoryId($categoryId, $count = 10, $orderBy = null);

    public function orderByProducts($orderType, $productList);

    public function getCategoriesByHasCategoryAndFilterText($category_id, $search_text, $paginate = false);

    public function getProductsAndAttributeSubAttributesByCategory($category, $sub_categories);

    public function getProductsAttributesSubAttributesProductFilterWithAjax($categorySlug, $orderType, $selectedSubAttributeIdList, $selectedBrandIdList, $currentPage = 1);
}
