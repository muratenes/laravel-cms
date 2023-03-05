<?php

namespace App\Repositories\Interfaces;

interface CategoryInterface
{
    public function getSubCategoriesByCategoryId(int $categoryId, int $count = 10, string $orderBy = null);

    public function orderByProducts(string $orderType, array $productList);

    public function getCategoriesByHasCategoryAndFilterText(int $category_id, string $search_text, bool $paginate = false);

    public function getProductsAndAttributeSubAttributesByCategory($category, $sub_categories);

    public function getProductsAttributesSubAttributesProductFilterWithAjax($categorySlug, $orderType, $selectedSubAttributeIdList, $selectedBrandIdList, $currentPage = 1);
}
