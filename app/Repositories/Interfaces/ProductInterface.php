<?php

namespace App\Repositories\Interfaces;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

interface ProductInterface
{
    public function getProductDetailWithRelations(string $slug, array $relations = []): Product;

    public function getProductsByHasCategoryAndFilterText(int $category_id, string $search_text, int $company_id);

    public function updateWithCategory(array $productData, int $id, array $categories, array $selected_attributes_and_sub_attributes): Product;

    public function createWithCategory(array $productData, array $categories, array $selected_attributes_and_sub_attributes);

    public function getSubAttributesByAttributeId(int $id);

    public function deleteProductDetail(int $detailId): bool;

    public function getProductDetailWithSubAttributes(int $productId): array;

    public function deleteProductVariant(int $variant_id): void;

    public function saveProductVariants(Product $product, array $variantData, ?array $selectedVariantAttributeIDList): void;

    public function getProductVariantPriceAndQty(int $product_id, array $sub_attribute_id_list);

    public function deleteProductImage(int $id);

    public function addProductImageGallery(int $product_id, array $image_files, Model $entry): bool;

    public function getProductsAndAttributeSubAttributesByFilter($category, $searchKey, $currentPage = 1, $selectedSubAttributeList = null, $selectedBrandIdList = null, $orderType = null);

    public function getProductsBySearchTextForAjax(string $searchQuery);

    public function getFeaturedProducts($categoryId = null, $qty = 10, $excludeProductId = null, $relations = null, $columns = ['*']);

    public function getBestSellersProducts($categoryId = null, $qty = 9, $excludeProductId = null);

    public function filterProductsFilterBySelectedSubAttributeIdList($selectedSubAttributeList);
}
